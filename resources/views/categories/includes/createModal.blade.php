
  <!-- The Modal -->
  <div class="modal" id="myModalAddCategory">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Category</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form id="frmAddCategory" action="{{ route('imagecrud.store') }}" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="category_name">Category Name</label>
              <input type="text" class="form-control" placeholder="Enter category_name" id="category_name" name="category_name">
            </div>
            <div class="form-group">
              <label for="image">Feature Image</label>
              <input type="file" class="form-control" id="image" name="image">
            </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="frmSave">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="frmAddClose">Close</button>
        </div>
          </form>
      </div>
    </div>
  </div>
