<?php

use Illuminate\Database\Seeder;
use App\Banner;

class BannerTableSeeder extends Seeder
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
                Banner::updateOrCreate($item);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function items(): array
    {
        return [
            [
                'img' => 'https://napon.id/images/media/img/bg-first.jpg',
                'description' => 'Rajin Menabung Pohon Pangkal Kaya + Bonus Alam Lestari. AYO #NabungPohon'
            ],
            [
                'img' => 'https://napon.id/images/media/img/bg-second.jpg',
                'description' => 'Setiap Yang Kita Tanam Akan Kita Tuai Hasilnya. #NabungPohon Sekarang'
            ],
            [
                'img' => 'https://napon.id/images/media/img/bg-third.jpg',
                'description' => 'Hutan Lestari, Anak Cucu Terjamin. AYO #NabungPohon'
            ]
        ];
    }
}
