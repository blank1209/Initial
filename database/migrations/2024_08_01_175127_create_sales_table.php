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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('salesID');
            $table->datetime('salesDate');
            $table->string('salesStatus', 15)->nullable();
            $table->unsignedBigInteger('deliveryID')->nullable();
            $table->unsignedBigInteger('userName');
            $table->unsignedBigInteger('branch');

            $table->foreign('deliveryID')->references('deliveryID')->on('deliveries')->onDelete('cascade');
            $table->foreign('userName')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('branch')->references('branchID')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
