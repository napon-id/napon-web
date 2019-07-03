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
            $table->integer('tree_quantity');
            $table->string('img');
            $table->text('secondary_img')->nullable();
            $table->text('simulation_img')->nullable();
            $table->text('description')->nullable();
            $table->string('time');
            $table->integer('percentage');
            $table->enum('available', ['yes', 'no'])->default('yes');
            $table->boolean('has_certificate')->nullable();
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
