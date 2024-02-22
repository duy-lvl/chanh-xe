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
        Schema::create('partner_route_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained(table: 'partner_stations');
            $table->foreignId('partner_route_id')->constrained(table: 'partner_routes');
            $table->integer('milestone_number');
            $table->integer('distance_from_previous')->comment("unit: meter");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_route_milestones');
    }
};
