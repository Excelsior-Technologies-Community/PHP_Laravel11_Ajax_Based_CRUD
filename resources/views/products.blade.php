<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Ajax CRUD</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <style>
        .dark-mode {
            background-color: #1a1a1a;
            color: #e0e0e0;
        }
        .dark-mode .card {
            background-color: #2d2d2d;
            color: #e0e0e0;
        }
        .dark-mode .card-header {
            background-color: #3d3d3d;
            color: #e0e0e0;
        }
        .dark-mode .table {
            color: #e0e0e0;
        }
        .dark-mode .table thead th {
            background-color: #3d3d3d;
            color: #e0e0e0;
        }
        .dark-mode .table tbody td {
            background-color: #2d2d2d;
            color: #e0e0e0;
        }
        .dark-mode .form-control {
            background-color: #3d3d3d;
            color: #e0e0e0;
            border-color: #555;
        }
        .dark-mode .modal-content {
            background-color: #2d2d2d;
            color: #e0e0e0;
        }
        .dark-mode .modal-header {
            border-bottom-color: #555;
        }
        .dark-mode .modal-footer {
            border-top-color: #555;
        }
        .dark-mode label {
            color: #e0e0e0;
        }
        .skeleton-loader {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
        }
        .skeleton-loader .skeleton-title {
            height: 20px;
            background: #eee;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .skeleton-loader .skeleton-text {
            height: 15px;
            background: #eee;
            margin-bottom: 5px;
            border-radius: 4px;
        }
        .dark-mode .skeleton-loader .skeleton-title,
        .dark-mode .skeleton-loader .skeleton-text {
            background: #444;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
        }
        .dark-mode .select2-container--default .select2-selection--single {
            background-color: #3d3d3d;
            color: #e0e0e0;
            border-color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card mt-5 shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0"><i class="fa-regular fa-credit-card"></i> Laravel 11 Ajax CRUD</h2>
            <button class="btn btn-sm btn-outline-secondary" id="darkModeToggle">
                <i class="fa-solid fa-moon"></i> Dark Mode
            </button>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <button class="btn btn-success btn-sm" id="createNewProduct">
                        <i class="fa fa-plus"></i> Create New Product
                    </button>
                    <button class="btn btn-danger btn-sm" id="bulkDelete" disabled>
                        <i class="fa fa-trash"></i> Bulk Delete
                    </button>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success" id="exportCsv">
                            <i class="fa fa-file-csv"></i> CSV
                        </button>
                        <button class="btn btn-sm btn-primary" id="exportExcel">
                            <i class="fa fa-file-excel"></i> Excel
                        </button>
                        <button class="btn btn-sm btn-danger" id="exportPdf">
                            <i class="fa fa-file-pdf"></i> PDF
                        </button>
                        <button class="btn btn-sm btn-info" id="printTable">
                            <i class="fa fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="customSearch" class="form-control" placeholder="Search products...">
                </div>
                <div class="col-md-2">
                    <select id="customStatus" class="form-control">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="customCategory" class="form-control">
                        <option value="">All Categories</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Clothing">Clothing</option>
                        <option value="Food">Food</option>
                    </select>
                </div>
            </div>

            <div id="tableSkeleton" class="skeleton-loader" style="display: none;">
                <div class="skeleton-title"></div>
                <div class="skeleton-text"></div>
                <div class="skeleton-text"></div>
                <div class="skeleton-text"></div>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Detail</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Brand</th>
                        <th>Expiry Date</th>
                        <th>Tags</th>
                        <th>File</th>
                        <th width="280px">
                            <input type="checkbox" id="selectAll">
                        </th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    </div>
</div>

<!-- PRODUCT CREATE/EDIT MODAL -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="productForm" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" id="product_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Name: <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control">
                                <small class="text-danger error-name"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Category:</label>
                                <select id="category" name="category" class="form-control">
                                    <option value="">Select Category</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Clothing">Clothing</option>
                                    <option value="Food">Food</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Status:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Brand:</label>
                                <input type="text" id="brand" name="brand" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label>Detail: <span class="text-danger">*</span></label>
                        <textarea id="detail" name="detail" class="form-control"></textarea>
                        <small class="text-danger error-detail"></small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Image:</label>
                                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                                <img id="imagePreview" class="image-preview" src="" alt="Image Preview">
                                <input type="hidden" name="existing_image" id="existing_image">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>File:</label>
                                <input type="file" id="file" name="file" class="form-control">
                                <small class="text-muted" id="existingFileName"></small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Expiry Date:</label>
                                <div class="input-group date" id="expiryDatePicker">
                                    <input type="text" id="expiry_date" name="expiry_date" class="form-control" readonly>
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Tags:</label>
                                <input type="text" id="tags" name="tags" class="form-control" value=''>
                            </div>
                        </div>
                    </div>

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
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa-regular fa-eye"></i> Product Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Name:</strong> <span class="show-name"></span></p>
                <p><strong>Detail:</strong> <span class="show-detail"></span></p>
                <p><strong>Category:</strong> <span class="show-category"></span></p>
                <p><strong>Status:</strong> <span class="show-status"></span></p>
                <p><strong>Brand:</strong> <span class="show-brand"></span></p>
                <p><strong>Expiry Date:</strong> <span class="show-expiry-date"></span></p>
                <p><strong>Tags:</strong> <span class="show-tags"></span></p>
                <p><strong>Image:</strong> <img class="show-image" src="" alt="Product Image" style="max-width: 200px;"></p>
                <p><strong>File:</strong> <a href="#" class="show-file" target="_blank">Download File</a></p>
            </div>

        </div>
    </div>
</div>

<script>
$(function () {
    window.onerror = function(message, source, lineno, colno, error) {
        console.error('Global error:', message, source, lineno, colno, error);
        toastr.error('JavaScript error: ' + message, 'Error');
        return false;
    };

    $.ajaxSetup({
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
        }
    });

    var tagify = new Tagify(document.querySelector('#tags'), {
        whitelist: [],
        dropdown: {
            enabled: 1,
            maxItems: 20
        }
    });

    $('#expiryDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('products.index') }}",
            data: function (d) {
                d.search = $('#customSearch').val();
                d.status = $('#customStatus').val();
                d.category = $('#customCategory').val();
            }
        },
        columns: [
            {data: 'no', name: 'no', orderable: false, searchable: false},
            {data: 'id', name: 'id'},
            {data: 'image', name: 'image', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'detail', name: 'detail'},
            {data: 'category', name: 'category'},
            {data: 'status', name: 'status'},
            {data: 'brand', name: 'brand'},
            {data: 'expiry_date', name: 'expiry_date'},
            {data: 'tags', name: 'tags', orderable: false, searchable: false},
            {data: 'file', name: 'file', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [[3, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        drawCallback: function() {
            $('#tableSkeleton').hide();
        }
    });

    $('#tableSkeleton').show();

    $('#customSearch, #customStatus, #customCategory').on('keyup change', function() {
        table.draw();
    });

    $('#selectAll').on('click', function() {
        $('.select-row').prop('checked', this.checked);
        updateBulkDeleteButton();
    });

    $('.data-table').on('change', '.select-row', function() {
        updateBulkDeleteButton();
    });

    function updateBulkDeleteButton() {
        var count = $('.select-row:checked').length;
        $('#bulkDelete').prop('disabled', count === 0);
    }

    $('#createNewProduct').click(function () {
        $('#productForm').trigger("reset");
        $('#modelHeading').text("Create New Product");
        $('#existing_image').val('');
        $('#existingFileName').text('');
        $('#imagePreview').hide();
        $('#ajaxModel').modal('show');
        tagify.removeAllTags();
        if (editorInstance && typeof editorInstance.setData === 'function') {
            editorInstance.setData('');
        }
    });

    $('body').on('click', '.showProduct', function () {
        var id = $(this).data('id');
        $.get("/products/" + id, function (data) {
            $('.show-name').text(data.name);
            $('.show-detail').text(data.detail);
            $('.show-category').text(data.category || '');
            $('.show-status').text(data.status || '');
            $('.show-brand').text(data.brand || '');
            $('.show-expiry-date').text(data.expiry_date || '');
            var tags = data.tags ? data.tags.join(', ') : '';
            $('.show-tags').text(tags);
            if (data.image) {
                $('.show-image').attr('src', '/storage/' + data.image).show();
            } else {
                $('.show-image').hide();
            }
            if (data.file) {
                $('.show-file').attr('href', '/storage/' + data.file).show();
            } else {
                $('.show-file').hide();
            }
            $('#showModel').modal('show');
        });
    });

    $('body').on('click', '.editProduct', function () {
        var id = $(this).data('id');
        $.get("/products/" + id + "/edit", function (data) {
            $('#modelHeading').text("Edit Product");
            $('#product_id').val(data.id);
            $('#name').val(data.name);
            $('#detail').val(data.detail);
            $('#category').val(data.category || '');
            $('#status').val(data.status || '');
            $('#brand').val(data.brand || '');
            $('#expiry_date').val(data.expiry_date || '');
            $('#existing_image').val(data.image || '');
            if (data.image) {
                $('#imagePreview').attr('src', '/storage/' + data.image).show();
            }
            if (data.file) {
                $('#existingFileName').text('Current file: ' + data.file.split('/').pop());
            }
            if (data.tags) {
                tagify.removeAllTags();
                tagify.addTags(data.tags);
            }
            $('#ajaxModel').modal('show');
        });
    });

    $('#image').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(file);
        }
    });

    let editorInstance;

    if (typeof ClassicEditor !== 'undefined') {
        ClassicEditor
            .create(document.querySelector('#detail'))
            .then(editor => {
                editorInstance = editor;
            })
            .catch(error => {
                console.error('CKEditor init failed:', error);
            });
    } else {
        console.warn('CKEditor not loaded. Using plain textarea.');
    }

    function syncDetailToTextarea() {
        if (editorInstance && typeof editorInstance.getData === 'function') {
            $('#detail').val(editorInstance.getData());
        }
    }

    function buildPayload() {
        syncDetailToTextarea();

        var payload = new FormData();
        payload.append('_token', $('meta[name="csrf-token"]').attr('content'));
        payload.append('name', $('#name').val().trim());
        payload.append('detail', $('#detail').val().trim());
        payload.append('product_id', $('#product_id').val());
        payload.append('category', $('#category').val());
        payload.append('status', $('#status').val());
        payload.append('brand', $('#brand').val());
        payload.append('expiry_date', $('#expiry_date').val());

        if ($('#tags').length && tagify) {
            var tags = tagify.value.map(function(t) { return t.value; });
            tags.forEach(function(tag) {
                payload.append('tags[]', tag);
            });
        }

        if ($('#image')[0].files.length) {
            payload.append('image', $('#image')[0].files[0]);
        }

        if ($('#file')[0].files.length) {
            payload.append('file', $('#file')[0].files[0]);
        }

        for (var pair of payload.entries()) {
            console.log('Payload:', pair[0], pair[1]);
        }

        return payload;
    }

    $('#productForm').submit(function (e) {
        try {
            e.preventDefault();

            console.log('Form submitted');
            console.log('Name:', $('#name').val());
            console.log('Detail textarea raw:', $('#detail').val());

            syncDetailToTextarea();
            console.log('Detail after sync:', $('#detail').val());

            if (!$('#name').val().trim()) {
                toastr.error('Please enter a product name', 'Validation Error');
                return;
            }

            if (!$('#detail').val().trim()) {
                toastr.error('Please enter product details', 'Validation Error');
                return;
            }

            var payload = buildPayload();

            $.ajax({
                url: "{{ route('products.store') }}",
                type: "POST",
                data: payload,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#saveBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                    $('.error-name, .error-detail').text('');
                },
                success: function (response) {
                    console.log('Success:', response);
                    if (response.success) {
                        $('#ajaxModel').modal('hide');
                        $('#productForm')[0].reset();
                        $('#customSearch').val('');
                        $('#customStatus').val('');
                        $('#customCategory').val('');
                        table.draw();
                        toastr.success(response.success, 'Success');
                    }
                    $('#saveBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Save');
                },
                error: function(xhr) {
                    console.log('Error status:', xhr.status);
                    console.log('Error response:', xhr.responseJSON);
                    
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        console.log('Validation errors:', errors);
                        Object.keys(errors).forEach(function(key) {
                            var el = $('.error-' + key);
                            var msg = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
                            if (el.length) {
                                el.text(msg);
                            } else {
                                toastr.error(msg, 'Validation Error');
                            }
                        });
                    } else if (xhr.status === 419) {
                        toastr.error('CSRF token mismatch. Please refresh the page.', 'Error');
                    } else {
                        var message = 'Something went wrong. Status: ' + xhr.status;
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        toastr.error(message, 'Error');
                    }
                    $('#saveBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Save');
                }
            });
        } catch (error) {
            console.error('Form submission error:', error);
            toastr.error('An error occurred: ' + error.message, 'Error');
            $('#saveBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Save');
        }
    });

    $('body').on('click', '.deleteProduct', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/products/" + id,
                    success: function () {
                        table.draw();
                        Swal.fire('Deleted!', 'Product has been deleted.', 'success');
                    }
                });
            }
        });
    });

    $('#bulkDelete').click(function () {
        var ids = [];
        $('.select-row:checked').each(function() {
            ids.push($(this).data('id'));
        });

        if (ids.length === 0) return;

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('products.bulkDelete') }}",
                    type: "POST",
                    data: { ids: ids },
                    success: function () {
                        table.draw();
                        Swal.fire('Deleted!', 'Products have been deleted.', 'success');
                        $('#selectAll').prop('checked', false);
                        updateBulkDeleteButton();
                    }
                });
            }
        });
    });

    $('#exportCsv').click(function() {
        window.location.href = "{{ route('products.export.csv') }}";
    });

    $('#exportExcel').click(function() {
        window.location.href = "{{ route('products.export.excel') }}";
    });

    $('#exportPdf').click(function() {
        window.location.href = "{{ route('products.export.pdf') }}";
    });

    $('#printTable').click(function() {
        var printContents = $('.data-table').clone();
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<div class="container">');
        printWindow.document.write(printContents.prop('outerHTML'));
        printWindow.document.write('</div>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });

    $('#darkModeToggle').click(function() {
        $('body').toggleClass('dark-mode');
        var isDark = $('body').hasClass('dark-mode');
        $(this).html(isDark ? '<i class="fa-solid fa-sun"></i> Light Mode' : '<i class="fa-solid fa-moon"></i> Dark Mode');
        localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
    });

    if (localStorage.getItem('darkMode') === 'enabled') {
        $('body').addClass('dark-mode');
        $('#darkModeToggle').html('<i class="fa-solid fa-sun"></i> Light Mode');
    }

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right"
    };
});
</script>

</body>
</html>
