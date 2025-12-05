<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;  // DataTables Facade import
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display the listing of products (DataTable AJAX support)
     */
    public function index(Request $request)
    {
        // If request is AJAX → Return JSON for DataTables
        if ($request->ajax()) {

            // Fetch all products using query builder
            $data = Product::query();

            return DataTables::of($data)
                ->addIndexColumn()  // Auto number column
                ->addColumn('action', function($row) {

                    // Action buttons HTML
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" 
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
                ->rawColumns(['action']) // Allow HTML in "action" column
                ->make(true);            // Return JSON
        }

        // If not AJAX → Return view page
        return view('products');
    }


    /**
     * Store or update a product (AJAX)
     */
    public function store(Request $request): JsonResponse
    {
        // Validate form fields
        $request->validate([
            'name'   => 'required',
            'detail' => 'required',
        ]);

        // Insert / Update product
        Product::updateOrCreate(
            ['id' => $request->product_id],      // If id exists → update
            ['name' => $request->name,           // Otherwise → insert
             'detail' => $request->detail]
        );

        return response()->json(['success' => 'Product saved successfully.']);
    }


    /**
     * Show product details (for View modal)
     */
    public function show($id): JsonResponse
    {
        return response()->json(Product::find($id));
    }


    /**
     * Edit product (fetch existing data)
     */
    public function edit($id): JsonResponse
    {
        return response()->json(Product::find($id));
    }


    /**
     * Delete product
     */
    public function destroy($id): JsonResponse
    {
        Product::find($id)->delete();

        return response()->json(['success' => 'Product deleted successfully.']);
    }
}

