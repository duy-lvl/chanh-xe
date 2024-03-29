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
        Schema::table('partners', function (Blueprint $table) {
            $table->string('avatar_url')->nullable();
            $table->string('description')->nullable();
        });

        Schema::table('partner_stations', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('avatar_url');
            $table->dropColumn('description');
        });

        Schema::table('partner_stations', function (Blueprint $table) {
            $table->string('image_url')->nullable();
        });
    }
};
