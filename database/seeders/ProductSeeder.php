<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('products/images');
        Storage::disk('public')->makeDirectory('products/files');

        $products = [
            [
                'name' => 'Wireless Headphones',
                'detail' => 'High-quality wireless headphones with noise cancellation and 30-hour battery life.',
                'category' => 'Electronics',
                'status' => 'Active',
                'brand' => 'SoundMax',
                'expiry_date' => '2027-12-31',
                'tags' => json_encode(['audio', 'wireless', 'bluetooth']),
                'image' => $this->createPlaceholderImage('headphones', 300, 300, '1abc2'),
                'file' => $this->createPlaceholderFile('headphones_specs', 'pdf'),
            ],
            [
                'name' => 'Smart Watch',
                'detail' => 'Feature-rich smartwatch with heart rate monitor, GPS, and water resistance.',
                'category' => 'Electronics',
                'status' => 'Active',
                'brand' => 'TechWear',
                'expiry_date' => '2027-06-30',
                'tags' => json_encode(['wearable', 'fitness', 'smart']),
                'image' => $this->createPlaceholderImage('smartwatch', 300, 300, '2def4'),
                'file' => $this->createPlaceholderFile('smartwatch_manual', 'pdf'),
            ],
            [
                'name' => 'Cotton T-Shirt',
                'detail' => 'Comfortable 100% cotton t-shirt, available in multiple colors.',
                'category' => 'Clothing',
                'status' => 'Active',
                'brand' => 'WearCo',
                'expiry_date' => '2026-12-31',
                'tags' => json_encode(['casual', 'cotton', 'summer']),
                'image' => $this->createPlaceholderImage('tshirt', 300, 300, '3ghi5'),
                'file' => null,
            ],
            [
                'name' => 'Organic Honey',
                'detail' => 'Pure organic honey sourced from local farms. 500g jar.',
                'category' => 'Food',
                'status' => 'Active',
                'brand' => 'NatureBest',
                'expiry_date' => '2026-03-31',
                'tags' => json_encode(['organic', 'food', 'natural']),
                'image' => $this->createPlaceholderImage('honey', 300, 300, '4jkl6'),
                'file' => $this->createPlaceholderFile('honey_certificate', 'pdf'),
            ],
            [
                'name' => 'Laptop Backpack',
                'detail' => 'Water-resistant laptop backpack with USB charging port and multiple compartments.',
                'category' => 'Clothing',
                'status' => 'Inactive',
                'brand' => 'CarryAll',
                'expiry_date' => '2027-09-30',
                'tags' => json_encode(['bag', 'laptop', 'travel']),
                'image' => $this->createPlaceholderImage('backpack', 300, 300, '5mno7'),
                'file' => null,
            ],
            [
                'name' => 'Wireless Earbuds',
                'detail' => 'Compact wireless earbuds with crystal clear sound and touch controls.',
                'category' => 'Electronics',
                'status' => 'Active',
                'brand' => 'SoundMax',
                'expiry_date' => '2027-11-30',
                'tags' => json_encode(['audio', 'wireless', 'earbuds']),
                'image' => $this->createPlaceholderImage('earbuds', 300, 300, '6pqr8'),
                'file' => $this->createPlaceholderFile('earbuds_guide', 'pdf'),
            ],
            [
                'name' => 'Running Shoes',
                'detail' => 'Lightweight running shoes with superior cushioning and breathable mesh.',
                'category' => 'Clothing',
                'status' => 'Active',
                'brand' => 'SpeedRun',
                'expiry_date' => '2026-08-31',
                'tags' => json_encode(['sports', 'running', 'shoes']),
                'image' => $this->createPlaceholderImage('shoes', 300, 300, '7stu9'),
                'file' => null,
            ],
            [
                'name' => 'Green Tea Pack',
                'detail' => 'Premium green tea bags. Pack of 100. Rich in antioxidants.',
                'category' => 'Food',
                'status' => 'Active',
                'brand' => 'NatureBest',
                'expiry_date' => '2026-05-31',
                'tags' => json_encode(['tea', 'organic', 'healthy']),
                'image' => $this->createPlaceholderImage('greentea', 300, 300, '8vwx0'),
                'file' => $this->createPlaceholderFile('greentea_benefits', 'pdf'),
            ],
            [
                'name' => 'Mechanical Keyboard',
                'detail' => 'RGB mechanical keyboard with blue switches and aluminum frame.',
                'category' => 'Electronics',
                'status' => 'Active',
                'brand' => 'TypeMaster',
                'expiry_date' => '2028-01-31',
                'tags' => json_encode(['gaming', 'keyboard', 'rgb']),
                'image' => $this->createPlaceholderImage('keyboard', 300, 300, '9yza1'),
                'file' => $this->createPlaceholderFile('keyboard_manual', 'pdf'),
            ],
            [
                'name' => 'Denim Jacket',
                'detail' => 'Classic denim jacket with a modern fit. Durable and stylish.',
                'category' => 'Clothing',
                'status' => 'Inactive',
                'brand' => 'WearCo',
                'expiry_date' => '2026-10-31',
                'tags' => json_encode(['denim', 'casual', 'winter']),
                'image' => $this->createPlaceholderImage('denim', 300, 300, '0bcd2'),
                'file' => null,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        echo "Seeded " . count($products) . " products successfully.\n";
    }

    private function createPlaceholderImage(string $name, int $width, int $height, string $colorHex): ?string
    {
        $filename = $name . '_' . time() . '_' . uniqid() . '.png';
        $path = storage_path('app/public/products/images/' . $filename);

        $image = imagecreatetruecolor($width, $height);
        list($r, $g, $b) = sscanf($colorHex, "%02x%02x%02x");
        $bg = imagecolorallocate($image, $r ?? 100, $g ?? 100, $b ?? 100);
        $textColor = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, $width, $height, $bg);
        imagestring($image, 5, 10, 140, ucfirst($name), $textColor);
        imagepng($image, $path);
        imagedestroy($image);

        return 'products/images/' . $filename;
    }

    private function createPlaceholderFile(string $name, string $extension): ?string
    {
        $filename = $name . '_' . time() . '_' . uniqid() . '.' . $extension;
        $path = storage_path('app/public/products/files/' . $filename);
        $content = "This is a sample file for {$name}.\nGenerated on: " . now()->toDateTimeString();
        file_put_contents($path, $content);
        return 'products/files/' . $filename;
    }
}
