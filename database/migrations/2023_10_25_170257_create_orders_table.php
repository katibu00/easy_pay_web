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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('combo_id');
            $table->unsignedBigInteger('user_id'); 
            $table->string('status')->default('pending');
            $table->string('payment_mode');
            $table->string('payment_duration');
            $table->string('address_type');
            $table->string('state');
            $table->string('city');
            $table->string('pickup_location')->nullable();
            $table->string('town')->nullable();
            $table->string('street_address')->nullable();
            $table->string('landmark')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('combo_id')->references('id')->on('combos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};