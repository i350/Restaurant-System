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
        Schema::create('ingredient_stock_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id');
            $table->unsignedInteger('in')->default(0);
            $table->unsignedInteger('out')->default(0);
            $table->unsignedInteger('remaining')->comment("Closing amount");
            $table->string('comment')->nullable();
            $table->timestamps();


            $table->foreign("ingredient_id")
                ->references('id')
                ->on("ingredients");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient_stock_activities');
    }
};
