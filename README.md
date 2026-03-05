# E-Commerce API (Backend Developer Technical Test)

Ini adalah RESTful API untuk sistem manajemen e-commerce yang dibangun menggunakan Laravel 12. Proyek ini mencakup fitur pengelolaan kategori, produk, manajemen stok, perhitungan nilai inventaris, autentikasi keamanan JWT, dan sistem diskon produk.

## 🚀 Fitur yang Tersedia

* **Manajemen Kategori:** CRUD (Create, Read) kategori produk.
* **Manajemen Produk:** CRUD (Create, Read, Update, Delete) produk.
* **Pencarian & Filter:** Cari produk berdasarkan nama dan filter berdasarkan kategori.
* **Manajemen Stok:** Update stok produk (penambahan/pengurangan berdasarkan transaksi).
* **Nilai Inventaris:** Hitung otomatis total nilai aset produk (Harga x Stok).
* **Autentikasi JWT:** Melindungi endpoint manajemen (CRUD) agar hanya dapat diakses oleh Admin.
* **Sistem Diskon (Bonus):** Pengaturan persentase diskon dengan kalkulasi harga akhir otomatis.

## 🛠️ Persyaratan Sistem (Requirements)

Pastikan sistem Anda telah terpasang perangkat lunak berikut:
* PHP >= 8.2
* Composer (v2.x)
* MySQL (v8.x) / MariaDB
* Laravel Framework (v12.x)

## 📦 Cara Instalasi & Menjalankan Aplikasi

Ikuti langkah-langkah berurutan berikut untuk menjalankan proyek ini di komputer lokal Anda:

### 1. Clone Repositori (atau Ekstrak File ZIP)
Buka terminal dan arahkan ke direktori tempat Anda menyimpan proyek ini.

### 2. Install Dependencies
Jalankan perintah berikut untuk mengunduh semua paket yang dibutuhkan Laravel dan JWT:

```bash
composer install
```

### 3. Konfigurasi Environment
Salin file bawaan `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Buka file `.env` menggunakan *text editor* dan sesuaikan kredensial database Anda pada bagian ini:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key & JWT Secret
Jalankan dua perintah ini untuk membuat kunci keamanan aplikasi dan *secret key* khusus untuk token JWT:

```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Jalankan Migrasi Database
Buat seluruh tabel yang dibutuhkan ke dalam database yang sudah Anda siapkan:

```bash
php artisan migrate
```

### 6. Buat Akun Admin (Untuk Login JWT) menggunakan Tinker
Karena endpoint manajemen produk dikunci dengan JWT, Anda perlu membuat satu akun Admin. Masuk ke environment Tinker dengan perintah:

```bash
php artisan tinker
```

Setelah masuk ke *prompt* Tinker (`>`), *copy-paste* kode berikut dan tekan Enter:

```php
App\Models\User::create(['name' => 'Admin Toko', 'email' => 'admin@toko.com', 'password' => bcrypt('password123')]);
```

Jika sudah berhasil membuat *user*, ketik `exit` lalu tekan Enter untuk keluar dari Tinker.

### 7. Jalankan Server Lokal
Jalankan aplikasi dengan perintah bawaan artisan:

```bash
php artisan serve
```

API sekarang berjalan dan dapat diakses melalui `http://127.0.0.1:8000/api`

---

## 📚 Dokumentasi API (Postman)

Dokumentasi lengkap mengenai endpoint, cara penggunaan parameter pencarian, struktur *Request Body*, dan *Response* telah diekspor dalam format **Postman Collection**.

**Cara Penggunaan:**
1. Temukan file `Postman_Collection_API_Toko.json` di dalam folder root proyek ini.
2. Buka aplikasi **Postman**, lalu pilih menu **Import**.
3. Masukkan file JSON tersebut.
4. **PENTING:** Untuk mengakses *Protected Routes* (seperti Create, Update, Delete produk), jalankan *request* **Login** terlebih dahulu menggunakan email `admin@toko.com` dan password `password123`.
5. *Copy* Token JWT yang didapat, lalu *Paste* ke dalam tab **Authorization -> Bearer Token** di *request* yang ingin Anda uji.
