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
        return Product::query()
            ->orderBy('id', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Detail',
            'Category',
            'Status',
            'Brand',
            'Expiry Date',
            'Tags'
        ];
    }

    public function map($product): array
    {
        $tags = '';

        if ($product->tags) {

            $decoded = json_decode($product->tags, true);

            if (is_array($decoded)) {
                $tags = implode(', ', $decoded);
            }
        }

        return [
            $product->id,
            $product->name,
            $product->detail,
            $product->category,
            $product->status,
            $product->brand,
            optional($product->expiry_date)->format('Y-m-d'),
            $tags,
        ];
    }
}
