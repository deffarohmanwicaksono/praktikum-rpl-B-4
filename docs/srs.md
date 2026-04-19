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
|-----------|------------------|
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
# Fitur Requirements (FR)
# Non-Functional Requirements (NFR)
# Catatan