<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel 11 Product Management</title>


    <!-- =========================================================
         BOOTSTRAP
    ========================================================== -->

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- =========================================================
         DATATABLE
    ========================================================== -->

    <link
        href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css"
        rel="stylesheet"
    >


    <!-- =========================================================
         FONT AWESOME
    ========================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    <!-- =========================================================
         SWEETALERT
    ========================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"
    >


    <!-- =========================================================
         TOASTR
    ========================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
    >


    <!-- =========================================================
         TAGIFY
    ========================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css"
    >


    <!-- =========================================================
         DATE PICKER
    ========================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
    >


    <!-- =========================================================
         JAVASCRIPT LIBRARIES
    ========================================================== -->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>


    <!-- =========================================================
         CUSTOM CSS
    ========================================================== -->

    <style>

        :root {

            --primary: #6366f1;
            --primary-dark: #4f46e5;

            --secondary: #8b5cf6;

            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;

            --dark: #111827;

            --muted: #6b7280;

            --border: #e5e7eb;

            --bg: #f5f7fb;

            --card: #ffffff;

        }


        * {
            box-sizing: border-box;
        }


        body {

            background: var(--bg);

            color: #1f2937;

            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                sans-serif;

            transition:
                background .3s ease,
                color .3s ease;

        }


        /* =========================================================
           DASHBOARD WRAPPER
        ========================================================== */

        .dashboard-wrapper {

            max-width: 1600px;

            margin: 0 auto;

            padding: 30px;

        }


        /* =========================================================
           HEADER
        ========================================================== */

        .dashboard-header {

            position: relative;

            overflow: hidden;

            border-radius: 22px;

            padding: 30px;

            margin-bottom: 25px;

            color: #fff;

            background:
                radial-gradient(
                    circle at 90% 20%,
                    rgba(255,255,255,.18),
                    transparent 25%
                ),
                radial-gradient(
                    circle at 10% 90%,
                    rgba(255,255,255,.12),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #7c3aed 55%,
                    #9333ea
                );

            box-shadow:
                0 15px 40px rgba(79,70,229,.22);

        }


        .dashboard-header::before {

            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            right: -70px;
            top: -100px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.08);

        }


        .dashboard-header::after {

            content: "";

            position: absolute;

            width: 160px;
            height: 160px;

            left: 40%;
            bottom: -120px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.07);

        }


        .header-content {

            position: relative;

            z-index: 2;

        }


        .header-title {

            font-size: 30px;

            font-weight: 800;

            margin: 0;

            letter-spacing: -.5px;

        }


        .header-subtitle {

            margin: 8px 0 0;

            opacity: .85;

            font-size: 14px;

        }


        .header-actions {

            display: flex;

            align-items: center;

            gap: 10px;

        }


        .header-btn {

            border:
                1px solid rgba(255,255,255,.25);

            background:
                rgba(255,255,255,.12);

            color: #fff;

            backdrop-filter:
                blur(10px);

            border-radius: 10px;

            padding: 9px 14px;

            transition: .2s ease;

        }


        .header-btn:hover {

            background:
                rgba(255,255,255,.2);

            color: #fff;

            transform:
                translateY(-1px);

        }


        /* =========================================================
           STATISTICS
        ========================================================== */

        .stats-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;

            margin-bottom: 25px;

        }


        .stat-card {

            background:
                var(--card);

            border:
                1px solid var(--border);

            border-radius: 18px;

            padding: 20px;

            position: relative;

            overflow: hidden;

            transition: .25s ease;

            box-shadow:
                0 5px 18px rgba(15,23,42,.04);

        }


        .stat-card:hover {

            transform:
                translateY(-4px);

            box-shadow:
                0 12px 30px rgba(15,23,42,.09);

        }


        .stat-card::after {

            content: "";

            position: absolute;

            width: 100px;
            height: 100px;

            right: -45px;
            bottom: -50px;

            border-radius: 50%;

            background:
                rgba(99,102,241,.06);

        }


        .stat-icon {

            width: 46px;
            height: 46px;

            border-radius: 13px;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 18px;

            margin-bottom: 15px;

        }


        .stat-icon.primary {

            background: #eef2ff;

            color: #4f46e5;

        }


        .stat-icon.success {

            background: #ecfdf5;

            color: #059669;

        }


        .stat-icon.warning {

            background: #fffbeb;

            color: #d97706;

        }


        .stat-icon.danger {

            background: #fef2f2;

            color: #dc2626;

        }


        .stat-label {

            font-size: 13px;

            color: var(--muted);

            margin-bottom: 5px;

        }


        .stat-value {

            font-size: 27px;

            font-weight: 800;

            color: #111827;

        }


        /* =========================================================
           MAIN CARD
        ========================================================== */

        .main-card {

            background:
                var(--card);

            border:
                1px solid var(--border);

            border-radius: 20px;

            box-shadow:
                0 8px 30px rgba(15,23,42,.05);

            overflow: hidden;

        }


        .card-toolbar {

            padding: 22px 24px;

            border-bottom:
                1px solid var(--border);

        }


        .toolbar-title {

            font-size: 18px;

            font-weight: 750;

            margin: 0;

        }


        .toolbar-subtitle {

            font-size: 13px;

            color: var(--muted);

            margin-top: 4px;

        }


        /* =========================================================
           SEARCH
        ========================================================== */

        .search-wrapper {

            position: relative;

        }


        .search-wrapper i {

            position: absolute;

            left: 14px;

            top: 50%;

            transform:
                translateY(-50%);

            color: #9ca3af;

            z-index: 2;

        }


        .modern-input {

            height: 42px;

            border:
                1px solid #dfe3eb;

            border-radius: 10px;

            padding-left: 40px;

            font-size: 13px;

            transition: .2s ease;

            background: #fff;

        }


        .modern-input:focus {

            border-color:
                var(--primary);

            box-shadow:
                0 0 0 3px
                rgba(99,102,241,.1);

        }


        .modern-select {

            height: 42px;

            border:
                1px solid #dfe3eb;

            border-radius: 10px;

            font-size: 13px;

            transition: .2s ease;

            background-color: #fff;

        }


        .modern-select:focus {

            border-color:
                var(--primary);

            box-shadow:
                0 0 0 3px
                rgba(99,102,241,.1);

        }


        /* =========================================================
           BUTTONS
        ========================================================== */

        .btn-modern {

            border-radius: 10px;

            font-size: 13px;

            font-weight: 600;

            padding: 9px 14px;

            border: none;

            transition: .2s ease;

        }


        .btn-modern:hover {

            transform:
                translateY(-1px);

        }


        .btn-create {

            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #7c3aed
                );

            color: #fff;

            box-shadow:
                0 5px 15px
                rgba(99,102,241,.2);

        }


        .btn-create:hover {

            color: #fff;

            box-shadow:
                0 8px 20px
                rgba(99,102,241,.3);

        }


        .btn-bulk {

            background:
                #fee2e2;

            color:
                #dc2626;

        }


        .btn-bulk:disabled {

            opacity: .5;

        }


        .export-group {

            display: flex;

            gap: 6px;

            flex-wrap: wrap;

        }


        .export-btn {

            border:
                1px solid var(--border);

            background:
                #fff;

            color:
                #4b5563;

            border-radius:
                9px;

            padding:
                8px 12px;

            font-size:
                12px;

            font-weight:
                600;

            transition:
                .2s;

        }


        .export-btn:hover {

            background:
                #f8fafc;

            border-color:
                #c7d2fe;

            color:
                var(--primary);

        }


        /* =========================================================
           TABLE
        ========================================================== */

        .table-wrapper {

            overflow-x: auto;

        }


        .data-table {

            margin-bottom:
                0 !important;

            border:
                none !important;

            min-width:
                1250px;

        }


        .data-table thead th {

            background:
                #f8fafc !important;

            color:
                #64748b !important;

            border:
                none !important;

            border-bottom:
                1px solid var(--border) !important;

            font-size:
                11px;

            text-transform:
                uppercase;

            letter-spacing:
                .5px;

            font-weight:
                700;

            padding:
                14px 12px;

            white-space:
                nowrap;

        }


        .data-table tbody td {

            padding:
                14px 12px;

            border-color:
                #eef0f4 !important;

            vertical-align:
                middle;

            font-size:
                13px;

            color:
                #374151;

            background:
                #fff !important;

        }


        .data-table tbody tr {

            transition:
                .15s ease;

        }


        .data-table tbody tr:hover td {

            background:
                #fafbff !important;

        }


        /* =========================================================
           PRODUCT IMAGE
        ========================================================== */

        .product-thumb {

            width:
                42px;

            height:
                42px;

            border-radius:
                10px;

            object-fit:
                cover;

            border:
                1px solid #e5e7eb;

            background:
                #f8fafc;

        }


        .product-placeholder {

            width:
                42px;

            height:
                42px;

            border-radius:
                10px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                #eef2ff;

            color:
                #6366f1;

        }


        /* =========================================================
           INLINE EDITING
        ========================================================== */

        .inline-edit {

            cursor:
                pointer;

            padding:
                6px 9px;

            border-radius:
                8px;

            display:
                inline-block;

            min-width:
                80px;

            transition:
                .2s ease;

            border:
                1px dashed transparent;

            font-weight:
                600;

        }


        .inline-edit:hover {

            background:
                #eef2ff;

            border-color:
                #c7d2fe;

            color:
                #4f46e5;

        }


        .inline-edit-input {

            width:
                100%;

            min-width:
                130px;

            border-radius:
                8px !important;

        }


        .inline-edit-saving {

            opacity:
                .5;

            pointer-events:
                none;

        }


        /* =========================================================
           STATUS SWITCH
        ========================================================== */

        .status-toggle {

            cursor:
                pointer;

            width:
                2.5em !important;

            height:
                1.35em !important;

        }


        .status-toggle:checked {

            background-color:
                #10b981;

            border-color:
                #10b981;

        }


        .status-toggle:disabled {

            opacity:
                .5;

            cursor:
                wait;

        }


        /* =========================================================
           ACTION BUTTONS
        ========================================================== */

        .action-btn {

            width:
                32px;

            height:
                32px;

            border-radius:
                8px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            border:
                1px solid #e5e7eb;

            background:
                #fff;

            margin:
                2px;

            transition:
                .2s ease;

            font-size:
                12px;

            text-decoration:
                none;

        }


        .action-btn:hover {

            transform:
                translateY(-2px);

        }


        /* =========================================================
           MODAL
        ========================================================== */

        .modal-content {

            border:
                none;

            border-radius:
                18px;

            overflow:
                hidden;

            box-shadow:
                0 25px 70px
                rgba(15,23,42,.2);

        }


        .modal-header {

            padding:
                20px 24px;

            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #7c3aed
                );

            color:
                #fff;

            border:
                none;

        }


        .modal-header .btn-close {

            filter:
                brightness(0) invert(1);

            opacity:
                .8;

        }


        .modal-body {

            padding:
                25px;

        }


        .modal label {

            font-size:
                13px;

            font-weight:
                600;

            margin-bottom:
                6px;

            color:
                #374151;

        }


        .modal .form-control,
        .modal .form-select {

            border-radius:
                9px;

            border-color:
                #dfe3eb;

            min-height:
                42px;

        }


        .modal .form-control:focus,
        .modal .form-select:focus {

            border-color:
                var(--primary);

            box-shadow:
                0 0 0 3px
                rgba(99,102,241,.1);

        }


        /* =========================================================
           PRODUCT VIEW MODAL
        ========================================================== */

        .product-detail-item {

            padding:
                12px 0;

            border-bottom:
                1px solid #eef0f4;

        }


        .product-detail-label {

            color:
                #6b7280;

            font-size:
                12px;

            font-weight:
                600;

            text-transform:
                uppercase;

            margin-bottom:
                4px;

        }


        .product-detail-value {

            color:
                #111827;

            font-size:
                14px;

            font-weight:
                600;

        }


        .show-image {

            border-radius:
                12px;

            border:
                1px solid #e5e7eb;

            padding:
                4px;

            object-fit:
                cover;

        }


        /* =========================================================
           IMAGE PREVIEW
        ========================================================== */

        .image-preview {

            max-width:
                180px;

            max-height:
                180px;

            margin-top:
                12px;

            border-radius:
                12px;

            border:
                1px solid #e5e7eb;

            padding:
                4px;

            object-fit:
                cover;

        }


        /* =========================================================
           SKELETON
        ========================================================== */

        .skeleton-loader {

            border:
                none;

            padding:
                20px;

            margin:
                0;

            background:
                transparent;

        }


        .skeleton-loader .skeleton-title,
        .skeleton-loader .skeleton-text {

            background:
                linear-gradient(
                    90deg,
                    #f1f5f9 25%,
                    #e2e8f0 37%,
                    #f1f5f9 63%
                );

            background-size:
                400% 100%;

            animation:
                skeleton 1.4s ease infinite;

        }


        .skeleton-loader .skeleton-title {

            height:
                20px;

            margin-bottom:
                15px;

            border-radius:
                7px;

        }


        .skeleton-loader .skeleton-text {

            height:
                14px;

            margin-bottom:
                9px;

            border-radius:
                6px;

        }


        @keyframes skeleton {

            0% {
                background-position:
                    100% 0;
            }

            100% {
                background-position:
                    0 0;
            }

        }


        /* =========================================================
           DATATABLE
        ========================================================== */

        .dataTables_wrapper {

            padding:
                18px 22px;

        }


        .dataTables_wrapper
        .dataTables_length
        select,
        .dataTables_wrapper
        .dataTables_filter
        input {

            border:
                1px solid #dfe3eb;

            border-radius:
                8px;

            padding:
                6px 10px;

            outline:
                none;

        }


        .dataTables_wrapper
        .dataTables_filter
        input:focus {

            border-color:
                var(--primary);

        }


        .dataTables_wrapper
        .dataTables_paginate
        .paginate_button {

            border-radius:
                8px !important;

            border:
                none !important;

            margin:
                2px;

        }


        .dataTables_wrapper
        .dataTables_paginate
        .paginate_button.current {

            background:
                var(--primary) !important;

            color:
                #fff !important;

            border:
                none !important;

        }


        /* =========================================================
           DARK MODE
        ========================================================== */

        body.dark-mode {

            background:
                #0f172a;

            color:
                #e5e7eb;

        }


        .dark-mode .main-card,
        .dark-mode .stat-card {

            background:
                #1e293b;

            border-color:
                #334155;

            color:
                #e5e7eb;

        }


        .dark-mode .card-toolbar {

            border-color:
                #334155;

        }


        .dark-mode .toolbar-title,
        .dark-mode .stat-value {

            color:
                #f8fafc;

        }


        .dark-mode .toolbar-subtitle,
        .dark-mode .stat-label {

            color:
                #94a3b8;

        }


        .dark-mode .modern-input,
        .dark-mode .modern-select,
        .dark-mode .export-btn,
        .dark-mode .action-btn {

            background:
                #0f172a;

            color:
                #e5e7eb;

            border-color:
                #334155;

        }


        .dark-mode .data-table thead th {

            background:
                #172033 !important;

            color:
                #94a3b8 !important;

            border-color:
                #334155 !important;

        }


        .dark-mode .data-table tbody td {

            background:
                #1e293b !important;

            color:
                #dbeafe;

            border-color:
                #334155 !important;

        }


        .dark-mode .data-table tbody tr:hover td {

            background:
                #243147 !important;

        }


        .dark-mode .inline-edit:hover {

            background:
                #312e81;

            border-color:
                #4f46e5;

            color:
                #c7d2fe;

        }


        .dark-mode .stat-icon.primary {

            background:
                #312e81;

        }


        .dark-mode .stat-icon.success {

            background:
                #064e3b;

        }


        .dark-mode .stat-icon.warning {

            background:
                #78350f;

        }


        .dark-mode .stat-icon.danger {

            background:
                #7f1d1d;

        }


        .dark-mode .modal-content {

            background:
                #1e293b;

            color:
                #e5e7eb;

        }


        .dark-mode .modal label {

            color:
                #dbeafe;

        }


        .dark-mode .modal .form-control,
        .dark-mode .modal .form-select {

            background:
                #0f172a;

            color:
                #e5e7eb;

            border-color:
                #334155;

        }


        .dark-mode .product-detail-item {

            border-color:
                #334155;

        }


        .dark-mode .product-detail-label {

            color:
                #94a3b8;

        }


        .dark-mode .product-detail-value {

            color:
                #f8fafc;

        }


        .dark-mode
        .dataTables_wrapper
        .dataTables_length,
        .dark-mode
        .dataTables_wrapper
        .dataTables_filter,
        .dark-mode
        .dataTables_wrapper
        .dataTables_info {

            color:
                #94a3b8;

        }


        .dark-mode
        .dataTables_wrapper
        .dataTables_length
        select,
        .dark-mode
        .dataTables_wrapper
        .dataTables_filter
        input {

            background:
                #0f172a;

            color:
                #e5e7eb;

            border-color:
                #334155;

        }


        /* =========================================================
           RESPONSIVE
        ========================================================== */

        @media (max-width: 1200px) {

            .stats-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

        }


        @media (max-width: 768px) {

            .dashboard-wrapper {

                padding:
                    15px;

            }


            .dashboard-header {

                padding:
                    22px;

                border-radius:
                    16px;

            }


            .header-title {

                font-size:
                    23px;

            }


            .header-actions {

                margin-top:
                    18px;

            }


            .stats-grid {

                grid-template-columns:
                    1fr;

            }


            .card-toolbar {

                padding:
                    18px;

            }


            .export-group {

                margin-top:
                    12px;

            }

        }

    </style>

