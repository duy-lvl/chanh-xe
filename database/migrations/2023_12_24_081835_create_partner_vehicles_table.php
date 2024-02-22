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
        Schema::create('partner_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained(table: 'partners');
            $table->string('type');
            $table->string('image_url');
            $table->string('plate_number');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_vehicles');
    }
};
