<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
	public function index(Request $request)
	{
        $q = $request->query();
        $params = getQueryParameter($q);

        $users = DB::table('users')
        ->when(isset($params['filter']), function ($query) use ($params) {
            foreach ($params['filter'] as $key => $value) {
                $query->where($key, $value);
            }
        })
        ->when(isset($params['sort']), function ($query) use ($params) {
            return $query->orderBy($params['sort'][0][0], $params['sort'][0][1]);
        })
        ->offset($params['offset'])
        ->limit($params['limit'])
        ->get();

        // $users = User::all();
		return response()->json([
            'draw'=> $params['draw'],
            'data' => $users,
            'success'=> true,
            'data' => $users,
            'total'=> count($users)
        ], 200);

	}

    public function store(Request $request)
    {
        $user = new User;

        $validator = Validator::make($request->all(), [
            'name'      => 'required|min:3',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8',
            'phone'  => [
                'required',
                'min:9',
                'max:14',
                function ($attribute, $value, $fail) {
                    if(!preg_match('/^(\+62|62|0)8[1-9][0-9]{6,9}$/', $value)) {
                        $fail('Nomor HP anda tidak valid! Pastikan awalan nomor +62, 62 atau 0');
                    }
                }
            ]
        ]);

        if ($validator->fails()) {
            $response = [
                'success'   => false,
                'errors'    => $validator->errors(),
                'message'   => 'Input data tidak valid',
                'code'      => "1001"
            ];

            return response()->json($response);
        }

        /* Check valid indonesia phone numbers */
        if(!preg_match('/^(\+62|62|0)8[1-9][0-9]{6,9}$/', $request->phone)) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor HP anda tidak valid! Pastikan awalan nomor +62, 62 atau 0',
            ]);
        }

        $activate_hash = sha1(Str::random(40) . time());

        /* Generate short code */
        $code = code_generator(6);
        while(1)
		{
			if(code_exists($code, 'users')) $code = code_generator(6);
			else break;
		}

        $user = $user::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'phone'     => !$request->phone ? '' : $request->phone,
            // 'created_at'      => date('Y-m-d H:i:s'),
            'activate_hash' => $activate_hash,
            'code'      => $code,
            'uuid'      => (string) Str::uuid(),
            'active'    => 1
        ]);

        // $user->assignRole('siswa');

        $response = [
            "success"=> true,
            "message"=> "Data sudah ditambahkan"
        ];

        return response()->json($response);
    }

    public function update(Request $request, $code = '0')
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone'  => [
                'required',
                'min:9',
                'max:14',
                function ($attribute, $value, $fail) {
                    if(!preg_match('/^(\+62|62|0)8[1-9][0-9]{6,9}$/', $value)) {
                        $fail('Nomor HP anda tidak valid! Pastikan awalan nomor +62, 62 atau 0');
                    }
                }
            ],
            // 'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $response = [
                'success'   => false,
                'details'    => [
                    'insert_id' => $id,
                    'errors'    => $validator->errors()
                ],
                'message'   => 'Gagal edit data user',
                'code'      => 200
            ];

            return response()->json($response);
        }

        if(!preg_match('/^(\+62|62|0)8[1-9][0-9]{6,9}$/', $request->phone)) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor HP anda tidak valid! Pastikan awalan nomor +62, 62 atau 0',
            ]);
        }

        $user = User::where('code', $code)->first();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->phone = $input['phone'];

        if(isset($input['password'])) {
            $user->password = bcrypt($input['password']);
        }

        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();

        $response = [
            'success'   => true,
            'message'   => 'Data sudah diupdate'
        ];

        return response()->json($response);
    }

    public function delete($code='0')
	{
        if ($code == '0') {
            return response()->json([
                'success'   => false,
                "code"  => "1001",
                'message'   => 'Parameter belum diisi'
            ], 400);
        }
        $user = User::where('code', $code)->first();
        if (!$user) {
            return response()->json([
                'success'   => false,
                'message'   => 'Data tidak ditemukan'
            ], 404);
        }
        $user->delete();

		return response()->json([
			'success'   => true,
            'message'   => 'Data sudah dihapus',
		], 200);
	}

    public function detail($code='0')
	{
        if ($code == '0') {
            return response()->json([
                'success'   => false,
                "code"  => "1001",
                'message'   => 'Parameter belum diisi'
            ], 400);
        }
        $user = User::where('code', $code)->first();
        if (!$user) {
            return response()->json([
                'success'   => false,
                'message'   => 'Data tidak ditemukan'
            ], 404);
        }

		return response()->json([
			'success'   => true,
            'data'   => $user,
		], 200);
	}

    public function current_user(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => "Akun tidak ditemukan",
                'success' => false
            ], 404);
        }

    }

    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|min:3',
            // 'email'     => 'required|email|unique:users',
            // 'password'  => 'required|min:8',
            'phone'  => [
                'required',
                'min:9',
                'max:14',
                function ($attribute, $value, $fail) {
                    if(!preg_match('/^(\+62|62|0)8[1-9][0-9]{6,9}$/', $value)) {
                        $fail('Nomor HP anda tidak valid! Pastikan awalan nomor +62, 62 atau 0');
                    }
                }
            ]
        ]);

        if ($validator->fails()) {
            $response = [
                'success'   => false,
                'code'      => "1001",
                'message'   => 'Input data tidak valid',
                'errors'    => $validator->errors(),
            ];

            return response()->json($response);
        }

        $user = auth()->user();
        if ($user) {
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => "Data sudah diupdate"
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Akun tidak ditemukan"
            ], 404);
        }
    }

    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword'  => 'required|min:8',
            'newPassword'  => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $response = [
                'success'   => false,
                'code'      => "1001",
                'message'   => 'Input data tidak valid',
                'errors'    => $validator->errors(),
            ];

            return response()->json($response);
        }

        $user = auth()->user();
        // $2y$12$X3Nuhq0n/nnSR2IkNqOZ2.3T19FaVUNYkdnzrpo7HJRSM9rE1tYSG
        //$2y$12$j/adbdA49TrhSkEzUIrN/OxhMW02yUEdcsEHi2txNx8b7UUXxKI/K
        // return response()->json(Hash::make($request->oldPassword));
        if (Hash::check($request->oldPassword, $user->password)) {
            $user->password = Hash::make($request->newPassword);
            $user->save();
            return response()->json([
                'success' => true,
                'message' => "Password sudah diupdate"
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Password lama tidak sesuai"
            ], 400);
        }
    }

}