</head>


<body>


<div class="dashboard-wrapper">


    <!-- =========================================================
         DASHBOARD HEADER
    ========================================================== -->

    <div class="dashboard-header">

        <div class="header-content">

            <div class="d-flex flex-column flex-md-row
                        justify-content-between
                        align-items-md-center">

                <div>

                    <div class="d-flex align-items-center gap-3">

                        <div
                            style="
                                width:52px;
                                height:52px;
                                border-radius:14px;
                                background:rgba(255,255,255,.15);
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:22px;
                            "
                        >

                            <i class="fa-solid fa-boxes-stacked"></i>

                        </div>


                        <div>

                            <h1 class="header-title">
                                Product Management
                            </h1>

                            <p class="header-subtitle">
                                Manage products, inventory information
                                and product files from one place.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="header-actions">

                    <button
                        class="header-btn"
                        id="darkModeToggle"
                    >

                        <i class="fa-solid fa-moon"></i>

                        Dark Mode

                    </button>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================================
         STATISTICS
    ========================================================== -->

    <div class="stats-grid">


        <!-- TOTAL -->

        <div class="stat-card">

            <div class="stat-icon primary">

                <i class="fa-solid fa-box"></i>

            </div>

            <div class="stat-label">
                Total Products
            </div>

            <div
                class="stat-value"
                id="totalProducts"
            >
                0
            </div>

        </div>


        <!-- ACTIVE -->

        <div class="stat-card">

            <div class="stat-icon success">

                <i class="fa-solid fa-circle-check"></i>

            </div>

            <div class="stat-label">
                Active Products
            </div>

            <div
                class="stat-value"
                id="activeProducts"
            >
                0
            </div>

        </div>


        <!-- INACTIVE -->

        <div class="stat-card">

            <div class="stat-icon danger">

                <i class="fa-solid fa-circle-xmark"></i>

            </div>

            <div class="stat-label">
                Inactive Products
            </div>

            <div
                class="stat-value"
                id="inactiveProducts"
            >
                0
            </div>

        </div>


        <!-- CATEGORIES -->

        <div class="stat-card">

            <div class="stat-icon warning">

                <i class="fa-solid fa-layer-group"></i>

            </div>

            <div class="stat-label">
                Categories
            </div>

            <div
                class="stat-value"
                id="totalCategories"
            >
                0
            </div>

        </div>


    </div>


    <!-- =========================================================
         MAIN PRODUCT CARD
    ========================================================== -->

    <div class="main-card">


        <!-- =====================================================
             TOOLBAR
        ====================================================== -->

        <div class="card-toolbar">


            <div class="row align-items-center g-3">


                <div class="col-lg-4">

                    <h2 class="toolbar-title">

                        <i
                            class="fa-solid fa-cubes-stacked me-2"
                            style="color:#6366f1;"
                        ></i>

                        Products

                    </h2>


                    <div class="toolbar-subtitle">

                        Create, edit, search and manage your products.

                    </div>

                </div>


                <div class="col-lg-8">

                    <div
                        class="d-flex flex-wrap
                               justify-content-lg-end
                               gap-2"
                    >


                        <!-- CREATE -->

                        <button
                            class="btn btn-modern btn-create"
                            id="createNewProduct"
                        >

                            <i class="fa-solid fa-plus me-1"></i>

                            New Product

                        </button>


                        <!-- BULK DELETE -->

                        <button
                            class="btn btn-modern btn-bulk"
                            id="bulkDelete"
                            disabled
                        >

                            <i class="fa-solid fa-trash me-1"></i>

                            Bulk Delete

                        </button>


                        <!-- EXPORT -->

                        <div class="export-group">


                            <button
                                class="export-btn"
                                id="exportCsv"
                            >

                                <i
                                    class="fa-solid fa-file-csv me-1"
                                ></i>

                                CSV

                            </button>


                            <button
                                class="export-btn"
                                id="exportExcel"
                            >

                                <i
                                    class="fa-solid fa-file-excel me-1"
                                ></i>

                                Excel

                            </button>


                            <button
                                class="export-btn"
                                id="exportPdf"
                            >

                                <i
                                    class="fa-solid fa-file-pdf me-1"
                                ></i>

                                PDF

                            </button>


                            <button
                                class="export-btn"
                                id="printTable"
                            >

                                <i
                                    class="fa-solid fa-print me-1"
                                ></i>

                                Print

                            </button>


                        </div>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 SEARCH / FILTER
            ================================================== -->

            <div class="row g-2 mt-3">


                <!-- SEARCH -->

                <div class="col-lg-6">

                    <div class="search-wrapper">

                        <i
                            class="fa-solid fa-magnifying-glass"
                        ></i>

                        <input
                            type="text"
                            id="customSearch"
                            class="form-control modern-input"
                            placeholder="Search by product name, detail, category or brand..."
                        >

                    </div>

                </div>


                <!-- STATUS -->

                <div class="col-lg-3 col-md-6">

                    <select
                        id="customStatus"
                        class="form-select modern-select"
                    >

                        <option value="">
                            All Status
                        </option>

                        <option value="Active">
                            ● Active
                        </option>

                        <option value="Inactive">
                            ● Inactive
                        </option>

                    </select>

                </div>


                <!-- CATEGORY -->

                <div class="col-lg-3 col-md-6">

                    <select
                        id="customCategory"
                        class="form-select modern-select"
                    >

                        <option value="">
                            All Categories
                        </option>

                        <option value="Electronics">
                            Electronics
                        </option>

                        <option value="Clothing">
                            Clothing
                        </option>

                        <option value="Food">
                            Food
                        </option>

                    </select>

                </div>


            </div>

        </div>


        <!-- =====================================================
             SKELETON
        ====================================================== -->

        <div
            id="tableSkeleton"
            class="skeleton-loader"
            style="display:none;"
        >

            <div class="skeleton-title"></div>

            <div class="skeleton-text"></div>

            <div class="skeleton-text"></div>

            <div class="skeleton-text"></div>

            <div class="skeleton-text"></div>

        </div>


        <!-- =====================================================
             TABLE
        ====================================================== -->

        <div class="table-wrapper">


            <table class="table data-table">


                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            ID
                        </th>

                        <th>
                            Product
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Detail
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Brand
                        </th>

                        <th>
                            Expiry
                        </th>

                        <th>
                            Tags
                        </th>

                        <th>
                            File
                        </th>

                        <th width="280">

                            Actions

                            <input
                                type="checkbox"
                                id="selectAll"
                                class="form-check-input ms-2"
                            >

                        </th>

                    </tr>

                </thead>


                <tbody></tbody>


            </table>

        </div>


    </div>


