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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('start_station_id')->constrained(table: 'partner_stations');
            $table->foreignId('end_station_id')->constrained(table: 'partner_stations');
            $table->foreignId('customer_id')->nullable()->constrained(table: 'customers');
            $table->string('code')->unique();
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('sender_email')->nullable();
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('receiver_email')->nullable();
            $table->text('note')->nullable();
            $table->bigInteger('package_value')->comment('unit: VND');
            $table->bigInteger('delivery_price')->comment('unit: VND');
            $table->double('weight')->comment('unit: g');
            $table->double('height')->comment('unit: mm');
            $table->double('length')->comment('unit: mm');
            $table->double('width')->comment('unit: mm');
            $table->boolean('collect_on_delivery');
            $table->boolean('is_confirmed')->default(false);
            $table->boolean('is_cancelled')->default(false);
            $table->string('cancel_token')->nullable();
            $table->string('package_types')->comment("0 - Normal\n1 - Food\n2 - Chemical\n3 - Document\n4 - Electronic\n5 - Fragile");
            $table->integer('payment_method')->comment("0 - Cash\n1 - VNPay");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
