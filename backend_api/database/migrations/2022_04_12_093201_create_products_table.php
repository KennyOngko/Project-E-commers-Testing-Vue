<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoriesID');
            $table->foreign('categoriesID')->references('id')->on('categories');
            $table->integer('qty');
            $table->string('productName');
            $table->BigInteger('price');
            $table->String('gambar')->nullable();
            $table->String('description')->nullable();
            $table->boolean('toggle')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
