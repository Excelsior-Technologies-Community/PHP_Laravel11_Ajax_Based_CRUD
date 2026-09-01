<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    /**
     * Display the listing of products (DataTable AJAX support)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('id', 'image', 'name', 'detail', 'category', 'status', 'brand', 'expiry_date', 'tags', 'file');

            if ($request->filled('search')) {
                $data->where(function($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->search.'%')
                          ->orWhere('detail', 'like', '%'.$request->search.'%')
                          ->orWhere('category', 'like', '%'.$request->search.'%')
                          ->orWhere('brand', 'like', '%'.$request->search.'%');
                });
            }

            if ($request->filled('status')) {
                $data->where('status', $request->status);
            }

            if ($request->filled('category')) {
                $data->where('category', $request->category);
            }

            return DataTables::of($data)
                ->addColumn('no', function($row) {
                    static $i = 1;
                    return $i++;
                })
                ->editColumn('image', function($row) {
                    if ($row->image) {
                        return '<img src="/storage/'.$row->image.'" width="50" height="50" style="object-fit: cover;">';
                    }
                    return '';
                })
                ->editColumn('tags', function($row) {
                    if ($row->tags) {
                        $tags = json_decode($row->tags, true);
                        return implode(', ', $tags);
                    }
                    return '';
                })
                ->editColumn('file', function($row) {
                    if ($row->file) {
                        return '<a href="/storage/'.$row->file.'" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-download"></i> Download</a>';
                    }
                    return '';
                })
                ->addColumn('action', function($row) {
                    $btn = '<input type="checkbox" class="select-row" data-id="'.$row->id.'">';

                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" 
                            class="btn btn-info btn-sm me-1 showProduct">
                            <i class="fa-regular fa-eye"></i> View</a>';

                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" 
                            class="btn btn-primary btn-sm me-1 editProduct">
                            <i class="fa-regular fa-pen-to-square"></i> Edit</a>';

                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" 
                            class="btn btn-danger btn-sm deleteProduct">
                            <i class="fa-solid fa-trash"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['no', 'image', 'tags', 'file', 'action'])
                ->make(true);
        }

        return view('products');
    }

    /**
     * Store or update a product (AJAX)
     */
    public function store(Request $request): JsonResponse
    {
        \Log::info('Store request data:', $request->all());

        try {
            $request->validate([
                'name'   => 'required',
                'detail' => 'required',
                'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'file'   => 'nullable|file|mimes:pdf,doc,docx,txt|max:5120',
                'category' => 'nullable|string|max:255',
                'status' => 'nullable|string|max:255',
                'brand' => 'nullable|string|max:255',
                'expiry_date' => 'nullable|date',
                'tags' => 'nullable|array',
            ]);

            $data = $request->only(['name', 'detail', 'category', 'status', 'brand', 'expiry_date']);
            $data['tags'] = $request->tags ? json_encode($request->tags) : null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products/images', 'public');
                $data['image'] = $imagePath;
            } elseif ($request->product_id) {
                $existing = Product::find($request->product_id);
                if ($existing) {
                    $data['image'] = $existing->image;
                }
            }

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('products/files', 'public');
                $data['file'] = $filePath;
            } elseif ($request->product_id) {
                $existing = Product::find($request->product_id);
                if ($existing) {
                    $data['file'] = $existing->file;
                }
            }

            \Log::info('Store data:', $data);

            $product = Product::updateOrCreate(
                ['id' => $request->product_id],
                $data
            );

            \Log::info('Product saved:', $product->toArray());

            return response()->json(['success' => 'Product saved successfully.']);
        } catch (\Exception $e) {
            \Log::error('Store error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show product details (for View modal)
     */
    public function show($id): JsonResponse
    {
        $product = Product::find($id);
        if ($product && $product->tags) {
            $product->tags = json_decode($product->tags, true);
        }
        return response()->json($product);
    }

    /**
     * Edit product (fetch existing data)
     */
    public function edit($id): JsonResponse
    {
        $product = Product::find($id);
        if ($product && $product->tags) {
            $product->tags = json_decode($product->tags, true);
        }
        return response()->json($product);
    }

    /**
     * Delete product
     */
    public function destroy($id): JsonResponse
    {
        $product = Product::find($id);
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }
        if ($product->file && \Storage::disk('public')->exists($product->file)) {
            \Storage::disk('public')->delete($product->file);
        }
        $product->delete();

        return response()->json(['success' => 'Product deleted successfully.']);
    }

    /**
     * Bulk delete products
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $product = Product::find($id);
            if ($product) {
                if ($product->image && \Storage::disk('public')->exists($product->image)) {
                    \Storage::disk('public')->delete($product->image);
                }
                if ($product->file && \Storage::disk('public')->exists($product->file)) {
                    \Storage::disk('public')->delete($product->file);
                }
                $product->delete();
            }
        }

        return response()->json(['success' => 'Products deleted successfully.']);
    }

    /**
     * Export products to CSV
     */
    public function exportCsv()
    {
        $products = Product::all();
        $csv = "ID,Name,Detail,Category,Status,Brand,Expiry Date,Tags\n";
        foreach ($products as $product) {
            $tags = $product->tags ? implode('|', json_decode($product->tags, true)) : '';
            $csv .= "{$product->id},\"{$product->name}\",\"{$product->detail}\",\"{$product->category}\",\"{$product->status}\",\"{$product->brand}\",\"{$product->expiry_date}\",\"{$tags}\"\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products.csv"',
        ]);
    }

    /**
     * Export products to Excel
     */
    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    /**
     * Export products to PDF
     */
    public function exportPdf()
    {
        $products = Product::all();
        $pdf = Pdf::loadView('products.pdf', compact('products'));
        return $pdf->download('products.pdf');
    }
}
