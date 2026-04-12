# User Stories

1. Registrasi via SSO UNS  
    As a user, I want mendaftar dan login SeMart menggunakan akun SSO UNS, so that hanya mahasiswa yang valid yang dapat menggunakan fitur marketplace
    **Acceptance Criteria:**
    - AC-1:
        - Given user merupakan mahasiswa dan mempunyai SSO UNS yang valid
        - When user melakukan login menggunakan SSO UNS 
        - Then saya berhasil login dan diarahkan ke halaman beranda SeMart
    - AC-2:
        - Given user bukan mahasiswa UNS
        - When mencoba login tanpa akun SSO UNS
        - Then sistem menolak akses 

2. Upload barang  
    As a seller, I want mengunggah barang bekas, so that barang saya dapat ditemukan oleh buyer di platform
    **Acceptance Criteria:**
    - AC-1:
        - Given seller sudah login
        - When seller mengisi data barang (nama, deskripsi, harga, foto) dan submit
        - Then sistem menyimpan barang dengan status “menunggu verifikasi”
    - AC-2:
        - Given seller dalam proses mengunggah barang
        - When seller menekan submit tanpa mengisi salah satu atau lebih field wajib (contoh: foto atau harga)
        - Then sistem menampilkan pesan validasi pada field yang kosong dan pengunggahan barang belum berhasil dijalankan

3. Verifikasi barang  
    As a admin, I want meninjau dan memverifikasi barang yg diunggah seller, barang ilegal atau berbahaya tidak beredar di platform
    **Acceptance Criteria:**
    - AC-1:
        - Given terdapat barang dengan status “menunggu verifikasi”
        - When admin meninjau dan menyetujui barang
        - Then status berubah menjadi “dijual” dan dapat muncul di halaman pencarian buyer
    - AC-2:
        - Given admin menilai barang melanggar aturan (ilegal/berbahaya)
        - When admin menolak barang dan mengisi alasan penolakan
    - Then status berubah menjadi “ditolak”, barang tidak dapat muncul di pencarian buyer, seller menerima notifikasi

4. Pencarian barang  
    As a buyer, I want mencari barang berdasarkan kata kunci, so that saya dapat menemukan barang yang saya butuhkan dengan cepat.
    **Acceptance Criteria:**
    - AC-1:
        - Given terdapat barang dengan status “dijual”
        - When buyer melakukan pencarian dengan mengetikkan kata kunci
        - Then sistem menampilkan daftar barang yang relevan beserta foto dan harga
    - AC-2:
        - Given buyer mengetikkan kata kunci yang tidak cocok dengan barang manapun
        - When pencarian diproses
        - Then sistem menampilkan pesan "Barang tidak ditemukan" tanpa crash atau halaman kosong

5. Chat dengan seller  
    As a buyer, I want menghubungi seller melalui fitur chat sebelum melakukan pembelian, so that saya dapat bertanya, bernegosiasi harga, dan memastikan kondisi barang.
    **Acceptance Criteria:**
    - AC-1:
        - Given buyer membuka detail barang
        - When buyer menekan tombol chat
        - Then sistem membuka fitur chat antara buyer dan seller

6. Seller kirim link pembelian  
    As a seller, I want mengirimkan link pembelian melalui chat, so that buyer dapat melanjutkan ke proses checkout secara aman dan terkontrol.
    **Acceptance Criteria:**
    - AC-1:
        - Given seller sedang berada dalam sesi chat dengan buyer dan sudah mendapat kesepakatan pembelian
        - When seller menekan tombol "Kirim Link Pembelian"
        - Then buyer dapat melihat dan mengakses link tersebut
    - AC-2:
        - Given buyer menerima link pembelian
        - When buyer membuka link yang sudah digunakan sebelumnya atau sudah melewati batas waktu
        - Then sistem menampilkan pesan "Link tidak valid atau sudah kedaluwarsa" dan buyer diarahkan untuk meminta link baru dari seller

7. Checkout & pembayaran  
    As a buyer, I want melakukan checkout melalui link pembelian, so that saya dapat menyelesaikan transaksi
    **Acceptance Criteria:**
    - AC-1:
        - Given buyer membuka link pembelian yang valid dari seller
        - When buyer memilih metode pembayaran yang tersedia dan menekan "Bayar Sekarang"
        - Then  transaksi tercatat di sistem, status pesanan berubah menjadi "Menunggu Konfirmasi Seller", dan buyer menerima notifikasi berhasil
    - AC-2:
        - Given buyer sedang di halaman checkout
        - When proses pembayaran gagal (timeout, saldo tidak cukup, dll)
        - Then sistem menampilkan pesan error spesifik, transaksi tidak diproses, dan buyer dapat mencoba ulang tanpa kehilangan data pesanan

8. Tutup penjualan  
    As a seller, I want mengubah status barang menjadi "Sold Out" setelah transaksi selesai, so that buyer lain tidak lagi dapat memesan barang yang sudah terjual
    **Acceptance Criteria:**
    - AC-1:
        - Given pembayaran buyer sudah berhasil dikonfirmasi
        - When saya menekan tombol "Tutup Penjualan" pada barang tersebut
        - Then status barang berubah menjadi "Sold Out", barang hilang dari hasil pencarian
    - AC-2:
        - Given buyer sudah membayar tetapi seller belum menekan "Tutup Penjualan"
        - When melewati batas waktu konfirmasi yang ditentukan sistem (2x24 jam)
        - Then sistem secara otomatis mengubah status barang menjadi "Sold Out" dan mengirim notifikasi ke seller

