<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('users', function (Blueprint $table) {

        // Add only if NOT exists
        if (!Schema::hasColumn('users', 'is_admin')) {
            $table->boolean('is_admin')->default(0)->after('password');
        }

        if (!Schema::hasColumn('users', 'otp')) {
            $table->string('otp')->nullable()->after('is_admin');
        }

        if (!Schema::hasColumn('users', 'otp_expires_at')) {
            $table->timestamp('otp_expires_at')->nullable()->after('otp');
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
