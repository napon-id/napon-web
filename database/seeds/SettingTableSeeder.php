<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key' => 'term_and_condition',
            'value' => '
                <p align="justify">Selamat datang di NAPON (Nabung Pohon)</p>
                <p align="justify">Syarat &amp; Ketentuan (S&amp;K) yang ditetapkan di bawah ini mengatur seluruh pemakaian jasa aplikasi Napon yang dibuat oleh <strong>PT. Napon Investama Indonesia.</strong> Pengguna diharapkan membaca setiap poin informasi S&amp;K seksama karena berdampak pada hak dan kewajiban Pengguna di bawah hukum.</p>
                <p align="justify">Dengan mendaftar dan atau menggunakan aplikasi Napon, maka pengguna dianggap telah membaca, mengerti, memahami, dan menyetujui seluruh isi syarat dan ketentuan. Syarat dan ketentuan merupakan bentuk kesepakatan yang dituangkan dalam perjanjian yang sah antara Pengguna dengan PT. Napon Investama Indonesia. Jika Pengguna tidak menyetujui salah satu, sebagian, atau seluruh isi syarat dan ketentuan, maka Pengguna tidak diperkenankan menggunakan layanan di aplikasi Napon.</p>
                <p align="justify"><strong>Definisi</strong></p>
                <p align="justify">Pihak Pertama adalah PT Napon Investama Indonesia selaku penerima dan pengelola dana penabung. Pihak Kedua adalah penabung pemilik dana investasi.</p>
                <p align="justify">Pihak Ketiga adalah kelompok petani yang tergabung sebagai mitra petani Pihak Pertama. Berkewajiban mengelola dana investasi dengan cara merawat pohon dari Pihak Pertama.</p>
                <p align="justify">Virtual money adalah saldo yang ada di aplikasi Napon. Bentuk Virtual Money Napon adalah <strong>SaldoPon</strong>.</p>
                <p align="justify"><em>Force Majeur</em> adalah kejadian atau keadaan yang terjadi diluar kuasa dari para pihak yang bersangkutan, dalam hal ini perusahaan dan pekerja/buruh seperti bencana alam, kebakaran, sabotase, perang, pencurian, pemberontakan, banjir, dan lainnya.</p>
                <p align="justify"><strong>Ruang Lingkup</strong></p>
                <p align="justify">Pihak Pertama, Pihak Kedua, dan Pihak Ketiga setuju dan sepakat mengadakan perjanjian kerja sama investasi di bidang pertanian.</p>
                <p align="justify">Perjanjian kerja sama ini dibuat dengan tujuan memperoleh keuntungan sebesar-besarnya secara halal dan tidak melanggar peraturan perundang-undangan yang berlaku.</p>
                <p align="justify">Kesepakatan kerja sama antara Pihak Pertama dan Pihak Kedua meliputi investasi yang dimiliki Pihak Kedua dengan Pihak Pertama sebagai penyalur dana investasi dari Pihak Kedua ke Pihak Ketiga.</p>
                <p align="justify">Pihak Pertama bertindak selaku pengelola modal dalam hal penyaluran dana, pembelian bibit, pembelian pupuk, penjualan pohon sengon, riset, pembinaan, dan pengawasan petani.</p>
                <p align="justify">Pihak Ketiga bertindak selaku pengelola modal dalam hal pertumbuhan dan pemeliharaan pohon sengon.</p>
                <p align="justify">Pihak Kedua berhak melakukan pengawasan terhadap proses yang dijalankan oleh Pihak Pertama dan Pihak Ketiga.</p>
                <p align="justify">Pihak Pertama dan Pihak Ketiga tidak boleh mengalihkan pengelolaan kepada pihak lain tanpa persetujuan Pihak Kedua.</p>
                <p align="justify">Pihak Pertama dan Pihak Ketiga diperbolehkan melimpahkan sebagian kerja pengelolaan kepada pihak lain dengan kesepakatan tertentu yang diatur dalam aturan tambahan diluar perjanjian ini.</p>
                <p align="justify"><strong>Nilai Investasi</strong></p>
                <p align="justify">Pihak Pertama selaku PENERIMA DANA INVESTASI sepakat bertanggung jawab terhadap dana yang diserahkan Pihak Kedua selaku PENABUNG</p>
                <p align="justify">Keuntungan adalah selisih antara hasil penjualan dengan harga beli bakalan dan biaya operasional.</p>
                <p align="justify">Pembagian keuntungan Pihak Kedua dari penjualan pohon sengon adalah 85% dan petani 15%.</p>
                <p align="justify">Pembagian keuntungan penabung sesuai porsi terhadap keseluruhan nilai investasi.</p>
                <p align="justify"><strong>Jangka Waktu</strong></p>
                <p align="justify">Jangka waktu kerja sama Pihak Pertama dan Pihak Kedua dilakukan sesuai periode investasi yang dipilih Pihak Kedua di aplikasi Napon. Periode investasi dimulai sejak pohon dibeli oleh Pihak Pertama dan selesai setelah bagi hasil di periode investasi terakhir.</p>
                <p align="justify">Selama periode investasi berlangsung, Pihak Pertama memberikan laporan perkembangan kondisi pohon sengon per enam bulan kepada Pihak Kedua.</p>
                <p align="justify">Pihak Kedua dapat menerima saldo investasi di fitur saldopon aplikasi Napon selambat-lambatnya 3 hari setelah dilakukannya bagi hasil Pihak Pertama ke Pihak Ketiga.</p>
                <p align="justify">Pihak Kedua dapat melakukan pencairan saldo investasi setiap saat. Uang investasi akan dikirimkan oleh Pihak Pertama ke bank tujuan Pihak Kedua selambat-lambatnya 3 hari kerja.</p>
                <p align="justify"><strong>Berakhirnya Perjanjian</strong></p>
                <p align="justify">Perjanjian ini berakhir pada saat Pihak Kedua melakukan pencairan dana seluruhnya yaitu setelah 3 bulan investasi berlangsung.</p>
                <p align="justify">Pihak Pertama dan Pihak Kedua tidak berhak mengakhiri perjanjian ini tanpa adanya pemberitahuan dan kesepakatan antara kedua belah pihak.</p>
                <p align="justify">Apabila Pihak Kedua memaksakan untuk menarik modalnya maka Pihak Pertama berhak meminta ganti rugi sesuai dengan tahapan usaha yang telah dilakukan.</p>
                <p align="justify">Setelah perjanjian berakhir, Pihak Pertama berkewajiban mengembalikan dana investasi dan melakukan bagi hasil kepada Pihak Kedua dalam bentuk virtual money di fitur Saldopon aplikasi Napon.</p>
                <p align="justify">Setelah Pihak Pertama mengembalikan dana investasi dan melakukan bagi hasil melalui virtual money kepada Pihak Kedua sesuai dengan kesepakatan, maka perjanjian kerja sama ini dinyatakan selesai dan masing-masing pihak tidak punya kewajiban serta tanggung jawab apapun.</p>
                <p align="justify"><strong>Force Majeure</strong></p>
                <p align="justify">Apabila terjadi gangguan teknis atau bertepatan dengan hal diluar kemampuan, maka akan ada kesepakatan semua pihak.</p>
                <p align="justify">Apabila terjadi musibah pada salah satu pihak, maka pihak tersebut harus segera memberitahukan kepada pihak lainnya secara lisan maupun secara tertulis, selambat-lambatnya dalam waktu 3x24 jam sejak terjadinya Force Majeure.</p>
                <p align="justify"><strong>Ganti Rugi</strong></p>
                <p align="justify">Apabila Pihak Pertama atau Pihak Ketiga melakukan kesalahan yang meliputi faktor kesengajaan, kelalaian, dan pelanggaran dalam pengelolaan yang menimbulkan kerugian, maka Pihak Kedua berhak mendapatkan ganti rugi.</p>
                <p align="justify">Besaran ganti rugi ditentukan berdasarkan kesepakatan semua pihak di dalam perjanjian ini.</p>
                <p align="justify">Apabila terjadi kerugian pada saat penjualan, petani akan mendapatkan dana kompensasi sebesar Rp80.000/1 unit pohon sengon selama proyek yang sudah berjalan sebelumnya.</p>
                <p align="justify">Contoh kerugian yang terjadi diantaranya yaitu gagal jual atau penurunan harga pasar yang mengakibatkan kerugian.</p>
                <p align="justify"><strong>H. Risiko Investasi</strong></p>
                <p align="justify">Risiko investasi yaitu gagal jual, penurunan harga pasar, dan produktivitas pohon sengon kurang optimal yang mengakibatkan penurunan harga jual.</p>
                <p align="justify">Risiko investasi yang dialami Pihak Kedua berupa kerugian modal sebesar selisih harga beli unit dengan besar kerugian.</p>
                <p align="justify">Persentase nilai risiko ditentukan oleh jumlah kepemilikan saldo investasi per satu pohon sengon.</p>
                <p align="justify">Risiko kerusakan pohon sengon, kehilangan dan sakit yang disebabkan bukan karena kelalaian Pihak Pertama dan Pihak Ketiga akan ditanggung oleh asuransi pohon.</p>
                <p align="justify"><strong>I. Ketentuan&ndash;ketentuan Lain</strong></p>
                <p align="justify">Hal-hal yang tidak atau belum cukup diatur dalam perjanjian ini, akan ditetapkan kemudian dalam kesepakatan adendum atau tambahan dari pihak yang bersangkutan.</p>
                <p align="justify">Semua ketentuan tambahan, atau perubahan dalam akta perjanjian ini hanya dapat dianggap sah dan mengikat apabila dibuat secara tertulis dan ditandatangani/memberikan tanda sepakat pada aplikasi oleh pihak yang bersangkutan.</p>
                <p align="justify"><strong>J. Penutup</strong></p>
                <p align="justify">Setiap pihak sepakat untuk saling mempercayai dan bersikap jujur selama masa kerja sama dan berjalannya proyek.</p>
                <p align="justify">Apabila terjadi perselisihan mengenai kerja sama ini, setiap pihak sepakat dan setuju untuk menyelesaikan dengan cara musyawarah untuk mencapai mufakat.</p>
                <p align="justify">Apabila terjadi penyimpangan dari ketentuan-ketentuan dalam perjanjian kerja sama yang dilakukan oleh salah satu pihak yang disengaja, maka pihak lain yang merasa dirugikan berhak mengajukan musyawarah untuk mencapai mufakat.</p>
                <p align="justify">Apabila dalam penyelesaian masalah belum terjadi kata sepakat maka pihak yang bersangkutan akan membawa permasalahan tersebut melalui jalan lain seperti mediasi, negosiasi, konsiliasasi, arbitrase (pilih salah satu).</p>
                <p align="justify">Demikian surat perjanjian ini dibuat oleh kedua belah pihak dengan penuh kesadaran dan tanpa unsur paksaan.</p>
                <p align="justify">Tanggal pembaharuan: 06/03/2019</p>
            '
        ]);

        Setting::create([
            'key' => 'contact_address',
            'value' => 'Jl. Pattimura Raya, kompleks ruko Masjid Baitut Taqwa, Mapangan - Ungaran'
        ]);

        Setting::create([
            'key' => 'contact_email',
            'value' => 'naponindonesia@gmail.com'
        ]);

        Setting::create([
            'key' => 'contact_phone',
            'value' => '(024) 7590 1139'
        ]);


    }
}
