<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;

class MediaController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getFile($foldername,$filename)
	{
    		$fullpath="app/public/{$foldername}/{$filename}";
    		return response()->download(storage_path($fullpath), null, [], null);
	}
}
