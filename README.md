# 📚 Sistem Reservasi Perpustakaan

> Aplikasi web manajemen perpustakaan berbasis Laravel dengan fitur reservasi buku, verifikasi pembayaran, dan pengelolaan anggota.

![Laravel](https://img.shields.io/badge/Laravel-v13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-v4-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-v4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Spesifikasi Teknologi](#-spesifikasi-teknologi)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi Environment](#-konfigurasi-environment)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Akun Default](#-akun-default)
- [Struktur Proyek](#-struktur-proyek)
- [Struktur Database](#-struktur-database)
- [Alur Penggunaan](#-alur-penggunaan)
- [Perintah Artisan Berguna](#-perintah-artisan-berguna)
- [Testing](#-testing)
- [Lisensi](#-lisensi)

---

## 🏛 Tentang Proyek

**Sistem Reservasi Perpustakaan** adalah aplikasi web full-stack yang dibangun menggunakan Laravel 13 dan Livewire 4, dirancang untuk mempermudah proses peminjaman buku di perpustakaan secara digital. Aplikasi ini mendukung dua peran pengguna: **Admin** dan **Anggota**, masing-masing dengan dashboard dan hak akses yang berbeda.

---

## ✨ Fitur Utama

### 👤 Fitur Anggota

| Fitur | Deskripsi |
|---|---|
| Registrasi & Login | Autentikasi lengkap menggunakan Laravel Fortify |
| Reservasi Buku | Anggota dapat memesan buku yang tersedia |
| Upload Bukti Pembayaran | Anggota mengunggah bukti pembayaran denda/biaya |
| Riwayat Peminjaman | Lihat seluruh histori reservasi dan statusnya |
| Profil | Kelola data diri dan foto profil |

### 🛡 Fitur Admin

| Fitur | Deskripsi |
|---|---|
| Dashboard | Statistik ringkasan aktivitas perpustakaan |
| Kelola Buku | Tambah, edit, hapus data buku & kategori |
| Verifikasi Anggota | Setujui atau tolak pendaftaran anggota baru |
| Verifikasi Reservasi | Proses persetujuan peminjaman buku |
| Verifikasi Pembayaran | Konfirmasi bukti pembayaran dari anggota |
| Verifikasi Pengembalian | Catat pengembalian buku dari anggota |
| Kelola Pengumuman | Buat dan kelola pengumuman perpustakaan |
| Konfigurasi Sistem | Pengaturan denda, biaya, dan parameter sistem |

---

## 🛠 Spesifikasi Teknologi

### Backend

| Paket | Versi | Deskripsi |
|---|---|---|
| `laravel/framework` | ^13.17 | Framework PHP utama |
| `livewire/livewire` | ^4.1 | Reactive UI tanpa JavaScript penuh |
| `livewire/flux` | ^2.13 | Komponen UI untuk Livewire |
| `laravel/fortify` | ^1.37 | Backend autentikasi |
| `spatie/laravel-permission` | ^8.3 | Manajemen peran & izin (RBAC) |
| `laravel/tinker` | ^3.0 | REPL interaktif untuk debugging |
| `laravel/chisel` | ^0.1 | Tooling tambahan Laravel |
| `livewire/blaze` | ^1.0 | Ekstensi Livewire |

### Frontend

| Paket | Versi | Deskripsi |
|---|---|---|
| `tailwindcss` | ^4.3 | Framework CSS utility-first |
| `@tailwindcss/vite` | ^4.3 | Plugin Vite untuk Tailwind |
| `vite` | ^8.0 | Build tool frontend modern |
| `laravel-vite-plugin` | ^3.1 | Integrasi Vite dengan Laravel |
| `aos` | ^2.3 | Animasi scroll (Animate On Scroll) |

### Dev Dependencies

| Paket | Versi | Deskripsi |
|---|---|---|
| `pestphp/pest` | ^4.7 | Framework testing PHP |
| `larastan/larastan` | ^3.9 | Analisis statis berbasis PHPStan |
| `laravel/pint` | ^1.27 | Code formatter PHP |
| `laravel/pail` | ^1.2 | Log viewer real-time |
| `laravel/sail` | ^1.53 | Lingkungan Docker |
| `fakerphp/faker` | ^1.24 | Generator data palsu untuk testing |

---

## 💻 Persyaratan Sistem

Pastikan lingkungan Anda memenuhi persyaratan berikut sebelum instalasi:

| Kebutuhan | Versi Minimum |
|---|---|
| **PHP** | 8.3 atau lebih baru |
| **Composer** | 2.x |
| **Node.js** | 18.x atau lebih baru |
| **NPM / Bun** | NPM 9+ / Bun 1+ |
| **SQLite** | 3.x (default) **atau** MySQL 8+ / PostgreSQL 14+ |
| **Git** | 2.x |

> **Ekstensi PHP yang dibutuhkan:** `pdo`, `pdo_sqlite` (atau `pdo_mysql`), `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `openssl`

---

## 🚀 Instalasi

### Cara Cepat (Otomatis)

Gunakan skrip `setup` dari Composer untuk instalasi satu perintah:

```bash
composer run setup
```

Perintah ini akan secara otomatis:
1. Menginstall semua dependensi PHP via Composer
2. Menyalin `.env.example` ke `.env`
3. Membuat application key
4. Menjalankan seluruh migrasi database
5. Menginstall dependensi Node.js
6. Melakukan build aset frontend

---

### Cara Manual (Langkah demi Langkah)

#### 1. Clone Repository

```bash
git clone https://github.com/<username>/reservasi-perpustakaan.git
cd reservasi-perpustakaan/library-app
```

#### 2. Install Dependensi PHP

```bash
composer install
```

#### 3. Salin File Environment

```bash
cp .env.example .env
```

#### 4. Generate Application Key

```bash
php artisan key:generate
```

#### 5. Konfigurasi Database

Edit file `.env` sesuai kebutuhan (lihat bagian Konfigurasi Environment di bawah).

#### 6. Jalankan Migrasi & Seeder

```bash
# Migrasi saja
php artisan migrate

# Migrasi + data awal (recommended untuk development)
php artisan migrate --seed
```

#### 7. Install Dependensi Node.js

```bash
npm install
# atau menggunakan Bun
bun install
```

#### 8. Build Aset Frontend

```bash
# Production build
npm run build

# atau untuk development (hot reload)
npm run dev
```

#### 9. Buat Symlink Storage (untuk upload file)

```bash
php artisan storage:link
```

---

## ⚙ Konfigurasi Environment

Berikut adalah variabel environment penting di file `.env`:

```env
# ========================
# Konfigurasi Aplikasi
# ========================
APP_NAME="NoireeLibrary"
APP_ENV=local          # local | staging | production
APP_KEY=               # Di-generate otomatis oleh artisan key:generate
APP_DEBUG=true         # Ubah ke false di production
APP_URL=http://localhost

APP_LOCALE=id          # Bahasa default (id = Indonesia)
APP_FALLBACK_LOCALE=en

# ========================
# Konfigurasi Database
# ========================
# SQLite (default, tidak perlu konfigurasi tambahan)
DB_CONNECTION=sqlite

# MySQL (jika ingin menggunakan MySQL)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=reservasi_perpustakaan
# DB_USERNAME=root
# DB_PASSWORD=secret

# ========================
# Konfigurasi Session & Cache
# ========================
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database

# ========================
# Konfigurasi Mail (Opsional)
# ========================
MAIL_MAILER=log        # Gunakan 'smtp' untuk production
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="noreply@perpustakaan.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## ▶ Menjalankan Aplikasi

### Mode Development (Recommended)

Gunakan perintah berikut untuk menjalankan server PHP, queue worker, dan Vite secara bersamaan:

```bash
composer run dev
```

Perintah ini akan menjalankan secara paralel:
- **PHP Server** → `http://localhost:8000`
- **Queue Worker** → memproses antrian job
- **Vite Dev Server** → hot-reload aset frontend

### Manual

```bash
# Terminal 1: PHP development server
php artisan serve

# Terminal 2: Vite untuk frontend (jika dev mode)
npm run dev

# Terminal 3: Queue worker (jika diperlukan)
php artisan queue:listen --tries=1
```

Akses aplikasi di browser: **http://localhost:8000**

---

## 🔑 Akun Default

Setelah menjalankan seeder (`php artisan db:seed`), akun-akun berikut tersedia:

### Admin

| Field | Value |
|---|---|
| **Email** | `admin@perpustakaan.com` |
| **Password** | `password` |
| **Role** | `admin` |

### Anggota (Aktif)

| Nama | Email | Password | Status |
|---|---|---|---|
| Budi Santoso | `budi@member.com` | `password` | ✅ Aktif |
| Sari Dewi | `sari@member.com` | `password` | ✅ Aktif |
| Andi Pratama | `andi@member.com` | `password` | ✅ Aktif |

### Anggota (Pending)

| Nama | Email | Password | Status |
|---|---|---|---|
| Rizky Firmansyah | `rizky@member.com` | `password` | ⏳ Menunggu Verifikasi |

> ⚠️ **Peringatan:** Segera ganti semua password default sebelum deploy ke lingkungan production.

---

## 🗂 Struktur Proyek

```
library-app/
├── app/
│   ├── Actions/             # Action classes (logika bisnis)
│   ├── Concerns/            # Reusable traits
│   ├── Http/                # Controllers & Middleware
│   ├── Livewire/            # Komponen Livewire
│   │   ├── Admin/           # Komponen khusus Admin
│   │   │   ├── Dashboard.php
│   │   │   ├── KelolaBuku.php
│   │   │   ├── KelolaAnggota.php
│   │   │   ├── KelolaAnnouncement.php
│   │   │   ├── VerifikasiAnggota.php
│   │   │   ├── VerifikasiReservasi.php
│   │   │   ├── VerifikasiPembayaran.php
│   │   │   ├── VerifikasiPengembalian.php
│   │   │   └── Konfigurasi.php
│   │   ├── Member/          # Komponen khusus Anggota
│   │   │   ├── PeminjamanBuku.php
│   │   │   ├── ListPeminjaman.php
│   │   │   └── Profile.php
│   │   ├── Announcements/   # Pengumuman publik
│   │   └── Welcome.php      # Halaman beranda
│   ├── Models/              # Eloquent Models
│   │   ├── User.php
│   │   ├── Book.php
│   │   ├── BookCategory.php
│   │   ├── Reservation.php
│   │   ├── Payment.php
│   │   ├── Announcement.php
│   │   └── SystemSetting.php
│   └── Providers/           # Service Providers
├── database/
│   ├── factories/           # Factory untuk testing
│   ├── migrations/          # Skema database
│   └── seeders/             # Data awal database
│       └── UserSeeder.php
├── resources/
│   ├── css/                 # Stylesheet Tailwind
│   ├── js/                  # JavaScript
│   └── views/               # Blade templates
├── routes/
│   ├── web.php              # Route web utama
│   └── settings.php         # Route pengaturan akun
├── tests/                   # Test suite (Pest)
├── .env.example             # Template konfigurasi environment
├── composer.json            # Dependensi PHP
├── package.json             # Dependensi Node.js
├── vite.config.js           # Konfigurasi Vite
└── phpunit.xml              # Konfigurasi testing
```

---

## 🗄 Struktur Database

### Relasi Antar Tabel

```
users
  ├──< reservations (user_id)
  ├──< reservations (verified_by)
  └──< payments (verified_by)

book_categories
  └──< books (category_id)

books
  └──< reservations (book_id)

reservations
  └──< payments (reservation_id)
```

### Deskripsi Tabel

| Tabel | Deskripsi |
|---|---|
| `users` | Data pengguna (admin & anggota) |
| `book_categories` | Kategori buku (fiksi, non-fiksi, dll.) |
| `books` | Koleksi buku perpustakaan |
| `reservations` | Data peminjaman/reservasi buku |
| `payments` | Bukti & status pembayaran denda |
| `announcements` | Pengumuman dari admin |
| `system_settings` | Konfigurasi sistem (denda per hari, dll.) |
| `roles`, `permissions` | Tabel RBAC dari Spatie Permission |

### Status Reservasi

| Status | Keterangan |
|---|---|
| `pending` | Menunggu persetujuan admin |
| `approved` | Disetujui admin |
| `rejected` | Ditolak admin |
| `waiting_payment` | Menunggu pembayaran dari anggota |
| `completed` | Selesai (buku sudah diterima anggota) |
| `returned` | Buku sudah dikembalikan |
| `cancelled` | Dibatalkan |

---

## 🔄 Alur Penggunaan

### Alur Peminjaman Buku

```
1. Anggota mendaftar akun baru
2. Admin memverifikasi & mengaktifkan akun anggota
3. Anggota login dan melakukan reservasi buku
4. Admin memverifikasi permintaan reservasi
5. (Jika ada denda) Anggota mengupload bukti pembayaran
6. Admin memverifikasi bukti pembayaran
7. Anggota mengambil buku (status: completed)
8. Admin mencatat pengembalian buku (status: returned)
```

### Routing Aplikasi

| URL | Role | Deskripsi |
|---|---|---|
| `/` | Publik | Halaman beranda |
| `/pengumuman` | Publik | Daftar pengumuman |
| `/peminjaman` | Anggota | Form reservasi buku |
| `/peminjaman/list` | Anggota | Riwayat peminjaman |
| `/profile` | Anggota | Profil pengguna |
| `/dashboard` | Admin | Dashboard statistik |
| `/admin/verifikasi-anggota` | Admin | Kelola pendaftaran anggota |
| `/admin/verifikasi-reservasi` | Admin | Proses reservasi buku |
| `/admin/verifikasi-pembayaran` | Admin | Konfirmasi pembayaran |
| `/admin/verifikasi-pengembalian` | Admin | Catat pengembalian |
| `/admin/buku` | Admin | Kelola katalog buku |
| `/admin/kelola-anggota` | Admin | Manajemen anggota |
| `/admin/pengumuman` | Admin | Kelola pengumuman |
| `/admin/konfigurasi` | Admin | Pengaturan sistem |

---

## 🧰 Perintah Artisan Berguna

```bash
# Menjalankan semua migrasi
php artisan migrate

# Reset dan jalankan ulang semua migrasi + seeder
php artisan migrate:fresh --seed

# Hanya menjalankan seeder
php artisan db:seed

# Membersihkan semua cache
php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear

# Melihat daftar route (tanpa vendor)
php artisan route:list --except-vendor

# Melihat konfigurasi database
php artisan config:show database

# Membuat komponen Livewire baru
php artisan make:livewire NamaKomponen

# Membuat model beserta migrasi, factory, seeder
php artisan make:model NamaModel -mfs

# Log viewer real-time
php artisan pail

# Static analysis
php artisan about
```

---

## 🧪 Testing

Proyek ini menggunakan **Pest** sebagai framework testing.

### Menjalankan Test

```bash
# Jalankan semua test
php artisan test --compact

# Jalankan test dengan filter nama
php artisan test --compact --filter=NamaTest

# Jalankan file test spesifik
php artisan test --compact tests/Feature/NamaTest.php
```

### CI Full Check (Lint + Static Analysis + Test)

```bash
composer run test
```

Perintah ini mencakup:
1. **Laravel Pint** — Cek format kode PHP
2. **Larastan / PHPStan** — Analisis statis tipe data
3. **Pest** — Jalankan seluruh test suite

### Code Formatting

```bash
# Format semua file PHP yang dimodifikasi
vendor/bin/pint --dirty

# Cek format tanpa mengubah file
vendor/bin/pint --test
```

---

## 📊 Variabel Environment Lengkap

| Variabel | Default | Deskripsi |
|---|---|---|
| `APP_NAME` | `Laravel` | Nama aplikasi |
| `APP_ENV` | `local` | Environment (`local`/`production`) |
| `APP_KEY` | *(kosong)* | Kunci enkripsi (di-generate otomatis) |
| `APP_DEBUG` | `true` | Mode debug |
| `APP_URL` | `http://localhost` | URL aplikasi |
| `DB_CONNECTION` | `sqlite` | Driver database |
| `DB_HOST` | `127.0.0.1` | Host database (MySQL) |
| `DB_PORT` | `3306` | Port database (MySQL) |
| `DB_DATABASE` | *(nama db)* | Nama database |
| `DB_USERNAME` | `root` | Username database |
| `DB_PASSWORD` | *(kosong)* | Password database |
| `SESSION_DRIVER` | `database` | Driver session |
| `QUEUE_CONNECTION` | `database` | Driver queue |
| `CACHE_STORE` | `database` | Driver cache |
| `MAIL_MAILER` | `log` | Driver email |

---

## 📜 Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

<div align="center">
  <p>Dibuat dengan ❤️ menggunakan <strong>Laravel</strong> + <strong>Livewire</strong></p>
  <p><strong>Sistem Reservasi Perpustakaan</strong> &copy; 2026</p>
</div>
