<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 4 Example</title>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
</head>
<body>

<div class="container">
  <h1 class="text-center text-danger">Laravel Ajax crud with image upload</h1>
  <!-- Button to Open the Modal -->
  <button type="button" id="AddData" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalAddCategory">
    Add New Category
  </button>
</div>

  @include('categories.includes.createModal')

  <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

  <script type="text/javaScript">
    $(document).ready(function(){
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      //save data to database
      $('#frmAddCategory').on('submit',function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
          type: "POST",
          url: "{{ route('imagecrud.store') }}",
          data: formData,
          dataType: "JSON",
          contentType:false,
          cache:false,
          processData:false,
          success: function (response) {
            console.log(response)
            alert('success')
          }
        });
      });
    });
  </script>
</body>
</html>