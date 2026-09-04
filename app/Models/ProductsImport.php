<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (empty($row['name'])) {
                continue;
            }

            $tags = null;

            if (!empty($row['tags'])) {

                $tagArray = array_filter(
                    array_map(
                        'trim',
                        explode(',', $row['tags'])
                    )
                );

                $tags = json_encode(array_values($tagArray));
            }

            Product::create([
                'name' => $row['name'],
                'detail' => $row['detail'] ?? '',
                'category' => $row['category'] ?? null,
                'status' => $row['status'] ?? 'Active',
                'brand' => $row['brand'] ?? null,
                'expiry_date' => $row['expiry_date'] ?? null,
                'tags' => $tags,
            ]);
        }
    }
}