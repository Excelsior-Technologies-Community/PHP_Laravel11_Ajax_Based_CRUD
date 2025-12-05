<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Ajax CRUD</title>

    <!-- CSRF Token for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- MAIN PAGE CONTAINER -->
<div class="container">

    <!-- Card Box -->
    <div class="card mt-5 shadow">
        <h2 class="card-header"><i class="fa-regular fa-credit-card"></i> Laravel 11 Ajax CRUD</h2>

        <div class="card-body">

            <!-- Create Button -->
            <div class="text-end mb-3">
                <button class="btn btn-success btn-sm" id="createNewProduct">
                    <i class="fa fa-plus"></i> Create New Product
                </button>
            </div>

            <!-- DataTable -->
            <table class="table table-bordered data-table">
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

<!-- PRODUCT CREATE/EDIT MODAL -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>

            <!-- Modal Form -->
            <div class="modal-body">

                <form id="productForm">

                    <input type="hidden" name="product_id" id="product_id">

                    @csrf

                    <!-- Name Input -->
                    <div class="form-group mb-2">
                        <label>Name:</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>

                    <!-- Detail Input -->
                    <div class="form-group mb-2">
                        <label>Detail:</label>
                        <textarea id="detail" name="detail" class="form-control"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="saveBtn" class="btn btn-success">
                        <i class="fa fa-save"></i> Save
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>

<!-- SHOW PRODUCT MODAL -->
<div class="modal fade" id="showModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa-regular fa-eye"></i> Product Details</h4>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <p><strong>Name:</strong> <span class="show-name"></span></p>
                <p><strong>Detail:</strong> <span class="show-detail"></span></p>
            </div>

        </div>
    </div>
</div>

<!-- MAIN SCRIPT -->
<script>
$(function () {

    /*------------------------------------------
       Setup AJAX CSRF token
    -------------------------------------------*/
    $.ajaxSetup({
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
        }
    });

    /*------------------------------------------
       Initialize DataTable
    -------------------------------------------*/
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,        // Server-side processing
        ajax: "{{ route('products.index') }}",  // Fetch data
        columns: [
            {data: 'id', name: 'id'},           // Product ID
            {data: 'name', name: 'name'},       // Product Name
            {data: 'detail', name: 'detail'},   // Product Detail
            {data: 'action', name: 'action', orderable: false, searchable: false}, // Action buttons
        ]
    });

    /*------------------------------------------
       Open Create Product Modal
    -------------------------------------------*/
    $('#createNewProduct').click(function () {
        $('#productForm').trigger("reset");
        $('#modelHeading').text("Create New Product");
        $('#ajaxModel').modal('show');
    });

    /*------------------------------------------
       Show Product Details
    -------------------------------------------*/
    $('body').on('click', '.showProduct', function () {
        var id = $(this).data('id');

        $.get("/products/" + id, function (data) {
            $('.show-name').text(data.name);
            $('.show-detail').text(data.detail);
            $('#showModel').modal('show');
        });
    });

    /*------------------------------------------
       Edit Product Modal
    -------------------------------------------*/
    $('body').on('click', '.editProduct', function () {
        var id = $(this).data('id');

        $.get("/products/" + id + "/edit", function (data) {
            $('#modelHeading').text("Edit Product");
            $('#ajaxModel').modal('show');

            $('#product_id').val(data.id);
            $('#name').val(data.name);
            $('#detail').val(data.detail);
        });
    });

    /*------------------------------------------
       SAVE / UPDATE PRODUCT
    -------------------------------------------*/
    $('#productForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('products.store') }}",  // POST
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,

            success: function () {
                $('#ajaxModel').modal('hide');
                table.draw(); // Refresh table
            }
        });
    });

    /*------------------------------------------
       DELETE PRODUCT
    -------------------------------------------*/
    $('body').on('click', '.deleteProduct', function () {

        if(!confirm("Are you sure?")) return;

        var id = $(this).data('id');

        $.ajax({
            type: "DELETE",
            url: "/products/" + id,
            success: function () {
                table.draw(); // refresh table
            }
        });

    });

});
</script>

</body>
</html>
