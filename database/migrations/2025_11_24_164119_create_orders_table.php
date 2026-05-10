<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('order_id')->unique();  // Internal order reference
            $table->string('awb_id')->unique();    // Shipping/tracking ID
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('phone');
            $table->enum('payment_method', ['online', 'cash']);
            $table->decimal('total', 10, 2);
            $table->timestamps();

            // Foreign key (optional)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
