<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Product listing + AJAX DataTable + statistics
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */
        if ($request->boolean('stats')) {

            $today = Carbon::today();
            $next30Days = Carbon::today()->addDays(30);

            return response()->json([
                'total' => Product::count(),

                'active' => Product::where('status', 'active')->count(),

                'inactive' => Product::where('status', 'inactive')->count(),

                'categories' => Product::whereNotNull('category')
                    ->distinct()
                    ->count('category'),

                'expired' => Product::whereDate(
                    'expiry_date',
                    '<',
                    $today
                )->count(),

                'expiring_soon' => Product::whereDate(
                    'expiry_date',
                    '>=',
                    $today
                )
                    ->whereDate(
                        'expiry_date',
                        '<=',
                        $next30Days
                    )
                    ->count(),

                'trash' => Product::onlyTrashed()->count(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | AJAX DataTable
        |--------------------------------------------------------------------------
        */
        if ($request->ajax()) {

            $query = Product::query()
                ->select([
                    'id',
                    'image',
                    'name',
                    'detail',
                    'category',
                    'status',
                    'brand',
                    'expiry_date',
                    'tags',
                    'file',
                    'created_at',
                ]);

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */
            $search = $request->input('search.value');

            if (!empty($search)) {

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('detail', 'like', '%' . $search . '%')
                        ->orWhere('category', 'like', '%' . $search . '%')
                        ->orWhere('brand', 'like', '%' . $search . '%')
                        ->orWhere('tags', 'like', '%' . $search . '%');

                    /*
                    |--------------------------------------------------------------------------
                    | Search By ID
                    |--------------------------------------------------------------------------
                    */
                    if (is_numeric($search)) {
                        $q->orWhere('id', (int) $search);
                    }
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Status Filter
            |--------------------------------------------------------------------------
            */
            if ($request->filled('status')) {

                $query->where(
                    'status',
                    $request->input('status')
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Category Filter
            |--------------------------------------------------------------------------
            */
            if ($request->filled('category')) {

                $query->where(
                    'category',
                    $request->input('category')
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Brand Filter
            |--------------------------------------------------------------------------
            */
            if ($request->filled('brand')) {

                $query->where(
                    'brand',
                    $request->input('brand')
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Expiry Filter
            |--------------------------------------------------------------------------
            */
            if ($request->filled('expiry_filter')) {

                $today = Carbon::today();

                $next30Days = Carbon::today()->addDays(30);

                switch ($request->input('expiry_filter')) {

                    case 'expired':

                        $query->whereDate(
                            'expiry_date',
                            '<',
                            $today
                        );

                        break;

                    case 'expiring_soon':

                        $query->whereDate(
                            'expiry_date',
                            '>=',
                            $today
                        )
                            ->whereDate(
                                'expiry_date',
                                '<=',
                                $next30Days
                            );

                        break;

                    case 'valid':

                        $query->whereDate(
                            'expiry_date',
                            '>',
                            $next30Days
                        );

                        break;

                    case 'no_expiry':

                        $query->whereNull('expiry_date');

                        break;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Created Date From
            |--------------------------------------------------------------------------
            */
            if ($request->filled('date_from')) {

                $query->whereDate(
                    'created_at',
                    '>=',
                    $request->input('date_from')
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Created Date To
            |--------------------------------------------------------------------------
            */
            if ($request->filled('date_to')) {

                $query->whereDate(
                    'created_at',
                    '<=',
                    $request->input('date_to')
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Server Side Sorting
            |--------------------------------------------------------------------------
            */
            $allowedSorts = [
                'id',
                'name',
                'category',
                'status',
                'brand',
                'expiry_date',
                'created_at',
            ];

            $sortBy = $request->input(
                'sort_by',
                'created_at'
            );

            $sortOrder = strtolower(
                $request->input(
                    'sort_order',
                    'desc'
                )
            );

            if (!in_array($sortBy, $allowedSorts)) {
                $sortBy = 'created_at';
            }

            if (!in_array($sortOrder, ['asc', 'desc'])) {
                $sortOrder = 'desc';
            }

            $query->orderBy(
                $sortBy,
                $sortOrder
            );

            /*
            |--------------------------------------------------------------------------
            | DataTable Response
            |--------------------------------------------------------------------------
            */
            return DataTables::of($query)

                /*
                |--------------------------------------------------------------------------
                | Sequential Row Number
                |
                | This gives:
                | 1
                | 2
                | 3
                | 4
                | ...
                |
                | It does NOT show database IDs.
                |--------------------------------------------------------------------------
                */
                ->addIndexColumn()

                /*
                |--------------------------------------------------------------------------
                | Image
                |--------------------------------------------------------------------------
                */
                ->addColumn('image', function ($row) {

                    if (!$row->image) {

                        return '<span class="text-muted">
                                    No Image
                                </span>';
                    }

                    $url = asset(
                        'storage/' . $row->image
                    );

                    return '
                        <img
                            src="' . $url . '"
                            width="50"
                            height="50"
                            class="rounded object-fit-cover"
                            alt="Product"
                        >
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Product Name Inline Edit
                |--------------------------------------------------------------------------
                */
                ->editColumn('name', function ($row) {

                    return '
                        <span
                            class="inline-edit"
                            data-id="' . $row->id . '"
                            data-field="name"
                            contenteditable="true"
                        >
                            ' . e($row->name) . '
                        </span>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Category Inline Edit
                |--------------------------------------------------------------------------
                */
                ->editColumn('category', function ($row) {

                    return '
                        <span
                            class="inline-edit"
                            data-id="' . $row->id . '"
                            data-field="category"
                            contenteditable="true"
                        >
                            ' . e($row->category) . '
                        </span>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Brand Inline Edit
                |--------------------------------------------------------------------------
                */
                ->editColumn('brand', function ($row) {

                    return '
                        <span
                            class="inline-edit"
                            data-id="' . $row->id . '"
                            data-field="brand"
                            contenteditable="true"
                        >
                            ' . e($row->brand) . '
                        </span>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Status Toggle
                |--------------------------------------------------------------------------
                */
                ->editColumn('status', function ($row) {

                    $checked = $row->status === 'active'
                        ? 'checked'
                        : '';

                    return '
                        <div class="form-check form-switch">

                            <input
                                class="form-check-input status-toggle"
                                type="checkbox"
                                data-id="' . $row->id . '"
                                ' . $checked . '
                            >

                        </div>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Expiry Date
                |--------------------------------------------------------------------------
                */
                ->editColumn('expiry_date', function ($row) {

                    if (!$row->expiry_date) {

                        return '
                            <span class="badge bg-secondary">
                                No Expiry
                            </span>
                        ';
                    }

                    $date = Carbon::parse(
                        $row->expiry_date
                    );

                    $today = Carbon::today();

                    $next30Days = Carbon::today()
                        ->addDays(30);

                    if ($date->lt($today)) {

                        $badge = 'danger';

                        $text = 'Expired';

                    } elseif (
                        $date->gte($today) &&
                        $date->lte($next30Days)
                    ) {

                        $badge = 'warning';

                        $text = 'Expiring Soon';

                    } else {

                        $badge = 'success';

                        $text = 'Valid';
                    }

                    return '
                        <span class="badge bg-' . $badge . '">
                            ' . $text . '
                        </span>

                        <br>

                        <small>
                            ' . $date->format('d M Y') . '
                        </small>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Tags
                |--------------------------------------------------------------------------
                */
                ->editColumn('tags', function ($row) {

                    if (!$row->tags) {

                        return '
                            <span class="text-muted">
                                No Tags
                            </span>
                        ';
                    }

                    $tags = json_decode(
                        $row->tags,
                        true
                    );

                    if (!is_array($tags)) {

                        return e($row->tags);
                    }

                    return collect($tags)
                        ->map(function ($tag) {

                            return '
                                <span
                                    class="badge bg-light text-dark border me-1"
                                >
                                    ' . e($tag) . '
                                </span>
                            ';
                        })
                        ->implode('');
                })

                /*
                |--------------------------------------------------------------------------
                | File
                |--------------------------------------------------------------------------
                */
                ->editColumn('file', function ($row) {

                    if (!$row->file) {

                        return '
                            <span class="text-muted">
                                No File
                            </span>
                        ';
                    }

                    $url = asset(
                        'storage/' . $row->file
                    );

                    return '
                        <a
                            href="' . $url . '"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Download
                        </a>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Actions
                |--------------------------------------------------------------------------
                */
                ->addColumn('actions', function ($row) {

                    return '
                        <div class="d-flex gap-1">

                            <input
                                type="checkbox"
                                class="product-checkbox"
                                value="' . $row->id . '"
                            >

                            <button
                                type="button"
                                class="btn btn-sm btn-info showProduct"
                                data-id="' . $row->id . '"
                            >
                                View
                            </button>

                            <button
                                type="button"
                                class="btn btn-sm btn-primary editProduct"
                                data-id="' . $row->id . '"
                            >
                                Edit
                            </button>

                            <button
                                type="button"
                                class="btn btn-sm btn-secondary duplicateProduct"
                                data-id="' . $row->id . '"
                            >
                                Duplicate
                            </button>

                            <button
                                type="button"
                                class="btn btn-sm btn-danger deleteProduct"
                                data-id="' . $row->id . '"
                            >
                                Delete
                            </button>

                        </div>
                    ';
                })

                /*
                |--------------------------------------------------------------------------
                | Allow HTML
                |--------------------------------------------------------------------------
                */
                ->rawColumns([
                    'image',
                    'name',
                    'category',
                    'status',
                    'brand',
                    'expiry_date',
                    'tags',
                    'file',
                    'actions',
                ])

                ->make(true);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Dropdown Data
        |--------------------------------------------------------------------------
        */
        $categories = Product::query()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        $brands = Product::query()
            ->whereNotNull('brand')
            ->distinct()
            ->pluck('brand');

        return view(
            'products',
            compact(
                'categories',
                'brands'
            )
        );
    }


    /**
     * Store / Update Product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'detail' => 'nullable|string',

            'category' => 'nullable|string|max:255',

            'status' => 'required|in:active,inactive',

            'brand' => 'nullable|string|max:255',

            'expiry_date' => 'nullable|date',

            'tags' => 'nullable',

            'image' => 'nullable|image|max:5120',

            'file' => 'nullable|file|max:10240',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {

            $validated['image'] =
                $request->file('image')
                    ->store(
                        'products/images',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | Upload File
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('file')) {

            $validated['file'] =
                $request->file('file')
                    ->store(
                        'products/files',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | Convert Tags To JSON
        |--------------------------------------------------------------------------
        */
        if ($request->filled('tags')) {

            $tags = $request->input('tags');

            if (is_string($tags)) {

                $tags = array_filter(
                    array_map(
                        'trim',
                        explode(',', $tags)
                    )
                );
            }

            $validated['tags'] =
                json_encode(
                    array_values($tags)
                );

        } else {

            $validated['tags'] = json_encode([]);
        }


        /*
        |--------------------------------------------------------------------------
        | Update Existing Product
        |--------------------------------------------------------------------------
        */
        $productId = $request->input('product_id');

        if ($productId) {

            $product = Product::withTrashed()
                ->findOrFail($productId);

            if ($product->trashed()) {

                $product->restore();
            }

            $product->update($validated);

        } else {

            /*
            |--------------------------------------------------------------------------
            | Create New Product
            |--------------------------------------------------------------------------
            */
            Product::create($validated);
        }


        return response()->json([

            'success' => true,

            'message' =>
                'Product saved successfully.',
        ]);
    }


    /**
     * Show Product
     */
    public function show(Product $product)
    {
        return response()->json([

            'success' => true,

            'product' => $product,
        ]);
    }


    /**
     * Edit Product
     */
    public function edit(Product $product)
    {
        return response()->json([

            'success' => true,

            'product' => $product,
        ]);
    }


    /**
     * Soft Delete Product
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([

            'success' => true,

            'message' =>
                'Product moved to trash.',
        ]);
    }


    /**
     * Bulk Soft Delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([

            'ids' => 'required|array',

            'ids.*' => 'integer',
        ]);


        Product::whereIn(
            'id',
            $request->input('ids')
        )->delete();


        return response()->json([

            'success' => true,

            'message' =>
                'Selected products moved to trash.',
        ]);
    }


    /**
     * Toggle Product Status
     *
     * IMPORTANT:
     * Route must contain {id}
     */
    public function toggleStatus(
        Request $request,
        $id
    ) {
        $request->validate([

            'status' =>
                'required|in:active,inactive',
        ]);


        $product = Product::findOrFail($id);


        $product->update([

            'status' =>
                $request->input('status'),
        ]);


        return response()->json([

            'success' => true,

            'message' =>
                'Status updated successfully.',
        ]);
    }


    /**
     * Duplicate Product
     */
    public function duplicate(Product $product)
    {
        $newProduct =
            $product->replicate();

        $newProduct->name =
            $product->name . ' Copy';

        $newProduct->save();


        return response()->json([

            'success' => true,

            'message' =>
                'Product duplicated successfully.',

            'product' => $newProduct,
        ]);
    }


    /**
     * Inline Update
     */
    public function inlineUpdate(
        Request $request
    ) {
        $request->validate([

            'id' =>
                'required|integer',

            'field' =>
                'required|in:name,category,brand',

            'value' =>
                'nullable|string|max:255',
        ]);


        $product =
            Product::findOrFail(
                $request->input('id')
            );


        $product->update([

            $request->input('field') =>
                $request->input('value'),
        ]);


        return response()->json([

            'success' => true,

            'message' =>
                'Product updated successfully.',
        ]);
    }


    /**
     * CSV Export
     */
    public function exportCsv()
    {
        $products = Product::all();

        $filename = 'products.csv';


        $headers = [

            'Content-Type' =>
                'text/csv',

            'Content-Disposition' =>
                'attachment; filename="' .
                $filename .
                '"',
        ];


        $callback =
            function () use ($products) {

                $file =
                    fopen(
                        'php://output',
                        'w'
                    );


                fputcsv(
                    $file,
                    [
                        'ID',
                        'Name',
                        'Detail',
                        'Category',
                        'Status',
                        'Brand',
                        'Expiry Date',
                        'Tags',
                    ]
                );


                foreach ($products as $product) {

                    fputcsv(
                        $file,
                        [
                            $product->id,
                            $product->name,
                            $product->detail,
                            $product->category,
                            $product->status,
                            $product->brand,
                            $product->expiry_date,
                            $product->tags,
                        ]
                    );
                }


                fclose($file);
            };


        return response()->stream(
            $callback,
            200,
            $headers
        );
    }


    /**
     * Excel Export
     */
    public function exportExcel()
    {
        return Excel::download(
            new ProductsExport,
            'products.xlsx'
        );
    }


    /**
     * PDF Export
     */
    public function exportPdf()
    {
        $products = Product::all();


        $pdf = app(
            'dompdf.wrapper'
        );


        $pdf->loadView(
            'products_pdf',
            compact('products')
        );


        return $pdf->download(
            'products.pdf'
        );
    }


    /**
     * Bulk Status Change
     */
    public function bulkStatus(
        Request $request
    ) {
        $request->validate([

            'ids' =>
                'required|array',

            'ids.*' =>
                'integer',

            'status' =>
                'required|in:active,inactive',
        ]);


        Product::whereIn(
            'id',
            $request->input('ids')
        )->update([

            'status' =>
                $request->input('status'),
        ]);


        return response()->json([

            'success' => true,

            'message' =>
                'Status changed successfully.',
        ]);
    }


    /**
     * Trash Listing
     */
  public function trash()
{
    $products = Product::onlyTrashed()
        ->latest('deleted_at')
        ->paginate(10);

    return view('products.trash', compact('products'));
}


    /**
     * Restore Product
     */
    public function restore($id)
    {
        $product =
            Product::onlyTrashed()
                ->findOrFail($id);


        $product->restore();


        return response()->json([

            'success' => true,

            'message' =>
                'Product restored successfully.',
        ]);
    }


    /**
     * Permanently Delete Product
     */
    public function forceDelete($id)
    {
        $product =
            Product::onlyTrashed()
                ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */
        if ($product->image) {

            Storage::disk('public')
                ->delete(
                    $product->image
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete File
        |--------------------------------------------------------------------------
        */
        if ($product->file) {

            Storage::disk('public')
                ->delete(
                    $product->file
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Permanent Delete
        |--------------------------------------------------------------------------
        */
        $product->forceDelete();


        return response()->json([

            'success' => true,

            'message' =>
                'Product permanently deleted.',
        ]);
    }


    /**
     * Bulk Restore
     */
    public function bulkRestore(
        Request $request
    ) {
        $request->validate([

            'ids' =>
                'required|array',

            'ids.*' =>
                'integer',
        ]);


        Product::onlyTrashed()
            ->whereIn(
                'id',
                $request->input('ids')
            )
            ->restore();


        return response()->json([

            'success' => true,

            'message' =>
                'Products restored successfully.',
        ]);
    }


    /**
     * Bulk Permanent Delete
     */
    public function bulkForceDelete(
        Request $request
    ) {
        $request->validate([

            'ids' =>
                'required|array',

            'ids.*' =>
                'integer',
        ]);


        $products =
            Product::onlyTrashed()
                ->whereIn(
                    'id',
                    $request->input('ids')
                )
                ->get();


        foreach ($products as $product) {

            if ($product->image) {

                Storage::disk('public')
                    ->delete(
                        $product->image
                    );
            }


            if ($product->file) {

                Storage::disk('public')
                    ->delete(
                        $product->file
                    );
            }


            $product->forceDelete();
        }


        return response()->json([

            'success' => true,

            'message' =>
                'Products permanently deleted.',
        ]);
    }


    /**
     * Excel Import
     */
    public function importExcel(
        Request $request
    ) {
        $request->validate([

            'file' =>
                'required|mimes:xlsx,xls,csv|max:10240',
        ]);


        Excel::import(
            new ProductsImport,
            $request->file('file')
        );


        return response()->json([

            'success' => true,

            'message' =>
                'Products imported successfully.',
        ]);
    }


    /**
     * Expiry Statistics
     */
    public function expiryStats()
    {
        $today =
            Carbon::today();

        $next30Days =
            Carbon::today()
                ->addDays(30);


        $expired =
            Product::whereDate(
                'expiry_date',
                '<',
                $today
            )->count();


        $expiringSoon =
            Product::whereDate(
                'expiry_date',
                '>=',
                $today
            )
                ->whereDate(
                    'expiry_date',
                    '<=',
                    $next30Days
                )
                ->count();


        $valid =
            Product::whereDate(
                'expiry_date',
                '>',
                $next30Days
            )->count();


        $noExpiry =
            Product::whereNull(
                'expiry_date'
            )->count();


        return response()->json([

            'expired' =>
                $expired,

            'expiring_soon' =>
                $expiringSoon,

            'valid' =>
                $valid,

            'no_expiry' =>
                $noExpiry,
        ]);
    }


    /**
     * API Product List
     */
    public function apiList(
        Request $request
    ) {
        $query =
            Product::query();


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->input('status')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */
        if ($request->filled('category')) {

            $query->where(
                'category',
                $request->input('category')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Brand
        |--------------------------------------------------------------------------
        */
        if ($request->filled('brand')) {

            $query->where(
                'brand',
                $request->input('brand')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Expiry Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('expiry_filter')) {

            $today =
                Carbon::today();

            $next30Days =
                Carbon::today()
                    ->addDays(30);


            switch (
                $request->input(
                    'expiry_filter'
                )
            ) {

                case 'expired':

                    $query->whereDate(
                        'expiry_date',
                        '<',
                        $today
                    );

                    break;


                case 'expiring_soon':

                    $query->whereDate(
                        'expiry_date',
                        '>=',
                        $today
                    )
                        ->whereDate(
                            'expiry_date',
                            '<=',
                            $next30Days
                        );

                    break;


                case 'valid':

                    $query->whereDate(
                        'expiry_date',
                        '>',
                        $next30Days
                    );

                    break;


                case 'no_expiry':

                    $query->whereNull(
                        'expiry_date'
                    );

                    break;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */
        $perPage =
            $request->integer(
                'per_page',
                10
            );


        if ($perPage < 1) {
            $perPage = 10;
        }


        if ($perPage > 100) {
            $perPage = 100;
        }


        return response()->json([

            'success' => true,

            'data' =>
                $query->paginate(
                    $perPage
                ),
        ]);
    }
}