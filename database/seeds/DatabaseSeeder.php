<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TreeTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        // $this->call(OrderTableSeeder::class);
        $this->call(FaqTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(DescriptionTableSeeder::class);
        $this->call(BannerTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(BankListSeeder::class);
    }
}