</div>



<!-- =============================================================
     CREATE / EDIT PRODUCT MODAL
============================================================== -->

<div
    class="modal fade"
    id="ajaxModel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                <div>

                    <h4
                        class="modal-title mb-1"
                        id="modelHeading"
                    ></h4>

                    <small style="opacity:.8;">
                        Enter product information below.
                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <div class="modal-body">


                <form
                    id="productForm"
                    enctype="multipart/form-data"
                >


                    <input
                        type="hidden"
                        name="product_id"
                        id="product_id"
                    >


                    <!-- =================================================
                         NAME / CATEGORY
                    ================================================== -->

                    <div class="row">


                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Name
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    placeholder="Enter product name"
                                >

                                <small
                                    class="text-danger error-name"
                                ></small>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Category
                                </label>

                                <select
                                    id="category"
                                    name="category"
                                    class="form-select"
                                >

                                    <option value="">
                                        Select Category
                                    </option>

                                    <option value="Electronics">
                                        Electronics
                                    </option>

                                    <option value="Clothing">
                                        Clothing
                                    </option>

                                    <option value="Food">
                                        Food
                                    </option>

                                </select>

                            </div>

                        </div>


                    </div>


                    <!-- =================================================
                         STATUS / BRAND
                    ================================================== -->

                    <div class="row">


                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Status
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    class="form-select"
                                >

                                    <option value="">
                                        Select Status
                                    </option>

                                    <option value="Active">
                                        Active
                                    </option>

                                    <option value="Inactive">
                                        Inactive
                                    </option>

                                </select>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Brand
                                </label>

                                <input
                                    type="text"
                                    id="brand"
                                    name="brand"
                                    class="form-control"
                                    placeholder="Enter brand name"
                                >

                            </div>

                        </div>


                    </div>


                    <!-- =================================================
                         DETAIL
                    ================================================== -->

                    <div class="form-group mb-3">

                        <label>
                            Detail
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            id="detail"
                            name="detail"
                            class="form-control"
                        ></textarea>

                        <small
                            class="text-danger error-detail"
                        ></small>

                    </div>


                    <!-- =================================================
                         IMAGE / FILE
                    ================================================== -->

                    <div class="row">


                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Product Image
                                </label>

                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    class="form-control"
                                    accept="image/*"
                                >

                                <img
                                    id="imagePreview"
                                    class="image-preview"
                                    src=""
                                    alt="Image Preview"
                                >

                                <input
                                    type="hidden"
                                    name="existing_image"
                                    id="existing_image"
                                >

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Product File
                                </label>

                                <input
                                    type="file"
                                    id="file"
                                    name="file"
                                    class="form-control"
                                >

                                <small
                                    class="text-muted"
                                    id="existingFileName"
                                ></small>

                            </div>

                        </div>


                    </div>


                    <!-- =================================================
                         EXPIRY / TAGS
                    ================================================== -->

                    <div class="row">


                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Expiry Date
                                </label>

                                <div
                                    class="input-group date"
                                    id="expiryDatePicker"
                                >

                                    <input
                                        type="text"
                                        id="expiry_date"
                                        name="expiry_date"
                                        class="form-control"
                                        readonly
                                        placeholder="Select expiry date"
                                    >

                                    <span class="input-group-text">

                                        <i
                                            class="fa fa-calendar"
                                        ></i>

                                    </span>

                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Tags
                                </label>

                                <input
                                    type="text"
                                    id="tags"
                                    name="tags"
                                    class="form-control"
                                    value=""
                                    placeholder="Add product tags"
                                >

                            </div>

                        </div>


                    </div>


                    <!-- =================================================
                         SAVE
                    ================================================== -->

                    <div class="d-flex justify-content-end gap-2 mt-3">

                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            id="saveBtn"
                            class="btn btn-modern btn-create"
                        >

                            <i class="fa fa-save"></i>

                            Save Product

                        </button>

                    </div>


                </form>


            </div>

        </div>

    </div>

