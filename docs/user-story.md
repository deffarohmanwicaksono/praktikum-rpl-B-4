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
