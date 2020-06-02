<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Image;
use Illuminate\Http\Request;
// use Intervention\Image\Facades\Image;

class PluploadController extends Controller
{
protected $tmp_path = 'plupload-tmp';

	protected $upload_path = 'plupload-upload';
	protected $resizes = [32, 48, 64, 72, 96, 128];
	protected $allow_size = (2048 * 1024);
	protected $allow_file = 'image/jpeg,.jpg,image/gif,.gif,image/png,.png,.jpeg';
	protected $limit   = 8;

	public function __construct()
	{        
		@ini_set('upload_max_filesize', $this->allowsize);        
	}
	
	public function index()
	{          
		if(session::has($this->tmp_path))
		{
			$get_tmp = session::get($this->tmp_path); 
			foreach ($get_tmp as $value) {
					@unlink(public_path($this->tmp_path.'/'.$value['name']));
			}                  
			session::forget($this->tmp_path);
		}
		$data['limit_field'] = $this->limit;
		$data['upload_url']  = \URL::to('/plupload/upload');
		$data['save_url']    = \URL::to('/plupload/save');
		$data['rotate_url']  = \URL::to('/plupload/rotate').'/';
		$data['delete_url']  = \URL::to('/plupload/delete').'/';
		$data['allow_size']  = $this->allow_size;
		return view('plupload', $data);
	}

	public function store(Request $request)
	{       
		$response = array();
		$files    = array();
		$errors   = array();
		$file_ini = array();
		
		if(Session::has($this->tmp_path)){
			if(count(Session::get($this->tmp_path)) > $this->limit){
					return $response =  response(
								array(
									'success' => false,
									'error'   => true,
									'message' => 'Limit :'.$this->limit
							),
							500
					);
			}
		} 
		if($request->hasFile('files')){
			$files = $request->file('files');
			foreach($files as $file){        
				if($file->getSize() > $this->allow_size){
					$response = response(
							array(
							'success' => false,
							'error'   => true,
							'message' => 'File allow size  : '.$this->_human_filesize($this->allow_size)
							),
						500
					);
					$errors[] = array(
							'files' => array(
									'name' => $file->getClientOriginalName(),
									'type' => $file->getMimeType(),
									'size' => $this->_human_filesize($file->getSize()),
									'error' => 'File allow size  : '.$this->_human_filesize($this->allow_size)
							)
					);                  
					continue;
				}else{                  
					$fileExtension    = pathinfo(str_replace('/','.',$file->getMimeType()),PATHINFO_EXTENSION);
					if(preg_match("/{$fileExtension}/i", $this->allow_file)){
						$fileName  = $this->generate(8).'_'.$this->generate(15).'_'.$this->generate(19).'_n.'.$fileExtension; 
						if($file->move(public_path($this->tmp_path), $fileName)){
							$file_detail = array(
													'name' => $fileName,
													'path' => asset($this->tmp_path.'/'.$fileName),
													'type' => $fileExtension,
													'size' => \File::size(public_path($this->tmp_path).'/'.$fileName)
											);           
							$file_ini[] = $file_detail;   
							if(session::has($this->tmp_path)){
								session::push($this->tmp_path,$file_detail);
							}else{
								session::put($this->tmp_path,$file_ini);
							}                                          
						}
					}                
				} 
			}            
			$response = array(
					'success' => true,
					'files'   => $file_ini,
					'errors'  => $errors,             
					'count'   => count(session::get($this->tmp_path)),
			);
		}else{
			$response = response( 
				array(
						'success' => false,
						'error'   => true,
						'message' => 'File allow size  : '.$this->_human_filesize($this->allow_size)
				),
				500
			);
		}      
		return $response;
	}

	public function rotate(Request $request, $id)
	{
			$response = array();
			if($request->id){           
					if(is_file(public_path($this->tmp_path.'/'.$request->id))){
							$img = Image::make(public_path($this->tmp_path.'/'.$request->id));
							if($img->rotate(-90)){
									$img->save();
									$response = array(
											'success' => true,
											'message' => 'Rotate successfully.',
									);
							}
					}           
			}
			return  $response;			
	}

