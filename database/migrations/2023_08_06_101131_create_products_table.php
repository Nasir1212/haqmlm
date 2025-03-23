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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('category_id')->nullable();
            $table->string('brand_id')->nullable();
            $table->string('details')->nullable();
            $table->decimal('main_price', 18,3)->nullable();
            $table->decimal('regular_price',18,3)->nullable();
            $table->decimal('purchase_price', 18,3)->nullable();
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
