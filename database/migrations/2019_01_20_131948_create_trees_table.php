<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 16, 2);
            $table->enum('available', ['yes', 'no'])->default('yes');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('trees')->insert([
          [
            'name' => 'Sengon Solomon',
            'description' =>  'Sengon (Albizia chinensis) adalah pohon penghasil kayu. Pohon Sengon Solomon dapat dipanen ketika masuk usia 5 hingga 6 tahun dengan perkiraan tinggi 10-13 meter dan diameter sekitar 25-30cm.',
            'price' => 300000.00,
            'available' => 'yes',
          ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trees');
    }
}
