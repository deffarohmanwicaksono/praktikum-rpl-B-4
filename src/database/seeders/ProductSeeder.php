<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        $sellers = User::whereJsonContains('roles', 'seller')->get();

        $dataProducts = [
            [
                'user_id' => 4,
                'category_id' => 1,
                'name' => 'Headset Gaming RGB',
                'description' => "Headset gaming dengan pencahayaan RGB yang menarik dan tampilan yang keren saat digunakan. Dilengkapi dengan driver speaker 50mm yang menghasilkan suara bass kuat dan detail audio yang jernih, cocok untuk gaming maupun mendengarkan musik.\n\nFitur noise-cancelling pada mikrofon membantu komunikasi yang jelas saat bermain game online bersama teman. Bantalan telinga berbahan memory foam yang lembut membuat headset ini nyaman dipakai dalam waktu lama tanpa membuat telinga panas.\n\nKondisi barang masih sangat baik, semua lampu RGB berfungsi normal, suara kiri-kanan seimbang, dan kabel tidak ada yang putus. Dijual karena sudah upgrade ke headset wireless.",
                'price' => 250000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 4,
                'category_id' => 1,
                'name' => 'Laptop Lenovo Thinkpad Bekas',
                'description' => "Laptop Lenovo ThinkPad seri bisnis yang terkenal tangguh dan tahan lama, sangat cocok untuk kebutuhan kuliah, mengetik laporan, browsing, hingga pemrograman ringan. Dibekali prosesor Intel Core i5 generasi ke-8 yang masih cukup bertenaga untuk multitasking.\n\nSpesifikasi singkat:\n• Prosesor: Intel Core i5-8250U\n• RAM: 8GB DDR4\n• Storage: SSD 256GB (boot sangat cepat)\n• Layar: 14 inci anti-glare, nyaman untuk mata\n• Baterai: masih bertahan 4-5 jam pemakaian normal\n\nKondisi fisik: bodi hitam khas ThinkPad masih mulus, keyboard nyaman diketik, trackpad dan TrackPoint berfungsi normal. Semua port (USB, HDMI, audio) berfungsi dengan baik. Dijual karena mendapatkan laptop baru dari beasiswa.",
                'price' => 3500000,
                'status' => 'sold_out',
            ],
            [
                'user_id' => 5,
                'category_id' => 2,
                'name' => 'Buku Kalkulus Stewart',
                'description' => "Buku Kalkulus karya James Stewart edisi terbaru, salah satu referensi kalkulus paling populer dan direkomendasikan di berbagai universitas, termasuk UNS. Mencakup materi kalkulus satu variabel dan multivariabel secara lengkap dengan penjelasan yang sistematis dan banyak contoh soal beserta pembahasannya.\n\nKondisi buku sekitar 90%, halaman lengkap tidak ada yang robek atau hilang. Terdapat sedikit coretan stabilo kuning dan hijau pada beberapa bagian bab 1-3, sisanya bersih. Sampul sedikit lecek di sudut tapi isi buku masih sangat layak baca.\n\nCocok untuk mahasiswa teknik, MIPA, dan informatika yang mengambil mata kuliah Kalkulus 1 maupun Kalkulus 2. Dijual karena sudah lulus mata kuliah ini.",
                'price' => 80000,
                'stock' => 2,
                'status' => 'sold_out',
            ],
            [
                'user_id' => 21,
                'category_id' => 3,
                'name' => 'Meja Belajar Lipat',
                'description' => "Meja belajar lipat serbaguna yang sangat praktis untuk anak kos dengan ruangan terbatas. Desain lipat memungkinkan meja disimpan di pojok kamar saat tidak digunakan sehingga menghemat ruang secara signifikan.\n\nPermukaan meja cukup luas untuk menaruh laptop, buku, dan alat tulis sekaligus. Konstruksi kaki besi yang kokoh mampu menopang beban hingga 30kg tanpa goyah. Ketinggian meja sesuai standar ergonomis sehingga nyaman digunakan dalam waktu lama.\n\nKondisi masih sangat baik, cat tidak mengelupas, engsel lipat kencang dan tidak longgar. Bekas pemakaian selama 1 semester kuliah. Dijual karena pindah kos yang sudah tersedia meja bawaan.",
                'price' => 150000,
                'status' => 'menunggu_verifikasi'
            ],
            [
                'user_id' => 22,
                'category_id' => 1,
                'name' => 'Smartphone Samsung A12',
                'description' => "Smartphone Samsung Galaxy A12 dengan layar 6.5 inci yang luas, cocok untuk kebutuhan kuliah sehari-hari seperti membaca materi, mengakses e-learning, hingga video call dengan dosen dan teman.\n\nSpesifikasi:\n• Prosesor: MediaTek Helio P35\n• RAM: 4GB\n• Storage: 64GB (dapat diperluas dengan microSD)\n• Kamera belakang: 48MP quad camera\n• Baterai: 5000mAh, tahan seharian penuh\n• OS: Android 11\n\nKondisi fisik sekitar 85%, terdapat beberapa goresan halus di bagian belakang yang tidak mengganggu fungsi. Layar masih bening dan responsif, tidak ada dead pixel. Baterai masih sehat di atas 80%. Dijual karena upgrade ke HP baru.",
                'price' => 1200000,
                'status' => 'dijual'
            ],
            [
                'user_id' => 23,
                'category_id' => 1,
                'name' => 'Printer Canon IP2770',
                'description' => "Printer Canon PIXMA iP2770 yang andal untuk mencetak dokumen kuliah, laporan, tugas, dan materi belajar. Menggunakan teknologi ChromaLife100 yang menghasilkan cetakan tajam dan tahan lama meski pada kertas biasa.\n\nKeunggulan printer ini adalah harga tinta yang terjangkau dan mudah ditemukan di pasaran. Kecepatan cetak mencapai 7 lembar per menit untuk dokumen hitam putih. Mendukung kertas ukuran A4 hingga foto 4R.\n\nKondisi printer masih berfungsi normal, hasil cetakan tidak ada garis-garis putus. Termasuk 1 cartridge hitam yang masih terisi sekitar 50%. Kabel power dan USB tersedia. Dijual karena sudah memiliki printer baru yang lebih canggih.",
                'price' => 450000,
                'status' => 'menunggu_verifikasi'
            ],
            [
                'user_id' => 24,
                'category_id' => 1,
                'name' => 'Tablet Samsung Tab A',
                'description' => "Samsung Galaxy Tab A dengan layar 10.1 inci yang lega, sangat nyaman digunakan untuk membaca e-book, PDF materi kuliah, mencatat dengan stylus, dan menonton video pembelajaran secara online maupun offline.\n\nSpesifikasi:\n• Layar: 10.1 inci TFT, resolusi 1920x1200\n• Prosesor: Exynos 7904\n• RAM: 3GB\n• Storage: 32GB + slot microSD\n• Baterai: 6150mAh, tahan hingga 8 jam\n\nKondisi tablet masih baik, layar tidak ada goresan berarti karena selalu menggunakan tempered glass. Performa masih lancar untuk keperluan sehari-hari. Dijual bersama charger original dan case pelindung.",
                'price' => 1800000,
                'status' => 'ditolak'
            ],
            [
                'user_id' => 25,
                'category_id' => 2,
                'name' => 'Buku Struktur Data Java',
                'description' => "Buku referensi Struktur Data menggunakan bahasa pemrograman Java yang sangat relevan untuk mahasiswa informatika, ilmu komputer, dan teknik informatika. Membahas secara mendalam konsep array, linked list, stack, queue, tree, graph, hingga algoritma sorting dan searching.\n\nSetiap topik disertai dengan contoh kode Java yang dapat langsung dipraktikkan, penjelasan kompleksitas algoritma (Big-O notation), serta latihan soal di akhir bab untuk menguji pemahaman.\n\nKondisi buku masih sangat bagus, halaman lengkap dan bersih tanpa coretan. Hanya terdapat nama pemilik di halaman pertama. Cocok dijadikan referensi tambahan selain modul kuliah resmi.",
                'price' => 95000,
                'status' => 'dijual'
            ],
            [
                'user_id' => 26,
                'category_id' => 2,
                'name' => 'Kalkulator Casio FX-991EX',
                'description' => "Kalkulator scientific Casio FX-991EX ClassWiz, salah satu kalkulator paling canggih yang diperbolehkan dalam ujian dan sangat umum digunakan pada mata kuliah matematika, fisika, statistika, dan teknik di UNS.\n\nFitur unggulan:\n• Layar high-resolution 192x63 piksel yang menampilkan notasi matematika natural\n• Lebih dari 550 fungsi matematika\n• Mendukung perhitungan matriks, vektor, persamaan simultan, dan distribusi statistik\n• Fitur QR code untuk memvisualisasikan grafik di smartphone\n• Baterai tahan sangat lama (AAA x 1)\n\nKondisi masih sangat baik, semua tombol responsif dan layar bening. Dijual karena sudah lulus semua mata kuliah yang membutuhkan kalkulator ini.",
                'price' => 250000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 27,
                'category_id' => 2,
                'name' => 'Paket Alat Tulis Kuliah',
                'description' => "Paket lengkap alat tulis kuliah yang siap pakai, sangat cocok untuk mahasiswa baru atau siapa saja yang butuh perlengkapan menulis berkualitas dengan harga terjangkau.\n\nIsi paket:\n• 1 binder A4 tebal dengan ring kuat, kapasitas banyak lembar\n• 3 pulpen gel hitam dengan tinta lancar dan tidak bocor\n• 1 pensil mekanik 0.5mm untuk sketsa dan mengerjakan soal\n• 1 set stabilo 4 warna (kuning, hijau, merah muda, biru)\n• 10 lembar kertas filler A4 sebagai bonus\n\nSemua item masih dalam kondisi layak pakai. Stabilo sudah terpakai sekitar 30%, pulpen dan pensil mekanik masih penuh. Binder masih kokoh dan ring tidak ada yang bengkok.",
                'price' => 50000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 28,
                'category_id' => 3,
                'name' => 'Kipas Angin Miyako',
                'description' => "Kipas angin Miyako ukuran sedang (diameter 40cm) yang sangat cocok untuk kamar kos ukuran standar. Dilengkapi 3 kecepatan angin yang dapat disesuaikan dengan kebutuhan, dari angin lembut saat tidur hingga kecepatan penuh saat cuaca sangat panas.\n\nFitur kepala kipas yang dapat diputar 90 derajat ke kiri dan kanan (oscillating) memastikan sirkulasi udara merata ke seluruh ruangan. Tombol pengatur mudah dijangkau dan masih berfungsi dengan baik.\n\nKondisi kipas masih normal, suara tidak berisik, putaran baling-baling stabil di semua kecepatan. Bersih dari debu karena rutin dibersihkan. Kabel dan steker dalam kondisi aman. Dijual karena kamar kos sekarang sudah ada AC.",
                'price' => 175000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 29,
                'category_id' => 3,
                'name' => 'Rice Cooker Cosmos',
                'description' => "Rice cooker Cosmos kapasitas 0.6 liter yang ideal untuk porsi 1-2 orang, sangat cocok untuk mahasiswa kos yang memasak sendiri. Ukurannya yang ringkas tidak memakan banyak tempat di meja atau rak kos.\n\nFitur cook dan warm otomatis memastikan nasi matang sempurna lalu beralih ke mode menghangatkan secara otomatis tanpa perlu diawasi. Bagian dalam panci anti lengket sehingga mudah dibersihkan.\n\nKondisi rice cooker masih berfungsi dengan baik, nasi matang merata dan tidak gosong. Lampu indikator cook dan warm berfungsi normal. Panci anti lengket masih mulus tidak ada goresan. Tersedia spatula plastik bawaan. Dijual karena pulang kampung dan tidak dipakai lagi.",
                'price' => 220000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 30,
                'category_id' => 3,
                'name' => 'Rak Plastik 4 Susun',
                'description' => "Rak penyimpanan plastik 4 susun yang serbaguna dan ringan, mudah dipindahkan sesuai kebutuhan. Setiap susun mampu menampung beban hingga 10kg sehingga cukup kuat untuk menyimpan buku-buku kuliah, pakaian terlipat, perlengkapan mandi, atau peralatan kos lainnya.\n\nSistem pemasangan knock-down tanpa baut membuat rak ini mudah dibongkar pasang saat pindah kos. Bahan plastik food-grade yang tidak mudah rapuh meski terkena panas ruangan.\n\nKondisi rak masih kokoh dan stabil, tidak ada bagian yang patah atau retak. Warna masih cerah tidak kusam. Tinggi total sekitar 120cm, lebar 40cm. Dijual karena pindah ke kos yang sudah tersedia lemari.",
                'price' => 120000,
                'status' => 'menunggu_verifikasi',
            ],
            [
                'user_id' => 31,
                'category_id' => 3,
                'name' => 'Setrika Philips',
                'description' => "Setrika listrik Philips dengan soleplate berbahan keramik yang menghasilkan luncuran halus di atas kain sehingga pakaian cepat rapi tanpa risiko gosong. Daya 1000 watt membuat setrika cepat panas dalam waktu kurang dari 2 menit.\n\nDilengkapi pengatur suhu untuk berbagai jenis kain, mulai dari bahan sintetis yang sensitif panas hingga katun dan denim yang membutuhkan suhu tinggi. Fungsi semprotan uap membantu melunakkan kusutan yang membandel.\n\nKondisi setrika masih berfungsi dengan baik, panas merata dan semprotan uap normal. Soleplate masih mulus tidak ada goresan berarti. Kabel masih lentur tidak ada yang terkelupas. Dijual karena membeli setrika uap baru.",
                'price' => 100000,
                'status' => 'ditolak',
            ],
            [
                'user_id' => 21,
                'category_id' => 4,
                'name' => 'Almamater UNS',
                'description' => "Almamater resmi Universitas Sebelas Maret (UNS) ukuran L dengan kondisi masih sangat baik dan layak digunakan. Warna kuning khas UNS masih cerah tidak pudar, jahitan masih kuat di semua sisi.\n\nAlmamater ini wajib dimiliki setiap mahasiswa UNS untuk berbagai keperluan akademik seperti sidang, wisuda, kegiatan BEM, ospek, hingga acara resmi kampus lainnya. Bahan kain berkualitas yang tidak mudah kusut dan nyaman dipakai.\n\nKondisi: tidak ada noda permanen, logo UNS di dada masih jelas, kancing semua lengkap dan tidak ada yang copot. Hanya dicuci bersih dan disetrika rapi. Dijual karena sudah lulus dan tidak lagi membutuhkan.",
                'price' => 120000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 22,
                'category_id' => 4,
                'name' => 'Hoodie Hitam Polos',
                'description' => "Hoodie warna hitam polos berbahan fleece premium yang tebal dan hangat, sangat cocok dipakai saat kuliah pagi, pergi ke perpustakaan, atau bepergian di malam hari. Desain minimalis tanpa tulisan membuatnya mudah dipadukan dengan berbagai outfit.\n\nBahan fleece berkualitas tidak mudah berbulu (pilling) meski sudah sering dicuci. Tali hoodie masih ada dan tidak rusak. Kantong depan (kangaroo pocket) masih jahitannya kuat dan berfungsi dengan baik.\n\nUkuran L (fits M-L), panjang badan sekitar 68cm, lebar dada 55cm. Kondisi masih sangat baik, hanya ada bekas lipatan kecil yang akan hilang setelah dicuci. Dijual karena kebanyakan koleksi hoodie.",
                'price' => 80000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 23,
                'category_id' => 4,
                'name' => 'Tas Ransel Eiger',
                'description' => "Tas ransel Eiger original dengan kapasitas 30 liter yang cukup luas untuk membawa laptop 15 inci, buku-buku tebal, botol minum, dan semua perlengkapan kuliah dalam satu tas. Brand Eiger dikenal dengan kualitas bahan dan jahitan yang kuat serta tahan lama.\n\nDilengkapi dengan:\n• Kompartemen laptop dengan bantalan pelindung\n• Kompartemen utama yang luas\n• Kantong depan untuk akses cepat\n• Kantong samping jaring untuk botol minum\n• Tali punggung berpadding tebal yang nyaman di bahu\n\nKondisi tas masih sangat baik, semua resleting lancar tidak seret, tidak ada jahitan yang lepas, bahan waterproof masih efektif. Warna hitam masih pekat. Dijual karena mendapat tas baru dari sponsor organisasi.",
                'price' => 250000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 24,
                'category_id' => 4,
                'name' => 'Sepatu Converse Bekas',
                'description' => "Sepatu Converse Chuck Taylor All Star ukuran 42 warna putih yang ikonik dan timeless, cocok dipakai ke kampus, jalan-jalan, maupun acara santai. Model high-top yang stylish dan mudah dipadukan dengan berbagai style pakaian.\n\nKondisi: sol masih tebal dan tidak ada yang mengelupas, jahitan canvas masih kuat di semua sisi, tali sepatu masih bersih. Terdapat sedikit noda kecil di bagian ujung yang dapat dibersihkan dengan sikat dan sabun. Insole masih empuk dan nyaman.\n\nBeli ori di toko resmi, tersedia struk pembelian. Dipakai sekitar 8 bulan dengan pemakaian tidak setiap hari. Dijual karena beli model baru.",
                'price' => 300000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 25,
                'category_id' => 4,
                'name' => 'Topi UNS',
                'description' => "Topi baseball resmi berlogo UNS yang cocok digunakan untuk berbagai aktivitas sehari-hari di kampus maupun luar kampus. Topi ini menjadi identitas kebanggaan sebagai mahasiswa Universitas Sebelas Maret.\n\nBahan kain twill yang adem dan tidak mudah kusut, bagian dalam dilapis sweatband yang menyerap keringat sehingga nyaman dipakai saat cuaca panas. Pengikat belakang model snapback yang dapat disesuaikan untuk berbagai ukuran kepala.\n\nKondisi topi masih baik, bordir logo UNS di bagian depan masih jelas dan rapi, bahan tidak ada yang pudar atau rusak. Hanya dipakai beberapa kali saja. Dijual karena jarang digunakan.",
                'price' => 50000,
                'status' => 'menunggu_verifikasi',
            ],
            [
                'user_id' => 26,
                'category_id' => 5,
                'name' => 'Raket Badminton Yonex',
                'description' => "Raket badminton Yonex original seri Nanoray, salah satu merek raket paling terpercaya di dunia bulu tangkis. Cocok untuk pemain tingkat menengah yang sudah serius berlatih maupun untuk bermain rutin di GOR.\n\nFrame raket terbuat dari bahan graphite yang ringan namun kuat, memberikan keseimbangan antara power dan kontrol. Ukuran kepala medium isometric memberikan sweet spot yang lebih luas sehingga memudahkan kontrol kok.\n\nKondisi raket masih sangat baik, senar masih kencang dan belum putus, grip masih empuk dan tidak licin. Frame tidak ada retak atau penyok. Sudah dipakai sekitar 6 bulan dengan intensitas bermain 1-2 kali seminggu. Tersedia tas raket sebagai bonus.",
                'price' => 350000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 27,
                'category_id' => 5,
                'name' => 'Dumbbell 5 Kg',
                'description' => "Sepasang dumbbell besi 5kg dengan lapisan rubber di bagian pegangan untuk kenyamanan dan keamanan saat berolahraga. Cocok untuk latihan ringan hingga menengah seperti bicep curl, tricep extension, shoulder press, dan berbagai latihan kekuatan lainnya langsung di kamar kos.\n\nBerat 5kg per buah sangat ideal untuk pemula yang baru memulai latihan beban maupun untuk mereka yang fokus pada latihan tonus otot dan daya tahan. Tidak memerlukan bench atau alat tambahan lainnya.\n\nKondisi dumbbell masih baik, besi tidak berkarat karena selalu disimpan di dalam ruangan, lapisan rubber pegangan masih elastis. Dijual berpasangan (2 buah total 10kg). Dijual karena pindah kos dan tidak ada ruang untuk menyimpan peralatan olahraga.",
                'price' => 180000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 28,
                'category_id' => 5,
                'name' => 'Bola Futsal Specs',
                'description' => "Bola futsal Specs original ukuran 4 yang sesuai standar pertandingan futsal indoor. Specs adalah brand olahraga lokal terpercaya yang produknya sudah digunakan di berbagai turnamen futsal mahasiswa tingkat nasional.\n\nBahan kulit sintetis PU berkualitas memberikan touch yang responsif dan konsisten, tidak mudah deformasi meski sudah digunakan intensif. Panel 32 sisi memberikan lintasan bola yang lebih akurat dan dapat diprediksi.\n\nKondisi bola masih sangat baik, tekanan udara stabil (tidak bocor), permukaan luar tidak ada sobek atau retak. Warna masih cerah. Telah digunakan untuk latihan rutin selama 4 bulan. Dijual karena tim sudah membeli bola baru untuk keperluan kompetisi.",
                'price' => 120000,
                'status' => 'menunggu_verifikasi',
            ],
            [
                'user_id' => 29,
                'category_id' => 6,
                'name' => 'Board Game Monopoly',
                'description' => "Board game Monopoly edisi klasik yang sudah menjadi ikon permainan keluarga dan pertemanan selama puluhan tahun. Sangat cocok dimainkan bersama 2-8 orang di waktu santai bersama teman-teman kos untuk mengisi waktu luang sambil melatih kemampuan strategi dan negosiasi.\n\nIsi kotak lengkap:\n• 1 papan permainan\n• Semua kartu Community Chest dan Chance\n• Uang Monopoly lengkap semua denominasi\n• 8 token pemain\n• 32 rumah merah dan 12 hotel hijau\n• 2 dadu\n• Buku panduan bahasa Indonesia\n\nKondisi semua komponen masih lengkap dan tidak ada yang hilang. Kartu-kartu masih bersih. Papan permainan sedikit kusut di lipatan tapi masih layak. Dijual karena jarang dimainkan lagi.",
                'price' => 180000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 30,
                'category_id' => 6,
                'name' => 'Action Figure Naruto',
                'description' => "Action figure Naruto Uzumaki versi Sage Mode dengan detail sculpting yang sangat presisi dan cat yang rapi, cocok untuk kolektor maupun penggemar anime Naruto Shippuden. Tinggi figure sekitar 16cm dengan base display yang stabil.\n\nFigure ini menampilkan Naruto dalam pose ikonik dengan jubah api, lengkap dengan detail tanda katak gunung di pipi dan simbol perguruan pada punggung jubah. Material PVC berkualitas yang tidak mudah goresan.\n\nKondisi masih sangat baik, cat tidak ada yang terkelupas atau pudar. Semua aksesoris (tangan alternatif, efek angin) masih lengkap. Disimpan di dalam kotak dan jauh dari paparan sinar matahari langsung. Dijual karena merapikan koleksi.",
                'price' => 220000,
                'status' => 'menunggu_verifikasi',
            ],
            [
                'user_id' => 31,
                'category_id' => 6,
                'name' => 'Gitar Akustik Yamaha',
                'description' => "Gitar akustik Yamaha seri F310 yang sudah menjadi pilihan utama para pemula dan gitaris hobi karena kualitasnya yang konsisten dan harganya yang terjangkau. Yamaha dikenal menghasilkan suara yang seimbang antara treble dan bass, cocok untuk berbagai genre musik.\n\nSpesifikasi:\n• Top: Spruce laminat\n• Back & sides: Meranti\n• Neck: Nato dengan fretboard rosewood\n• Scale length: 634mm\n• Senar: Bronze acoustic, ukuran standar\n\nKondisi gitar masih nyaman dimainkan, fret tidak ada yang tajam atau menonjol, neck tidak melengkung, aksi senar sudah di-setup rendah sehingga jari tidak mudah sakit. Tersedia bersama capo dan pick. Dijual karena sudah jarang digunakan sejak sibuk KKN.",
                'price' => 650000,
                'status' => 'sold_out',
            ],
            [
                'user_id' => 21,
                'category_id' => 7,
                'name' => 'Hair Dryer Philips',
                'description' => "Hair dryer Philips seri Essential Care dengan daya 1200 watt yang cukup kuat untuk mengeringkan rambut dengan cepat, menghemat waktu saat pagi hari sebelum kuliah. Dilengkapi 2 pengaturan panas dan 2 pengaturan kecepatan udara yang dapat disesuaikan dengan jenis dan kondisi rambut.\n\nFitur cool shot button yang sangat berguna untuk mengunci gaya rambut setelah dikeringkan. Ukuran yang kompak dan ringan (hanya 440 gram) membuatnya nyaman digenggam dalam waktu lama tanpa membuat tangan pegal.\n\nKondisi hair dryer masih berfungsi sangat baik, panas merata dan tidak ada bau gosong. Kabel masih lentur sepanjang 1.8m. Motor tidak ada suara aneh. Dijual karena mendapat hadiah hair dryer baru dari orang tua.",
                'price' => 130000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 22,
                'category_id' => 7,
                'name' => 'Catokan Rambut Nova',
                'description' => "Catokan rambut Nova dengan pelat keramik berukuran 3cm yang memanaskan secara merata untuk hasil penataan yang sempurna. Teknologi pelat keramik lebih aman untuk rambut dibanding pelat besi biasa karena panas yang lebih merata dan ion negatif yang dihasilkan membantu mengurangi efek frizzy.\n\nDilengkapi pengatur suhu dari 150°C hingga 230°C yang cocok untuk berbagai jenis rambut. Panas tercapai dalam waktu 30 detik sehingga sangat praktis saat terburu-buru. Tersedia fitur auto-off setelah 30 menit tidak digunakan untuk keamanan.\n\nKondisi catokan masih berfungsi dengan baik, panas merata di seluruh pelat, layar indikator suhu masih akurat. Dijual karena mendapat catokan professional grade baru.",
                'price' => 85000,
                'status' => 'ditolak',
            ],
            [
                'user_id' => 23,
                'category_id' => 8,
                'name' => 'Lampu Belajar LED',
                'description' => "Lampu belajar LED dengan desain leher angsa yang fleksibel, dapat diarahkan ke sudut manapun sesuai kebutuhan. Sangat cocok untuk belajar, mengerjakan tugas, atau membaca di malam hari tanpa mengganggu teman sekamar karena pencahayaan yang terfokus.\n\nCahaya LED putih netral (4000K) yang nyaman di mata dan tidak menyebabkan silau maupun kelelahan mata meski digunakan berjam-jam. Tersedia 3 tingkat kecerahan yang dapat disesuaikan dengan kondisi ruangan.\n\nDaya hanya 5 watt namun menghasilkan cahaya setara 40 watt lampu pijar, sangat hemat listrik. Koneksi USB sehingga bisa dihubungkan ke laptop, power bank, atau adaptor. Kondisi masih sangat baik, semua LED menyala sempurna. Dijual karena sudah punya lampu kamar yang cukup terang.",
                'price' => 65000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 26,
                'category_id' => 1,
                'name' => 'Mouse Wireless Logitech',
                'description' => "Mouse wireless Logitech seri M185 dengan koneksi USB receiver nano yang nyaris tidak terasa menancap di laptop. Logitech dikenal sebagai salah satu merek mouse paling andal dengan sensor optis yang presisi untuk berbagai aktivitas komputasi.\n\nErgonomi desain ambidextrous yang pas di tangan kanan maupun kiri, nyaman digunakan berjam-jam tanpa kelelahan tangan. Scroll wheel yang presisi memudahkan navigasi dokumen panjang dan halaman web. Jangkauan koneksi wireless hingga 10 meter.\n\nKondisi mouse masih sangat baik, semua tombol (kiri, kanan, scroll, back, forward) berfungsi responsif. Sensor optis akurat di berbagai permukaan. Baterai AA yang disertakan masih berfungsi. USB receiver tersimpan rapi di kompartemen bawah mouse. Dijual karena beralih ke mouse gaming.",
                'price' => 50000,
                'status' => 'menunggu_verifikasi',
            ],
            [
                'user_id' => 25,
                'category_id' => 3,
                'name' => 'Kursi Belajar Ergonomis',
                'description' => "Kursi belajar ergonomis dengan sandaran punggung berbentuk S yang mengikuti lekukan tulang belakang alami, dirancang untuk mengurangi kelelahan dan nyeri punggung saat duduk lama mengerjakan tugas atau skripsi.\n\nFitur unggulan:\n• Sandaran kepala yang dapat diatur tingginya\n• Armrest yang dapat dilipat saat tidak digunakan\n• Dudukan berbahan mesh yang breathable, tidak membuat gerah\n• Roda kastor yang lancar di berbagai lantai\n• Ketinggian dapat disesuaikan dari 45-55cm via gas lift\n\nKondisi kursi masih sangat baik, semua mekanisme pengaturan berfungsi lancar, roda tidak ada yang macet, jok mesh tidak ada yang sobek. Dijual karena pindah kos yang sudah ada kursi belajar.",
                'price' => 275000,
                'status' => 'menunggu_verifikasi',
            ],
            [
                'user_id' => 2,
                'category_id' => 1,
                'name' => 'Power Bank Xiaomi 10000mAh',
                'description' => "Power bank Xiaomi 10000mAh yang ringan dan compact, cocok dibawa ke kampus setiap hari. Kapasitas 10000mAh cukup untuk mengisi penuh smartphone 2-3 kali, sangat membantu saat hari kuliah yang panjang tanpa akses colokan listrik.\n\nDilengkapi 2 port USB output sehingga dapat mengisi daya 2 perangkat sekaligus. Port Micro-USB input untuk mengisi daya power bank itu sendiri. Teknologi charging protection mencegah overcharge dan overheat yang menjaga keamanan baterai smartphone.\n\nKondisi masih sangat baik, kapasitas masih terjaga di atas 90% (diuji dengan charger tester). Bodi tidak ada penyok atau retak. Kabel Micro-USB bawaan masih tersedia. Dijual karena mendapat power bank baru dengan fast charging.",
                'price' => 150000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 2,
                'category_id' => 1,
                'name' => 'Keyboard Mechanical Fantech',
                'description' => "Keyboard mechanical Fantech MK852 dengan switch blue yang memberikan feedback taktil dan suara klik yang memuaskan, sangat cocok untuk mengetik cepat maupun gaming. Layout tenkeyless (TKL) tanpa numpad membuat ukuran lebih compact dan memberikan lebih banyak ruang untuk mouse.\n\nFitur RGB per-key yang dapat dikustomisasi dengan 18 efek lighting berbeda. Keycap ABS double-shot yang cetakan hurufnya tidak mudah pudar meski digunakan intensif. Braket besi yang kokoh memberikan stabilitas saat digunakan di meja.\n\nKondisi keyboard masih sangat baik, semua switch merespons dengan konsisten, tidak ada tombol yang macet atau ghosting. RGB berfungsi penuh di semua warna. Dijual karena upgrade ke keyboard wireless.",
                'price' => 275000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'name' => 'Buku Basis Data',
                'description' => "Buku referensi Sistem Basis Data yang komprehensif, mencakup konsep fundamental hingga implementasi praktis yang sangat relevan untuk mata kuliah Basis Data di program studi Informatika dan Sistem Informasi UNS.\n\nMateri yang dibahas:\n• Konsep dasar basis data dan DBMS\n• Model Entity-Relationship (ER Diagram)\n• Normalisasi database hingga 3NF dan BCNF\n• SQL lengkap: DDL, DML, DCL, dan TCL\n• Transaksi dan concurrency control\n• Indeks dan optimasi query\n• Pengantar NoSQL dan Big Data\n\nKondisi buku masih lengkap dan layak baca. Ada beberapa penanda halaman penting dan sedikit catatan pensil yang bisa dihapus. Sangat direkomendasikan sebagai pendamping modul kuliah.",
                'price' => 85000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 3,
                'category_id' => 4,
                'name' => 'Jaket Denim Biru',
                'description' => "Jaket denim biru medium wash ukuran L dengan potongan reguler fit yang cocok untuk berbagai postur tubuh. Denim adalah pilihan fashion yang tidak pernah salah — mudah dipadukan dengan kaos polos, kemeja, maupun hoodie untuk tampilan kasual yang stylish ke kampus.\n\nBahan denim 12oz yang cukup tebal memberikan kehangatan di ruangan ber-AC tanpa terlalu panas saat di luar. Dua kantong dada dan dua kantong samping yang fungsional. Kancing logam asli yang tidak mudah berkarat.\n\nKondisi masih sangat baik, tidak ada sobekan atau noda permanen. Warna biru masih bagus dan merata, tidak belang-belang. Sudah dicuci bersih dan disetrika rapi. Ukuran L (lebar dada 55cm, panjang 65cm). Dijual karena sudah jarang dipakai.",
                'price' => 180000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 3,
                'category_id' => 3,
                'name' => 'Dispenser Air Mini',
                'description' => "Dispenser air mini yang sangat compact dan hemat tempat, ideal untuk kamar kos yang sempit. Cukup muat di atas meja belajar atau rak kecil. Kompatibel dengan galon standar 19 liter yang mudah ditemukan di mana saja.\n\nDilengkapi dua keran: keran biru untuk air dingin (dengan kulkas mini internal) dan keran merah untuk air panas yang siap diseduh untuk mie instan, kopi, atau teh kapan saja tanpa perlu menunggu. Sistem pemanasan cepat dalam waktu 3-5 menit.\n\nKondisi dispenser masih berfungsi dengan baik, baik fungsi pendingin maupun pemanas bekerja normal. Tidak ada kebocoran dari keran. Bodi plastik masih bersih dan tidak ada goresan berarti. Tersedia kabel power dan buku panduan. Dijual karena pindah ke kos yang sudah include air minum.",
                'price' => 200000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 3,
                'category_id' => 5,
                'name' => 'Matras Yoga',
                'description' => "Matras yoga tebal 6mm dengan permukaan anti-slip di kedua sisi yang memberikan stabilitas dan keamanan saat berolahraga. Sangat cocok untuk yoga, pilates, senam, atau sekadar stretching dan sit-up di kamar kos tanpa perlu ke gym.\n\nMaterial TPE (Thermoplastic Elastomer) yang ramah lingkungan, bebas PVC dan lateks sehingga aman untuk kulit sensitif. Tekstur permukaan yang bertitik-titik memberikan grip yang baik mencegah terpeleset saat pose yang menantang.\n\nKondisi matras masih sangat baik, permukaan tidak ada yang mengelupas atau robek, elastisitas masih bagus saat ditekan. Ukuran standar 183x61cm yang cukup luas. Mudah digulung dan dibawa dengan tali pengikat bawaan. Dijual karena sudah tidak rutin berolahraga lagi.",
                'price' => 120000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 27,
                'category_id' => 6,
                'name' => 'UNO Card Game',
                'description' => "Permainan kartu UNO original yang sudah menjadi klasik dan tidak pernah membosankan dimainkan bersama teman-teman kos, saat nongkrong, atau mengisi waktu luang. Sangat mudah dipelajari namun tetap seru dan penuh kejutan di setiap ronde.\n\nIsi: 108 kartu yang terdiri dari kartu angka (0-9) dalam 4 warna, kartu Skip, Reverse, Draw Two, Wild, dan Wild Draw Four. Aturan permainan sederhana namun membutuhkan strategi dan sedikit keberuntungan untuk menang.\n\nKondisi kartu masih lengkap 108 lembar, sudah dihitung ulang. Kartu tidak ada yang robek atau terlipat parah, gambar masih jelas terbaca. Tersimpan dalam kotak asli yang masih utuh. Dijual karena sudah punya dua set UNO.",
                'price' => 35000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 28,
                'category_id' => 3,
                'name' => 'Cermin Berdiri',
                'description' => "Cermin berdiri (standing mirror) ukuran 40x120cm dengan bingkai kayu minimalis warna hitam yang elegan dan cocok untuk berbagai dekorasi kamar. Ukurannya yang sedang cukup untuk melihat penampilan dari kepala hingga pinggang sebelum berangkat kuliah.\n\nBase penyangga berbentuk L yang stabil sehingga cermin tidak mudah jatuh meski tersenggol. Kaki dapat dibuka lebar untuk stabilitas ekstra di lantai keramik. Bingkai kayu MDF yang cukup ringan sehingga mudah dipindahkan.\n\nKondisi cermin masih jernih dan bening, tidak ada bercak atau jamur di permukaan kaca. Bingkai tidak ada yang retak atau cat yang mengelupas. Dijual karena kamar kos baru sudah memiliki cermin dinding permanen.",
                'price' => 95000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 29,
                'category_id' => 7,
                'name' => 'Organizer Kosmetik',
                'description' => "Organizer kosmetik akrilik bening 360 derajat yang berputar untuk akses mudah ke semua produk skincare dan makeup dari segala arah. Desain transparan memudahkan menemukan produk yang diinginkan tanpa harus membongkar semua isi.\n\nKapasitas penyimpanan besar dengan berbagai ukuran kompartemen:\n• Slot lipstik untuk 12 buah\n• Kompartemen besar untuk foundation, moisturizer, dan serum\n• Laci kecil untuk item kecil seperti eyeshadow dan blush\n• Slot kuas makeup untuk 10-12 kuas\n\nKondisi organizer masih bersih dan tidak ada retak atau goresan pada akrilik. Mekanisme putar masih lancar. Sudah dibersihkan sebelum dijual. Cocok untuk meja rias atau meja belajar yang sekaligus jadi meja makeup.",
                'price' => 70000,
                'status' => 'dijual',
            ],
            [
                'user_id' => 31,
                'category_id' => 6,
                'name' => 'Ukulele Concert',
                'description' => "Ukulele concert berukuran 23 inci dengan badan mahoni yang menghasilkan suara hangat dan resonan, lebih berisi dibanding ukulele soprano. Ukuran concert yang lebih besar dari soprano memberikan jarak fret yang lebih lebar sehingga lebih nyaman dimainkan oleh pemula dengan jari yang lebih besar.\n\nDilengkapi dengan senar Aquila Nylgut yang sudah terkenal sebagai senar ukulele terbaik, menghasilkan intonasi yang akurat dan suara yang merdu. Tuning peg geared (bukan friction) yang lebih mudah dan akurat saat stem.\n\nKondisi ukulele masih sangat baik, suara jernih dan nyaring, tidak ada fret buzz yang mengganggu. Neck lurus dan tidak ada retak di body. Tersedia bersama tas softcase pelindung, tuner clip-on, dan pick ukulele. Dijual karena pindah fokus ke gitar.",
                'price' => 280000,
                'status' => 'dijual',
            ],
        ];

        foreach ($dataProducts as $product) {
            $seller = User::findOrFail( $product['user_id']);

            Product::factory()->forSeller($seller)->create([
                    'category_id' => $product['category_id'],
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'status' => $product['status'],
                ]);
        }

        //Factory untuk produk tambahan namun belum memiliki image
        // for ($i = 0; $i < 30; $i++) {
        //     $seller = $sellers->random();
        //     $category = $categories->random();

        //     Product::factory()->forSeller($seller)->create([
        //         'category_id' => $category->id,
        //         'name' => fake()->randomElement( $productsByCategory[$category->id]),
        //     ]);
        // }
    }
}