	public function delete(Request $request, $id)
	{
		$response = array();
		if($request->id){
			if (session::has($this->tmp_path)) {
				$get_tmp = session::get($this->tmp_path);			
				foreach ($get_tmp as $key => $value) {                  
					if ($value['name'] === $request->id) {
						unset($get_tmp[$key]);                    
						if(unlink(public_path($this->tmp_path . '/' . $request->id))){
							session::put($this->tmp_path, $get_tmp);
							$response = array(
									'success' => true,
									'message' => 'Delete successfully.',
									'errors'  => session::get($this->tmp_path),
									'count'   => count(session::get($this->tmp_path)),
							);
						}
					}
				}
			}
		}
		return $response;
	}

	public function save(Request $request)
	{
		$files = array();
		if(session::has($this->tmp_path)){
				$get_tmp = session::get($this->tmp_path); 
				$i = 0;
				if (!is_dir(public_path($this->upload_path))) {
					mkdir(public_path($this->upload_path));
				}
				if (!is_dir(public_path($this->upload_path .'/original'))) {
					mkdir(public_path($this->upload_path .'/original'));
				}					
				foreach ($get_tmp as $value) {
					$upload = new Image();
					$upload->img = $value['name'];
					$upload->thumbnail_img = $value['name'];
					$upload->save();
					if(\File::copy(public_path($this->tmp_path .'/' .$value['name']), public_path($this->upload_path .'/original/' .$value['name'])))
					{
						$file = array();
						$file['original'] = array(
								'name' => $value['name'],
								'path' => asset($this->upload_path.'/original/' . $value['name']),
								'size' => 'original',
							);
						// foreach ($this->resizes as $size) {
						// 	if (!is_dir(public_path($this->upload_path.'/'  . $size))) {
						// 		mkdir(public_path($this->upload_path.'/'  . $size));
						// 	}
						// 	if(!file_exists(public_path($this->upload_path.'/'. $size . '/' . $value['name'])))
						// 	{  
						// 		\File::copy(public_path($this->tmp_path .'/' .$value['name']), public_path($this->upload_path .'/'.$size.'/' .$value['name']));
						// 			//Image::make(public_path($this->upload_path.'/'  . $size . '/' . $value['name']))->resize($size, $size)->save();
						// 			$img = Image::make(public_path($this->upload_path.'/'  . $size . '/' . $value['name']));
						// 			$img->fit($size);
						// 			$img->save();
						// 			$file[$size] = array(
						// 				'name' => $value['name'],
						// 				'path' => asset($this->upload_path.'/'  . $size . '/' . $value['name']),
						// 				'size' => $size,
						// 			);
						// 	}											
						// }
						$files[] = $file;
						unset($get_tmp[$i]);
						@unlink(public_path($this->tmp_path.'/'.$value['name']));
					}
					$i++;
				}
				$response = array(
						'success' => true,
						'message' => 'Successfully.',
						'files'   => $files,
						'count'   => count(session::get($this->tmp_path)),
				); 
		}else{
			$response = array(
					'success' => false,
					'error'   => true,
					'message' => 'No image.',
					'count'   => count(session::get($this->tmp_path)),
			); 
		}
		return $response;
	}

	public static function generate($length = 8)
	{
		$chars = "0123456789011121314151617181920";
		$str = '';
		$size = strlen($chars);
		for ($i = 0; $i < $length; $i++) {
				$str .= $chars[rand(0, $size - 1)];
		}
		return $str;
	}

	public static function _human_filesize($bytes, $decimals = 2)
	{
			$sz = 'BKMGTP';
			$factor = floor((strlen($bytes) - 1) / 3);
			$sz = (@$sz[$factor] == 'B') ? @$sz[$factor]: @$sz[$factor] .'B';
			return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .$sz  ;
	}
}
