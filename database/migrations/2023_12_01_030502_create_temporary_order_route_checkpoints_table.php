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
        Schema::create('temporary_order_route_checkpoints', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('temporary_order_route_id')->constrained(table: 'temporary_order_routes');
            $table->morphs('checkpoint');
            $table->integer('checkpoint_number');
            $table->integer('distance_from_previous');
            $table->double('distance_percentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_order_route_checkpoints');
    }
};