9. Detail barang
    As a buyer, I want melihat detail lengkap dari suatu barang yang ditampilkan di marketplace, so that saya bisa memastikan kondisi, spesifikasi, dan kelayakan barang sebelum memutuskan untuk membeli.
    **Acceptance Criteria:**
    - AC-1:
        - Given buyermembuka halaman detail suatu produk
        - When halaman dimuat sepenuhnya
        - Then sistem menampilkan informasi lengkap berupa nama produk, harga, deskripsi, kondisi barang, serta gambar produk secara jelas

10.Edit & hapus barang
    As a seller, I want mengedit atau menghapus barang yang saya jual di marketplace, so that saya dapat memastikan informasi yang ditampilkan tetap akurat atau menarik barang yang sudah tidak ingin dijual.
    **Acceptance Criteria:**
    - AC-1:
        - Given seller membuka halaman daftar barang miliknya
        - When seller memilih opsi untuk mengedit salah satu barang
        - Then sistem menampilkan form edit yang berisi data barang sebelumnya
    - AC-2:
        - Given seller telah melakukan perubahan pada data barang
        - When seller menyimpan perubahan tersebut
        - Then sistem memperbarui informasi barang sesuai data terbaru
    - AC-3:
        - Given seller memilih opsi untuk menghapus barang
        - When seller mengonfirmasi tindakan penghapusan
        - Then barang tersebut tidak lagi ditampilkan di marketplace

11.Monitoring admin
    As an admin, I want melihat dan memantau aktivitas yang terjadi di marketplace, so that saya dapat mengetahui performa sistem serta perkembangan jumlah pengguna, produk, dan transaksi.
    **Acceptance Criteria:**
    - AC-1:
        - Given admin membuka halaman dashboard
        - When halaman selesai dimuat
        - Then sistem menampilkan ringkasan data berupa jumlah user, jumlah produk, dan jumlah transaksi

12.Filter & sorting
    As a user, I want memfilter dan mengurutkan barang berdasarkan kategori dan harga, so that saya dapat menemukan barang yang sesuai dengan kebutuhan dan preferensi saya dengan lebih cepat.
    **Acceptance Criteria:**
    - AC-1:
        - Given user berada di halaman pencarian atau daftar produk
        - When user memilih kategori tertentu
        - Then sistem hanya menampilkan barang yang termasuk dalam kategori tersebut 
    - AC-2:
        - Given user memilih opsi pengurutan harga (termurah atau termahal)
        - When sistem menerapkan sorting
        - Then daftar barang ditampilkan sesuai urutan harga yang dipilih
    - AC-3:
        - Given user telah menerapkan filter
        - When user ingin menghapus atau mereset filter
        - Then sistem kembali menampilkan seluruh daftar barang tanpa filter

13.Wishlist
    As a user, I want menyimpan barang yang saya minati ke dalam wishlist, so that saya dapat dengan mudah menemukan kembali barang tersebut di kemudian hari.
    **Acceptance Criteria:**
    - AC-1:
        - Given user melihat produk yang diminati
        - When klik tombol “Suka”
        - Then sistem menyimpan produk tersebut ke dalam wishlist user
    - AC-2:
        - Given user membuka halaman wishlist
        - When halaman dimuat
        - Then sistem menampilkan seluruh barang yang telah disimpan oleh user 

14.Rating & ulasan
    As a buyer, I want memberikan rating dan ulasan kepada seller setelah transaksi selesai, so that user lain dapat menilai tingkat kepercayaan dan kualitas layanan dari seller tersebut.
    **Acceptance Criteria:**
    - AC-1:
        - Given transaksi antara buyer dan seller telah selesai
        - When buyer memberikan rating dan ulasan
        - Then sistem menyimpan rating tersebut pada profil seller
    - AC-2:
        - Given user membuka halaman profil seller
        - When halaman dimuat
        - Then sistem menampilkan rating dan ulasan dari user lain

15.Laporan barang
    As a user, I want melaporkan barang yang mencurigakan atau tidak sesuai, so that marketplace tetap aman dan terhindar dari penipuan atau konten yang tidak layak.
    **Acceptance Criteria:**
    - AC-1:
        - Given user membuka halaman detail produk
        - When user menekan tombol "Laporkan"
        - Then sistem menampilkan form laporan yang dapat diisi oleh user
    - AC-2:
        - Given user telah mengisi form laporan
        - When user mengirim laporan tersebut
        - Then sistem menyimpan laporan ke dalam database

16.Tindak laporan
    As an admin, I want melihat dan menindaklanjuti laporan dari user, so that saya dapat menjaga keamanan dan kenyamanan penggunaan marketplace.
    **Acceptance Criteria:**
    - AC-1:
        - Given admin membuka halaman daftar laporan
        - When halaman dimuat
        - Then sistem menampilkan seluruh laporan yang dikirim oleh user
    - AC-2:
        - Given admin memilih salah satu laporan
        - When admin meninjau isi laporan
        - Then sistem menampilkan detail laporan dan informasi terkait produk atau seller yang dilaporkan
    - AC-3:
        - Given admin  telah meninjau laporan
        - When admin mengambil tindakan (misalnya menghapus produk, memberi peringatan kepada seller, atau menyatakan laporan tidak valid)
        - Then sistem memperbarui status laporan sistem memperbarui status laporan menjadi “ditindaklanjuti” atau “ditolak” sesuai hasil keputusan admin
