<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Ajax CRUD - Fixed</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
    <div class="card mt-5 shadow">
        <h2 class="card-header"><i class="fa-regular fa-credit-card"></i> Laravel 11 Ajax CRUD</h2>
        <div class="card-body">
            <div class="text-end mb-3">
                <button class="btn btn-success btn-sm" id="createNewProduct">
                    <i class="fa fa-plus"></i> Create New Product
                </button>
            </div>
            <table class="table table-bordered data-table w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Details</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                   <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group mb-2">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" maxlength="50" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="control-label">Details</label>
                        <textarea id="detail" name="detail" required placeholder="Enter Details" class="form-control"></textarea>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product Details</h4>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span class="show-name"></span></p>
                <p><strong>Detail:</strong> <span class="show-detail"></span></p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(function () {
      
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
      
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('products.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'detail', name: 'detail'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
    $('#createNewProduct').click(function () {
        $('#saveBtn').val("create-product");
        $('#product_id').val(''); // <--- આ લાઈન થી નવો ડેટા ઉમેરાશે, ઓવરરાઈટ નહીં થાય
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });
      
    $('body').on('click', '.editProduct', function () {
      var product_id = $(this).data('id');
      $.get("{{ route('products.index') }}" +'/' + product_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Product");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#product_id').val(data.id);
          $('#name').val(data.name);
          $('#detail').val(data.detail);
      })
    });

    $('body').on('click', '.showProduct', function () {
      var product_id = $(this).data('id');
      $.get("{{ route('products.index') }}" +'/' + product_id, function (data) {
          $('.show-name').text(data.name);
          $('.show-detail').text(data.detail);
          $('#showModel').modal('show');
      })
    });
      
    $('#productForm').submit(function (e) {
        e.preventDefault();
        $(this).find('#saveBtn').html('Sending...');
      
        $.ajax({
          data: $(this).serialize(),
          url: "{{ route('products.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
              $('#productForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              $('#saveBtn').html('Save');
              table.draw();
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save');
          }
      });
    });
      
    $('body').on('click', '.deleteProduct', function () {
        var product_id = $(this).data("id");
        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                type: "DELETE",
                url: "{{ route('products.index') }}"+'/'+product_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });
  });
</script>
</body>
</html>