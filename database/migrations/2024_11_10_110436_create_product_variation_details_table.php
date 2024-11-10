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
        Schema::create('product_variation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->unsignedBigInteger('option_id')->nullable();
            $table->unsignedBigInteger('value_id')->nullable();
            $table->timestamps();

            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('set null');
            $table->foreign('option_id')->references('id')->on('variation_options')->onDelete('set null');
            $table->foreign('value_id')->references('id')->on('variation_values')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation_details');
    }
};
