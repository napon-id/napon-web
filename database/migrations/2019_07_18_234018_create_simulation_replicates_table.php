<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimulationReplicatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulation_replicates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->integer('year');
            $table->integer('min');
            $table->integer('max');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product_replicates')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simulation_replicates');
    }
}
