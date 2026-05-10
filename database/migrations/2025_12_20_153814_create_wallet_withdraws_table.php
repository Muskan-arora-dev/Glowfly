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
        Schema::create('wallet_withdraws', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to users table
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Amount to withdraw
            $table->decimal('amount', 10, 2);
            
            // Status of withdrawal
            $table->enum('status', ['pending','approved','rejected'])
                  ->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_withdraws');
    }
};