</div>



<!-- =============================================================
     SHOW PRODUCT MODAL
============================================================== -->

<div
    class="modal fade"
    id="showModel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                <div>

                    <h4 class="modal-title mb-1">

                        <i
                            class="fa-regular fa-eye me-2"
                        ></i>

                        Product Details

                    </h4>

                    <small style="opacity:.8;">
                        Complete product information
                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <div class="modal-body">


                <div class="row">


                    <!-- IMAGE -->

                    <div class="col-md-4 text-center mb-4">

                        <div
                            style="
                                background:#f8fafc;
                                border-radius:16px;
                                padding:20px;
                            "
                        >

                            <img
                                class="show-image"
                                src=""
                                alt="Product Image"
                                style="
                                    max-width:100%;
                                    max-height:250px;
                                "
                            >

                            <div
                                class="mt-3"
                                style="
                                    font-size:12px;
                                    color:#6b7280;
                                "
                            >
                                Product Image
                            </div>

                        </div>

                    </div>


                    <!-- DETAILS -->

                    <div class="col-md-8">


                        <div class="product-detail-item">

                            <div class="product-detail-label">
                                Product Name
                            </div>

                            <div
                                class="product-detail-value show-name"
                            ></div>

                        </div>


                        <div class="product-detail-item">

                            <div class="product-detail-label">
                                Category
                            </div>

                            <div
                                class="product-detail-value show-category"
                            ></div>

                        </div>


                        <div class="product-detail-item">

                            <div class="product-detail-label">
                                Status
                            </div>

                            <div
                                class="product-detail-value show-status"
                            ></div>

                        </div>


                        <div class="product-detail-item">

                            <div class="product-detail-label">
                                Brand
                            </div>

                            <div
                                class="product-detail-value show-brand"
                            ></div>

                        </div>


                        <div class="product-detail-item">

                            <div class="product-detail-label">
                                Expiry Date
                            </div>

                            <div
                                class="product-detail-value show-expiry-date"
                            ></div>

                        </div>


                        <div class="product-detail-item">

                            <div class="product-detail-label">
                                Tags
                            </div>

                            <div
                                class="product-detail-value show-tags"
                            ></div>

                        </div>


                    </div>


                </div>


                <!-- DETAIL -->

                <div class="product-detail-item">

                    <div class="product-detail-label">
                        Product Detail
                    </div>

                    <div
                        class="product-detail-value show-detail"
                    ></div>

                </div>


                <!-- FILE -->

                <div class="product-detail-item">

                    <div class="product-detail-label">
                        Product File
                    </div>

                    <a
                        href="#"
                        class="show-file btn btn-sm btn-outline-primary"
                        target="_blank"
                    >

                        <i class="fa-solid fa-download me-1"></i>

                        Download File

                    </a>

                </div>


            </div>

        </div>

    </div>

