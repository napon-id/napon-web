<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
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
                Product::updateOrCreate($item);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function items(): array 
    {
        return [
            [
                'tree_id' => 1,
                'name' => 'AKARKU',
                'tree_quantity' => 2,
                'description' => 'Nikmati menabung dari hal yang kecil. Tabung 2 pohon, anda mendukung go green.',
                'available' => 'yes',
                'img_black' => 'https://napon.id/images/media/product/akarku-black.png',
                'img_white' => 'https://napon.id/images/media/product/akarku-white.png',
                'img_background' => 'https://napon.id/images/media/product/akarku-background.png',
                'price' => 400000
            ],[
                'tree_id' => 1,
                'name' => 'BATANGKU',
                'tree_quantity' => 10,
                'description' => 'Menabung pohon memberikan dampak yang positif. Tabung 10 pohon, anda mendukung menanamkan pohon.',
                'available' => 'yes',
                'img_black' => 'https://napon.id/images/media/product/batangku-black.png',
                'img_white' => 'https://napon.id/images/media/product/batangku-white.png',
                'img_background' => 'https://napon.id/images/media/product/batangku-background.png',
                'price' => 2000000
            ],[
                'tree_id' => 1,
                'name' => 'RANTINGKU',
                'tree_quantity' => 25,
                'description' => 'Menabung pohon cara yang paling tepat untuk selamatkan bumi. Tabung 25 pohon, anda mendukung pertumbuhan pohon.
                ',
                'available' => 'yes',
                'img_black' => 'https://napon.id/images/media/product/rantingku-black.png',
                'img_white' => 'https://napon.id/images/media/product/rantingku-white.png',
                'img_background' => 'https://napon.id/images/media/product/rantingku-background.png',
                'price' => 5000000
            ],[
                'tree_id' => 1,
                'name' => 'DAUNKU',
                'tree_quantity' => 50,
                'description' => 'Kesadaran menabung pohon memberikan banyak manfaat. Tabung 50 pohon, anda membantu meningkatkan kualitas udara (menyerap CO2).',
                'available' => 'yes',
                'img_black' => 'https://napon.id/images/media/product/daunku-black.png',
                'img_white' => 'https://napon.id/images/media/product/daunku-white.png',
                'img_background' => 'https://napon.id/images/media/product/daunku-background.png',
                'price' => 10000000
            ],[
                'tree_id' => 1,
                'name' => 'HUTANKU',
                'tree_quantity' => 100,
                'description' => 'Menabung pohon menjadi nilai investasi yang menguntungkan. Tabung 100 pohon, anda telah menyelamatkan bumi dan memberikan dampak terhadap lingkungan sekitar.',
                'available' => 'yes',
                'img_black' => 'https://napon.id/images/media/product/hutanku-black.png',
                'img_white' => 'https://napon.id/images/media/product/hutanku-white.png',
                'img_background' => 'https://napon.id/images/media/product/hutanku-background.png',
                'price' => 20000000
            ]
        ];
    }
}
