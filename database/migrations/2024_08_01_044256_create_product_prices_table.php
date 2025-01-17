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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id('productPriceID');
            $table->unsignedBigInteger('product')->nullable();
            $table->unsignedBigInteger('area');
            $table->float('price');

            $table->foreign('product')->references('productID')->on('products')->onDelete('cascade');
            $table->foreign('area')->references('areaID')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_price');
    }
};
