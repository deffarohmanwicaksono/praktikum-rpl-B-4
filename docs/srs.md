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
| Kode FR | Deskripsi                                                                   | Prioritas | Ref US |
| ------- | --------------------------------------------------------------------------- | --------- | ------ |
| FR-01   | Sistem memungkinkan user login menggunakan SSO UNS                          | High      | US-01  |
| FR-02   | Sistem memungkinkan seller mengunggah barang (nama, deskripsi, harga, foto) | High      | US-02  |
| FR-03   | Sistem memungkinkan admin meninjau barang                                   | High      | US-03  |
| FR-04   | Sistem memungkinkan admin menyetujui barang                                 | High      | US-03  |
| FR-05   | Sistem memungkinkan admin menolak barang dengan alasan                      | High      | US-03  |
| FR-06   | Sistem memungkinkan buyer mencari barang                                    | High      | US-04  |
| FR-07   | Sistem menyediakan fitur chat antara buyer dan seller                       | High      | US-05  |
| FR-08   | Sistem memungkinkan seller mengirim link pembelian unik                     | High      | US-06  |
| FR-09   | Sistem memungkinkan buyer mengakses link pembelian yang valid               | High      | US-07  |
| FR-10   | Sistem memungkinkan buyer melakukan checkout                                | High      | US-07  |
| FR-11   | Sistem mencatat transaksi dan memperbarui status pesanan                    | High      | US-07  |
| FR-12   | Sistem memungkinkan seller mengubah status barang menjadi "Sold Out"        | High      | US-08  |
| FR-13   | Sistem memungkinkan user melihat detail barang                              | High      | US-09  |
| FR-14   | Sistem memungkinkan seller mengedit barang                                  | High      | US-10  |
| FR-15   | Sistem memungkinkan seller menghapus barang                                 | High      | US-10  |
| FR-16   | Sistem memungkinkan admin melihat dashboard aktivitas marketplace           | Medium    | US-11  |
| FR-17   | Sistem memungkinkan user memfilter barang berdasarkan kategori              | Medium    | US-12  |
| FR-18   | Sistem memungkinkan user mengurutkan barang berdasarkan harga               | Medium    | US-12  |
| FR-19   | Sistem memungkinkan user menyimpan barang ke wishlist                       | Medium    | US-13  |
| FR-20   | Sistem memungkinkan buyer memberikan rating dan ulasan                      | Medium    | US-14  |
| FR-21   | Sistem memungkinkan user melaporkan barang mencurigakan                     | Medium    | US-15  |
| FR-22   | Sistem memungkinkan admin meninjau laporan                                  | High      | US-16  |
| FR-23   | Sistem memungkinkan admin mengambil tindakan terhadap laporan               | High      | US-16  |
| FR-24   | Sistem memungkinkan login non-SSO (Google/email)                            | Low       | US-17  |
| FR-25   | Sistem memungkinkan seller menggunakan fitur promosi berbayar               | Low       | US-18  |
| FR-26   | Sistem menampilkan rekomendasi barang berdasarkan preferensi user           | Low       | US-19  |

 
# Non-Functional Requirements (NFR)
| Kode NFR | Kategori    | Deskripsi                                                                                                                     |
| -------- | ----------- | ----------------------------------------------------------------------------------------------------------------------------- |
| NFR-01   | Performance | Halaman pencarian dan detail produk harus dimuat dalam waktu ≤ 3 detik pada koneksi minimal 10 Mbps                           |
| NFR-02   | Performance | Sistem harus mampu menangani minimal 100 pengguna aktif secara bersamaan tanpa penurunan performa signifikan                  |
| NFR-03   | Security    | Hanya user yang telah login yang dapat mengakses fitur upload barang, chat, dan checkout                                      |
| NFR-04   | Security    | Data autentikasi pengguna harus disimpan menggunakan hashing (bcrypt) dan tidak dalam bentuk plain text                       |
| NFR-05   | Usability   | Antarmuka sistem harus responsif dan dapat digunakan pada perangkat mobile (≥360px) dan desktop tanpa kehilangan fungsi utama |
| NFR-06   | Usability   | User dapat mencari dan membuka detail barang dalam maksimal 3 langkah interaksi dari halaman utama                            |



# Catatan