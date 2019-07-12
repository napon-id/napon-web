<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tree_id');
            $table->string('name');
            $table->text('description');
            $table->integer('tree_quantity');
            $table->integer('price');
            $table->string('img_black');
            $table->text('img_white')->nullable();
            $table->text('img_background')->nullable();
            $table->enum('available', ['yes', 'no'])->default('yes');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tree_id')->references('id')->on('trees')->onDelete('cascade');
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
}
