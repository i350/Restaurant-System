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
        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id');
            $table->foreignId('ingredient_id');
            $table->unsignedInteger('amount');

            $table->foreign("product_id")
                ->references('id')
                ->on("products")
                ->cascadeOnDelete();
            $table->foreign("ingredient_id")
                ->references('id')
                ->on("ingredients")
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_ingredients');
    }
};
