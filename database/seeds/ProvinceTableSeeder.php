<?php

use Illuminate\Database\Seeder;
use App\Province;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        foreach ($this->items() as $item) {
            Province::query()->updateOrCreate($item);
        }
    }

    public function items(): array
    {
        $csv = array_map('str_getcsv', file(base_path() . "/database/seeds/csv/provinces.csv"));
        $provinces = [];

        foreach ($csv as $value) {
            $item['id'] = $value[0];
            $item['name'] = $value[1];

            array_push($provinces, $item);
        }

        return $provinces;
    }
}
