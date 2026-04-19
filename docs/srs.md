# Pendahuluan

## Tujuan Dokumen  
Dokumen Software Requirements Specification (SRS) ini disusun untuk mendefinisikan kebutuhan fungsional dan non-fungsional dari aplikasi SeMart, yaitu marketplace khusus mahasiswa Universitas Sebelas Maret. Dokumen ini menjadi acuan utama bagi tim pengembang dalam merancang, membangun, dan menguji sistem agar sesuai dengan kebutuhan pengguna.

## Ruang Lingkup Sistem  
SeMart merupakan aplikasi marketplace berbasis digital yang memfasilitasi mahasiswa Universitas Sebelas Maret dalam melakukan jual beli barang bekas secara aman dan terjangkau di lingkungan kampus.  
Fitur utama yang dicakup dalam sistem ini meliputi:
- Autentikasi pengguna menggunakan SSO UNS
- Pengunggahan barang oleh seller
- Verifikasi barang oleh admin
- Pencarian barang oleh buyer
- Komunikasi antara buyer dan seller melalui fitur chat
- Pengiriman link pembelian oleh seller
- Proses checkout oleh buyer
- Penutupan penjualan oleh seller  
Sistem ini tidak mencakup pengelolaan logistik pengiriman secara langsung (misalnya integrasi dengan jasa ekspedisi) dan hanya berfokus pada proses transaksi dalam aplikasi.

## Glosarium  
| Istilah   | Definisi         |
|-----------|------------------|
| User      | Pengguna aplikasi yang dapat berperan sebagai buyer maupun seller |
| Buyer     | Pengguna yang melakukan pembelian barang |
| Seller    | Pengguna yang menjual barang |
| Admin     | Pengguna yang bertugas memverifikasi barang dan mengawasi aktivitas dalam sistem |
| SSO       | Sistem autentikasi terpusat milik Universitas Sebelas Maret yang digunakan untuk login |
| Link Pembelian | Fitur yang memungkinkan seller mengirimkan tautan khusus kepada buyer untuk melanjutkan proses checkout |
| Checkout  | Proses penyelesaian transaksi oleh buyer setelah memilih metode pembayaran |
| Sold Out  | Status barang yang menandakan bahwa barang telah terjual dan tidak tersedia lagi |


# Deskripsi Umum  

## Perspektif Produk  
SeMart merupakan aplikasi marketplace berbasis digital yang dirancang khusus untuk mahasiswa Universitas Sebelas Maret. Sistem ini bersifat mandiri, namun terintegrasi dengan sistem eksternal berupa SSO UNS untuk keperluan autentikasi pengguna.  

Aplikasi ini berfungsi sebagai platform perantara antara buyer dan seller dalam melakukan transaksi jual beli barang bekas di lingkungan kampus. Seluruh proses, mulai dari pengunggahan barang hingga penyelesaian transaksi, dilakukan di dalam sistem SeMart tanpa melibatkan integrasi langsung dengan layanan pihak ketiga seperti jasa pengiriman atau payment gateway eksternal yang kompleks.

## Fungsi Utama  
SeMart menyediakan beberapa fungsi utama yang mendukung proses jual beli barang bekas, yaitu:  
- Sistem melakukan autentikasi pengguna menggunakan SSO UNS
- Sistem memungkinkan seller mengunggah barang untuk dijual
- Sistem menyediakan mekanisme verifikasi barang oleh admin sebelum ditampilkan
- Sistem memungkinkan buyer mencari barang berdasarkan kata kunci
- Sistem menyediakan fitur komunikasi (chat) antara buyer dan seller
- Sistem memungkinkan seller mengirimkan link pembelian kepada buyer
- Sistem memfasilitasi proses checkout oleh buyer
- Sistem memungkinkan seller menutup penjualan dan mengubah status barang menjadi “Sold Out”

## Karakteristik Pengguna  
Sistem SeMart memiliki dua jenis pengguna utama:  
1. User (Buyer & Seller)  
   - Merupakan mahasiswa Universitas Sebelas Maret
   - Memiliki akun SSO UNS yang valid
   - Memiliki tingkat literasi digital yang cukup baik (terbiasa menggunakan aplikasi mobile/web)
   - Menggunakan sistem untuk membeli atau menjual barang bekas
2. Admin  
   - Bertugas mengelola dan mengawasi sistem
   - Memiliki pemahaman yang lebih tinggi terhadap aturan dan kebijakan platform
   - Bertanggung jawab dalam memverifikasi barang serta menangani laporan atau pelanggaran

## Batasan  
Sistem SeMart memiliki beberapa batasan sebagai berikut:  
- Hanya pengguna dengan akun SSO UNS yang valid yang dapat mengakses sistem
- Barang yang diunggah harus melalui proses verifikasi oleh admin sebelum dapat ditampilkan
- Buyer tidak dapat melakukan pembelian tanpa melalui proses komunikasi (chat) dengan seller
- Proses transaksi dilakukan melalui mekanisme link pembelian yang dikirim oleh seller
- Sistem tidak mencakup integrasi dengan layanan logistik atau pengiriman barang secara otomatis
- Status barang hanya dapat diubah menjadi “Sold Out” setelah transaksi selesai

# Fitur Requirements (FR)
# Non-Functional Requirements (NFR)
# Catatan