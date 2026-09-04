<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| Standard AJAX CRUD
|--------------------------------------------------------------------------
*/

Route::resource(
    'products',
    ProductController::class
);


/*
|--------------------------------------------------------------------------
| Existing Bulk Delete
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/bulk-delete',
    [ProductController::class, 'bulkDelete']
)->name('products.bulkDelete');


/*
|--------------------------------------------------------------------------
| Existing Exports
|--------------------------------------------------------------------------
*/

Route::get(
    '/products/export/csv',
    [ProductController::class, 'exportCsv']
)->name('products.export.csv');

Route::get(
    '/products/export/excel',
    [ProductController::class, 'exportExcel']
)->name('products.export.excel');

Route::get(
    '/products/export/pdf',
    [ProductController::class, 'exportPdf']
)->name('products.export.pdf');


/*
|--------------------------------------------------------------------------
| Existing Feature #1
| AJAX Status Toggle
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/{id}/toggle-status',
    [ProductController::class, 'toggleStatus']
)->name('products.toggleStatus');


/*
|--------------------------------------------------------------------------
| Existing Feature #2
| Duplicate Product
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/{id}/duplicate',
    [ProductController::class, 'duplicate']
)->name('products.duplicate');


/*
|--------------------------------------------------------------------------
| Existing Feature #3
| Inline Update
|--------------------------------------------------------------------------
*/

Route::patch(
    '/products/{id}/inline-update',
    [ProductController::class, 'inlineUpdate']
)->name('products.inlineUpdate');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #1
| Bulk Status
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/bulk-status',
    [ProductController::class, 'bulkStatus']
)->name('products.bulkStatus');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #2
| Trash
|--------------------------------------------------------------------------
*/

Route::get(
    '/products-trash',
    [ProductController::class, 'trash']
)->name('products.trash');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #3
| Restore
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/{id}/restore',
    [ProductController::class, 'restore']
)->name('products.restore');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #4
| Permanent Delete
|--------------------------------------------------------------------------
*/

Route::delete(
    '/products/{id}/force-delete',
    [ProductController::class, 'forceDelete']
)->name('products.forceDelete');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #5
| Bulk Restore
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/bulk-restore',
    [ProductController::class, 'bulkRestore']
)->name('products.bulkRestore');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #6
| Bulk Permanent Delete
|--------------------------------------------------------------------------
*/

Route::delete(
    '/products/bulk-force-delete',
    [ProductController::class, 'bulkForceDelete']
)->name('products.bulkForceDelete');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #7
| Excel Import
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/import/excel',
    [ProductController::class, 'importExcel']
)->name('products.import.excel');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #8
| Expiry Statistics
|--------------------------------------------------------------------------
*/

Route::get(
    '/products/expiry/stats',
    [ProductController::class, 'expiryStats']
)->name('products.expiry.stats');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #9
| JSON API
|--------------------------------------------------------------------------
*/

Route::get(
    '/api/products',
    [ProductController::class, 'apiList']
)->name('api.products');
