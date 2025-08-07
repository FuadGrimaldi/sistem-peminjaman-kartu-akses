# Panduan Instalasi Laravel 11 dengan Vite (2 Terminal)

Panduan ini akan memandu Anda melalui proses instalasi proyek Laravel 11 baru dan menjalankannya menggunakan Vite, yang memerlukan dua terminal untuk server pengembangan.

---

## Prasyarat

Sebelum memulai, pastikan perangkat lunak berikut sudah terinstal di komputer Anda:

-   **PHP** (versi 8.2 atau lebih tinggi)
-   **Composer**: Manajer paket untuk PHP
-   **Node.js dan NPM**: Lingkungan runtime JavaScript dan manajer paketnya (Node.js versi 18 atau lebih tinggi)
-   **Git**: Untuk version control (opsional tapi direkomendasikan)

### Verifikasi Instalasi

Pastikan semua prasyarat sudah terinstal dengan menjalankan perintah berikut:

```bash
php --version
composer --version
node --version
npm --version
```

---

## Langkah 1: Clone Repository Existing Laravel

Jika Anda ingin mengkloning proyek Laravel yang sudah ada dari repository Git, ikuti langkah-langkah berikut:

### Clone Repository

```bash
git clone https://github.com/username/nama-repository.git
```

_Ganti URL di atas dengan URL repository yang sebenarnya_

### Masuk ke Direktori Project

```bash
cd nama-repository
```

### Buat File Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

_Untuk Windows, gunakan:_

```cmd
copy .env.example .env
```

### Konfigurasi Environment

Edit file `.env` untuk mengkonfigurasi database dan pengaturan lainnya:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_anda
DB_PASSWORD=password_anda
```

### Install Dependencies

Install dependensi PHP dan JavaScript:

```bash
composer install
npm install
```

### Generate Application Key

```bash
php artisan key:generate
```

### Setup Database

Pastikan database sudah dibuat, kemudian jalankan migrasi:

```bash
php artisan migrate
```

### Jalankan Seeder (Jika Ada)

Jika project memiliki seeder, jalankan perintah berikut:

```bash
php artisan db:seed --class=CreateUsersSeeder
php artisan db:seed --class=AccessCardSeeder
```

_Atau jalankan semua seeder sekaligus:_

```bash
php artisan db:seed
```

---

## Langkah 2: Build Assets (Pilihan)

### Build untuk Production

Jika Anda tidak ingin menggunakan mode development dan ingin membuild assets untuk production:

```bash
npm run build
```

### Build untuk Development (Hot Reload)

Jika Anda ingin mode development dengan hot reload, jalankan di terminal terpisah:

```bash
npm run dev
```

---

## Langkah 3: Menjalankan Aplikasi

### Menjalankan Server Laravel

Jalankan server development Laravel:

```bash
php artisan serve
```

Server akan berjalan di `http://127.0.0.1:8000` atau `http://localhost:8000`.

---

## Mode Development dengan Hot Reload (2 Terminal)

Jika Anda ingin menggunakan fitur hot reload untuk development, Anda perlu menjalankan dua terminal secara bersamaan.

### Terminal 1: Server Backend Laravel 🐘

Buka terminal pertama Anda, pastikan Anda berada di direktori proyek, dan jalankan server pengembangan PHP Artisan. Server ini akan menangani semua logika backend aplikasi Anda.

```bash
php artisan serve
```

**Output yang diharapkan:**

```
Starting Laravel development server: http://127.0.0.1:8000
[Thu Jan 25 10:30:00 2024] PHP 8.2.0 Development Server (http://127.0.0.1:8000) started
```

Server ini biasanya akan berjalan dan merespons pada alamat `http://127.0.0.1:8000`. **Biarkan terminal ini tetap berjalan.**

### Terminal 2: Server Frontend Vite ⚡

Sekarang, buka terminal **kedua**. Masuk ke direktori proyek yang sama dan jalankan server pengembangan Vite:

```bash
npm run dev
```

**Output yang diharapkan:**

```
VITE v5.0.0  ready in 500 ms

➜  Local:   http://localhost:5173/
➜  Network: use --host to expose
➜  press h to show help
```

Server Vite ini bertugas untuk:

-   Mengkompilasi aset (JavaScript dan CSS) secara _on-the-fly_
-   Menyediakan fitur canggih seperti **Hot Module Replacement (HMR)**
-   Memungkinkan perubahan pada kode frontend langsung terlihat di browser tanpa perlu me-refresh halaman

---

## Langkah 5: Akses Aplikasi Anda

Dengan kedua server yang sudah berjalan, buka browser web Anda dan kunjungi alamat yang diberikan oleh server Artisan:

**🌐 [http://localhost:8000](http://localhost:8000)**

Anda sekarang akan melihat halaman selamat datang Laravel. Vite secara otomatis akan menangani semua aset frontend. Setiap kali Anda menyimpan perubahan pada file di `resources/js` atau `resources/css`, perubahan tersebut akan langsung tercermin di browser.

---

## Struktur File Penting

Berikut adalah struktur file penting yang perlu Anda ketahui:

```
nama-proyek-anda/
├── resources/
│   ├── js/
│   │   └── app.js          # Entry point JavaScript utama
│   ├── css/
│   │   └── app.css         # Stylesheet utama
│   └── views/
│       └── welcome.blade.php
├── public/
│   └── build/              # File yang dikompilasi oleh Vite
├── vite.config.js          # Konfigurasi Vite
├── package.json            # Dependensi Node.js
└── .env                    # Konfigurasi environment
```

---

## Tips dan Troubleshooting

### 🔧 Perintah Berguna

| Perintah                        | Deskripsi                               |
| ------------------------------- | --------------------------------------- |
| `php artisan serve --port=8080` | Menjalankan server di port yang berbeda |
| `npm run build`                 | Membuat build produksi untuk aset       |
| `php artisan config:clear`      | Membersihkan cache konfigurasi          |
| `php artisan route:list`        | Melihat daftar semua route              |
| `npm run dev -- --host`         | Mengekspos Vite server ke jaringan      |

### ⚠️ Masalah Umum

**1. Port 8000 sudah digunakan:**

```bash
php artisan serve --port=8080
```

**2. NPM install gagal:**

```bash
npm cache clean --force
npm install
```

**3. Vite tidak bisa mengkompilasi aset:**

```bash
npm run build
php artisan view:clear
```

**4. APP_KEY belum di-generate:**

```bash
php artisan key:generate
```

**5. Permission denied saat menjalankan artisan:**

```bash
chmod +x artisan
php artisan serve
```

**6. Seeder tidak ditemukan:**

```bash
composer dump-autoload
php artisan db:seed --class=NamaSeederClass
```

---

## Langkah Selanjutnya

Selamat! Lingkungan pengembangan Laravel 11 Anda sudah siap digunakan! 🚀

Berikut beberapa langkah yang bisa Anda lakukan selanjutnya:

1. **Pelajari Routing**: Mulai dengan membuat route baru di `routes/web.php`
2. **Buat Controller**: Gunakan `php artisan make:controller NamaController`
3. **Desain Database**: Buat migration dengan `php artisan make:migration`
4. **Frontend Development**: Mulai edit file di `resources/js` dan `resources/css`
5. **Pelajari Blade Templates**: Buat view baru di `resources/views`

### Sumber Belajar Tambahan

-   [Dokumentasi Laravel Official](https://laravel.com/docs/11.x)
-   [Laravel Vite Documentation](https://laravel.com/docs/11.x/vite)
-   [Laravel Bootcamp](https://bootcamp.laravel.com/)

---

**Happy Coding! 💻✨**
