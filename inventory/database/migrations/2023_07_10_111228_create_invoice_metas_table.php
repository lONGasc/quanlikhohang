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
        Schema::create('invoice_metas', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('category_id');
            $table->integer('product_id');
            $table->string('unit_price');
            $table->string('quantity');
            $table->string('unit_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_metas');
    }
};
