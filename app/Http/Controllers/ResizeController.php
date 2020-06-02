<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use ImageResize;
class ResizeController extends Controller
{
function index()
{
    return view('resize');
}

function resize_image(Request $request)
{
    $this->validate($request, [
      'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $image = $request->file('image');
    $image_name = time() . '.' . $image->getClientOriginalExtension();
		$destinationPath = public_path('/thumbnail');
		if (!is_dir($destinationPath)) {
    	mkdir($destinationPath);
		}
    $resize_image = ImageResize::make($image->getRealPath());
    $resize_image->resize(150, 150, function ($constraint) {
        $constraint->aspectRatio();
    })->save($destinationPath . '/' . $image_name);
    $destinationPath = public_path('/images');
		$image->move($destinationPath, $image_name);
		$resize = Image::create(['img'=>$image_name,'thumbnail_img'=>$image_name]);
    return back()
        ->with('success', 'Image Upload successful')
        ->with('imageName', $image_name); 
}

}
