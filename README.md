# 🚀 Laravel 11 AJAX CRUD Using Yajra DataTables

A complete step-by-step guide to building modern CRUD without page reload.

This repository demonstrates how to create a full **AJAX-based CRUD** system in **Laravel 11**, using:

- ✔️ Yajra DataTables  
- ✔️ Bootstrap 5  
- ✔️ jQuery AJAX  
- ✔️ Modal-based Create / Edit / View  
- ✔️ RESTful Controller  
- ✔️ No Page Reload CRUD  

---

## 🌟 Features

- AJAX Create, Read, Update & Delete  
- Server-side DataTables  
- Bootstrap 5 UI  
- Clean modal-based interactions  
- Laravel 11 REST API structure  

---

## 🛠️ Step 1: Install Laravel 11

```bash
composer create-project laravel/laravel TestAjax "11.*"
```

---

## 🛠️ Step 2: Install Yajra DataTables

```bash
composer require yajra/laravel-datatables-oracle
```

---

## 🛠️ Step 3: Database Configuration

Update your `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=testajax
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🛠️ Step 4: Create Migration

```bash
php artisan make:migration create_products_table --create=products
```

### Migration File:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('detail');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
```

---

## 🛠️ Step 5: Add Route

```php
use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);
```

---

## 🛠️ Step 6: Controller

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller {

    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Product::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-id="'.$row->id.'" class="btn btn-info btn-sm showProduct">View</a>
                        <a href="#" data-id="'.$row->id.'" class="btn btn-primary btn-sm editProduct">Edit</a>
                        <a href="#" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteProduct">Delete</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('products');
    }

    public function store(Request $request): JsonResponse {
        $request->validate([
            'name' => 'required',
            'detail' => 'required'
        ]);

        Product::updateOrCreate(
            ['id' => $request->product_id],
            ['name' => $request->name, 'detail' => $request->detail]
        );

        return response()->json(['success' => 'Product saved successfully.']);
    }

    public function show($id): JsonResponse {
        return response()->json(Product::find($id));
    }

    public function edit($id): JsonResponse {
        return response()->json(Product::find($id));
    }

    public function destroy($id): JsonResponse {
        Product::find($id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
```

---

## 🛠️ Step 7: Product Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = ['name', 'detail'];
}
```

---

## 🛠️ Step 8: Run Application

```bash
php artisan serve
```

Open:

```
http://localhost:8000/products
```

---

### 🎉 Your AJAX CRUD is ready!
