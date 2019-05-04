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
                'img' => 'https://napon.id/images/media/product/akarku2.png',
                'tree_quantity' => 1,
                'description' => 'Nikmati menabung dari hal yang kecil. Tabung 1 pohon, anda mendukung go green.',
                'time' => '5-6 tahun',
                'percentage' => 85,
                'available' => 'yes',
                'has_certificate' => false,
                'img_android' => 'https://napon.id/images/media/product/android-akarku.jpg',
                'secondary_img' => 'https://napon.id/images/media/product/akarku.png',
                'simulation_img' => 'https://napon.id/images/media/simulate/akarku.jpg'
            ],
            [
                    'tree_id' => 1,
                    'name' => 'BATANGKU',
                    'img' => 'https://napon.id/images/media/product/batangku2.png',
                    'tree_quantity' => 10,
                    'description' => 'Menabung pohon memberikan dampak yang positif. Tabung 10 pohon, anda mendukung menanamkan pohon.',
                    'time' => '5-6 tahun',
                    'percentage' => 85,
                    'available' => 'yes',
                    'has_certificate' => true,
                    'img_android' => 'https://napon.id/images/media/product/android-batangku.jpg',
                    'secondary_img' => 'https://napon.id/images/media/product/batangku.png',
                    'simulation_img' => 'https://napon.id/images/media/simulate/batangku.jpg'
            ],
            [
                'tree_id' => 1,
                'name' => 'RANTINGKU',
                'img' => 'https://napon.id/images/media/product/rantingku2.png',
                'tree_quantity' => 25,
                'description' => 'Menabung pohon cara yang paling tepat untuk selamatkan bumi. Tabung 25 pohon, anda mendukung pertumbuhan pohon.
    ',
                'time' => '5-6 tahun',
                'percentage' => 85,
                'available' => 'yes',
                'has_certificate' => true,
                'img_android' => 'https://napon.id/images/media/product/android-rantingku.jpg',
                'secondary_img' => 'https://napon.id/images/media/product/rantingku.png',
                'simulation_img' => 'https://napon.id/images/media/simulate/rantingku.jpg'
            ],
            [
                'tree_id' => 1,
                'name' => 'DAUNKU',
                'img' => 'https://napon.id/images/media/product/daunku2.png',
                'tree_quantity' => 50,
                'description' => 'Kesadaran menabung pohon memberikan banyak manfaat. Tabung 50 pohon, anda membantu meningkatkan kualitas udara (menyerap CO2).',
                'time' => '5-6 tahun',
                'percentage' => 85,
                'available' => 'yes',
                'has_certificate' => true,
                'img_android' => 'https://napon.id/images/media/product/android-daunku.jpg',
                'secondary_img' => 'https://napon.id/images/media/product/daunku.png',
                'simulation_img' => 'https://napon.id/images/media/simulate/daunku.jpg'
            ],
            [
                'tree_id' => 1,
                'name' => 'HUTANKU',
                'img' => 'https://napon.id/images/media/product/hutanku2.png',
                'tree_quantity' => 100,
                'description' => 'Menabung pohon menjadi nilai investasi yang menguntungkan. Tabung 100 pohon, anda telah menyelamatkan bumi dan memberikan dampak terhadap lingkungan sekitar.',
                'time' => '5-6 tahun',
                'percentage' => 85,
                'available' => 'yes',
                'has_certificate' => true,
                'img_android' => 'https://napon.id/images/media/product/android-hutanku.jpg',
                'secondary_img' => 'https://napon.id/images/media/product/hutanku.png',
                'simulation_img' => 'https://napon.id/images/media/simulate/hutanku.jpg'
            ]
        ];
    }
}
