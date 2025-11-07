# 🎬 Dokumentasi Lengkap UNEMA Cinema

Selamat datang di dokumentasi resmi UNEMA Cinema, sebuah aplikasi pemesanan tiket bioskop modern yang dibangun menggunakan Laravel dan Livewire. Dokumen ini akan memandu Anda melalui setiap aspek proyek, mulai dari instalasi hingga detail teknis implementasi.

---

## 📜 Daftar Isi
1.  [Ringkasan Proyek](#-ringkasan-proyek)
2.  [Fitur Utama](#-fitur-utama)
3.  [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
4.  [Panduan Instalasi](#-panduan-instalasi)
5.  [Konfigurasi](#-konfigurasi)
6.  [Struktur Proyek](#-struktur-proyek)
7.  [Skema Database](#-skema-database)
8.  [Implementasi Livewire](#-implementasi-livewire)
9.  [Sorotan UI/UX](#-sorotan-uiux)
10. [Rute Aplikasi (Endpoints)](#-rute-aplikasi-endpoints)
11. [Pengujian](#-pengujian)
12. [Panduan Deployment](#-panduan-deployment)
13. [Troubleshooting](#-troubleshooting)
14. [Kontribusi & Lisensi](#-kontribusi--lisensi)

---

## 1.  Ringkasan Proyek

UNEMA Cinema adalah aplikasi web canggih yang dirancang untuk menyederhanakan proses pemesanan tiket bioskop. Aplikasi ini menawarkan antarmuka yang intuitif bagi pengguna untuk menelusuri film, melihat jadwal, memilih kursi, dan melakukan pembayaran dengan aman. Di sisi lain, admin memiliki dasbor yang kuat untuk mengelola seluruh aspek operasional bioskop secara digital.

![UNEMA Cinema](https://img.shields.io/badge/UNEMA-Cinema-blue?style=for-the-badge)
![Laravel](https://img.shields.io/badge/Laravel-11-red?style=for-the-badge)
![Livewire](https://img.shields.io/badge/Livewire-3-green?style=for-the-badge)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple?style=for-the-badge)

---

## 2. Fitur Utama

### 🎫 Untuk Pengguna
- **Autentikasi Aman**: Proses login dan registrasi yang aman dengan desain antarmuka bertema tiket bioskop.
- **Penjelajahan Film**: Mencari, memfilter (berdasarkan genre & status), dan mengurutkan film dengan pembaruan *real-time*.
- **Jadwal Tayang Interaktif**: Melihat jadwal tayang yang tersedia dengan filter berdasarkan tanggal dan film.
- **Pemesanan Tiket Mudah**: Proses pemilihan kursi yang interaktif dan alur checkout yang lancar.
- **Pembayaran Aman**: Terintegrasi dengan Midtrans sebagai *payment gateway* terpercaya.
- **Manajemen Tiket**: Melihat riwayat tiket dan melakukan pembatalan tiket yang telah dipesan.
- **Pengaturan Profil**: Mengelola informasi pribadi dan mengubah kata sandi dengan mudah.

### 👨‍💼 Untuk Admin
- **Dasbor Analitik**: Statistik lengkap mengenai film, jadwal, pemesanan, pengguna, dan total pendapatan.
- **Manajemen Film (CRUD)**: Kemampuan untuk menambah, mengedit, dan menghapus data film.
- **Manajemen Jadwal**: Mengelola jadwal tayang untuk setiap film dan studio.
- **Manajemen Pemesanan**: Memantau dan mengelola status semua pemesanan yang masuk.
- **Manajemen Pengguna**: Mengelola data pengguna yang terdaftar di sistem.

---

## 3. Teknologi yang Digunakan

| Kategori      | Teknologi                                           |
|---------------|-----------------------------------------------------|
| **Backend**   | Laravel 11, Livewire 3                              |
| **Frontend**  | Bootstrap 5.3, Vanilla JS, Bootstrap Icons          |
| **Database**  | MySQL                                               |
| **Pembayaran**| Midtrans Payment Gateway                            |
| **Styling**   | CSS3, Google Fonts (Poppins, Bebas Neue)            |

---

## 4. Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek secara lokal.

**Prasyarat:**
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM (opsional, untuk manajemen aset frontend)

**Langkah-langkah Instalasi:**

1.  **Clone Repository**
    ```bash
    git clone <url-repository-anda>
    cd unema-laravel
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment**
    Salin file `.env.example` menjadi `.env` dan generate kunci aplikasi.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan konfigurasi database Anda.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=unema
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Jalankan Migrasi & Seeding**
    Buat struktur tabel dan isi dengan data awal (opsional).
    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```

7.  **Akses Aplikasi**
    Buka browser dan kunjungi `http://localhost:8000`.

---

## 5. Konfigurasi

### Midtrans Payment Gateway
Dapatkan API keys dari dasbor Midtrans Anda dan tambahkan ke file `.env`.
```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

### Konfigurasi Email (Opsional)
Untuk fitur seperti notifikasi email, konfigurasikan kredensial SMTP Anda di `.env`.
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 6. Struktur Proyek

Struktur direktori utama yang perlu diperhatikan:

```
unema-laravel/
├── app/
│   ├── Http/Controllers/      # Logic untuk handle request HTTP
│   ├── Livewire/              # Komponen interaktif Livewire
│   ├── Models/                # Representasi tabel database (Eloquent)
│   └── Services/              # Logic bisnis (contoh: MidtransService)
├── resources/
│   ├── views/
│   │   ├── auth/              # Halaman Login & Register
│   │   ├── admin/             # Halaman khusus Admin
│   │   ├── livewire/          # Tampilan untuk komponen Livewire
│   │   └── ...                # Halaman lainnya (movies, tickets, dll)
│   ├── css/                   # File CSS
│   └── js/                    # File JavaScript
├── database/
│   ├── migrations/            # Skema struktur database
│   └── seeders/               # Data awal untuk database
├── public/
│   ├── css/auth.css           # Styling khusus halaman autentikasi
│   └── js/auth.js             # Script khusus halaman autentikasi
└── routes/
    └── web.php                # Definisi semua rute web
```

---

## 7. Skema Database

Aplikasi ini menggunakan 5 tabel utama:

1.  **users**: Menyimpan data pengguna dan admin.
    - `id`, `username`, `email`, `password`, `full_name`, `phone`, `is_admin`

2.  **movies**: Menyimpan semua informasi terkait film.
    - `id`, `title`, `description`, `poster_url`, `trailer_url`, `duration`, `rating`, `release_date`, `genre`, `status`

3.  **showtimes**: Menyimpan jadwal tayang untuk setiap film.
    - `id`, `movie_id`, `show_date`, `show_time`, `studio`, `price`, `available_seats`, `total_seats`

4.  **bookings**: Menyimpan data transaksi pemesanan tiket.
    - `id`, `user_id`, `showtime_id`, `seats`, `total_price`, `booking_code`, `status`

5.  **reviews**: Menyimpan ulasan dan rating dari pengguna untuk film.
    - `id`, `movie_id`, `user_id`, `rating`, `comment`

---

## 8. Implementasi Livewire

Livewire adalah teknologi kunci yang membuat antarmuka UNEMA Cinema terasa cepat dan dinamis tanpa perlu me-refresh halaman.

### Komponen Utama Livewire:

1.  **MoviesList (`movies-list`)**
    - **Fungsi**: Mengelola tampilan daftar film di halaman utama.
    - **Fitur**: Pencarian *real-time*, filter genre & status, serta pengurutan.

2.  **ShowtimesList (`showtimes-list`)**
    - **Fungsi**: Menampilkan daftar jadwal tayang yang tersedia.
    - **Fitur**: Filter berdasarkan film dan tanggal.

3.  **TicketsList (`tickets-list`)**
    - **Fungsi**: Menampilkan daftar tiket yang dimiliki pengguna.
    - **Fitur**: Pencarian *real-time*, filter status tiket, dan fungsi pembatalan tiket.

### Keuntungan Penggunaan Livewire:
- **Interaktivitas Tinggi**: Filter, pencarian, dan paginasi terasa instan.
- **UX yang Lebih Baik**: Pengguna mendapatkan umpan balik visual (loading states) saat data diproses.
- **Kode Terpusat**: Logika frontend dan backend berada dalam satu komponen yang sama, menyederhanakan pengembangan.

---

## 9. Sorotan UI/UX

### Halaman Login & Register
- **Desain Tiket Bioskop**: Antarmuka yang unik dan tematik.
- **Animasi Tirai**: Efek tirai terbuka saat halaman dimuat.
- **Efek Spotlight**: Animasi lampu sorot yang bergerak dinamis.
- **Video Latar**: Latar belakang video yang sinematik.

### Aplikasi Utama
- **Tema Gelap (Dark Mode)**: Tampilan modern yang nyaman di mata.
- **Navigasi Sidebar**: Akses mudah ke semua fitur utama.
- **Desain Responsif**: Tampilan optimal di berbagai perangkat (desktop, tablet, mobile).
- **Komponen Interaktif**: Penggunaan modal, notifikasi, dan *badge* yang informatif.

---

## 10. Rute Aplikasi (Endpoints)

### Rute Publik
- `GET /`: Halaman utama (Daftar Film)
- `GET /movies/{id}`: Halaman detail film
- `GET /showtimes`: Halaman daftar jadwal tayang
- `GET /login`: Halaman login
- `GET /register`: Halaman registrasi

### Rute Terproteksi (Memerlukan Login)
- `GET /settings`: Halaman pengaturan akun
- `PUT /settings`: Aksi untuk memperbarui profil
- `GET /select-seats/{showtimeId}`: Halaman pemilihan kursi
- `POST /checkout`: Aksi untuk memproses checkout
- `GET /tickets`: Halaman "Tiket Saya"
- `POST /tickets/cancel`: Aksi untuk membatalkan tiket

### Rute Admin (Memerlukan Login & Status Admin)
- `GET /admin`: Dasbor admin
- `GET /admin/movies`: Manajemen film
- `GET /admin/showtimes`: Manajemen jadwal
- `GET /admin/bookings`: Manajemen pemesanan
- `GET /admin/users`: Manajemen pengguna

---

## 11. Pengujian

### Akun untuk Pengujian
- **User Biasa**:
  - Email: `user@example.com`
  - Password: `password`
- **Admin**:
  - Email: `admin@example.com`
  - Password: `password`

### Pengujian Pembayaran (Midtrans Sandbox)
Gunakan detail kartu kredit uji berikut saat checkout:
- **Nomor Kartu**: `4811 1111 1111 1114`
- **Tanggal Kedaluwarsa**: `12/25`
- **CVV**: `123`

---

## 12. Panduan Deployment

Sebelum melakukan deployment ke server produksi, jalankan langkah-langkah berikut untuk optimasi:

1.  **Optimasi Konfigurasi**
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

2.  **Atur Environment Produksi**
    Pastikan variabel berikut diatur dengan benar di file `.env` server Anda.
    ```env
    APP_ENV=production
    APP_DEBUG=false
    MIDTRANS_IS_PRODUCTION=true
    ```

3.  **Jalankan Migrasi**
    ```bash
    php artisan migrate --force
    ```

4.  **Kompilasi Aset Frontend**
    ```bash
    npm run build
    ```

5.  **Atur Hak Akses Folder**
    Pastikan web server memiliki izin tulis ke direktori `storage` dan `bootstrap/cache`.
    ```bash
    chmod -R 775 storage bootstrap/cache
    ```

---

## 13. Troubleshooting

| Masalah                               | Solusi                                                              |
|---------------------------------------|---------------------------------------------------------------------|
| **Livewire tidak berfungsi**          | Jalankan `php artisan cache:clear` dan `php artisan config:clear`. Pastikan `@livewireStyles` dan `@livewireScripts` ada di layout utama. |
| **Error Database / "Class not found"**| Jalankan `composer dump-autoload` dan `php artisan migrate:fresh --seed`. |
| **Pembayaran gagal**                  | Verifikasi kembali kredensial Midtrans di `.env`. Pastikan mode sandbox/produksi sudah sesuai. |
| **Aset (CSS/JS) tidak termuat**       | Pastikan path aset benar dan jalankan `npm run build` jika perlu.      |

---

## 14. Kontribusi & Lisensi

### Kontribusi
Kontribusi untuk pengembangan proyek ini sangat diterima. Silakan buat *fork* dari repositori, buat *feature branch*, dan ajukan *Pull Request*.

### Lisensi
Proyek UNEMA Cinema dilisensikan di bawah **MIT License**. Ini berarti Anda bebas untuk menggunakan, memodifikasi, dan mendistribusikan kode ini untuk tujuan apa pun.

---

**Terima kasih telah menggunakan UNEMA Cinema! Selamat menonton! 🎬🍿**

*Versi: 1.0.0 | Terakhir Diperbarui: 2025*
