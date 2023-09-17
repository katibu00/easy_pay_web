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
        Schema::create('combos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('short_description');
            $table->longText('long_description');
            $table->longText('combo_terms');
            $table->decimal('original_price', 10, 2)->default(0.00);
            $table->decimal('sale_price', 10, 2)->default(0.00);
            $table->decimal('price_30', 10, 2)->nullable();
            $table->decimal('price_60', 10, 2)->nullable();
            $table->decimal('price_90', 10, 2)->nullable();
            $table->decimal('price_125', 10, 2)->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('featured_image')->default('no-image.jpg');
            $table->timestamps();
        
            $table->foreign('category_id')->references('id')->on('categories');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combos');
    }
};
