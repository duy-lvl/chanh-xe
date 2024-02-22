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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('box_size_id')->constrained(table: 'box_sizes');
            $table->date('apply_from');
            $table->date('apply_to');
            $table->string('name')->nullable();
            $table->integer('priority');
            $table->string('note')->nullable();
            $table->integer('status')->comment("0 - Inactive\n1-Active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
