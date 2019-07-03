<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->string('report_key');
            $table->string('period');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('tree_height')->nullable();
            $table->double('tree_diameter')->nullable();
            $table->text('tree_state')->nullable();
            $table->string('weather')->nullable();
            $table->integer('roi')->nullable();
            $table->text('report_image');
            $table->text('report_video');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
