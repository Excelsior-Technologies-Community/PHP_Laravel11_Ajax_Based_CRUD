<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'detail',
        'image',
        'file',
        'category',
        'status',
        'brand',
        'expiry_date',
        'tags',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];
}
