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
        Schema::table('orders', function (Blueprint $table) {
            // Add delivery_charge only if it does not exist
            if (!Schema::hasColumn('orders', 'delivery_charge')) {
                $table->decimal('delivery_charge', 10, 2)->default(0)->after('total');
            }

            // Add status column only if it does not exist
            if (!Schema::hasColumn('orders', 'status')) {
                $table->enum('status', [
                    'placed',
                    'paid',
                    'assigned',
                    'picked',
                    'on_the_way',
                    'delivered',
                    'cancelled'
                ])->default('placed')->after('total');
            }

            // Add delivery_partner_id only if it does not exist
            if (!Schema::hasColumn('orders', 'delivery_partner_id')) {
                $table->unsignedBigInteger('delivery_partner_id')->nullable()->after('user_id');
                $table->foreign('delivery_partner_id')
                      ->references('id')->on('users')
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'delivery_charge')) {
                $table->dropColumn('delivery_charge');
            }
            if (Schema::hasColumn('orders', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('orders', 'delivery_partner_id')) {
                $table->dropForeign(['delivery_partner_id']);
                $table->dropColumn('delivery_partner_id');
            }
        });
    }
};
