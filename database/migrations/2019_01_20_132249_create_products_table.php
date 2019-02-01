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
            $table->foreign('tree_id')->references('id')->on('trees')->onDelete('cascade');
            $table->string('name');
            $table->integer('tree_quantity');
            $table->text('description')->nullable();
            $table->string('time');
            $table->integer('percentage');
            $table->enum('available', ['yes', 'no'])->default('yes');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('products')->insert([
          [
            'tree_id' => 1,
            'name' => 'AKARKU',
            'tree_quantity' => 1,
            'time' => '5-6 tahun',
            'percentage' => 85,
            'available' => 'yes',
          ],
          [
            'tree_id' => 1,
            'name' => 'BATANGKU',
            'tree_quantity' => 10,
            'time' => '5-6 tahun',
            'percentage' => 85,
            'available' => 'yes',
          ],
          [
            'tree_id' => 1,
            'name' => 'RANTINGKU',
            'tree_quantity' => 25,
            'time' => '5-6 tahun',
            'percentage' => 85,
            'available' => 'yes',
          ],
          [
            'tree_id' => 1,
            'name' => 'DAUNKU',
            'tree_quantity' => 50,
            'time' => '5-6 tahun',
            'percentage' => 85,
            'available' => 'yes',
          ],
          [
            'tree_id' => 1,
            'name' => 'HUTANKU',
            'tree_quantity' => 100,
            'time' => '5-6 tahun',
            'percentage' => 85,
            'available' => 'yes',
          ],
        ]);
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
