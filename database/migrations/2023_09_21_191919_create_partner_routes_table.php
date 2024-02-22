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
        Schema::create('partner_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained(table: 'partners');
            $table->integer('start_city_code');
            $table->integer('start_district_code');
            $table->integer('end_city_code');
            $table->integer('end_district_code');
            $table->string('name')->nullable();
            $table->string('package_types')->comment("0 - Normal\n1 - Food\n2 - Chemical\n3 - Document\n4 - Electronic\n5 - Fragile");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_routes');
    }
};
