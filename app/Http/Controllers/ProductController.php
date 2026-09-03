<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    /**
     * Display products with AJAX DataTables.
     */
public function index(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Statistics AJAX Request
    |--------------------------------------------------------------------------
    */

    if ($request->boolean('stats')) {

        return response()->json([
            'stats' => [
                'total' => Product::count(),

                'active' => Product::where(
                    'status',
                    'Active'
                )->count(),

                'inactive' => Product::where(
                    'status',
                    'Inactive'
                )->count(),

                'categories' => Product::whereNotNull('category')
                    ->where('category', '!=', '')
                    ->distinct('category')
                    ->count('category'),
            ]
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DataTables AJAX Request
    |--------------------------------------------------------------------------
    */

    if ($request->ajax()) {

        $data = Product::select(
            'id',
            'image',
            'name',
            'detail',
            'category',
            'status',
            'brand',
            'expiry_date',
            'tags',
            'file'
        );

        /*
        |--------------------------------------------------------------------------
        | Custom Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $data->where(function ($query) use ($search) {

                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('detail', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('brand', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $data->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $data->where('category', $request->category);
        }

        return DataTables::of($data)

            /*
            |--------------------------------------------------------------------------
            | Row Number
            |--------------------------------------------------------------------------
            */

            ->addColumn('no', function ($row) {

                static $i = 1;

                return $i++;
            })

            /*
            |--------------------------------------------------------------------------
            | Image
            |--------------------------------------------------------------------------
            */

            ->editColumn('image', function ($row) {

                if ($row->image) {

                    return '
                        <img
                            src="' . asset('storage/' . $row->image) . '"
                            class="product-thumb"
                            alt="' . e($row->name) . '"
                        >
                    ';
                }

                return '
                    <div class="product-placeholder">
                        <i class="fa-solid fa-box"></i>
                    </div>
                ';
            })

            /*
            |--------------------------------------------------------------------------
            | Inline Editable Name
            |--------------------------------------------------------------------------
            */

            ->editColumn('name', function ($row) {

                return '
                    <span
                        class="inline-edit"
                        data-id="' . $row->id . '"
                        data-field="name"
                        data-value="' . e($row->name) . '"
                        title="Click to edit"
                    >
                        ' . e($row->name) . '
                    </span>
                ';
            })

            /*
            |--------------------------------------------------------------------------
            | Inline Editable Category
            |--------------------------------------------------------------------------
            */

            ->editColumn('category', function ($row) {

                $category = $row->category ?: '';

                return '
                    <span
                        class="inline-edit"
                        data-id="' . $row->id . '"
                        data-field="category"
                        data-value="' . e($category) . '"
                        title="Click to edit"
                    >
                        ' . e($category ?: 'Not Set') . '
                    </span>
                ';
            })

            /*
            |--------------------------------------------------------------------------
            | AJAX Status Toggle
            |--------------------------------------------------------------------------
            */

            ->editColumn('status', function ($row) {

                $checked = $row->status === 'Active'
                    ? 'checked'
                    : '';

                return '
                    <div class="form-check form-switch d-flex justify-content-center">

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
            | Inline Editable Brand
            |--------------------------------------------------------------------------
            */

            ->editColumn('brand', function ($row) {

                $brand = $row->brand ?: '';

                return '
                    <span
                        class="inline-edit"
                        data-id="' . $row->id . '"
                        data-field="brand"
                        data-value="' . e($brand) . '"
                        title="Click to edit"
                    >
                        ' . e($brand ?: 'Not Set') . '
                    </span>
                ';
            })

            /*
            |--------------------------------------------------------------------------
            | Tags
            |--------------------------------------------------------------------------
            */

            ->editColumn('tags', function ($row) {

                if ($row->tags) {

                    $tags = json_decode($row->tags, true);

                    if (is_array($tags)) {

                        return implode(', ', array_map(
                            'e',
                            $tags
                        ));
                    }
                }

                return '';
            })

            /*
            |--------------------------------------------------------------------------
            | File
            |--------------------------------------------------------------------------
            */

            ->editColumn('file', function ($row) {

                if ($row->file) {

                    return '
                        <a
                            href="' . asset('storage/' . $row->file) . '"
                            target="_blank"
                            class="btn btn-sm btn-info"
                        >
                            <i class="fa fa-download"></i>
                            Download
                        </a>
                    ';
                }

                return '<span class="text-muted">No File</span>';
            })

            /*
            |--------------------------------------------------------------------------
            | Action Buttons
            |--------------------------------------------------------------------------
            */

            ->addColumn('action', function ($row) {

                $btn = '
                    <input
                        type="checkbox"
                        class="select-row me-1"
                        data-id="' . $row->id . '"
                    >
                ';

                $btn .= '
                    <a
                        href="javascript:void(0)"
                        data-id="' . $row->id . '"
                        class="btn btn-info btn-sm me-1 showProduct"
                        title="View Product"
                    >
                        <i class="fa-regular fa-eye"></i>
                    </a>
                ';

                $btn .= '
                    <a
                        href="javascript:void(0)"
                        data-id="' . $row->id . '"
                        class="btn btn-primary btn-sm me-1 editProduct"
                        title="Edit Product"
                    >
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                ';

                $btn .= '
                    <a
                        href="javascript:void(0)"
                        data-id="' . $row->id . '"
                        class="btn btn-warning btn-sm me-1 duplicateProduct"
                        title="Duplicate Product"
                    >
                        <i class="fa-regular fa-copy"></i>
                    </a>
                ';

                $btn .= '
                    <a
                        href="javascript:void(0)"
                        data-id="' . $row->id . '"
                        class="btn btn-danger btn-sm deleteProduct"
                        title="Delete Product"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </a>
                ';

                return $btn;
            })

            /*
            |--------------------------------------------------------------------------
            | Raw HTML Columns
            |--------------------------------------------------------------------------
            */

            ->rawColumns([
                'no',
                'image',
                'name',
                'category',
                'status',
                'brand',
                'tags',
                'file',
                'action'
            ])

            ->make(true);
    }

    /*
    |--------------------------------------------------------------------------
    | Normal Page Request
    |--------------------------------------------------------------------------
    */

    return view('products');
}


    /**
     * Store or update product using AJAX.
     */
    public function store(Request $request): JsonResponse
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'detail' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:5120',
                'category' => 'nullable|string|max:255',
                'status' => 'nullable|string|max:255',
                'brand' => 'nullable|string|max:255',
                'expiry_date' => 'nullable|date',
                'tags' => 'nullable|array',
            ]);

            $data = $request->only([
                'name',
                'detail',
                'category',
                'status',
                'brand',
                'expiry_date'
            ]);

            $data['tags'] = $request->tags
                ? json_encode($request->tags)
                : null;

            /*
            |--------------------------------------------------------------------------
            | Image
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('image')) {

                $imagePath = $request
                    ->file('image')
                    ->store('products/images', 'public');

                $data['image'] = $imagePath;
            } elseif ($request->product_id) {

                $existing = Product::find($request->product_id);

                if ($existing) {
                    $data['image'] = $existing->image;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | File
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('file')) {

                $filePath = $request
                    ->file('file')
                    ->store('products/files', 'public');

                $data['file'] = $filePath;
            } elseif ($request->product_id) {

                $existing = Product::find($request->product_id);

                if ($existing) {
                    $data['file'] = $existing->file;
                }
            }

            Product::updateOrCreate(
                ['id' => $request->product_id],
                $data
            );

            return response()->json([
                'success' => 'Product saved successfully.'
            ]);

        } catch (\Exception $e) {

            \Log::error('Store error', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Show product.
     */
    public function show($id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found.'
            ], 404);
        }

        if ($product->tags) {
            $product->tags = json_decode($product->tags, true);
        }

        return response()->json($product);
    }


    /**
     * Edit product.
     */
    public function edit($id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found.'
            ], 404);
        }

        if ($product->tags) {
            $product->tags = json_decode($product->tags, true);
        }

        return response()->json($product);
    }


    /**
     * Delete product.
     */
    public function destroy($id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found.'
            ], 404);
        }

        if (
            $product->image &&
            Storage::disk('public')->exists($product->image)
        ) {
            Storage::disk('public')->delete($product->image);
        }

        if (
            $product->file &&
            Storage::disk('public')->exists($product->file)
        ) {
            Storage::disk('public')->delete($product->file);
        }

        $product->delete();

        return response()->json([
            'success' => 'Product deleted successfully.'
        ]);
    }


    /**
     * Bulk delete products.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer'
        ]);

        foreach ($request->ids as $id) {

            $product = Product::find($id);

            if (!$product) {
                continue;
            }

            if (
                $product->image &&
                Storage::disk('public')->exists($product->image)
            ) {
                Storage::disk('public')->delete($product->image);
            }

            if (
                $product->file &&
                Storage::disk('public')->exists($product->file)
            ) {
                Storage::disk('public')->delete($product->file);
            }

            $product->delete();
        }

        return response()->json([
            'success' => 'Products deleted successfully.'
        ]);
    }


    /**
     * ============================================================
     * AJAX FEATURE #1
     * Toggle Product Status
     * ============================================================
     */
    public function toggleStatus($id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        $product->status = $product->status === 'Active'
            ? 'Inactive'
            : 'Active';

        $product->save();

        return response()->json([
            'success' => true,
            'status' => $product->status,
            'message' => 'Product status changed to ' . $product->status . '.'
        ]);
    }


    /**
     * ============================================================
     * AJAX FEATURE #2
     * Duplicate Product
     * ============================================================
     */
    public function duplicate($id): JsonResponse
    {
        try {

            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.'
                ], 404);
            }

            /*
            |--------------------------------------------------------------------------
            | Create duplicate data
            |--------------------------------------------------------------------------
            */

            $newProduct = $product->replicate();

            $newProduct->name = $product->name . ' (Copy)';

            /*
            |--------------------------------------------------------------------------
            | Copy image
            |--------------------------------------------------------------------------
            */

            if (
                $product->image &&
                Storage::disk('public')->exists($product->image)
            ) {

                $extension = pathinfo($product->image, PATHINFO_EXTENSION);

                $newImage = 'products/images/' .
                    'copy_' .
                    uniqid() .
                    '_' .
                    time() .
                    '.' .
                    $extension;

                Storage::disk('public')->copy(
                    $product->image,
                    $newImage
                );

                $newProduct->image = $newImage;
            }

            /*
            |--------------------------------------------------------------------------
            | Copy file
            |--------------------------------------------------------------------------
            */

            if (
                $product->file &&
                Storage::disk('public')->exists($product->file)
            ) {

                $extension = pathinfo($product->file, PATHINFO_EXTENSION);

                $newFile = 'products/files/' .
                    'copy_' .
                    uniqid() .
                    '_' .
                    time() .
                    '.' .
                    $extension;

                Storage::disk('public')->copy(
                    $product->file,
                    $newFile
                );

                $newProduct->file = $newFile;
            }

            $newProduct->save();

            return response()->json([
                'success' => true,
                'message' => 'Product duplicated successfully.',
                'product' => $newProduct
            ]);

        } catch (\Exception $e) {

            \Log::error('Duplicate product error', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to duplicate product.'
            ], 500);
        }
    }


    /**
     * ============================================================
     * AJAX FEATURE #3
     * Inline Update
     * ============================================================
     */
    public function inlineUpdate(Request $request, $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        $request->validate([
            'field' => 'required|in:name,brand,category',
            'value' => 'nullable|string|max:255'
        ]);

        $field = $request->field;
        $value = trim($request->value ?? '');

        /*
        |--------------------------------------------------------------------------
        | Name validation
        |--------------------------------------------------------------------------
        */

        if ($field === 'name' && $value === '') {
            return response()->json([
                'success' => false,
                'message' => 'Product name cannot be empty.'
            ], 422);
        }

        $product->{$field} = $value;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => ucfirst($field) . ' updated successfully.',
            'value' => $product->{$field}
        ]);
    }


    /**
     * Export CSV.
     */
    public function exportCsv()
    {
        $products = Product::all();

        $csv = "ID,Name,Detail,Category,Status,Brand,Expiry Date,Tags\n";

        foreach ($products as $product) {

            $tags = $product->tags
                ? implode('|', json_decode($product->tags, true))
                : '';

            $csv .= "{$product->id},";
            $csv .= '"' . str_replace('"', '""', $product->name) . '",';
            $csv .= '"' . str_replace('"', '""', $product->detail) . '",';
            $csv .= '"' . str_replace('"', '""', $product->category) . '",';
            $csv .= '"' . str_replace('"', '""', $product->status) . '",';
            $csv .= '"' . str_replace('"', '""', $product->brand) . '",';
            $csv .= '"' . $product->expiry_date . '",';
            $csv .= '"' . str_replace('"', '""', $tags) . '"';
            $csv .= "\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products.csv"',
        ]);
    }


    /**
     * Export Excel.
     */
    public function exportExcel()
    {
        return Excel::download(
            new ProductsExport,
            'products.xlsx'
        );
    }


    /**
     * Export PDF.
     */
    public function exportPdf()
    {
        $products = Product::all();

        $pdf = Pdf::loadView(
            'products.pdf',
            compact('products')
        );

        return $pdf->download('products.pdf');
    }
}