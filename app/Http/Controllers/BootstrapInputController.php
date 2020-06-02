<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class BootstrapInputController extends Controller
{
  public function index()
	{
		return view('image-view');
	}

	public function store(Request $request)
	{
		$imageName = $request->file('file')->getClientOriginalName();
		// $imageName=$request->file('file')->getClientOrginalName();
		$uploaded = Image::create(['img'=>$imageName,'thumbnail_img'=>$imageName]);
		$request->file->move(public_path('boostrapinput/'),$imageName);
		return response()->json(['uploaded'=>'boostrapinput'.$imageName]);
	}
}
