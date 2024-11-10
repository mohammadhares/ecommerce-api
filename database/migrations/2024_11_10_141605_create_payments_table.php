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
        Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('payment_card_id');
                $table->string('payment_method', 50); // e.g., 'Credit Card', 'PayPal'
                $table->decimal('amount', 10, 2);
                $table->dateTime('payment_date');
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                // $table->foreign('payment_card_id')->references('id')->on('payment_cards')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
