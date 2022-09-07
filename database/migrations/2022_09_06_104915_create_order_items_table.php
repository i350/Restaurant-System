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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('order_id');
            $table->foreignId('product_id');
            $table->unsignedInteger('quantity');

            $table->foreign("order_id")
                ->references('id')
                ->on("orders")
                ->cascadeOnDelete();
            $table->foreign("product_id")
                ->references('id')
                ->on("products")
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
        Schema::dropIfExists('order_items');
    }
};
