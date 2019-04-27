<?php

use Illuminate\Database\Seeder;
use App\Description;

class DescriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Description::create([
            'img' => 'https://napon.id/images/media/icon/registrasi.png',
            'title' => 'Registrasi',
            'text' => 'Anda dapat mendaftar pada platform Napon.ID melalui Website atau Aplikasi.'
        ]);
        Description::create([
            'img' => 'https://napon.id/images/media/icon/danai.png',
            'title' => 'Menabung',
            'text' => 'Anda dapat memulai menabung pohon melalui platform kami setelah melakukan verifikasi alamat email.'
        ]);
        Description::create([
            'img' => 'https://napon.id/images/media/icon/budidaya.png',
            'title' => 'Budidaya',
            'text' => 'Napon.ID bersama mitra petani menjalankan proyek budidaya dengan dana yang Anda tabung.'
        ]);
        Description::create([
            'img' => 'https://napon.id/images/media/icon/panen.png',
            'title' => 'Panen',
            'text' => 'Napon.ID bersama mitra petani menjual hasil budidaya ketika musim panen telah tiba.'
        ]);
        Description::create([
            'img' => 'https://napon.id/images/media/icon/bagi-hasil.png',
            'title' => 'Bagi hasil',
            'text' => 'Setelah panen selesai, Anda dapat menikmati keuntungan dari bagi hasil dengan dana yang Anda tabung.'
        ]);
    }
}
