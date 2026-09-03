<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| Standard AJAX CRUD
|--------------------------------------------------------------------------
*/

Route::resource('products', ProductController::class);


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
| NEW FEATURE #1
| AJAX Status Toggle
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/{id}/toggle-status',
    [ProductController::class, 'toggleStatus']
)->name('products.toggleStatus');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #2
| AJAX Duplicate Product
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/{id}/duplicate',
    [ProductController::class, 'duplicate']
)->name('products.duplicate');


/*
|--------------------------------------------------------------------------
| NEW FEATURE #3
| AJAX Inline Update
|--------------------------------------------------------------------------
*/

Route::patch(
    '/products/{id}/inline-update',
    [ProductController::class, 'inlineUpdate']
)->name('products.inlineUpdate');