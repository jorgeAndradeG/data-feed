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
        Schema::create('product', function (Blueprint $table) {
            $table->id('entity_id');
            $table->string('CategoryName')->nullable();
            $table->integer('sku')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('shortdesc')->nullable();
            $table->double('price')->nullable();
            $table->longText('link')->nullable();
            $table->longText('image')->nullable();
            $table->string('Brand')->nullable();
            $table->double('Rating')->nullable();
            $table->string('CaffeineType')->nullable();
            $table->integer('Count')->nullable();
            $table->string('Flavored')->nullable();
            $table->string('Seasonal')->nullable();
            $table->string('Instock')->nullable();
            $table->integer('Facebook')->nullable();
            $table->integer('IsKCup')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
