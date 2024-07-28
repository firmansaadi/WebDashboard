<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if (!function_exists('avatar_url'))
{
	function avatar_url($code)
	{
		if(!$code)$code  = 'default';
		$img_path = config('app.avatar_path').'/thumbnails/'. $code . '.jpg';
		$fs_type = config('filesystems.default');
        $url = config("filesystems.disks.$fs_type.url");
		return $url . '/' . $img_path;
	}	
}

if (!function_exists('photo_url'))
{
	function photo_url($code)
	{
		if(!$code)$code  = 'default';
		$img_path = config('app.avatar_path').'/'. $code . '.jpg';
		$fs_type = config('filesystems.default');
        $url = config("filesystems.disks.$fs_type.url");
		return $url . '/' . $img_path;
	}	
}

if (!function_exists('file_url'))
{
	function file_url($code)
	{
		$img_path = 'file/view/'. $code;
		$fs_type = config('filesystems.default');
        $url = config("filesystems.disks.$fs_type.url");
		return $url . '/' . $img_path;
	}
}

if (!function_exists('storage_url'))
{
	function storage_url($filename, $path = '')
	{
		//$img_path = "files/$path/". $filename;
		$img_path = "$path/". $filename;
		$fs_type = config('filesystems.default');
        $url = config("filesystems.disks.$fs_type.url");
		return $url . '/' . $img_path;
	}
}

if (!function_exists('code_generator'))
{
    function code_generator($len)
	{
        $alpha = 'abcdefghijklmnopqrstuvwxyz01234567890';

        $code = '';
        for ($i = 0; $i < $len; $i++) {
            $index = rand(0, strlen($alpha) - 1);
            $code .= substr($alpha, $index, 1);
        }

        return $code;
    }
}

if (!function_exists('code_exists'))
{
    function code_exists($code, $table)
	{
        $code = DB::table($table)->where('code', '=', $code)->whereNull('deleted_at')->get();
        return sizeof($code) > 0;
    }
}

if (!function_exists('code_exists_result'))
{
    function code_exists_result($code, $table)
	{
        $code = DB::connection('pgsql2')->table($table)->where('result_code', '=', $code)->get();
        return sizeof($code) > 0;
    }
}

if (!function_exists('getQueryParameter'))
{
function getQueryParameter($array)
{
    $def_limit = 10;
    $max_limit = 50;
		$def_offset = 0;
    $limit = isset($array['limit']) && ctype_digit($array['limit']) ? intval($array['limit']) : $def_limit;
    $offset = isset($array['offset']) && ctype_digit($array['offset']) ? intval($array['offset']) : $def_offset;
    $sorts = isset($array['sort_by']) ? explode(',', $array['sort_by']) : [];
    $sortarr = [];
    foreach($sorts as $val)
    {
    	$sortpair = explode('.', $val);
      $sorttype = count($sortpair) > 1 ? $sortpair[1] : 'asc';
    	$sortarr[] = [$sortpair[0], in_array($sorttype, ['asc', 'desc']) ? $sorttype : 'asc'];
    }
    $filter = $array;
    unset($filter['limit']);
    unset($filter['offset']);
    unset($filter['sort_by']);
    $filterarr = [];
    foreach($filter as $key => $val)
    {
	    	//$pair = explode('=', $val);
        if(!$val)continue;
				$allowed = array(".", "-", "_");
			  if ( !ctype_alnum( str_replace($allowed, '', $key ) ) ) {
			    continue;
			  }
        $tmpval = explode(',', $val);
        $value = count($tmpval) > 1 ? $tmpval : $val;
        if(strpos($key, '.')!==false)
				{
	        	$pair = explode('.', $key);
            $key = $pair[0];
						if(!in_array($pair[1], ['lt', 'lte', 'gt', 'gte']))continue;
            $value = [$pair[1] => $value];
        }
        if(!isset($filterarr[$key]))$filterarr[$key] = $value;
        else $filterarr[$key] = array_merge($filterarr[$key], $value);
    }
		return [
    	'limit' => $limit > $max_limit ? $max_limit : $limit,
			'offset' => intval($offset),
			'sort' => $sortarr,
      'filter' => $filterarr,
      'draw' => isset($array['draw']) ? intval($array['draw']) : 0
    ];
}
}

function code_exists($code)
	{
		$ci = & get_instance();
		return $ci->db->get_where('files', array('code' => $code))->num_rows()>0;
	} 
