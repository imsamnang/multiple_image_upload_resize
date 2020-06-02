<?php

namespace App\Http\Controllers;

use App\Models\ImageCrud;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use ImageResize;


class ImageCrudController extends Controller
{
	public function index()
	{
		return view('categories.index');
	}

	public function readData()
	{
		$cats = ImageCrud::all();
		return response()->json($cats);
	}

	public function store(Request $request)
	{
    $this->validate($request, [
      'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $image = $request->file('image');
    $image_name = time() . '.' . $image->getClientOriginalExtension();
		$destinationPath = public_path('/categories');
		if (!is_dir($destinationPath)) {
    	mkdir($destinationPath);
		}
    $resize_image = ImageResize::make($image->getRealPath());
    $resize_image->resize(150, 150, function ($constraint) {
        $constraint->aspectRatio();
    })->save($destinationPath . '/' . $image_name);
    $destinationPath = public_path('/images');
		$image->move($destinationPath, $image_name);
		$resize = ImageCrud::create(['category_name'=>$request->category_name,'img'=>$image_name,'img_thumnail'=>$image_name]);
		if($resize){
			return response()->json($resize);
		}
	}

	public function show(ImageCrud $imageCrud)
	{
			//
	}

	public function edit(ImageCrud $imageCrud)
	{
			//
	}

	public function update(Request $request, ImageCrud $imageCrud)
	{
			//
	}

	public function destroy(ImageCrud $imageCrud)
	{
			//
	}
}
