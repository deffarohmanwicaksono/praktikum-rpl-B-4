# Panduan Evaluasi & Menjalankan Server Backend (Laravel)

Proyek ini adalah Backend API untuk aplikasi SeMart. Harap ikuti langkah-langkah di bawah ini untuk menjalankan server dan menyambungkannya dengan aplikasi Android.

## Persyaratan
- PHP (disarankan versi 8.1 / 8.2 ke atas)
- Composer
- Database MySQL (misal menggunakan Laragon/XAMPP)

## Langkah Instalasi & Konfigurasi

1. **Install Dependencies**
   Buka terminal di dalam folder proyek ini dan jalankan:
   ```bash
   composer install
   npm install
   ```

2. **Pengaturan `.env` (Environment)**
   Salin file `.env.example` menjadi `.env`.
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan pastikan konfigurasi database sudah benar. Contoh:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=semart_db   <-- Buat database kosong dengan nama ini di MySQL Anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

4. **Migrasi Database & Seeding (Opsional)**
   Untuk membuat tabel-tabel di database (beserta data awal jika ada), jalankan:
   ```bash
   php artisan migrate --seed
   ```

## Menjalankan Server

Aplikasi Android sudah disetel untuk melakukan koneksi ke port `8000` untuk API dan port `8080` untuk WebSocket (Laravel Reverb).

Oleh karena itu, **Anda HARUS membuka dua terminal** dan menjalankan kedua perintah berikut secara bersamaan:

**Terminal 1 (Menjalankan HTTP API):**
```bash
php artisan serve
```
*(Pastikan berjalan di port default: http://127.0.0.1:8000)*

**Terminal 2 (Menjalankan WebSocket Reverb):**
```bash
php artisan reverb:start
```

Setelah kedua server tersebut berjalan, silakan buka dan jalankan **Proyek Aplikasi Android SeMart** di Android Studio menggunakan **Emulator**. Aplikasi siap digunakan!
