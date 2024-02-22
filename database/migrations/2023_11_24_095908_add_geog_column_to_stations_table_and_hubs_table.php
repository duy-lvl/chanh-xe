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
        Schema::table('partner_stations', function (Blueprint $table) {
            $table->magellanGeography('geography');
        });

        Schema::table('hubs', function (Blueprint $table) {
            $table->magellanGeography('geography');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hubs', function (Blueprint $table) {
            $table->dropColumn('geography');
        });

        Schema::table('partner_stations', function (Blueprint $table) {
            $table->dropColumn('geography');
        });
    }
};
