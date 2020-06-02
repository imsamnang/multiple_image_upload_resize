<?php

namespace App\Http\Controllers;

use App\Models\Image;
use ImageResize;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('resize_image');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			if ($request->hasFile('image')) {
				foreach ($request->file('image') as $image) {
					if ($image->isValid()) {
						$img = new Image();
						$image_name = uniqid() . '.' . $image->getClientOriginalExtension();
						$path = public_path('/uploads/thumbnail');
						if (!file_exists( $path)) {
							mkdir( $path, 0777, true);
						}
						$imgx = ImageResize::make($image->getRealPath());
						$imgx->resize(360, 360, function ($constraint) {
								$constraint->aspectRatio();
						})->save($path . '/' . $image_name);

						$img->img = $image_name;
						$img->thumbnail_img = $image_name;

						// $date = date_create('now');
						// $format = date_formatthumbnail_img($date, "Y-m-d");
						// $img->date = $format;
						$img->save();
					}
				}
				return redirect()->back();
			}
        
        // $this->validate($request, [
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        // $image = $request->file('image');
        // $input['imagename'] = time() . '.' . $image->extension();
        // $destinationPath = public_path('/uploads/thumbnail');
        // if (!file_exists( $destinationPath)) {
        //     mkdir( $destinationPath, 0777, true);
        // }

        // $img = ImageResize::make($image->path());

        // // --------- [ Resize Image ] ---------------

        // $img->resize(150, 100, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->save($destinationPath . '/' . $input['imagename']);

        // // ----------- [ Uploads Image in Original Form ] ----------

        // $destinationPath = public_path('/uploads/original');

        // $image->move($destinationPath, $input['imagename']);

        // // store into database table
        // Image::create(['img' => $input['imagename'], 'thumbnail_img' => $input['imagename']]);

        // return back()
        //     ->with('success', 'Image Uploaded successfully')
        //     ->with('imageName', $input['imagename']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
