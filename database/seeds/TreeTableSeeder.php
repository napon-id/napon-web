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
        try {
            foreach ($this->items() as $item) {
                Tree::updateOrCreate($item);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function items(): array
    {
        return [
            [
                'name' => 'Sengon Solomon',
                'description' =>  'Sengon (Albizia chinensis) adalah pohon penghasil kayu. Pohon Sengon Salomon dapat dipanen ketika masuk usia 5 hingga 6 tahun dengan perkiraan tinggi 10-13 meter dan diameter sekitar 25-30cm.'
            ]
        ];
    }
}
