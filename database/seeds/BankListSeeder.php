<?php

use Illuminate\Database\Seeder;
use App\BankList;

class BankListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->items() as $item) {
            BankList::query()->updateOrCreate($item);
        }
    }

    public function items(): array
    {
        $csv = array_map('str_getcsv', file(base_path() . "/database/seeds/csv/banks.csv"));
        $banks = [];

        foreach ($csv as $value) {
            $item['code'] = $value[0];
            $item['bank_name'] = $value[1];
            $item['full_bank_name'] = $value[2];

            array_push($banks, $item);
        }

        return $banks;
    }
}
