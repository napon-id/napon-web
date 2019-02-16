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
        Product::create([
            'tree_id' => 1,
            'name' => 'AKARKU',
            'img' => 'https://media.napon.id/img/akarku2.png',
            'tree_quantity' => 1,
            'description' => 'Nikmati menabung dari hal yang kecil. Tabung 1 pohon, anda mendukung go green.',
            'time' => '5-6 tahun',
            'percentage' => 85,
            'available' => 'yes',
        ]);

        Product::create([
            'tree_id' => 1,
            'name' => 'BATANGKU',
            'img' => 'https://media.napon.id/img/vbatangku2.png',
            'tree_quantity' => 10,
            'description' => 'Menabung pohon memberikan dampak yang positif. Tabung 10 pohon, anda mendukung menanamkan pohon.',
            'time' => '5-6 tahun',
            'percentage' => 85,
            'available' => 'yes',
        ]);

        Product::create([
            'tree_id' => 1,
            'name' => 'RANTINGKU',
            'img' => 'https://media.napon.id/img/rantingku2.png',
            'tree_quantity' => 25,
            'description' => 'Menabung pohon cara yang paling tepat untuk selamatkan bumi. Tabung 25 pohon, anda mendukung pertumbuhan pohon.
',
            'time' => '5-6 tahun',
            'percentage' => 85,
            'available' => 'yes',
        ]);

        Product::create([
            'tree_id' => 1,
            'name' => 'DAUNKU',
            'img' => 'https://media.napon.id/img/daunku2.png',
            'tree_quantity' => 50,
            'description' => 'Kesadaran menabung pohon memberikan banyak manfaat. Tabung 50 pohon, anda membantu meningkatkan kualitas udara (menyerap CO2).',
            'time' => '5-6 tahun',
            'percentage' => 85,
            'available' => 'yes',
        ]);

        Product::create([
            'tree_id' => 1,
            'name' => 'HUTANKU',
            'img' => 'https://media.napon.id/img/hutanku2.png',
            'tree_quantity' => 100,
            'description' => 'Menabung pohon menjadi nilai investasi yang menguntungkan. Tabung 100 pohon, anda telah menyelamatkan bumi dan memberikan dampak terhadap lingkungan sekitar.',
            'time' => '5-6 tahun',
            'percentage' => 85,
            'available' => 'yes',
        ]);
    }
}
