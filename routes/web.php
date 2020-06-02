<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// multiple upload and resize images
    Route::get('image-upload', 'ImageController@index');
    Route::post('upload', 'ImageController@store');

// For Image
    Route::get('/plupload', 'PluploadController@index');
    Route::post('/plupload/upload', 'PluploadController@store');
    Route::post('/plupload/rotate/{id}', 'PluploadController@rotate');
    Route::post('/plupload/delete/{id}', 'PluploadController@delete');
    Route::post('/plupload/save', 'PluploadController@save');
	// single image upload and resize
    Route::get('resize', 'ResizeController@index');
		Route::post('resize/resize_image', 'ResizeController@resize_image');
	// bootstrap fileinput plugins
		Route::get('image-view','BootstrapInputController@index');
		Route::post('image/submit', 'BootstrapInputController@store');

	//Image Crud
		// Route::resource('imagecrud','ImageCrudController');
		Route::group(['prefix'=>'imagecrud','as'=>'imagecrud.'],function(){
			Route::get('/','ImageCrudController@index')->name('index');		
			Route::get('/readData','ImageCrudController@readData')->name('readData');
			Route::post('/save','ImageCrudController@store')->name('store');
			Route::get('/edit','ImageCrudController@edit')->name('edit');
			Route::post('/update','ImageCrudController@update')->name('update');
			Route::post('/destroy','ImageCrudController@destroy')->name('destroy');
		});

    


