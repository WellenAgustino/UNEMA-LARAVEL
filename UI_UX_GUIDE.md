# 📱 UI/UX GUIDE - UNEMA CINEMA

> Panduan lengkap tentang desain, komponen, dan prinsip UI/UX yang digunakan dalam aplikasi UNEMA CINEMA

---

## 📑 Daftar Isi

1. [Design System](#design-system)
2. [Palet Warna](#palet-warna)
3. [Tipografi](#tipografi)
4. [Komponen UI](#komponen-ui)
5. [Layout & Grid](#layout--grid)
6. [Responsiveness](#responsiveness)
7. [Animasi & Transisi](#animasi--transisi)
8. [Aksesibilitas](#aksesibilitas)
9. [User Flows](#user-flows)
10. [Best Practices](#best-practices)

---

## 🎨 Design System

### Filosofi Desain

UNEMA CINEMA menggunakan **Design System yang Modern dan Minimal** dengan fokus pada:

-   **Clarity**: Antarmuka yang jelas dan mudah dipahami
-   **Efficiency**: User dapat menyelesaikan tugas dengan cepat
-   **Accessibility**: Desain yang inklusif untuk semua pengguna
-   **Consistency**: Pengalaman yang konsisten di semua halaman
-   **Delight**: Elemen micro-interactions yang menyenangkan

### Tech Stack & Framework

```
Frontend Framework: Bootstrap 5 + Laravel Blade
Reactive Components: Livewire 3
Font Family: Poppins (400, 500, 700), Instrument Sans
Icons: Bootstrap Icons (v1.11.1)
CSS Utilities: Bootstrap Grid System
```

---

## 🎯 Palet Warna

### Primary Colors

| Nama                 | Hex       | Penggunaan             | Dark Mode |
| -------------------- | --------- | ---------------------- | --------- |
| **Primary Red**      | `#F53003` | CTA, Links, Highlights | `#FF4433` |
| **Dark Neutral**     | `#1b1b18` | Text utama, Headings   | `#EDEDEC` |
| **Light Background** | `#FDFDFC` | Background utama       | `#0a0a0a` |
| **White**            | `#FFFFFF` | Card backgrounds       | `#161615` |

### Secondary Colors

| Nama            | Hex       | Penggunaan                   |
| --------------- | --------- | ---------------------------- |
| **Gray Text**   | `#706f6c` | Secondary text, Descriptions |
| **Light Gray**  | `#e3e3e0` | Borders, Dividers            |
| **Medium Gray** | `#dbdbd7` | Disabled states              |
| **Dark Gray**   | `#3E3E3A` | Dark mode borders            |

### Status Colors

| Status      | Light     | Dark      | Penggunaan                      |
| ----------- | --------- | --------- | ------------------------------- |
| **Success** | `#10B981` | `#34D399` | Confirmations, Success messages |
| **Warning** | `#F59E0B` | `#FBBF24` | Warnings, Alerts                |
| **Error**   | `#EF4444` | `#F87171` | Errors, Validation              |
| **Info**    | `#3B82F6` | `#60A5FA` | Information messages            |

### Gradients

```css
/* Primary Gradient */
linear-gradient(135deg, #F53003 0%, #FF6B35 100%)

/* Dark Mode Gradient */
linear-gradient(135deg, #FF4433 0%, #FF6B35 100%)
```

---

## ✍️ Tipografi

### Font Family

```css
/* Sans Serif - Primary */
font-family: "Poppins", sans-serif;

/* Alt Sans Serif - Secondary */
font-family: "Instrument Sans", sans-serif;

/* Monospace - Code */
font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas;
```

### Font Weights & Sizes

| Element                   | Size     | Weight | Letter Spacing | Line Height |
| ------------------------- | -------- | ------ | -------------- | ----------- |
| **H1 - Heading Utama**    | 2.25rem  | 700    | -0.025em       | 1.2         |
| **H2 - Heading Sekunder** | 1.875rem | 700    | -0.025em       | 1.2         |
| **H3 - Sub Heading**      | 1.5rem   | 600    | 0              | 1.5         |
| **Body Text**             | 1rem     | 400    | 0              | 1.5         |
| **Body Text Medium**      | 1rem     | 500    | 0              | 1.5         |
| **Small Text**            | 0.875rem | 400    | 0              | 1.5         |
| **Caption**               | 0.75rem  | 500    | 0              | 1.2         |

### Hierarchy Examples

```html
<!-- Heading Utama -->
<h1 class="fw-bold" style="font-size: 2.25rem;">Pemesanan Tiket</h1>

<!-- Sub Heading -->
<h2 class="fw-bold" style="font-size: 1.875rem;">Pilih Film</h2>

<!-- Body Text -->
<p class="fw-normal" style="font-size: 1rem;">
    Pilih film favorit Anda dari daftar di bawah
</p>

<!-- Small Caption -->
<span class="fw-medium" style="font-size: 0.875rem;"
    >Tersedia di 5 bioskop</span
>
```

---

## 🧩 Komponen UI

### 1. Buttons

#### Button Primary (CTA)

```html
<!-- Light Mode -->
<button class="btn btn-danger">Pesan Sekarang</button>

<!-- Dark Mode -->
<button class="btn btn-outline-light">Pesan Sekarang</button>

<!-- Disabled State -->
<button class="btn btn-danger" disabled>Tidak Tersedia</button>
```

**Spesifikasi:**

-   Background: Primary Red (`#F53003`)
-   Text Color: White
-   Padding: 12px 24px
-   Border Radius: 6px
-   Font Weight: 500
-   Hover: Brightness -10%
-   Focus: Outline offset 2px

#### Button Secondary

```html
<button class="btn btn-outline-dark">Kembali</button>
```

**Spesifikasi:**

-   Border: 1px solid `#1b1b18`
-   Text Color: `#1b1b18`
-   Transparent background
-   Hover: Background `#f5f5f3`

#### Button Tertiary (Ghost)

```html
<button class="btn btn-link">Lanjut</button>
```

**Spesifikasi:**

-   No border, no background
-   Text color: Primary Red
-   Underline on hover

### 2. Cards

#### Movie Card

```html
<div class="card border-0 shadow-sm h-100">
    <img
        src="poster.jpg"
        class="card-img-top"
        alt="Movie Title"
        style="aspect-ratio: 335/376;"
    />
    <div class="card-body">
        <h5 class="card-title fw-bold">Judul Film</h5>
        <p class="card-text text-muted small">Genre • Rating</p>
        <button class="btn btn-danger btn-sm w-100">Pesan Sekarang</button>
    </div>
</div>
```

**Spesifikasi:**

-   Background: White / `#161615` (dark)
-   Border: 1px solid `#e3e3e0` / `#3E3E3A`
-   Shadow: Subtle shadow (0px 1px 3px rgba(0,0,0,0.1))
-   Border Radius: 8px
-   Poster Aspect Ratio: 335:376

#### Showtime Card

```html
<div class="card p-3 border-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="badge bg-warning text-dark">15:30</span>
        <span class="text-muted small">Regular</span>
    </div>
    <p class="fw-bold mb-2">Rp 75.000</p>
    <button class="btn btn-danger btn-sm w-100">Pilih</button>
</div>
```

#### Status Card

```html
<div class="card border-start-5 border-danger">
    <div class="card-body">
        <h6 class="card-title fw-bold">Status Pesanan</h6>
        <p class="card-text text-success">Pembayaran Berhasil</p>
    </div>
</div>
```

### 3. Forms & Inputs

#### Text Input

```html
<div class="mb-3">
    <label for="email" class="form-label fw-500">Email</label>
    <input
        type="email"
        class="form-control"
        id="email"
        placeholder="user@example.com"
    />
</div>
```

**Spesifikasi:**

-   Height: 40px
-   Padding: 8px 12px
-   Border: 1px solid `#e3e3e0`
-   Border Radius: 6px
-   Focus: Border color Primary Red, shadow

#### Select Dropdown

```html
<div class="mb-3">
    <label for="genre" class="form-label fw-500">Genre</label>
    <select class="form-select" id="genre">
        <option selected>Semua Genre</option>
        <option>Action</option>
        <option>Drama</option>
    </select>
</div>
```

#### Checkbox & Radio

```html
<!-- Checkbox -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" id="agree" />
    <label class="form-check-label" for="agree">
        Saya setuju dengan syarat dan ketentuan
    </label>
</div>

<!-- Radio -->
<div class="form-check">
    <input class="form-check-input" type="radio" name="type" id="regular" />
    <label class="form-check-label" for="regular"> Kursi Regular </label>
</div>
```

### 4. Seat Selection

```html
<div class="seat-container">
    <button class="seat available" data-seat="A1">
        <span>A1</span>
    </button>
    <button class="seat selected" data-seat="A2">
        <span>A2</span>
    </button>
    <button class="seat occupied" data-seat="A3" disabled>
        <span>A3</span>
    </button>
</div>
```

**Seat States:**

-   **Available**: Background light gray, cursor pointer
-   **Selected**: Background Primary Red, text white
-   **Occupied**: Background darker gray, opacity 0.5, disabled
-   **Hovered**: Brightness increase

**CSS:**

```css
.seat {
    width: 40px;
    height: 40px;
    border-radius: 4px;
    border: 2px solid #e3e3e0;
    background: #f5f5f3;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.75rem;
    font-weight: 500;
    color: #1b1b18;
}

.seat.available:hover {
    background: #efefea;
    border-color: #f53003;
}

.seat.selected {
    background: #f53003;
    color: white;
    border-color: #f53003;
}

.seat.occupied {
    background: #dbdbd7;
    opacity: 0.5;
    cursor: not-allowed;
    border-color: #e3e3e0;
}
```

### 5. Alerts & Notifications

```html
<!-- Success -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    <strong>Berhasil!</strong> Pesanan Anda telah dikonfirmasi.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<!-- Error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <strong>Error!</strong> Email tidak valid.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<!-- Warning -->
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="bi bi-info-circle me-2"></i>
    <strong>Perhatian!</strong> Kursi tersisa hanya 3.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<!-- Info -->
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <i class="bi bi-info-circle me-2"></i>
    <strong>Info:</strong> Jadwal mulai diunggah setiap Senin.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
```

### 6. Modals

```html
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Konfirmasi Pesanan</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin melanjutkan pembayaran?</p>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <button class="btn btn-danger">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
```

### 7. Badges

```html
<!-- Primary Badge -->
<span class="badge bg-danger">Action</span>

<!-- Success Badge -->
<span class="badge bg-success">Tersedia</span>

<!-- Warning Badge -->
<span class="badge bg-warning text-dark">Terbatas</span>

<!-- Info Badge -->
<span class="badge bg-info">2D</span>
```

### 8. Breadcrumb

```html
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/movies">Film</a></li>
        <li class="breadcrumb-item active">Avengers: Endgame</li>
    </ol>
</nav>
```

### 9. Pagination

```html
<nav aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Sebelumnya</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item active"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
    </ul>
</nav>
```

### 10. Navbar & Sidebar

#### Navigation Bar

```html
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">UNEMA</a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/movies">Film</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/tickets">Tiket</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
```

#### Sidebar Navigation

```html
<aside class="sidebar">
    <nav class="nav flex-column">
        <a class="nav-link active" href="/movies">
            <i class="bi bi-film"></i>
            <span>Film</span>
        </a>
        <a class="nav-link" href="/showtimes">
            <i class="bi bi-clock"></i>
            <span>Jadwal</span>
        </a>
        <a class="nav-link" href="/tickets">
            <i class="bi bi-ticket-perforated"></i>
            <span>Tiket</span>
        </a>
    </nav>
</aside>
```

---

## 📐 Layout & Grid

### Grid System

UNEMA CINEMA menggunakan **Bootstrap 12-column grid system** dengan breakpoints:

| Breakpoint      | Ukuran   | Penggunaan           |
| --------------- | -------- | -------------------- |
| **xs** (Mobile) | < 576px  | Smartphone portrait  |
| **sm**          | ≥ 576px  | Smartphone landscape |
| **md**          | ≥ 768px  | Tablet               |
| **lg**          | ≥ 992px  | Desktop kecil        |
| **xl**          | ≥ 1200px | Desktop besar        |
| **xxl**         | ≥ 1400px | Desktop sangat besar |

### Container Sizes

```css
/* Max widths untuk containers */
.container-xs {
    max-width: 20rem;
} /* 320px */
.container-sm {
    max-width: 24rem;
} /* 384px */
.container-md {
    max-width: 28rem;
} /* 448px */
.container-lg {
    max-width: 32rem;
} /* 512px */
.container-xl {
    max-width: 36rem;
} /* 576px */
.container-2xl {
    max-width: 42rem;
} /* 672px */
```

### Spacing (Margin & Padding)

```
0: 0px
1: 4px
2: 8px
3: 12px
4: 16px
5: 20px
6: 24px
7: 28px
8: 32px
```

Contoh:

```html
<div class="p-4 mt-3 mb-5">Spacing example</div>
<!-- padding: 16px, margin-top: 12px, margin-bottom: 20px -->
```

### Common Layouts

#### Hero Section

```html
<section class="hero py-5 text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Selamat Datang di UNEMA</h1>
        <p class="lead text-muted mb-4">Pesan tiket bioskop dengan mudah</p>
        <a href="#" class="btn btn-danger btn-lg">Mulai Pesan</a>
    </div>
</section>
```

#### Two Column Layout

```html
<div class="row g-4 mt-5">
    <div class="col-lg-8">
        <!-- Main Content -->
    </div>
    <div class="col-lg-4">
        <!-- Sidebar -->
    </div>
</div>
```

#### Card Grid

```html
<div class="row g-4">
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card"><!-- Card content --></div>
    </div>
    <!-- Repeat -->
</div>
```

---

## 📱 Responsiveness

### Mobile First Approach

UNEMA CINEMA menggunakan **mobile-first** strategy. Desain dimulai dari mobile, kemudian di-enhance untuk ukuran layar yang lebih besar.

### Breakpoint Usage

```html
<!-- Hidden on mobile, shown on md and up -->
<div class="d-none d-md-block">Desktop Only Content</div>

<!-- Shown on mobile, hidden on md and up -->
<div class="d-md-none">Mobile Only Content</div>

<!-- Responsive columns -->
<div class="row">
    <div class="col-12 col-md-6 col-lg-4">
        <!-- Takes full width on mobile, half on tablet, 1/3 on desktop -->
    </div>
</div>
```

### Mobile Optimizations

1. **Touch Targets**: Minimal 44px x 44px untuk buttons
2. **Readable Text**: Minimal 16px untuk body text
3. **Adequate Spacing**: 16px padding minimal pada mobile
4. **Single Column**: Gunakan satu kolom pada mobile
5. **Full Width Forms**: Forms span full width pada mobile

### Landscape Handling

```css
/* Landscape orientation (iPhone) */
@media (max-height: 500px) {
    .hero-section {
        padding: 1rem 0;
    }
}
```

---

## ✨ Animasi & Transisi

### Transition Defaults

```css
/* Durasi & Timing */
--default-transition-duration: 0.15s
--default-transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1)
```

### Animasi Umum

#### 1. Fade In/Out

```css
.fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
```

```html
<!-- Bootstrap built-in -->
<div class="fade show">Content</div>
```

#### 2. Slide In

```css
.slide-in {
    animation: slideInRight 0.3s ease-out;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
```

#### 3. Bounce

```css
.bounce {
    animation: bounce 0.6s ease-in-out;
}

@keyframes bounce {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}
```

#### 4. Scale

```css
.scale-hover:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}
```

### Micro-interactions

#### Button Hover

```css
.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn:active {
    transform: translateY(0);
}
```

#### Link Underline Animation

```css
.link-animated {
    position: relative;
    text-decoration: none;
    color: #f53003;
}

.link-animated::after {
    content: "";
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -2px;
    left: 0;
    background-color: #f53003;
    transition: width 0.3s ease;
}

.link-animated:hover::after {
    width: 100%;
}
```

### Loading States

```html
<!-- Spinner -->
<div class="spinner-border text-danger" role="status">
    <span class="visually-hidden">Loading...</span>
</div>

<!-- Skeleton Loading -->
<div class="placeholder-glow">
    <span class="placeholder col-12"></span>
    <span class="placeholder col-7"></span>
</div>
```

### Page Transitions

```css
/* Fade transition on page load */
.page-enter {
    animation: fadeIn 0.3s ease-in-out;
}

.page-exit {
    animation: fadeOut 0.3s ease-in-out;
}
```

---

## ♿ Aksesibilitas

### WCAG 2.1 Compliance

UNEMA CINEMA mengikuti **WCAG 2.1 Level AA** standards untuk aksesibilitas.

### Color Contrast

Semua teks harus memiliki contrast ratio minimal **4.5:1** untuk normal text dan **3:1** untuk large text.

| Element                      | Ratio | Status  |
| ---------------------------- | ----- | ------- |
| Body text (#1b1b18) on white | 16:1  | ✅ Pass |
| Button text on red (#F53003) | 4.8:1 | ✅ Pass |
| Disabled text                | 4.5:1 | ✅ Pass |

### Semantic HTML

```html
<!-- ✅ Good -->
<button class="btn">Pesan</button>
<nav>Navigation</nav>
<article>Article content</article>
<footer>Footer</footer>

<!-- ❌ Avoid -->
<div onclick="...">Pesan</div>
<div class="nav">Navigation</div>
<span>Article content</span>
```

### ARIA Labels

```html
<!-- Form inputs -->
<label for="email">Email:</label>
<input id="email" type="email" aria-label="Email address" />

<!-- Icon buttons -->
<button aria-label="Tutup modal">
    <i class="bi bi-x"></i>
</button>

<!-- Screen reader only text -->
<span class="visually-hidden">Loading...</span>
```

### Keyboard Navigation

```html
<!-- Logical tab order -->
<button tabindex="0">Pertama</button>
<button tabindex="1">Kedua</button>
<button tabindex="2">Ketiga</button>

<!-- Skip links -->
<a href="#main-content" class="skip-link">Lewati ke konten utama</a>
```

```css
.skip-link {
    position: absolute;
    top: -40px;
    left: 0;
    background: #f53003;
    color: white;
    padding: 8px;
    text-decoration: none;
    z-index: 100;
}

.skip-link:focus {
    top: 0;
}
```

### Focus Indicators

```css
/* Visible focus untuk keyboard users */
button:focus-visible,
a:focus-visible,
input:focus-visible {
    outline: 2px solid #f53003;
    outline-offset: 2px;
}
```

---

## 🔄 User Flows

### 1. User Registration Flow

```
Start
  ↓
Landing Page
  ↓
Click "Daftar"
  ↓
Registration Form
  ├─ Input: Email, Password, Full Name
  ├─ Validation: Email format, Password strength
  ↓
Email Verification (if enabled)
  ↓
Welcome Page
  ↓
Redirect to Dashboard
```

### 2. Movie Booking Flow

```
Start
  ↓
Browse Movies
  ├─ Filter by genre, rating
  ├─ Search by title
  ↓
View Movie Details
  ├─ Synopsis, rating, cast
  ├─ Available showtimes
  ↓
Select Showtime
  ├─ Choose date
  ├─ Choose time & cinema
  ↓
Select Seats
  ├─ View seat map
  ├─ Choose available seats
  ├─ See price calculation
  ↓
Review & Checkout
  ├─ Confirm details
  ├─ Add special requests (optional)
  ↓
Payment
  ├─ Choose payment method
  ├─ Process via Midtrans
  ├─ Confirmation
  ↓
Booking Confirmation
  ├─ Show ticket details
  ├─ Download E-ticket
  ↓
End
```

### 3. Admin Management Flow

```
Admin Login
  ↓
Admin Dashboard
  ├─ Statistics & Overview
  ├─ Quick actions
  ↓
Manage Movies
  ├─ Add, Edit, Delete movies
  ├─ Upload posters
  ├─ Set ratings & descriptions
  ↓
Manage Showtimes
  ├─ Create showtimes
  ├─ Set cinema & times
  ├─ Set prices
  ↓
Manage Bookings
  ├─ View all bookings
  ├─ Process refunds
  ├─ Check payment status
  ↓
Manage Users
  ├─ View user list
  ├─ Deactivate accounts
  ├─ Check booking history
  ↓
End
```

### 4. Ticket Purchase to Viewing

```
Ticket in Hand
  ↓
Arrive at Cinema
  ├─ Show E-ticket to staff
  ├─ Scan QR Code / Enter booking ID
  ↓
Verify Ticket
  ├─ Check date, time, seats
  ├─ Process entry
  ↓
Enjoy Movie
  ↓
End
```

---

## 🎯 Best Practices

### 1. Consistency

-   ✅ Gunakan spacing yang konsisten (4px, 8px, 12px, 16px, dll)
-   ✅ Warna yang sama untuk elemen yang sama di seluruh aplikasi
-   ✅ Gunakan font yang sama untuk heading level
-   ✅ Konsisten dengan icon usage

### 2. Feedback & Validation

```html
<!-- Real-time validation -->
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control is-invalid" id="email" />
    <div class="invalid-feedback">Format email tidak valid</div>
</div>

<!-- Success feedback -->
<div class="alert alert-success">✓ Email verified successfully</div>
```

### 3. Loading States

```html
<!-- Disable button during submission -->
<button class="btn btn-danger" id="submitBtn">
    <span id="btnText">Pesan Sekarang</span>
    <span
        id="btnSpinner"
        class="spinner-border spinner-border-sm ms-2 d-none"
        role="status"
    >
        <span class="visually-hidden">Loading...</span>
    </span>
</button>

<script>
    document.getElementById("submitBtn").addEventListener("click", function () {
        this.disabled = true;
        document.getElementById("btnText").classList.add("d-none");
        document.getElementById("btnSpinner").classList.remove("d-none");
        // Submit logic
    });
</script>
```

### 4. Error Handling

```html
<!-- Form Error -->
<div class="alert alert-danger alert-dismissible fade show">
    <strong>Error!</strong> Ada masalah saat memproses pesanan Anda:
    <ul class="mt-2 mb-0">
        <li>Kursi A1 telah terpilih oleh user lain</li>
        <li>Silakan pilih kursi lain</li>
    </ul>
</div>
```

### 5. Empty States

```html
<!-- No data message -->
<div class="text-center py-5">
    <i class="bi bi-inbox" style="font-size: 3rem; color: #dbdbd7;"></i>
    <h5 class="mt-3 text-muted">Tidak ada data</h5>
    <p class="text-muted small">Anda belum memiliki pesanan apapun</p>
    <a href="/movies" class="btn btn-outline-dark btn-sm mt-2">Mulai Pesan</a>
</div>
```

### 6. Progressive Enhancement

-   ✅ Aplikasi bekerja tanpa JavaScript (graceful degradation)
-   ✅ Form submission bekerja dengan POST tradisional
-   ✅ Livewire enhancements untuk interactivity

### 7. Performance

-   ✅ Images di-lazy load
-   ✅ CSS minimal (Bootstrap utility classes)
-   ✅ Livewire untuk partial page updates
-   ✅ Cache static assets

```html
<!-- Lazy loading images -->
<img src="poster.jpg" class="lazy" loading="lazy" alt="Movie" />

<!-- Defer non-critical scripts -->
<script defer src="analytics.js"></script>
```

### 8. Dark Mode Support

```html
<!-- User preference detection -->
<script>
    if (
        window.matchMedia &&
        window.matchMedia("(prefers-color-scheme: dark)").matches
    ) {
        document.documentElement.setAttribute("data-theme", "dark");
    }
</script>

<!-- Toggle switch -->
<button id="theme-toggle" aria-label="Toggle dark mode">
    <i class="bi bi-moon"></i>
</button>

<script>
    document
        .getElementById("theme-toggle")
        .addEventListener("click", function () {
            const isDark =
                document.documentElement.getAttribute("data-theme") === "dark";
            document.documentElement.setAttribute(
                "data-theme",
                isDark ? "light" : "dark"
            );
        });
</script>
```

### 9. Confirmation Dialogs

```html
<!-- Destructive actions require confirmation -->
<button
    class="btn btn-danger"
    data-bs-toggle="modal"
    data-bs-target="#deleteModal"
>
    Hapus Pesanan
</button>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title">Hapus Pesanan?</h5>
                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                ></button>
            </div>
            <div class="modal-body">
                <p>
                    Tindakan ini tidak dapat dibatalkan. Anda akan kehilangan
                    e-ticket.
                </p>
            </div>
            <div class="modal-footer border-0">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Batal
                </button>
                <button type="button" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>
```

### 10. Toast Notifications

```html
<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white border-0">
            <strong class="me-auto">Berhasil</strong>
            <button
                type="button"
                class="btn-close btn-close-white"
                data-bs-dismiss="toast"
            ></button>
        </div>
        <div class="toast-body">Pesanan Anda telah berhasil diproses!</div>
    </div>
</div>

<script>
    const toast = new bootstrap.Toast(document.querySelector(".toast"));
    toast.show();
</script>
```

---

## 📋 Checklist untuk Developers

### Sebelum Launch

-   [ ] Semua buttons memiliki proper hover & active states
-   [ ] Forms memiliki validation messages
-   [ ] Empty states ditampilkan dengan baik
-   [ ] Loading states terlihat
-   [ ] Error states jelas dan helpful
-   [ ] Mobile responsiveness tested
-   [ ] Dark mode berfungsi
-   [ ] Accessibility tested (keyboard nav, screen readers)
-   [ ] Color contrast checked
-   [ ] Performance optimized

### Code Standards

-   [ ] Gunakan Bootstrap utility classes
-   [ ] Hindari inline styles
-   [ ] Use semantic HTML
-   [ ] Add proper ARIA labels
-   [ ] Use semantic class names
-   [ ] Comment complex CSS
-   [ ] Follow indentation standards

---

## 🔗 Resources

### Documentation

-   [Bootstrap 5 Documentation](https://getbootstrap.com/)
-   [Bootstrap Icons](https://icons.getbootstrap.com/)
-   [Livewire Documentation](https://livewire.laravel.com/)
-   [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

### Tools

-   Chrome DevTools untuk testing
-   WebAIM Contrast Checker
-   WAVE Accessibility Tool
-   Lighthouse (Performance & Accessibility)

---

**Last Updated:** December 2024
**Version:** 1.0
**Status:** Active
