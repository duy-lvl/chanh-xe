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
        Schema::table('order_route_checkpoints', function (Blueprint $table) {
            $table->foreignId('vehicle_id')->nullable()->constrained('partner_vehicles');
            $table->foreignId('driver_id')->nullable()->constrained('partner_drivers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_route_checkpoints', function (Blueprint $table) {
            $table->dropConstrainedForeignId('vehicle_id');
            $table->dropConstrainedForeignId('driver_id');
        });
    }
};
