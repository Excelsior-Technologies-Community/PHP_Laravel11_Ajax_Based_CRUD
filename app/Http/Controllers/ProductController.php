<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::latest()->get(); // નવી પ્રોડક્ટ પહેલા દેખાશે
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-info btn-sm me-1 showProduct"><i class="fa-regular fa-eye"></i> View</a>';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-primary btn-sm me-1 editProduct"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('products');
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        // આ લાઈન ચેક કરશે: જો ID હોય તો Update, નહીંતર Create
        Product::updateOrCreate(
            ['id' => $request->product_id],
            ['name' => $request->name, 'detail' => $request->detail]
        );        

        return response()->json(['success' => 'Product saved successfully.']);
    }

    public function edit($id): JsonResponse
    {
        return response()->json(Product::find($id));
    }

    public function show($id): JsonResponse
    {
        return response()->json(Product::find($id));
    }

    public function destroy($id): JsonResponse
    {
        Product::find($id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
