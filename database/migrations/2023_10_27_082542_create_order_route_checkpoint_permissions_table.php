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
        Schema::create('order_route_checkpoint_permissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('order_route_checkpoint_id')->constrained(table: 'order_route_checkpoints');
            $table->integer('permission')->comment("0 - Accept\n1 - Delivering\n2 - Delivered\n3 - Done\n4 - Cancel");
            $table->timestamp('achieved_at')->nullable();
            $table->integer('permission_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_route_checkpoint_permissions');
    }
};
