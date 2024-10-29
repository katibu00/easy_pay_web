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
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->decimal('sale_price', 10, 2);
            $table->decimal('original_price', 10, 2);
            $table->unsignedBigInteger('featured_image_id')->nullable();
            $table->integer('quantity_in_stock');
            $table->unsignedBigInteger('category_id');
            // $table->boolean('is_featured')->default(false);
            // $table->boolean('is_new_arrival')->default(false);
            // $table->boolean('is_on_sale')->default(false);
            $table->timestamps();
        
            // $table->foreign('featured_image_id')->references('id')->on('product_images')->onDelete('set null');
            // $table->foreign('category_id')->references('id')->on('categories');
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
