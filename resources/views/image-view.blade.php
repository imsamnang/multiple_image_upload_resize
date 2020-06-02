<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Boostrap Fileinput</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/css/fileinput.min.css" rel="stylesheet" crossorigin="anonymous">
  {{-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous"> --}}
  <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" rel="stylesheet">

  <style>
    .main-section {
      margin: 0 auto;
      padding: 20px;
      margin-top: 100px;
      background-color: #fff;
      box-shadow: 0px 0px 20px #c1c1c1;
    }
  </style>
</head>
<body class="bg-info">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-sm12 col-11 main-section">
        <h1 class="text-center text-danger">Muliple Images Upload</h1>
        {{ csrf_field() }}
        <div class="form-group">
          <input type="file" name="file" id="file-1" class="form-control file" data-overwrite-initial="false"
          data-min-file-count="2" multiple>
        </div>
      </div>
    </div>  
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/js/fileinput.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/themes/fa/theme.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script>
    $('#file-1').fileinput({
      theme: "fa",
      uploadUrl : '/image/submit',
      uploadExtraData:function(){
        return {
          _token:$("input[name='_token']").val()
        };
      },
      allowedFileExtensions:['jpg','jpeg','png','gif'],
      overwriteinitial:false,
      maxFileSize:2024,
      maxFileNum:8,
      slugCallback:function(filename){
        return filename.replace('(','_').replace(']','_');
      }
    });
  </script>
</body>
</html>