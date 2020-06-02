<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="{{asset('/assets/plupload/upload.css')}}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" crossorigin="anonymous">
	<meta name="_token" content="{{ csrf_token() }}">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
      <form action="{{URL::to($save_url)}}" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="card mt-5">
              <div class="card-header">
                <span>Upload</span>
              </div>
              <div class="card-body">
                <div 
                  class="list-image" 
                  data-token="{{csrf_token()}}"
                  data-limit-image="{{$limit_field}}" 
                  data-upload-url="{{$upload_url}}" 
                  data-delete-url="{{$delete_url}}"
                  data-rotate-url="{{$rotate_url}}"
                  data-allow-size="{{$allow_size}}">
                </div>                  
              </div>
              <div class="card-footer">
                {{-- <a href="#" class="btn btn-primary pull-left">Back</a> --}}
                <button type="submit" class="btn btn-success pull-right btn-sm">Upload</button>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" crossorigin="anonymous"></script>
  <script src="{{asset('/assets/plupload/upload.js')}}" type="text/javascript"></script>
  <script>
    $('.list-image').Upload();
  </script>
</body>
</html>