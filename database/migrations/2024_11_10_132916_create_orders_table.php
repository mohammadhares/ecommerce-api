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
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('cart_id')->nullable();
            $table->unsignedBigInteger('address_id');
            $table->decimal('total_amount', 10, 2);
            $table->date('delivery_date')->nullable();
            $table->time('delivery_time')->nullable();
            $table->decimal('delivery_fee', 10, 2)->nullable();
            $table->string('status', 20)->default('Pending');
            $table->string('payment_status', 20)->default('Unpaid');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('set null');
            // $table->foreign('address_id')->references('id')->on('customer_addresses')->onDelete('set null');
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
