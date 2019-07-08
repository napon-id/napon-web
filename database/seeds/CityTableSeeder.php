    <?php

use Illuminate\Database\Seeder;
use App\Cities;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->items() as $item) {
            Cities::query()->updateOrCreate($item);
        }
    }

    public function items(): array
    {
        $csv = array_map('str_getcsv', file(base_path() . "/database/seeds/csv/cities.csv"));
        $cities = [];

        foreach ($csv as $value) {
            $item['id'] = $value[0];
            $item['province_id'] = $value[1];
            $item['name'] = $value[2];

            array_push($cities, $item);
        }

        return $cities;
    }
}
