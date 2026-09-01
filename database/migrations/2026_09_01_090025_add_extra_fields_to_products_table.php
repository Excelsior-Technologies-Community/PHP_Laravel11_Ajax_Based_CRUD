<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->nullable();
            $table->string('brand')->nullable();
            $table->date('expiry_date')->nullable();
            $table->json('tags')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image', 'file', 'category', 'status', 'brand', 'expiry_date', 'tags']);
        });
    }
};
