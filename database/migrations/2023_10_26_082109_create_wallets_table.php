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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained(table: 'partners');
            $table->bigInteger('balance')->default(0);
            $table->integer('type')->comment("0 - Cash\n1 - Revenue\n2 - CollectionOnBehalf");
            $table->timestamps();

            $table->unique(['partner_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
