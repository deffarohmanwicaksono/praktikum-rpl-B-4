# ERD Data Dictionary

## 1. Tabel Users

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| users | id_user | INT | PK, IDENTITY(1,1) | ID unik pengguna |
| users | name | NVARCHAR(150) | NOT NULL | Nama pengguna |
| users | email | NVARCHAR(150) | UNIQUE, NOT NULL | Email pengguna |
| users | role | NVARCHAR(20) | NOT NULL | Peran pengguna (buyer/seller/admin) |
| users | created_at | DATETIME | DEFAULT GETDATE() | Waktu akun dibuat |

## 2. Tabel Products

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| products | id_product | INT | PK, IDENTITY(1,1) | ID unik produk |
| products | user_id | INT | FK → users.id_user, NOT NULL | ID seller |
| products | category_id | INT | FK → categories.id_category, NULL | Kategori produk |
| products | name | NVARCHAR(200) | NOT NULL | Nama produk |
| products | description | NTEXT | NULL | Deskripsi produk |
| products | price | DECIMAL(18,2) | NOT NULL | Harga produk |
| products | status | NVARCHAR(30) | NOT NULL | Status produk ('menunggu_verifikasi','dijual','sold_out','ditolak') |

## 3. Tabel Product Images

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| products | created_at | DATETIME | DEFAULT GETDATE() | Waktu upload produk |
| product_images | id_image | INT | PK, IDENTITY(1,1) | ID unik image |
| product_images | product_id | INT | FK → products.id_product, NOT NULL | ID produk |
| product_images | image_url | NVARCHAR(500) | NOT NULL | URL image produk |
| product_images | [order] | INT | DEFAULT 0 | Urutan gambar |

## 4. Tabel Categories

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| categories | id_category | INT | PK, IDENTITY(1,1) | ID kategori |
| categories | name | NVARCHAR(100) | NOT NULL | Nama kategori |
| categories | description | NVARCHAR(255) | NOT NULL | Deskripsi kategori |
| categories | created_at | DATETIME | DEFAULT GETDATE() | Waktu kategori dibuat |

## 5. Tabel Wishlist

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| whistlist | id_wishlist | INT | PK, IDENTITY(1,1) | ID wishlist |
| whistlist | user_id | INT | FK → users.id_user, NOT NULL | ID buyer |
| whistlist | product_id | INT | FK → products.id_product, NOT NULL | ID produk |
| whistlist | (user_id, product_id) | - | UNIQUE | Tidak boleh duplikat |

## 6. Tabel Chat

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| chat | id_chat | INT | PK, IDENTITY(1,1) | ID chat |
| chat | buyer_id | INT | FK → users.id_user, NOT NULL | ID buyer |
| chat | seller_id | INT | FK → users.id_user, NOT NULL | ID seller |
| chat | product_id | INT | FK → products.id_product, NOT NULL | ID produk |
| chat | created_at | DATETIME | DEFAULT GETDATE() | Waktu chat dibuat |

## 7. Tabel Messages

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| messages | id_message | INT | PK, IDENTITY(1,1) | ID pesan |
| messages | chat_id | INT | FK → chat.id_chat, NOT NULL | Relasi ke chat |
| messages | sender_id | INT | FK → users.id_user, NOT NULL | Pengirim pesan |
| messages | message | NTEXT | NOT NULL | Isi pesan |
| messages | created_at | DATETIME | DEFAULT GETDATE() | Waktu kirim pesan |

## 8. Tabel Purchase Links

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| purchase_links | id_link | INT | PK, IDENTITY(1,1) | ID link pembelian |
| purchase_links | chat_id | INT | FK → chat.id_chat, NOT NULL | ID chat |
| purchase_links | token | NVARCHAR(255) | UNIQUE, NOT NULL | Token unik link |
| purchase_links | expired_at | DATETIME | NOT NULL | Waktu kadaluarsa link |
| purchase_links | is_used | BIT | DEFAULT 0 | Status penggunaan link |

## 9. Tabel Transactions

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| transactions | id_transaction | INT | PK, IDENTITY(1,1) | ID transaksi |
| transactions | product_id | INT | FK → products.id_product, NOT NULL | ID produk |
| transactions | buyer_id | INT | FK → users.id_user, NOT NULL | ID buyer |
| transactions | quantity | INT | DEFAULT 1, NOT NULL | Jumlah produk |
| transactions | total_price | DECIMAL(18,2) | NOT NULL | Total harga produk |
| transactions | status | NVARCHAR(30) | NOT NULL | Status transaksi ('menunggu_pembayaran','dibayar','selesai','gagal') |
| transactions | created_at | DATETIME | DEFAULT GETDATE() | Waktu transaksi dibuat |

## 10. Tabel Reviews

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| reviews | id_review | INT | PK, IDENTITY(1,1) | ID review |
| reviews | transaction_id | INT | FK → transactions.id_transaction, UNIQUE, NOT NULL | Relasi ke transaksi |
| reviews | rating | INT | NOT NULL | Nilai rating (1–5) |
| reviews | comment | NTEXT | NULL | Ulasan |
| reviews | created_at | DATETIME | DEFAULT GETDATE() | Waktu review dibuat |

## 11. Tabel Reports

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| reports | id_report | INT | PK, IDENTITY(1,1) | ID laporan |
| reports | user_id | INT | FK → users.id_user, NOT NULL | ID user |
| reports | product_id | INT | FK → products.id_product, NOT NULL | Produk yang dilaporkan |
| reports | reason | NTEXT | NOT NULL | Alasan laporan |
| reports | status | NVARCHAR(30) | DEFAULT 'menunggu' | Status laporan ('menunggu','ditindaklanjuti','ditolak') |
| reports | created_at | DATETIME | DEFAULT GETDATE() | Waktu laporan dibuat |

## 12. Tabel Notifications

| Table | Kolom | Tipe Data | Constraint | Keterangan |
|----------|------------------|-----------|-----------------------------|--------------------|
| notifications | id_notification | INT | PK, IDENTITY(1,1) | ID notifikasi |
| notifications | user_id | INT | FK → users.id_user, NOT NULL | ID user penerima |
| notifications | type | NVARCHAR(50) | NOT NULL | Jenis notifikasi |
| notifications | content | NTEXT | NOT NULL | Isi notifikasi |
| notifications | is_read | BIT | DEFAULT 0 | Status dibaca |
| notifications | created_at | DATETIME | DEFAULT GETDATE() | Waktu notifikasi dibuat |
