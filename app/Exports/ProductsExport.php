<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Detail', 'Category', 'Status', 'Brand', 'Expiry Date', 'Tags'];
    }

    public function map($product): array
    {
        $tags = $product->tags ? implode(', ', json_decode($product->tags, true)) : '';
        return [
            $product->id,
            $product->name,
            $product->detail,
            $product->category,
            $product->status,
            $product->brand,
            $product->expiry_date,
            $tags
        ];
    }
}
