<?php

use Illuminate\Database\Seeder;
use App\Faq;

class FaqTableSeeder extends Seeder
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
                Faq::updateOrCreate($item);       
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function items(): array
    {
        return [

            [
                'question' => 'Jenis pohon apa saja yang ditanam di Napon Investama Indonesia ?',
                'category' => 'about',
                'answer' => 'Untuk saat ini portal yang ada adalah “Pohon Sengon Solomon” . Sengon Solomon merupakan jenis varian pohon sengon yang berasal dari kepulauan Solomon dan memiliki keistimewaan dengan pertumbuhan yang sangat cepat hingga 2 kali lebih cepat dari sengon biasa. Jika sengon pada umumnya pada usia 6-7 tahun maksimal hanya mampu memperoleh diameter pohon sekitar 15-25 cm, sedangkan sengon Solomon dalam 6-7 tahun dapat memiliki diameter minimal 30-45 cm.'
            ],
            [
                'question' => 'Di mana lokasi Napon Investama Indonesia ?',
                'category' => 'about',
                'answer' => 'Lokasi kantor Napon Investama Indonesia berada di Jalan Pattimura Raya , kompleks Ruko masjid Baitut Taqwa, Mapagan, kec.Ungaran Barat,Kab.Semarang. Adapun lokasi pohon ada di beberapa lokasi yaitu Jepara, Rembang, Pati, Temanggung. Dan akan terus berkembang dengan berkembangnya Napon Investama Indonesia.'
            ],
            [
                'question' => 'Bentuk kerjasama apa saja yang ditawarkan Napon Investama Indonesia ?',
                'category' => 'about',
                'answer' => 'Napon merupakan penyedia Platform Menabung Pohon untuk masyarakat yang ingin menanam pohon sengon namun tidak punya keahlian bercocok tanam, tidak memiliki lahan, dan tidak memiliki link untuk menjual. '
            ],
            [
                'question' => 'Apakah Napon Investama Indonesia dilindungi OJK ?',
                'category' => 'about',
                'answer' => null,
            ],
            [
                'question' => 'Apakah Napon Investama Indonesia adalah perusahaan yang berbadan hukum ?',
                'category' => 'about',
                'answer' => null,
            ],
            // faq about user
            [
                'question' => 'Tentang Resiko ?',
                'category' => 'user',
                'answer' => 'Segala bentuk usaha pasti memiliki yang Namanya resiko. Sedangkan resiko terbesar dari User dan Napon ialah bencana Alam, adapun team Napon sudah melakukan riset SWOT secara fundamental maupun teknikal.'
            ],
            [
                'question' => 'Siapa yang membeli pohon tanam saya jika saya menjualnya ?',
                'category' => 'user',
                'answer' => 'Napon Investama Indonesia sudah memiliki team khusus, kami akan langsung menjual pohon ke pabrik pohon. Tentunya dengam pengolahan dari team Napon Investama Indonesia sehingga user akan mendapatkan harga terbaik. Sebab kami memangkas ongkos dari broker.'
            ],
    
            [
                'question' => 'Kapan saya mendapatkan report mengenai perkembangan pohon yang ditanam ?',
                'category' => 'user',
                'answer' => 'Kita akan melakukan report melalui foto, video dan laporan secara rutin setiap setahun sekali. Dan dapat dipantau pada dashboard website Napon Investama Indonesia maupun aplikasi Napon Investama Indonesia (comming soon).'
            ],
            [
                'question' => 'Kapan saya bisa menjual pohon di Napon Investama Indonesia ?',
                'category' => 'user',
                'answer' => 'Untuk mendapatkan harga terbaik maka team Napon Investama Indonesia akan menjual pohon dari user ketika sudah mencpaia diameter sekitar 30-35 cm dan itu untuk sengon Solomon berumur 5-6 tahun.'
            ],
    
            [
                'question' => 'Di mana saya dapat men-donwload aplikasi Napon Investama Indonesia ?',
                'category' => 'user',
                'answer' => 'Aplikasi Napon Investama Indonesia dapat di-download pada Play Store dan Apple Store (comming soon).'
            ],
            [
                'question' => 'Berapa banyak pohon yang dapat di beli oleh member Napon ?',
                'category' => 'user',
                'answer' => 'Kami memiliki beberapa paket, Anda dapat membeli secara berkala.'
            ],
    
            [
                'question' => 'Bagaimana sistem bagi hasil Napon Investama Indonesia ? ',
                'category' => 'user',
                'answer' => 'Sistem bagi hasil Napon Investama Indonesia dapat dilihat pada menu Layanan.',
            ],
            [
                'question' => 'Bagaimana saya menerima uang penjualan pohon ?',
                'category' => 'user',
                'answer' => 'Kami akan memberikan laporan melalui pesan elektronik (email) dan ketika Anda menyetujui maka hasil penjualan akan kami transfer ke rekening yang dimiliki.'
            ],
    
            [
                'question' => 'Bagaimana jika pohon saya rusak ?',
                'category' => 'user',
                'answer' => 'Kami akan mengganti dengan yang baru dengan cara tukar guling.'
            ],
            [
                'question' => 'Bagaimana cara menghitung harga pohon ?',
                'category' => 'user',
                'answer' => 'Berdasarkan diameter pohon dan hasil pengolahan Napon Investama Indonesia berdasarkan real harga tanpa ada rekayasa.'
            ],
            [
                'question' => 'Bagaimana cara menghitung biaya-biaya perawatan pohon ? ',
                'category' => 'user',
                'answer' => null,
            ],
            [
                'question' => 'Bagaimana cara memesan pohon di Napon ?',
                'category' => 'user',
                'answer' => 'Melakukan registrasi menjadi user – Melakukan verifikasi melalui email – Melengkapi informasi user - Melakukan pemilihan paket – Transfer ke salah satu rekening Napon Investama Indonesia – User mendapatkan sertifikat pohon sebagai bukti kepemilikan pohon.'
            ],
            [
                'question' => 'Bagaimana cara kerja sistem Napon Investama Indonesia ? ',
                'category' => 'user',
                'answer' => 'Anda dapat melihat cara kerja Napon Investama Indonesia secara detil pada halaman Layanan.'
            ],
            [
                'question' => 'Bagaimana cara bergabung dengan Napon ?',
                'category' => 'user',
                'answer' => 'Anda dapat mengarah ke halaman Registrasi Napon Investama Indonesia dan melakukan registrasi menggunakan alamat email aktif.'
            ],
            [
                'question' => 'Apakah semua transaksi saya di Napon aman ?',
                'category' => 'user',
                'answer' => 'Napon Investama Indonesia telah terdaftar sebagai anggota dari fintech asia dan diawasi oleh OJK.'
            ],
            [
                'question' => 'Apakah ada laporan perkembangan pohon dari Napon ?',
                'category' => 'user',
                'answer' => 'Ada. Setelah pohon Anda ditanam Anda akan mendapatkan laporan secara rutin.'
            ],
            [
                'question' => 'Apa saja kewajiban yang harus dipenuhi member Napon ?',
                'category' => 'user',
                'answer' => 'Mengisi informasi akun secara detail dan dengan data yang sesuai.'
            ],
            [
                'question' => 'Apa saja hak member Napon ?',
                'category' => 'user',
                'answer' => 'Setiap member Napon Investama Indonesia memiliki hak akses atas akun yang dimiliki dan sertifikat pohon beserta informasi secara jelas dari pohon yang ditabung.',
            ],
            [
                'question' => 'Apa itu member Napon Investama Indonesia ?',
                'category' => 'user',
                'answer' => 'Member Napon Investama Indonesia merupakan bentuk akun yang menunjukkan bahwa Anda merupakan penanam pohon pada platform Napon Investama Indonesia.'
            ],
            // question about miscellanous
            [
                'question' => 'Kapan pohon akan panen ?',
                'category' => 'misc',
                'answer' => 'Pada tahun ke 5-6 pohon akan diolah, dan tahun ke 7 kami menjual dan membagikan keuntungan kepada user sesuai dengan porsi yang dijelaskan pada halaman Layanan.'
            ],
            [
                'question' => 'Apakah untuk bertransaksi di Napon harus setor dalam jumlah besar ? ',
                'category' => 'misc',
                'answer' => 'Tidak perlu.'
            ],
            [
                'question' => 'Apakah saya bisa melakukan kunjungan ke tempat budidaya pohon ?',
                'category' => 'misc',
                'answer' => 'Tentu bisa, dengan menghubungi dan melakukan konfirmasi kunjungan melalui telepon/whatsapp ataupun email ke kontak Napon Investama Indonesia.'
            ]
        ];
    }
}
