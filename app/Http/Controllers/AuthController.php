<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

	public function login(Request $request)
	{
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required|min:8',
            'device'    => 'trim'
        ]);

        if ($validator->fails()) {
            $response = [
                'success'   => false,
                'details'    => [
                    'errors'    => $validator->errors()
                ],
                'message'   => 'Input tidak valid',
                'code'      => 200
            ];

            return response()->json($response);
        }

        $user = User::where('email', $request->email)->first();
        if(!$user)
        {
            return response()->json([
                'message' => 'Username atau Password tidak sesuai',
                'success' => false
            ], 401);
        }

        $password = $request->input('password');
        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'message' => 'Username atau Password tidak sesuai',
                'success' => false
            ], 401);
        }
        $device = $request->input('device', 'apikey-0');
        /*if($user->is_banned == 1)
        {
            return response()->json([
                'message' => "Akun ini sedang diblokir",
                'success' => false
            ], 401);
        }
        else if($user->active == 0)
        {
            return response()->json([
                'message' => "Akun ini tidak aktif",
                'success' => false
            ], 401);
        }*/

		Auth::login($user);

        if(env('APP_PLATFORM') == 'mobile')
        {
            $token = $user->createToken($device)->plainTextToken;
        }
        else
        {
            $token = session()->regenerate();
        }

        $userinfo = [
            'id' => $user->code,
            'email' => $user->email,
            'name' => $user->name,
            //'photo_url' => photo_url($user->photo_code),
            //'avatar_url' => avatar_url($user->photo_code)
        ];
		return response()->json([
            'success'=> true,
            'user' => $userinfo,
            'token' => $token,
            'menu' => [],
            'permission' => []
        ], 200);

	}

    public function login_google(Request $request)
    {
        $result = $this->verify_google($request->input('token'));
        if(!$result || !isset($result['email']))
            return response()->json([
                'message' => 'Gagal login dengan akun google',
                'success' => false
            ], 401);
        //return response()->json($result);
        $rules = array('email' => 'unique:users,email');
        $input['email'] = $result['email'];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            $token = $request->session()->regenerate();
            $user = User::where('email', $input['email'])->first();
            if($user->is_banned == 1)
            {
                return response()->json([
                    'message' => "Akun ini sedang diblokir",
                    'success' => false
                ], 401);
            }
            else if($user->active == 0)
            {
                return response()->json([
                    'message' => "Akun ini tidak aktif",
                    'success' => false
                ], 401);
            }
            Auth::login($user);
            //return response()->json($user, 200);
            //return response()->json(['token' => $request->session()->regenerate()], 200);
            return response()->json([
                'success'=> true,
                'user' => [
                    'id' => $user->code,
                    'email' => $user->email,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'school' => $user->school,
                    'photo_url' => photo_url($user->photo_code),
                    'avatar_url' => avatar_url($user->photo_code)
                ]
            ], 200);
        }
        else {
            return response()->json([
                'message' => "Akun dengan email $result[email] tidak ditemukan",
                'success' => false
            ], 401);
        }

    }

    private function verify_google($id_token)
    {
        $ch = curl_init();
        $url = "https://www.googleapis.com/oauth2/v3/tokeninfo?access_token=$id_token";

        //$url = 'https://oauth2.googleapis.com/tokeninfo';
        //$url .= ('?id_token='.$id_token);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"cred":1}');

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds

        $result = curl_exec($ch);
        if(curl_error($ch))
        {
            debug( 'error:' . curl_error($ch));
        }
        curl_close ($ch);
        $arr = json_decode($result, true);
        return $arr;
        $output = null;
        if(is_array($arr) && !isset($arr['error']))
        {
            $output = [
                'name' => $arr['name'],
                'email' => $arr['email'],
                'picture' => $arr['picture'],
                'id_token' => $id_token
            ];
        }
        return $output;
    }

    /*id
name
email
email_verified_at
password
remember_token
created_at
updated_at
phone
photo_code
role */

    public function register(Request $request)
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
                'details'    => [
                    'errors'    => $validator->errors()
                ],
                'message'   => 'Gagal registrasi',
                'code'      => 200
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
            'uuid'      => (string) Str::uuid()
        ]);

        // $user->assignRole('siswa');

        /* Send Email Verification */
        $link = config('app.front_url') . "/activate/$activate_hash";
        $dataEmailContent['link'] = $link;
        $dataEmailContent['name'] = $user->name;

        $dataEmail = [
            'to' => $request->email,
            'subject' => 'Email Verification',
            'message' => view("emails.register", $dataEmailContent)->render()
        ];

        $mailService = App::make(MailService::class);
        $mailService->send($dataEmail);

        $response = [
            'success'   => true,
            'message'   => 'Berhasil registrasi. Silahkan cek email untuk melakukan verifikasi data.',
            'code'      => 200
        ];

        return response()->json($response);
    }

    public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email'
        ]);

        if ($validator->fails()) {
            $response = [
                'success'   => false,
                'details'    => [
                    'errors'    => $validator->errors()
                ],
                'message'   => 'Gagal cek email',
                'code'      => 200
            ];

            return response()->json($response);
        }
        $email = $request->input('email');
        $role = $request->input('role');
        $user = User::where('email', $email)->where('role',$role)->first();

        if(!$user)
        {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan'
            ]);
        }

        $reset_hash = sha1(Str::random(40) . time() . $email);

        $user->reset_hash = $reset_hash;
        $user->reset_at = date('Y-m-d H:i:s', strtotime("+24 hours"));
        $user->save();

        // Create the link to reset the password.
        $link = config('app.front_url') . "/reset-password?code=$reset_hash";

        $dataEmailContent['link'] = $link;
        $dataEmailContent['name'] = $user->name;

        $dataEmail = [
            'to' => $request->email,
            'subject' => 'Lupa Password',
            'message' => view("emails.forgot", $dataEmailContent)->render()
        ];

        $mailService = App::make(MailService::class);
        $mailService->send($dataEmail);

        $response = [
            'success'   => true,
            'message'   => 'Silahkan cek email untuk melakukan reset password.',
            'code'      => 200
        ];

        return response()->json($response);
    }

    public function activate($code)
    {
        $users = new Users;
        $activated = $users::where('activate_hash', $code)->first();

        if (!isset($activated)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
                'code'    => 200
            ], 200);
        } else {
            $user = Users::find($activated->id);
            $user->email_verified_at = date("Y-m-d H:i:s");
            $user->activate_hash = '';
            $user->active = 1;
            $user->save();

            $response = [
                'success'   => true,
                'message'   => 'Berhasil verifikasi data.',
                'code'      => 200
            ];

            return response()->json($response);
        }
    }

    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'     => 'required|min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation'     => 'required|min:8',
            'hash_key'     => 'required|min:8',

        ]);

        if ($validator->fails()) {
            $response = [
                'success'   => false,
                'details'    => [
                    'errors'    => $validator->errors()
                ],
                'message'   => 'Gagal reset password',
                'code'      => 200
            ];

            return response()->json($response);
        }
        $reset_hash = $request->input('hash_key');
        $user = User::where('reset_hash', $reset_hash)->first();

        if(!$user)
        {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak ditemukan'
            ]);
        }

        if(strtotime($user->reset_at) < time())
        {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan reset password sudah kadaluarsa.'
            ]);
        }

        $user->reset_hash = '';
        $user->reset_at = date('Y-m-d H:i:s', strtotime("+24 hours"));
        $user->password = bcrypt($request->input('password'));
        $user->save();

        // Create the link to reset the password.
        $link = config('app.front_url');

        $dataEmailContent['link'] = $link;
        $dataEmailContent['name'] = $user->name;

        $dataEmail = [
            'to' => $user->email,
            'subject' => 'Reset Password',
            'message' => view("emails.reset_password", $dataEmailContent)->render()
        ];

        $mailService = App::make(MailService::class);
        $mailService->send($dataEmail);

        $response = [
            'success'   => true,
            'message'   => 'Anda berhasil melakukan reset password.',
            'code'      => 200
        ];

        return response()->json($response);
    }

    public function me(Request $request)
    {
        $except = ['login','404','register'];
    	$user = auth()->user();
        $restrict = false;
        $a = $request->input('p') != '/' ? str_replace('/', '', $request->input('p')) : 'dashboard';
        $explode = explode("/",$request->input('p'));
        if (count($explode) > 2) {
            $a = $explode[1];
        }
        if (!in_array($a,$except)) {
            if ($a != '') {
                $users = User::permission('read '.$a)->get();
            } else {
                $users = [];
            }

            if ($request->has('p')) {
                $ada = 0;
                foreach ($users as $key => $value) {
                    if ($value->id == $user->id) {
                        $ada += 1;
                    }
                }
                if ($ada > 0) {
                    $restrict = false;
                } else {
                    $restrict = true;
                }
            } else {
                $restrict = false;
            }
        }
    	return response()->json([
            'success'=> true,
            'user' => [
                'id' => $user->code,
                'email' => $user->email,
                'name' => $user->name,
                'phone' => $user->phone,
                'school' => $user->school,
                'photo_url' => photo_url($user->photo_code),
                'avatar_url' => avatar_url($user->photo_code),
                'passgrade_univ_code' => $user->passgrade_univ_code,
                'passgrade_jurusan_id' => $user->passgrade_jurusan_id,
                'role' => $user->role_user,
                'restrict' => $restrict,
                'link' => $request->input('p')
            ]
        ], 200);
    }
    public function logout(Request $request)
    {
        if(env('APP_PLATFORM') == 'mobile')
        {
            $request->user()->currentAccessToken()->delete();
            //$request->user()->tokens()->delete();
            //$tokenId = $request->user()->currentAccessToken();
            //$user->tokens()->where('id', $tokenId)->delete();
        }
        else
        {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }

        $device = $request->input('device', 'apikey-0');
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully'
        ]);
    }
}
