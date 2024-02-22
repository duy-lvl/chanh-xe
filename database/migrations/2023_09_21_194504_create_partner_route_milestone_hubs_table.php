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
        Schema::create('partner_route_milestone_hubs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_route_milestone_id')->constrained(table: 'partner_route_milestones');
            $table->foreignId('hub_id')->constrained(table: 'hubs');
            $table->integer('distance_from_milestone')->comment("unit: meter");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_route_milestone_hubs');
    }
};
