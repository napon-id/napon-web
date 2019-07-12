<?php

use Illuminate\Database\Seeder;
use App\Simulation;

class SimulationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->items() as $item) {
            Simulation::create($item);
        }
    }

    public function items(): array
    {
        return [
            //product AKARKU
            [
                'product_id' => 1,
                'year' => 1,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 1,
                'year' => 2,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 1,
                'year' => 3,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 1,
                'year' => 4,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 1,
                'year' => 5,
                'min' => 9,
                'max' => 15
            ],[
                'product_id' => 1,
                'year' => 6,
                'min' => 9,
                'max' => 15
            ], 
            // product BATANGKU
            [
                'product_id' => 2,
                'year' => 1,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 2,
                'year' => 2,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 2,
                'year' => 3,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 2,
                'year' => 4,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 2,
                'year' => 5,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 2,
                'year' => 6,
                'min' => 9,
                'max' => 15
            ],
            // product RANTINGKU
            [
                'product_id' => 3,
                'year' => 1,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 3,
                'year' => 2,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 3,
                'year' => 3,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 3,
                'year' => 4,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 3,
                'year' => 5,
                'min' => 9,
                'max' => 19
            ], [
                'product_id' => 3,
                'year' => 6,
                'min' => 9,
                'max' => 15
            ], 
            // product DAUNKU
            [
                'product_id' => 4,
                'year' => 1,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 4,
                'year' => 2,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 4,
                'year' => 3,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 4,
                'year' => 4,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 4,
                'year' => 5,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 4,
                'year' => 6,
                'min' => 9,
                'max' => 15
            ], 
            // product HUTANKU
            [
                'product_id' => 5,
                'year' => 1,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 5,
                'year' => 2,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 5,
                'year' => 3,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 4,
                'year' => 4,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 5,
                'year' => 5,
                'min' => 9,
                'max' => 15
            ], [
                'product_id' => 5,
                'year' => 6,
                'min' => 9,
                'max' => 15
            ]
        ];
    }
}
