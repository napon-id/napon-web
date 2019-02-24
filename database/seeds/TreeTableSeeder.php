<?php

use Illuminate\Database\Seeder;
use App\Tree;

class TreeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tree::create([
            'name' => 'Sengon Solomon',
            'description' =>  'Sengon (Albizia chinensis) adalah pohon penghasil kayu. Pohon Sengon Salomon dapat dipanen ketika masuk usia 5 hingga 6 tahun dengan perkiraan tinggi 10-13 meter dan diameter sekitar 25-30cm.',
            'price' => 300000.00,
            'available' => 'yes',
        ]);
    }
}