</div>



<script>

$(function () {


    /* =========================================================
       GLOBAL ERROR HANDLER
    ========================================================== */

    window.onerror = function(
        message,
        source,
        lineno,
        colno,
        error
    ) {

        console.error(
            'Global error:',
            message,
            source,
            lineno,
            colno,
            error
        );

        if (typeof toastr !== 'undefined') {

            toastr.error(
                'JavaScript error: ' + message,
                'Error'
            );

        }

        return false;

    };


    /* =========================================================
       CSRF
    ========================================================== */

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]').attr('content')

        }

    });


    /* =========================================================
       TOASTR
    ========================================================== */

    toastr.options = {

        closeButton: true,

        progressBar: true,

        positionClass:
            "toast-top-right"

    };


    /* =========================================================
       TAGIFY
    ========================================================== */

    var tagify =
        new Tagify(
            document.querySelector('#tags'),
            {

                whitelist: [],

                dropdown: {

                    enabled: 1,

                    maxItems: 20

                }

            }
        );


    /* =========================================================
       DATE PICKER
    ========================================================== */

    $('#expiryDatePicker').datepicker({

        format:
            'yyyy-mm-dd',

        autoclose:
            true,

        todayHighlight:
            true

    });


    /* =========================================================
       CKEDITOR
    ========================================================== */

    let editorInstance;


    if (
        typeof ClassicEditor !== 'undefined'
    ) {

        ClassicEditor
            .create(
                document.querySelector('#detail')
            )
            .then(
                editor => {

                    editorInstance =
                        editor;

                }
            )
            .catch(
                error => {

                    console.error(
                        'CKEditor init failed:',
                        error
                    );

                }
            );

    }


    /* =========================================================
       SYNC EDITOR
    ========================================================== */

    function syncDetailToTextarea() {

        if (
            editorInstance &&
            typeof editorInstance.getData === 'function'
        ) {

            $('#detail').val(
                editorInstance.getData()
            );

        }

    }


    /* =========================================================
       DATATABLE
    ========================================================== */

    var table =
        $('.data-table').DataTable({

            processing:
                true,

            serverSide:
                true,

            ajax: {

                url:
                    "{{ route('products.index') }}",

                data:
                    function(d) {

                        d.search =
                            $('#customSearch').val();

                        d.status =
                            $('#customStatus').val();

                        d.category =
                            $('#customCategory').val();

                    }

            },

            columns: [

                {
                    data: 'no',
                    name: 'no',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'id',
                    name: 'id'
                },

                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'name',
                    name: 'name'
                },

                {
                    data: 'detail',
                    name: 'detail'
                },

                {
                    data: 'category',
                    name: 'category'
                },

                {
                    data: 'status',
                    name: 'status'
                },

                {
                    data: 'brand',
                    name: 'brand'
                },

                {
                    data: 'expiry_date',
                    name: 'expiry_date'
                },

                {
                    data: 'tags',
                    name: 'tags',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'file',
                    name: 'file',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }

            ],

            order: [
                [3, 'asc']
            ],

            pageLength:
                10,

            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],

            drawCallback:
                function() {

                    $('#tableSkeleton')
                        .hide();

                    updateBulkDeleteButton();

                }

        });


    $('#tableSkeleton').show();


    /* =========================================================
       SEARCH / FILTER
    ========================================================== */

    $('#customSearch, #customStatus, #customCategory')
        .on(
            'keyup change',
            function() {

                $('#tableSkeleton').show();

                table.draw();

            }
        );


    /* =========================================================
       SELECT ALL
    ========================================================== */

    $('#selectAll').on(
        'click',
        function() {

            $('.select-row')
                .prop(
                    'checked',
                    this.checked
                );

            updateBulkDeleteButton();

        }
    );


    /* =========================================================
       INDIVIDUAL CHECKBOX
    ========================================================== */

    $('.data-table').on(
        'change',
        '.select-row',
        function() {

            updateBulkDeleteButton();

        }
    );


    /* =========================================================
       BULK DELETE BUTTON
    ========================================================== */

    function updateBulkDeleteButton() {

        var count =
            $('.select-row:checked').length;

        $('#bulkDelete')
            .prop(
                'disabled',
                count === 0
            );

    }


    /* =========================================================
       DASHBOARD STATISTICS
    ========================================================== */

    function updateDashboardStats() {

        $.ajax({

            url:
                "{{ route('products.index') }}",

            type:
                "GET",

            data: {

                stats:
                    true

            },

            success:
                function(response) {

                    if (
                        response.stats
                    ) {

                        $('#totalProducts')
                            .text(
                                response.stats.total
                            );

                        $('#activeProducts')
                            .text(
                                response.stats.active
                            );

                        $('#inactiveProducts')
                            .text(
                                response.stats.inactive
                            );

                        $('#totalCategories')
                            .text(
                                response.stats.categories
                            );

                    }

                },

            error:
                function(xhr) {

                    console.error(
                        'Statistics error:',
                        xhr
                    );

                }

        });

    }


    /* =========================================================
       LOAD STATISTICS
    ========================================================== */

    updateDashboardStats();


    /* =========================================================
       CREATE PRODUCT
    ========================================================== */

    $('#createNewProduct').click(
        function() {

            $('#productForm')
                .trigger("reset");

            $('#modelHeading')
                .text(
                    "Create New Product"
                );

            $('#product_id')
                .val('');

            $('#existing_image')
                .val('');

            $('#existingFileName')
                .text('');

            $('#imagePreview')
                .attr(
                    'src',
                    ''
                )
                .hide();

            $('#ajaxModel')
                .modal('show');

            tagify.removeAllTags();


            if (
                editorInstance &&
                typeof editorInstance.setData ===
                    'function'
            ) {

                editorInstance.setData('');

            }

        }
    );


    /* =========================================================
       SHOW PRODUCT
    ========================================================== */

    $('body').on(
        'click',
        '.showProduct',
        function() {

            var id =
                $(this).data('id');


            $.get(
                "/products/" + id,
                function(data) {


                    $('.show-name')
                        .text(
                            data.name || ''
                        );


                    $('.show-detail')
                        .html(
                            data.detail || ''
                        );


                    $('.show-category')
                        .text(
                            data.category || ''
                        );


                    $('.show-status')
                        .text(
                            data.status || ''
                        );


                    $('.show-brand')
                        .text(
                            data.brand || ''
                        );


                    $('.show-expiry-date')
                        .text(
                            data.expiry_date || ''
                        );


                    var tags =
                        data.tags
                            ? data.tags.join(', ')
                            : '';


                    $('.show-tags')
                        .text(
                            tags
                        );


                    if (data.image) {

                        $('.show-image')
                            .attr(
                                'src',
                                '/storage/' +
                                data.image
                            )
                            .show();

                    } else {

                        $('.show-image')
                            .hide();

                    }


                    if (data.file) {

                        $('.show-file')
                            .attr(
                                'href',
                                '/storage/' +
                                data.file
                            )
                            .show();

                    } else {

                        $('.show-file')
                            .hide();

                    }


                    $('#showModel')
                        .modal('show');

                }
            );

        }
    );


    /* =========================================================
       EDIT PRODUCT
    ========================================================== */

    $('body').on(
        'click',
        '.editProduct',
        function() {

            var id =
                $(this).data('id');


            $.get(
                "/products/" + id + "/edit",
                function(data) {


                    $('#modelHeading')
                        .text(
                            "Edit Product"
                        );


                    $('#product_id')
                        .val(
                            data.id
                        );


                    $('#name')
                        .val(
                            data.name
                        );


                    if (
                        editorInstance &&
                        typeof editorInstance.setData ===
                            'function'
                    ) {

                        editorInstance.setData(
                            data.detail || ''
                        );

                    } else {

                        $('#detail')
                            .val(
                                data.detail || ''
                            );

                    }


                    $('#category')
                        .val(
                            data.category || ''
                        );


                    $('#status')
                        .val(
                            data.status || ''
                        );


                    $('#brand')
                        .val(
                            data.brand || ''
                        );


                    $('#expiry_date')
                        .val(
                            data.expiry_date || ''
                        );


                    $('#existing_image')
                        .val(
                            data.image || ''
                        );


                    if (data.image) {

                        $('#imagePreview')
                            .attr(
                                'src',
                                '/storage/' +
                                data.image
                            )
                            .show();

                    } else {

                        $('#imagePreview')
                            .hide();

                    }


                    if (data.file) {

                        $('#existingFileName')
                            .text(
                                'Current file: ' +
                                data.file
                                    .split('/')
                                    .pop()
                            );

                    } else {

                        $('#existingFileName')
                            .text('');

                    }


                    tagify.removeAllTags();


                    if (data.tags) {

                        tagify.addTags(
                            data.tags
                        );

                    }


                    $('#ajaxModel')
                        .modal('show');

                }
            );

        }
    );


    /* =========================================================
       IMAGE PREVIEW
    ========================================================== */

    $('#image').on(
        'change',
        function() {

            var file =
                this.files[0];


            if (file) {

                var reader =
                    new FileReader();


                reader.onload =
                    function(e) {

                        $('#imagePreview')
                            .attr(
                                'src',
                                e.target.result
                            )
                            .show();

                    };


                reader.readAsDataURL(file);

            }

        }
    );


    /* =========================================================
       BUILD PAYLOAD
    ========================================================== */

    function buildPayload() {

        syncDetailToTextarea();


        var payload =
            new FormData();


        payload.append(
            '_token',
            $('meta[name="csrf-token"]').attr('content')
        );


        payload.append(
            'name',
            $('#name').val().trim()
        );


        payload.append(
            'detail',
            $('#detail').val().trim()
        );


        payload.append(
            'product_id',
            $('#product_id').val()
        );


        payload.append(
            'category',
            $('#category').val()
        );


        payload.append(
            'status',
            $('#status').val()
        );


        payload.append(
            'brand',
            $('#brand').val()
        );


        payload.append(
            'expiry_date',
            $('#expiry_date').val()
        );


        if (
            $('#tags').length &&
            tagify
        ) {

            var tags =
                tagify.value.map(
                    function(t) {

                        return t.value;

                    }
                );


            tags.forEach(
                function(tag) {

                    payload.append(
                        'tags[]',
                        tag
                    );

                }
            );

        }


        if (
            $('#image')[0].files.length
        ) {

            payload.append(
                'image',
                $('#image')[0].files[0]
            );

        }


        if (
            $('#file')[0].files.length
        ) {

            payload.append(
                'file',
                $('#file')[0].files[0]
            );

        }


        return payload;

    }


    /* =========================================================
       CREATE / UPDATE PRODUCT
    ========================================================== */

    $('#productForm').submit(
        function(e) {

            e.preventDefault();


            syncDetailToTextarea();


            if (
                !$('#name')
                    .val()
                    .trim()
            ) {

                toastr.error(
                    'Please enter a product name',
                    'Validation Error'
                );

                return;

            }


            if (
                !$('#detail')
                    .val()
                    .trim()
            ) {

                toastr.error(
                    'Please enter product details',
                    'Validation Error'
                );

                return;

            }


            var payload =
                buildPayload();


            $.ajax({

                url:
                    "{{ route('products.store') }}",

                type:
                    "POST",

                data:
                    payload,

                contentType:
                    false,

                processData:
                    false,


                beforeSend:
                    function() {

                        $('#saveBtn')
                            .prop(
                                'disabled',
                                true
                            )
                            .html(
                                '<i class="fa fa-spinner fa-spin"></i> Saving...'
                            );


                        $('.error-name, .error-detail')
                            .text('');

                    },


                success:
                    function(response) {


                        if (
                            response.success
                        ) {

                            $('#ajaxModel')
                                .modal('hide');


                            $('#productForm')[0]
                                .reset();


                            $('#customSearch')
                                .val('');


                            $('#customStatus')
                                .val('');


                            $('#customCategory')
                                .val('');


                            tagify.removeAllTags();


                            if (
                                editorInstance &&
                                typeof editorInstance.setData ===
                                    'function'
                            ) {

                                editorInstance.setData('');

                            }


                            $('#imagePreview')
                                .hide();


                            table.draw();


                            updateDashboardStats();


                            toastr.success(
                                response.success,
                                'Success'
                            );

                        }


                        $('#saveBtn')
                            .prop(
                                'disabled',
                                false
                            )
                            .html(
                                '<i class="fa fa-save"></i> Save Product'
                            );

                    },


                error:
                    function(xhr) {


                        if (
                            xhr.status === 422
                        ) {

                            var errors =
                                xhr.responseJSON.errors;


                            Object.keys(errors)
                                .forEach(
                                    function(key) {

                                        var el =
                                            $('.error-' + key);


                                        var msg =
                                            Array.isArray(
                                                errors[key]
                                            )
                                                ? errors[key][0]
                                                : errors[key];


                                        if (el.length) {

                                            el.text(msg);

                                        } else {

                                            toastr.error(
                                                msg,
                                                'Validation Error'
                                            );

                                        }

                                    }
                                );

                        }

                        else if (
                            xhr.status === 419
                        ) {

                            toastr.error(
                                'CSRF token mismatch. Please refresh the page.',
                                'Error'
                            );

                        }

                        else {

                            var message =
                                'Something went wrong. Status: ' +
                                xhr.status;


                            if (
                                xhr.responseJSON &&
                                xhr.responseJSON.message
                            ) {

                                message =
                                    xhr.responseJSON.message;

                            }


                            toastr.error(
                                message,
                                'Error'
                            );

                        }


                        $('#saveBtn')
                            .prop(
                                'disabled',
                                false
                            )
                            .html(
                                '<i class="fa fa-save"></i> Save Product'
                            );

                    }

            });

        }
    );


    /* =========================================================
       DELETE PRODUCT
    ========================================================== */

    $('body').on(
        'click',
        '.deleteProduct',
        function() {

            var id =
                $(this).data('id');


            Swal.fire({

                title:
                    'Are you sure?',

                text:
                    "You won't be able to revert this!",

                icon:
                    'warning',

                showCancelButton:
                    true,

                confirmButtonColor:
                    '#ef4444',

                cancelButtonColor:
                    '#6b7280',

                confirmButtonText:
                    'Yes, delete it!'

            }).then(
                function(result) {

                    if (
                        result.isConfirmed
                    ) {

                        $.ajax({

                            type:
                                "DELETE",

                            url:
                                "/products/" + id,

                            success:
                                function() {


                                    table.draw();


                                    updateDashboardStats();


                                    Swal.fire({

                                        icon:
                                            'success',

                                        title:
                                            'Deleted!',

                                        text:
                                            'Product has been deleted.',

                                        timer:
                                            1800,

                                        showConfirmButton:
                                            false

                                    });

                                },

                            error:
                                function(xhr) {

                                    toastr.error(
                                        xhr.responseJSON?.message ||
                                        'Unable to delete product.',
                                        'Error'
                                    );

                                }

                        });

                    }

                }
            );

        }
    );


    /* =========================================================
       STATUS TOGGLE
    ========================================================== */

    $('body').on(
        'change',
        '.status-toggle',
        function() {

            var checkbox =
                $(this);

            var id =
                checkbox.data('id');


            checkbox.prop(
                'disabled',
                true
            );


            $.ajax({

                url:
                    "{{ url('/products') }}/" +
                    id +
                    "/toggle-status",

                type:
                    "POST",


                success:
                    function(response) {


                        if (
                            response.success
                        ) {

                            toastr.success(
                                response.message,
                                'Status Updated'
                            );


                            updateDashboardStats();

                        }

                        else {

                            checkbox.prop(
                                'checked',
                                !checkbox.prop('checked')
                            );


                            toastr.error(
                                response.message ||
                                'Unable to update status.',
                                'Error'
                            );

                        }

                    },


                error:
                    function(xhr) {


                        checkbox.prop(
                            'checked',
                            !checkbox.prop('checked')
                        );


                        var message =
                            'Unable to update product status.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }


                        toastr.error(
                            message,
                            'Error'
                        );

                    },


                complete:
                    function() {

                        checkbox.prop(
                            'disabled',
                            false
                        );

                    }

            });

        }
    );


    /* =========================================================
       DUPLICATE PRODUCT
    ========================================================== */

    $('body').on(
        'click',
        '.duplicateProduct',
        function() {

            var id =
                $(this).data('id');


            Swal.fire({

                title:
                    'Duplicate Product?',

                text:
                    'A copy of this product will be created.',

                icon:
                    'question',

                showCancelButton:
                    true,

                confirmButtonColor:
                    '#f59e0b',

                cancelButtonColor:
                    '#6b7280',

                confirmButtonText:
                    'Yes, Duplicate'

            }).then(
                function(result) {


                    if (
                        !result.isConfirmed
                    ) {

                        return;

                    }


                    $.ajax({

                        url:
                            "{{ url('/products') }}/" +
                            id +
                            "/duplicate",

                        type:
                            "POST",


                        beforeSend:
                            function() {

                                Swal.fire({

                                    title:
                                        'Duplicating...',

                                    text:
                                        'Please wait while the product is being copied.',

                                    allowOutsideClick:
                                        false,

                                    allowEscapeKey:
                                        false,

                                    didOpen:
                                        function() {

                                            Swal.showLoading();

                                        }

                                });

                            },


                        success:
                            function(response) {


                                if (
                                    response.success
                                ) {


                                    table.ajax.reload(
                                        null,
                                        false
                                    );


                                    updateDashboardStats();


                                    Swal.fire({

                                        icon:
                                            'success',

                                        title:
                                            'Duplicated!',

                                        text:
                                            response.message,

                                        timer:
                                            1800,

                                        showConfirmButton:
                                            false

                                    });


                                }

                                else {

                                    Swal.fire(
                                        'Error',
                                        response.message ||
                                        'Unable to duplicate product.',
                                        'error'
                                    );

                                }

                            },


                        error:
                            function(xhr) {


                                var message =
                                    'Unable to duplicate the product.';


                                if (
                                    xhr.responseJSON &&
                                    xhr.responseJSON.message
                                ) {

                                    message =
                                        xhr.responseJSON.message;

                                }


                                Swal.fire(
                                    'Error',
                                    message,
                                    'error'
                                );

                            }

                    });

                }
            );

        }
    );


    /* =========================================================
       INLINE EDITING
    ========================================================== */

    $('body').on(
        'click',
        '.inline-edit',
        function() {


            var element =
                $(this);


            if (
                element.find(
                    'input, select'
                ).length > 0
            ) {

                return;

            }


            var id =
                element.data('id');


            var field =
                element.data('field');


            var value =
                element.data('value') || '';


            var originalHtml =
                element.html();


            /* =================================================
               CATEGORY
            ================================================== */

            if (
                field === 'category'
            ) {


                var select =
                    $('<select>')
                        .addClass(
                            'form-select form-select-sm inline-edit-input'
                        );


                select.append(

                    $('<option>', {

                        value:
                            '',

                        text:
                            'Select Category'

                    })

                );


                select.append(

                    $('<option>', {

                        value:
                            'Electronics',

                        text:
                            'Electronics'

                    })

                );


                select.append(

                    $('<option>', {

                        value:
                            'Clothing',

                        text:
                            'Clothing'

                    })

                );


                select.append(

                    $('<option>', {

                        value:
                            'Food',

                        text:
                            'Food'

                    })

                );


                select.append(

                    $('<option>', {

                        value:
                            'Other',

                        text:
                            'Other'

                    })

                );


                select.val(
                    value
                );


                element
                    .empty()
                    .append(select);


                select.focus();


                select.on(
                    'change',
                    function() {


                        saveInlineEdit(

                            element,

                            id,

                            field,

                            $(this).val(),

                            originalHtml

                        );

                    }
                );


                select.on(
                    'keydown',
                    function(e) {


                        if (
                            e.key === 'Escape'
                        ) {

                            element
                                .removeClass(
                                    'inline-edit-saving'
                                )
                                .html(
                                    originalHtml
                                );

                        }

                    }
                );


            }


            /* =================================================
               NAME / BRAND
            ================================================== */

            else {


                var input =
                    $('<input>')
                        .attr(
                            'type',
                            'text'
                        )
                        .val(
                            value
                        )
                        .addClass(
                            'form-control form-control-sm inline-edit-input'
                        );


                element
                    .empty()
                    .append(input);


                input.focus();


                input.select();


                input.on(
                    'keydown',
                    function(e) {


                        if (
                            e.key === 'Enter'
                        ) {

                            e.preventDefault();


                            saveInlineEdit(

                                element,

                                id,

                                field,

                                $(this).val(),

                                originalHtml

                            );

                        }


                        if (
                            e.key === 'Escape'
                        ) {

                            element
                                .removeClass(
                                    'inline-edit-saving'
                                )
                                .html(
                                    originalHtml
                                );

                        }

                    }
                );


                input.on(
                    'blur',
                    function() {


                        setTimeout(
                            function() {


                                if (
                                    element.find(
                                        'input'
                                    ).length > 0
                                ) {

                                    saveInlineEdit(

                                        element,

                                        id,

                                        field,

                                        input.val(),

                                        originalHtml

                                    );

                                }


                            },
                            150
                        );

                    }
                );

            }

        }
    );


    /* =========================================================
       SAVE INLINE EDIT
    ========================================================== */

    function saveInlineEdit(
        element,
        id,
        field,
        value,
        originalHtml
    ) {


        if (
            element.hasClass(
                'inline-edit-saving'
            )
        ) {

            return;

        }


        value =
            $.trim(value);


        if (
            field === 'name' &&
            value === ''
        ) {


            toastr.error(
                'Product name cannot be empty.',
                'Validation Error'
            );


            element
                .removeClass(
                    'inline-edit-saving'
                )
                .html(
                    originalHtml
                );


            return;

        }


        element.addClass(
            'inline-edit-saving'
        );


        $.ajax({

            url:
                "{{ url('/products') }}/" +
                id +
                "/inline-update",

            type:
                "PATCH",

            data: {

                field:
                    field,

                value:
                    value

            },


            success:
                function(response) {


                    if (
                        response.success
                    ) {


                        var displayValue =
                            response.value ||
                            'Not Set';


                        element
                            .data(
                                'value',
                                response.value || ''
                            )
                            .removeClass(
                                'inline-edit-saving'
                            )
                            .text(
                                displayValue
                            );


                        toastr.success(
                            response.message,
                            'Updated'
                        );


                    }

                    else {


                        element
                            .removeClass(
                                'inline-edit-saving'
                            )
                            .html(
                                originalHtml
                            );


                        toastr.error(
                            response.message ||
                            'Update failed.',
                            'Error'
                        );

                    }

                },


            error:
                function(xhr) {


                    element
                        .removeClass(
                            'inline-edit-saving'
                        )
                        .html(
                            originalHtml
                        );


                    var message =
                        'Unable to update product.';


                    if (
                        xhr.responseJSON &&
                        xhr.responseJSON.message
                    ) {

                        message =
                            xhr.responseJSON.message;

                    }


                    toastr.error(
                        message,
                        'Error'
                    );

                }

        });

    }


    /* =========================================================
       BULK DELETE
    ========================================================== */

    $('#bulkDelete').click(
        function() {


            var ids = [];


            $('.select-row:checked')
                .each(
                    function() {

                        ids.push(
                            $(this).data('id')
                        );

                    }
                );


            if (
                ids.length === 0
            ) {

                return;

            }


            Swal.fire({

                title:
                    'Delete Selected Products?',

                text:
                    'All selected products will be permanently deleted.',

                icon:
                    'warning',

                showCancelButton:
                    true,

                confirmButtonColor:
                    '#ef4444',

                cancelButtonColor:
                    '#6b7280',

                confirmButtonText:
                    'Yes, delete them!'

            }).then(
                function(result) {


                    if (
                        result.isConfirmed
                    ) {


                        $.ajax({

                            url:
                                "{{ route('products.bulkDelete') }}",

                            type:
                                "POST",

                            data: {

                                ids:
                                    ids

                            },


                            success:
                                function() {


                                    table.draw();


                                    updateDashboardStats();


                                    $('#selectAll')
                                        .prop(
                                            'checked',
                                            false
                                        );


                                    updateBulkDeleteButton();


                                    Swal.fire({

                                        icon:
                                            'success',

                                        title:
                                            'Deleted!',

                                        text:
                                            'Selected products have been deleted.',

                                        timer:
                                            1800,

                                        showConfirmButton:
                                            false

                                    });

                                },


                            error:
                                function(xhr) {


                                    toastr.error(
                                        xhr.responseJSON?.message ||
                                        'Unable to delete selected products.',
                                        'Error'
                                    );

                                }

                        });

                    }

                }
            );

        }
    );


    /* =========================================================
       CSV EXPORT
    ========================================================== */

    $('#exportCsv').click(
        function() {

            window.location.href =
                "{{ route('products.export.csv') }}";

        }
    );


    /* =========================================================
       EXCEL EXPORT
    ========================================================== */

    $('#exportExcel').click(
        function() {

            window.location.href =
                "{{ route('products.export.excel') }}";

        }
    );


    /* =========================================================
       PDF EXPORT
    ========================================================== */

    $('#exportPdf').click(
        function() {

            window.location.href =
                "{{ route('products.export.pdf') }}";

        }
    );


    /* =========================================================
       PRINT
    ========================================================== */

    $('#printTable').click(
        function() {


            var printContents =
                $('.data-table').clone();


            var printWindow =
                window.open(
                    '',
                    '_blank'
                );


            printWindow.document.write(

                '<html>' +
                '<head>' +
                '<title>Products</title>' +

                '<link href="' +
                'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css' +
                '" rel="stylesheet">' +

                '</head>' +

                '<body>' +

                '<div class="container-fluid mt-4">' +

                '<h3 class="mb-4">Product List</h3>' +

                printContents.prop(
                    'outerHTML'
                ) +

                '</div>' +

                '</body>' +

                '</html>'

            );


            printWindow.document.close();


            printWindow.focus();


            setTimeout(
                function() {

                    printWindow.print();

                    printWindow.close();

                },
                500
            );

        }
    );


    /* =========================================================
       DARK MODE
    ========================================================== */

    $('#darkModeToggle').click(
        function() {


            $('body')
                .toggleClass(
                    'dark-mode'
                );


            var isDark =
                $('body')
                    .hasClass(
                        'dark-mode'
                    );


            $(this).html(

                isDark

                    ? '<i class="fa-solid fa-sun"></i> Light Mode'

                    : '<i class="fa-solid fa-moon"></i> Dark Mode'

            );


            localStorage.setItem(

                'darkMode',

                isDark
                    ? 'enabled'
                    : 'disabled'

            );

        }
    );


    /* =========================================================
       LOAD DARK MODE
    ========================================================== */

    if (
        localStorage.getItem(
            'darkMode'
        ) === 'enabled'
    ) {


        $('body')
            .addClass(
                'dark-mode'
            );


        $('#darkModeToggle')
            .html(
                '<i class="fa-solid fa-sun"></i> Light Mode'
            );

    }


});
</script>


</body>

</html>