# UNEMA CINEMA - Dokumentasi Lengkap

## 📋 Daftar Isi

1. [Gambaran Umum](#gambaran-umum)
2. [Teknologi & Dependencies](#teknologi--dependencies)
3. [Struktur Folder](#struktur-folder)
4. [Database Schema](#database-schema)
5. [API Routes & Endpoints](#api-routes--endpoints)
6. [Controllers](#controllers)
7. [Models](#models)
8. [Views & UI](#views--ui)
9. [Services](#services)
10. [Workflow & User Flow](#workflow--user-flow)
11. [Setup & Instalasi](#setup--instalasi)
12. [Troubleshooting](#troubleshooting)

---

## 📱 Gambaran Umum

**UNEMA CINEMA** adalah web application untuk pemesanan tiket bioskop online dengan fitur:

-   ✅ Browse film dengan filter genre
-   ✅ Pilih jadwal tayang & kursi
-   ✅ Checkout dengan payment gateway Midtrans
-   ✅ Manajemen tiket & pembatalan
-   ✅ Admin dashboard untuk mengelola film, jadwal, user
-   ✅ Real-time seat availability tracking
-   ✅ Sistem authentikasi & autorisasi

**Stack Teknologi:** Laravel 12 + Livewire 3 + Bootstrap 5 + Midtrans Payment

---

## 🛠️ Teknologi & Dependencies

### Backend

| Paket             | Versi   | Fungsi                      |
| ----------------- | ------- | --------------------------- |
| Laravel Framework | ^12.0   | Web framework utama         |
| Livewire          | ^3.6    | Reactive UI components      |
| Midtrans          | \*      | Payment gateway integration |
| Guzzle HTTP       | ^7.10   | HTTP client                 |
| Laravel Tinker    | ^2.10.1 | REPL untuk debugging        |

### Frontend

| Library     | Fungsi                |
| ----------- | --------------------- |
| Bootstrap 5 | UI Framework          |
| SweetAlert2 | Modal & alert dialogs |
| Alpine.js   | Reactive components   |
| Vite        | Asset bundler         |

### Development

| Tool         | Fungsi              |
| ------------ | ------------------- |
| PHPUnit      | Unit testing        |
| Laravel Pint | Code style fixer    |
| Laravel Pail | Log viewer          |
| Faker        | Generate dummy data |

---

## 📁 Struktur Folder

```
unema-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Business logic handlers
│   │   │   ├── AdminController.php
│   │   │   ├── AdminMovieController.php
│   │   │   ├── AdminShowtimeController.php
│   │   │   ├── AdminUserController.php
│   │   │   ├── AdminBookingController.php
│   │   │   ├── AuthController.php
│   │   │   ├── BookingController.php
│   │   │   ├── MovieController.php
│   │   │   ├── ShowtimeController.php
│   │   │   ├── TicketController.php
│   │   │   ├── SettingsController.php
│   │   │   └── Controller.php      # Base controller
│   │   └── Middleware/            # Route protection
│   ├── Models/                    # Database models
│   │   ├── User.php
│   │   ├── Movie.php
│   │   ├── Showtime.php
│   │   ├── Booking.php
│   │   └── Review.php
│   ├── Livewire/                  # Reactive components
│   │   ├── TicketsList.php
│   │   └── MovieSearch.php
│   └── Services/                  # Business logic layer
│       └── MidtransService.php
├── config/
│   ├── app.php                    # App configuration
│   ├── database.php               # Database settings
│   └── services.php               # Service config (Midtrans)
├── database/
│   ├── migrations/                # Schema definitions
│   ├── factories/                 # Fake data generators
│   └── seeders/                   # Initial data
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php     # Main layout
│   │   │   └── guest.blade.php   # Guest layout
│   │   ├── auth/                  # Login & register pages
│   │   ├── movies/                # Movie listing & detail
│   │   ├── bookings/              # Booking workflow
│   │   ├── tickets/               # Ticket management
│   │   ├── admin/                 # Admin dashboard
│   │   └── components/            # Reusable components
│   ├── js/                        # JavaScript assets
│   ├── css/                       # Stylesheets
│   └── images/                    # Image assets
├── routes/
│   ├── web.php                    # Web routes
│   └── console.php                # Console commands
├── storage/
│   └── app/
│       └── public/                # File uploads
├── public/
│   ├── css/                       # Compiled CSS
│   ├── js/                        # Compiled JS
│   └── images/                    # Public images
├── tests/                         # Unit & feature tests
├── .env                           # Environment config
├── .env.example                   # Example env file
├── composer.json                  # PHP dependencies
├── package.json                   # Node dependencies
└── artisan                        # CLI tool
```

---

## 🗄️ Database Schema

### Users Table

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('user', 'admin') DEFAULT 'user',
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Movies Table

```sql
CREATE TABLE movies (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description LONGTEXT,
    poster_url VARCHAR(255),
    trailer_url VARCHAR(255),
    duration INT (minutes),
    rating DECIMAL(2, 1) (e.g., 8.5),
    release_date DATE,
    genre VARCHAR(100),
    status ENUM('showing', 'coming_soon', 'ended') DEFAULT 'showing',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Showtimes Table

```sql
CREATE TABLE showtimes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    movie_id BIGINT FOREIGN KEY,
    studio VARCHAR(50),
    show_date DATE,
    show_time TIME,
    price DECIMAL(10, 2),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Bookings Table

```sql
CREATE TABLE bookings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT FOREIGN KEY,
    showtime_id BIGINT FOREIGN KEY,
    seats VARCHAR(255) (comma-separated, e.g., "A1,A2,B3"),
    total_price DECIMAL(10, 2),
    booking_code VARCHAR(50) UNIQUE,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Reviews Table

```sql
CREATE TABLE reviews (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT FOREIGN KEY,
    movie_id BIGINT FOREIGN KEY,
    rating INT (1-5),
    comment TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Relationships:**

```
User ──1:N── Booking
User ──1:N── Review
Movie ──1:N── Showtime
Movie ──1:N── Review
Showtime ──1:N── Booking
```

---

## 🔌 API Routes & Endpoints

### Public Routes

#### Movies

```
GET /                              → Show semua film dengan filter
GET /movies/{id}                   → Detail film + reviews
GET /showtimes                     → List jadwal tayang
GET /showtimes/{movieId}           → Jadwal untuk film tertentu (AJAX)
```

### Authentication Routes

```
GET /login                         → Show login form
POST /login                        → Process login
GET /register                      → Show register form
POST /register                     → Process register
POST /logout                       → Logout user
```

### Protected Routes (Auth Required)

#### Booking Workflow

```
GET /select-seats/{showtimeId}     → Halaman pilih kursi
POST /checkout                     → Create booking & show checkout page
POST /process-payment              → Generate Midtrans snap token
POST /booking/confirm-payment      → Client-side payment confirmation
GET /booking-success?booking_id=X  → Show payment result
GET /booking/{bookingId}/status    → Check booking status (JSON)
```

#### Tickets & Bookings

```
GET /tickets                       → List tiket user (dengan status filter)
POST /tickets/cancel               → Cancel tiket user
```

#### Settings

```
GET /settings                      → User profile & preferences
PUT /settings                      → Update profile
```

### Admin Routes (Auth + Admin Role Required)

#### Dashboard

```
GET /admin                         → Admin dashboard dengan statistik
```

#### Movie Management

```
POST /admin/movies                 → Create film (Livewire modal)
PUT /admin/movies/{movie}          → Update film
DELETE /admin/movies/{movie}       → Delete film
```

#### Showtime Management

```
POST /admin/showtimes              → Create jadwal
PUT /admin/showtimes/{showtime}    → Update jadwal
DELETE /admin/showtimes/{showtime} → Delete jadwal
```

#### User Management

```
POST /admin/users                  → Create user
PUT /admin/users/{user}            → Update user
DELETE /admin/users/{user}         → Delete user
```

#### Booking Management

```
GET /admin/bookings/{booking}      → Detail booking
POST /admin/bookings/{booking}/approve  → Approve booking
POST /admin/bookings/{booking}/cancel   → Cancel booking
DELETE /admin/bookings/{booking}   → Delete booking
```

### Public Webhooks

```
POST /payment-callback             → Midtrans webhook (IPN)
```

---

## 🎮 Controllers

### AuthController

**Fungsi:** Handle authentication

-   `showLogin()` - Tampil form login
-   `login(Request)` - Process login dengan validasi
-   `showRegister()` - Tampil form register
-   `register(Request)` - Create user baru
-   `logout(Request)` - Logout & redirect

**Middleware:** Tanpa auth (public)

---

### MovieController

**Fungsi:** Display film untuk user

-   `index(Request)` - List film dengan filter genre & search
-   `show($id)` - Detail film + reviews + jadwal tayang

**Key Features:**

-   Filter berdasarkan genre dari request
-   Pagination untuk performa
-   Include relationships (reviews, showtimes)

**Middleware:** Tanpa auth (public)

---

### ShowtimeController

**Fungsi:** Manage jadwal tayang

-   `index(Request)` - List jadwal dengan filter
-   `getShowtimes($movieId)` - AJAX endpoint untuk jadwal film tertentu

**Key Features:**

-   Filter berdasarkan tanggal, film, studio
-   Return JSON untuk AJAX
-   Include movie data

**Middleware:** Tanpa auth (public)

---

### BookingController

**Fungsi:** Handle booking workflow & payment

**Methods:**

1. `selectSeats($showtimeId)`

    - Load halaman pilih kursi
    - Pass booked seats array ke view
    - **Bug:** No validation; race condition possible

2. `checkout(Request)`

    - Validasi input (showtime_id, seats)
    - Check kursi tersedia
    - Create booking dengan status 'pending'
    - **Bug:** Race condition between check & create (2 users bisa book kursi sama)

3. `processPayment(Request)`

    - Generate Midtrans snap token
    - Return JSON untuk Snap pop-up

4. `paymentCallback(Request)`

    - Webhook dari Midtrans
    - Verify signature
    - Update booking status ke 'confirmed' jika payment success
    - **Enhancement:** Added logging untuk debug

5. `success(Request)`

    - Show halaman status pembayaran
    - Polling untuk check status real-time
    - **Enhancement:** 3-second delay + 60 attempts (2 minute timeout)

6. `checkStatus($bookingId)`

    - Endpoint untuk polling status
    - Return JSON: `{ status: 'pending|confirmed|cancelled' }`

7. `confirmPayment(Request)`
    - Client-side fallback jika callback lambat
    - Update booking status ke 'confirmed' manual
    - Verify user ownership

**Middleware:** Auth required

---

### TicketController

**Fungsi:** Manage tiket user

**Methods:**

1. `index()`

    - List tiket user dengan Livewire component
    - Filter berdasarkan status

2. `cancel(Request)`
    - Cancel tiket user
    - Verify ownership
    - Update status ke 'cancelled'

**Middleware:** Auth required

---

### AdminController

**Fungsi:** Admin dashboard

**Methods:**

1. `dashboard(Request)`
    - Show statistik: total booking, pending, confirmed, cancelled
    - List recent bookings
    - Monthly revenue chart
    - Livewire modals untuk CRUD

**Middleware:** Auth + admin role

---

### AdminMovieController

**Fungsi:** CRUD film

**Methods:**

1. `store(Request)` - Create film dengan upload poster
2. `update(Request, Movie)` - Update film
3. `destroy(Movie)` - Delete film

**Validasi:**

-   Title, description required
-   Poster upload (image validation)
-   Duration harus integer
-   Rating 1-10

**Middleware:** Auth + admin role

---

### AdminShowtimeController

**Fungsi:** CRUD jadwal tayang

**Methods:**

1. `store(Request)` - Create showtime
2. `update(Request, Showtime)` - Update showtime
3. `destroy(Showtime)` - Delete showtime

**Validasi:**

-   Movie harus exist
-   Show date & time required
-   Price harus numeric > 0

**Middleware:** Auth + admin role

---

### AdminUserController

**Fungsi:** CRUD user

**Methods:**

1. `store(Request)` - Create user
2. `update(Request, User)` - Update user
3. `destroy(User)` - Delete user

**Validasi:**

-   Email unique
-   Password min 8 char (if provided)
-   Role harus 'user' atau 'admin'

**Middleware:** Auth + admin role

---

### AdminBookingController

**Fungsi:** Manage booking

**Methods:**

1. `show(Booking)` - Detail booking
2. `approve(Booking)` - Approve pending booking
3. `cancel(Booking)` - Cancel booking
4. `destroy(Booking)` - Delete booking

**Middleware:** Auth + admin role

---

### SettingsController

**Fungsi:** User profile settings

**Methods:**

1. `index()` - Show settings page
2. `update(Request)` - Update user data

**Middleware:** Auth required

---

## 💾 Models

### User Model

```php
protected $fillable = ['name', 'email', 'password', 'phone', 'role'];

// Relationships
hasMany('Booking')
hasMany('Review')

// Methods
isAdmin() → Check role = 'admin'
```

### Movie Model

```php
protected $fillable = ['title', 'description', 'poster_url', 'trailer_url',
                       'duration', 'rating', 'release_date', 'genre', 'status'];

// Relationships
hasMany('Showtime')
hasMany('Review')
```

### Showtime Model

```php
protected $fillable = ['movie_id', 'studio', 'show_date', 'show_time', 'price'];
protected $dates = ['show_date'];

// Relationships
belongsTo('Movie')
hasMany('Booking')
```

### Booking Model

```php
protected $fillable = ['user_id', 'showtime_id', 'seats', 'total_price',
                       'booking_code', 'status'];

// Relationships
belongsTo('User')
belongsTo('Showtime')

// Methods
getSeatsArray() → explode(',', $this->seats) → ['A1', 'A2', ...]
```

### Review Model

```php
protected $fillable = ['user_id', 'movie_id', 'rating', 'comment'];

// Relationships
belongsTo('User')
belongsTo('Movie')
```

---

## 🎨 Views & UI

### Layouts

-   `layouts/app.blade.php` - Main layout dengan navbar & footer
-   `layouts/guest.blade.php` - Guest layout (login/register)

### Pages

#### Public Pages

-   `movies/index.blade.php` - List semua film dengan filter & search
-   `movies/show.blade.php` - Detail film + trailer + reviews
-   `showtimes/index.blade.php` - List jadwal tayang dengan filter

#### Auth Pages

-   `auth/login.blade.php` - Login form
-   `auth/register.blade.php` - Register form

#### Booking Workflow

-   `bookings/select-seats.blade.php`

    -   Grid seat 8x10 (rows A-H, cols 1-10)
    -   Show booked seats (disabled)
    -   Calculate total price
    -   Submit form ke checkout
    -   **Bug:** No AJAX validation, seats bisa berubah saat user select

-   `bookings/checkout.blade.php`

    -   Show booking detail (film, kursi, tanggal, harga)
    -   Midtrans payment button
    -   Payment success/pending/error handling

-   `bookings/success.blade.php`
    -   Show payment result (success/pending/error)
    -   Polling untuk check status real-time (3s delay, 60 attempts)
    -   Show booking code & ticket detail jika confirmed

#### Ticket Pages

-   `tickets/index.blade.php`
    -   List tiket user dengan status badge
    -   Livewire component untuk filter & cancel
    -   Show booking code & kursi

#### Admin Pages

-   `admin/dashboard.blade.php`

    -   Statistik: total booking, revenue, trends
    -   Recent bookings table
    -   Livewire modals untuk CRUD film/jadwal/user
    -   Charts & graphs

-   `admin/movies/index.blade.php` - Modal untuk CRUD film
-   `admin/showtimes/index.blade.php` - Modal untuk CRUD jadwal
-   `admin/users/index.blade.php` - Modal untuk CRUD user

#### Settings

-   `settings/index.blade.php` - User profile & preferences form

### Components

-   `components/navbar.blade.php` - Navigation bar
-   `components/footer.blade.php` - Footer
-   `components/seat-grid.blade.php` - Reusable seat grid
-   `components/movie-card.blade.php` - Movie card untuk list

### Livewire Components

-   `Livewire/TicketsList.php`
    -   List tiket dengan status filter
    -   Search by movie
    -   Cancel tiket functionality
    -   Real-time updates

---

## ⚙️ Services

### MidtransService

**Fungsi:** Integration dengan Midtrans payment gateway

**Methods:**

```php
createTransaction(Booking $booking)
    → Generate snap token untuk payment pop-up

handleNotification(array $notification)
    → Process webhook dari Midtrans
    → Verify signature
    → Update booking status

verifySignature(string $orderId, string $statusCode, int $grossAmount, string $serverKey)
    → Verify webhook authenticity
```

**Config:**

-   Server Key & Client Key dari `.env` (Midtrans sandbox)
-   Transaction items: movie title, seat, price
-   Customer data: user name, email, phone

**Status Flow:**

```
settlement/capture → booking.status = 'confirmed'
pending → booking.status = 'pending'
deny/cancel/expire → booking.status = 'cancelled'
```

---

## 🔄 Workflow & User Flow

### 1️⃣ User Registration & Login

```
Register Form → Validate email/password → Create User → Redirect to Login
        ↓
Login Form → Verify credentials → Create session → Redirect to Home
```

### 2️⃣ Browse & Select Film

```
Home (Movie List) → Filter by Genre → Click Film
        ↓
Detail Page (Reviews + Showtimes) → Select Showtime
        ↓
Redirect to Select Seats
```

### 3️⃣ Booking Workflow ⚠️ (Has Issues)

```
Select Seats Page
├── Load booked seats dari DB
├── User select kursi (click checkbox)
├── Calculate total price
└── Click "Lanjut ke Pembayaran"
        ↓
Checkout Page (Race Condition Risk! ⚠️)
├── Check if seats still available
├── Create Booking dengan status 'pending'
├── Show checkout confirmation
└── Click "Lanjut ke Pembayaran"
        ↓
Midtrans Payment Modal
├── User select payment method
├── Complete payment
└── Midtrans callback ke server
        ↓
Payment Callback (Webhook)
├── Verify signature
├── Update booking.status = 'confirmed'
└── Log transaction
        ↓
Success Page
├── Show 3-second delay (wait untuk callback)
├── Polling status setiap 2 second (60 attempts = 2 min)
├── Display status: pending/confirmed/error
└── Show booking code & ticket
```

**Issues Found:**

1. ⚠️ **Race Condition**: 2 users bisa select & book kursi yang sama

    - User A check kursi A10 tersedia ✓
    - User B check kursi A10 tersedia ✓
    - User A create booking kursi A10 ✓
    - User B create booking kursi A10 ✓ ← OVERBOOKING!

2. ⚠️ **Stale Seat Data**: Kursi yang ditampilkan bisa berubah saat user select

    - Halaman load → tampil kursi A5 tersedia
    - User lain booking kursi A5
    - User masih lihat A5 tersedia
    - User select A5 & checkout → Error: Kursi sudah dipesan

3. ⚠️ **No Pre-Flight Validation**: Form submit tanpa check kursi terlebih dahulu
    - User tunggu server response sebelum tahu ada error
    - Bad UX

### 4️⃣ View Tickets & Cancel

```
Tickets Page
├── List all user bookings dengan status badge
├── Filter by status (confirmed/pending/cancelled)
└── Click "Cancel" untuk batalkan tiket
        ↓
Cancel Request
├── Verify user ownership
├── Update status → 'cancelled'
└── Redirect with success message
```

### 5️⃣ Admin Management

```
Admin Dashboard
├── View statistics (total booking, revenue, trends)
├── Livewire modal CRUD untuk:
│   ├── Film (create/edit/delete)
│   ├── Jadwal (create/edit/delete)
│   └── User (create/edit/delete)
├── Manage bookings (approve/cancel/delete)
└── View detailed reports
```

---

## 🚀 Setup & Instalasi

### Prerequisites

-   PHP 8.2+
-   Composer
-   Node.js & NPM
-   MySQL/MariaDB
-   Laragon atau XAMPP

### Step 1: Clone & Install Dependencies

```bash
cd c:\laragon\www
git clone <repo-url> unema-laravel
cd unema-laravel

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Step 2: Setup Environment

```bash
# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Setup database credentials di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unema_cinema
DB_USERNAME=root
DB_PASSWORD=

# Setup Midtrans keys (sandbox)
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxx
MIDTRANS_IS_PRODUCTION=false
```

### Step 3: Database Setup

```bash
# Create database
mysql -u root -e "CREATE DATABASE unema_cinema CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations
php artisan migrate

# Seed dummy data (optional)
php artisan db:seed
```

### Step 4: Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### Step 5: Run Development Server

```bash
# Terminal 1: PHP server
php artisan serve

# Terminal 2: Asset watcher (optional)
npm run dev

# Terminal 3: Queue listener (optional)
php artisan queue:listen

# Terminal 4: Log viewer (optional)
php artisan pail
```

**Access:** `http://localhost:8000`

### Test Account

```
Email: admin@unema.test
Password: password123
Role: admin

Email: user@unema.test
Password: password123
Role: user
```

---

## 🐛 Troubleshooting

### Issue: "SQLSTATE[HY000] [1045] Access denied for user"

**Solution:**

```bash
# Verify MySQL credentials di .env
# Make sure MySQL service running
# Test connection
php artisan tinker
>>> DB::connection()->getPdo()
```

### Issue: "Class not found: App\Models\User"

**Solution:**

```bash
# Regenerate class loader
composer dump-autoload

# Or clear cache
php artisan cache:clear
php artisan config:clear
```

### Issue: "File permissions denied" (storage folder)

**Solution:**

```bash
# Fix folder permissions
chmod -R 775 storage bootstrap/cache
```

### Issue: Assets (CSS/JS) tidak load

**Solution:**

```bash
# Rebuild assets
npm run build

# Or development watcher
npm run dev

# Make sure Vite configured correct
```

### Issue: Payment callback tidak diterima Midtrans

**Solution:**

```bash
# Verify server key di .env correct
# Check route /payment-callback accessible (public, no auth)
# Test webhook di Midtrans dashboard
# Check logs: storage/logs/laravel.log
```

### Issue: Booking stuck di "pending" setelah payment success

**Solution (Implemented):**

```
✓ 3-second delay sebelum polling (wait untuk callback)
✓ Polling 60 kali setiap 2 second (2 min timeout)
✓ Client-side confirmPayment() fallback
✓ Enhanced logging di paymentCallback()

Jika masih pending:
1. Check payment_callback route accessible
2. Verify Midtrans webhook settings
3. Check server logs untuk error
4. Manually confirm payment via admin panel
```

### Issue: "Two users book same seat" (Race Condition)

**Current Status:** ⚠️ UNRESOLVED

**Recommended Fix:**

```php
// Use database transaction dengan lock
DB::transaction(function () {
    $showtime = Showtime::lockForUpdate()->findOrFail($showtimeId);

    // Check & create dalam 1 transaction
    $booked = Booking::where('showtime_id', $showtimeId)
        ->whereIn('status', ['pending', 'confirmed'])
        ->pluck('seats')
        ->toArray();

    // If available, create immediately
    Booking::create([...]);
}, attempts: 3);
```

**See:** LOGICAL_ERRORS_FOUND.md untuk detail issues

---

## 📞 Support & Maintenance

### Monitoring

-   Check logs: `storage/logs/laravel.log`
-   Monitor payments: Midtrans Dashboard
-   Database: phpMyAdmin atau MySQL GUI

### Regular Maintenance

```bash
# Clear cache setiap deploy
php artisan cache:clear
php artisan config:clear

# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Monitor queue jobs
php artisan queue:work

# Backup database
mysqldump -u root unema_cinema > backup.sql
```

### Useful Commands

```bash
# Generate new migration
php artisan make:migration create_xxx_table

# Create new controller
php artisan make:controller XxxController --model=Xxx

# Create new model
php artisan make:model Xxx -m

# Database reset (development only!)
php artisan migrate:fresh --seed

# Test
php artisan test

# Clear all
php artisan tinker
>>> Artisan::call('cache:clear');
```

---

## 📝 License

MIT License - UNEMA CINEMA 2024

**Last Updated:** December 8, 2025
**Documented By:** GitHub Copilot
**Status:** ⚠️ 3 Logical Errors Found (See: LOGICAL_ERRORS_FOUND.md)
