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
        Schema::create('partner_drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained(table: 'partners');
            $table->string('name');
            $table->string('avatar_url');
            $table->string('phone');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['partner_id', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_drivers');
    }
};
