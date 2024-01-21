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
        Schema::create('seller_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->index();
            $table->foreign('seller_id')->on('sellers')->references('id')->cascadeOnDelete();
            $table->foreignId('product_id')->index();
            $table->foreign('product_id')->on('products')->references('id')->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_products');
    }
};
