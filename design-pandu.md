# DESIGN-PANDU.md
# Panduan Desain UI/UX — Sistem PANDU K3

> **Versi:** 1.0.0 | **Framework UI:** Bootstrap 5 CDN | **Tanggal:** 2025

---

## DAFTAR ISI

1. [Filosofi & Prinsip Desain](#1-filosofi--prinsip-desain)
2. [Palet Warna](#2-palet-warna)
3. [Tipografi](#3-tipografi)
4. [Layout & Grid Sistem](#4-layout--grid-sistem)
5. [Komponen Navigasi](#5-komponen-navigasi)
6. [Komponen Kartu & Panel](#6-komponen-kartu--panel)
7. [Komponen Form & Input](#7-komponen-form--input)
8. [Tabel & Data Display](#8-tabel--data-display)
9. [Badge, Status & Indikator](#9-badge-status--indikator)
10. [Alert & Notifikasi](#10-alert--notifikasi)
11. [Tombol & CTA](#11-tombol--cta)
12. [Grafik & Visualisasi Data](#12-grafik--visualisasi-data)
13. [Dashboard Per Peran](#13-dashboard-per-peran)
14. [Halaman Khusus](#14-halaman-khusus)
15. [Responsif & Mobile](#15-responsif--mobile)
16. [Animasi & Microinteraction](#16-animasi--microinteraction)
17. [CSS Custom Variables & Utilities](#17-css-custom-variables--utilities)
18. [Template Layout Utama](#18-template-layout-utama)

---

## 1. FILOSOFI & PRINSIP DESAIN

### 1.1 Identitas Visual
PANDU K3 mengusung estetika **"Industrial Command Center"** — tegas, profesional, dan informatif seperti pusat kontrol industri modern. Desain harus memancarkan otoritas, kepercayaan, dan urgensi yang sesuai dengan konteks keselamatan kerja.

### 1.2 Lima Prinsip Desain
1. **Clarity First** — Data kritis harus langsung terbaca tanpa perlu interpretasi
2. **Hierarchy of Urgency** — Bahaya/risiko tinggi selalu menonjol secara visual
3. **Trust & Authority** — Tampilan formal dan bersih memberi rasa profesional
4. **Efficiency of Action** — Aksi penting dapat diakses dalam ≤ 3 klik
5. **Context Awareness** — UI berbeda untuk lapangan (mobile) vs. kantor (desktop)

### 1.3 Tone Visual
- **Utama:** Biru navy gelap — otoritas, kepercayaan, profesionalisme industri
- **Aksen:** Oranye keselamatan — energi, perhatian, urgensi positif
- **Sinyal:** Merah-kuning-hijau — sistem semaphore risiko universal
- **Latar:** Abu-abu sangat terang — netral, bersih, tidak melelahkan mata

---

## 2. PALET WARNA

### 2.1 Warna Primer Sistem

```css
:root {
  /* === BRAND COLORS === */
  --pandu-navy:        #0D2137;   /* Sidebar, header utama */
  --pandu-navy-light:  #1A3A5C;   /* Hover sidebar, header secondary */
  --pandu-navy-mid:    #1F4E79;   /* Aksen medium */
  --pandu-blue:        #1565C0;   /* Link, tombol primer */
  --pandu-blue-light:  #1E88E5;   /* Tombol hover */
  --pandu-orange:      #E65100;   /* Aksen utama, badge urgent */
  --pandu-orange-mid:  #F57C00;   /* Warning medium */
  --pandu-orange-light:#FF9800;   /* Warning ringan */

  /* === SEMANTIC COLORS === */
  --color-danger:      #C0392B;   /* Bahaya kritis, hapus */
  --color-danger-light:#FDEDEC;   /* Background danger tipis */
  --color-danger-mid:  #E74C3C;   /* Hover danger */
  --color-warning:     #E67E22;   /* Perhatian, status in_progress */
  --color-warning-light:#FEF9E7;  /* Background warning tipis */
  --color-success:     #1A7A4A;   /* Aman, selesai, approved */
  --color-success-light:#EAFAF1;  /* Background success tipis */
  --color-info:        #117A8B;   /* Informasi, status baru */
  --color-info-light:  #E8F8F5;   /* Background info tipis */

  /* === RISK LEVEL COLORS === */
  --risk-very-low:     #27AE60;   /* Risk score 1-4 */
  --risk-low:          #82E0AA;   /* Risk score 5-9 */
  --risk-medium:       #F1C40F;   /* Risk score 10-14 */
  --risk-high:         #E67E22;   /* Risk score 15-19 */
  --risk-critical:     #C0392B;   /* Risk score 20-25 */

  /* === NEUTRAL COLORS === */
  --gray-50:           #F8F9FA;   /* Background halaman */
  --gray-100:          #F1F3F4;   /* Background card secondary */
  --gray-200:          #E9ECEF;   /* Border, divider */
  --gray-300:          #DEE2E6;   /* Border input */
  --gray-500:          #ADB5BD;   /* Placeholder text */
  --gray-600:          #6C757D;   /* Label, caption */
  --gray-700:          #495057;   /* Body text secondary */
  --gray-800:          #343A40;   /* Body text primary */
  --gray-900:          #212529;   /* Heading */

  /* === BACKGROUND === */
  --bg-page:           #F0F2F5;   /* Background seluruh halaman */
  --bg-card:           #FFFFFF;   /* Background card/panel */
  --bg-sidebar:        #0D2137;   /* Background sidebar */
  --bg-topbar:         #FFFFFF;   /* Background topbar */

  /* === SHADOWS === */
  --shadow-sm:         0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);
  --shadow-md:         0 4px 6px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.06);
  --shadow-lg:         0 10px 25px rgba(0,0,0,0.1), 0 4px 6px rgba(0,0,0,0.05);
  --shadow-card:       0 2px 8px rgba(13,33,55,0.08);

  /* === BORDER RADIUS === */
  --radius-sm:         6px;
  --radius-md:         10px;
  --radius-lg:         16px;
  --radius-xl:         24px;
  --radius-pill:       50px;

  /* === TRANSITION === */
  --transition-fast:   all 0.15s ease;
  --transition-base:   all 0.25s ease;
  --transition-slow:   all 0.4s ease;
}
```

### 2.2 Mapping Warna per Status

| Status | Warna | HEX | Penggunaan |
|---|---|---|---|
| `open` / Baru | Biru Info | `#117A8B` | Badge laporan baru |
| `in_review` | Biru Medium | `#1565C0` | Sedang ditinjau |
| `in_progress` | Oranye | `#E67E22` | Sedang dikerjakan |
| `pending_verification` | Ungu | `#7D3C98` | Menunggu verifikasi |
| `resolved` | Hijau Medium | `#1A7A4A` | Terselesaikan |
| `closed` | Abu Gelap | `#495057` | Ditutup |
| `overdue` | Merah Gelap | `#C0392B` | Terlambat |
| `emergency` | Merah + Pulse | `#E74C3C` | Darurat |
| `scheduled` | Biru Muda | `#1E88E5` | Terjadwal |
| `completed` | Hijau Tua | `#1A7A4A` | Selesai |
| `cancelled` | Abu Medium | `#6C757D` | Dibatalkan |
| `expired` | Merah | `#C0392B` | Kadaluarsa |
| `expiring_soon` | Oranye | `#F57C00` | Segera kadaluarsa |
| `active` | Hijau | `#27AE60` | Aktif/valid |

---

## 3. TIPOGRAFI

### 3.1 Font Stack

```css
/* Import di <head> layout utama */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

:root {
  --font-primary:  'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
  --font-mono:     'JetBrains Mono', 'Courier New', monospace;
}

body {
  font-family: var(--font-primary);
  font-size: 14px;
  line-height: 1.6;
  color: var(--gray-800);
}
```

### 3.2 Skala Tipografi

```css
/* Heading Halaman */
.page-title {
  font-size: 1.5rem;     /* 24px */
  font-weight: 700;
  color: var(--gray-900);
  letter-spacing: -0.3px;
}

/* Sub-heading / Section Title */
.section-title {
  font-size: 1.125rem;   /* 18px */
  font-weight: 600;
  color: var(--gray-800);
}

/* Card Title */
.card-title-custom {
  font-size: 1rem;       /* 16px */
  font-weight: 600;
  color: var(--gray-800);
}

/* Label / Caption */
.label-text {
  font-size: 0.75rem;    /* 12px */
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  color: var(--gray-600);
}

/* Metric Number (KPI) */
.metric-number {
  font-size: 2.25rem;    /* 36px */
  font-weight: 800;
  line-height: 1.1;
  letter-spacing: -1px;
}

/* Kode / Nomor Dokumen */
.doc-number {
  font-family: var(--font-mono);
  font-size: 0.8125rem;  /* 13px */
  font-weight: 500;
  color: var(--pandu-blue);
  background: rgba(21,101,192,0.08);
  padding: 2px 8px;
  border-radius: 4px;
}
```

---

## 4. LAYOUT & GRID SISTEM

### 4.1 Struktur Layout Utama

```
┌────────────────────────────────────────────────────────┐
│                     TOP BAR (64px)                      │
│  [☰ Logo PANDU K3]        [🔔 Notif] [👤 Profil User] │
├──────────────┬─────────────────────────────────────────┤
│              │                                          │
│   SIDEBAR    │          MAIN CONTENT AREA               │
│   (260px)    │                                          │
│              │  ┌─ Breadcrumb ─────────────────────┐   │
│  [Nav Menu]  │  │  Dashboard > Laporan Bahaya       │   │
│              │  └───────────────────────────────────┘   │
│              │                                          │
│              │  ┌─ Page Header ────────────────────┐   │
│              │  │  Judul Halaman      [+ Tambah]    │   │
│              │  └───────────────────────────────────┘   │
│              │                                          │
│              │  ┌─ Content ─────────────────────────┐  │
│              │  │   ...                              │  │
│              │  └───────────────────────────────────┘  │
│              │                                          │
└──────────────┴─────────────────────────────────────────┘
```

### 4.2 Dimensi Layout

```css
:root {
  --sidebar-width:      260px;
  --sidebar-collapsed:  72px;
  --topbar-height:      64px;
  --content-padding:    24px;
  --card-gap:           20px;
}

/* Main wrapper */
.pandu-wrapper {
  display: flex;
  min-height: 100vh;
  background: var(--bg-page);
}

.pandu-sidebar {
  width: var(--sidebar-width);
  min-height: 100vh;
  background: var(--bg-sidebar);
  position: fixed;
  left: 0; top: 0;
  transition: var(--transition-base);
  z-index: 1000;
  overflow-y: auto;
  overflow-x: hidden;
}

.pandu-main {
  margin-left: var(--sidebar-width);
  flex: 1;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  transition: var(--transition-base);
}

.pandu-topbar {
  height: var(--topbar-height);
  background: var(--bg-topbar);
  border-bottom: 1px solid var(--gray-200);
  padding: 0 var(--content-padding);
  display: flex;
  align-items: center;
  position: sticky;
  top: 0;
  z-index: 900;
  box-shadow: var(--shadow-sm);
}

.pandu-content {
  padding: var(--content-padding);
  flex: 1;
}
```

---

## 5. KOMPONEN NAVIGASI

### 5.1 Sidebar

```html
<!-- Sidebar Structure -->
<aside class="pandu-sidebar">
  <!-- Logo Area -->
  <div class="sidebar-logo">
    <div class="logo-icon">
      <i class="fas fa-shield-halved"></i>
    </div>
    <div class="logo-text">
      <span class="logo-brand">PANDU K3</span>
      <span class="logo-sub">HSE Management System</span>
    </div>
  </div>

  <!-- User Info -->
  <div class="sidebar-user">
    <img src="{{ user_avatar }}" class="user-avatar" alt="">
    <div class="user-info">
      <span class="user-name">{{ auth()->user()->name }}</span>
      <span class="user-role badge-role-{{ auth()->user()->role }}">
        {{ ucfirst(auth()->user()->role) }}
      </span>
    </div>
  </div>

  <!-- Navigation -->
  <nav class="sidebar-nav">
    <!-- Group Label -->
    <div class="nav-group-label">UTAMA</div>

    <a href="#" class="nav-item active">
      <span class="nav-icon"><i class="fas fa-gauge-high"></i></span>
      <span class="nav-text">Dashboard</span>
      <span class="nav-badge">3</span> <!-- notif count -->
    </a>

    <!-- Menu dengan submenu -->
    <div class="nav-item has-sub">
      <a href="#" class="nav-link-parent" data-bs-toggle="collapse" data-bs-target="#menuBahaya">
        <span class="nav-icon"><i class="fas fa-triangle-exclamation"></i></span>
        <span class="nav-text">Pelaporan</span>
        <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
      </a>
      <div class="collapse" id="menuBahaya">
        <a href="#" class="nav-sub-item">Laporan Bahaya</a>
        <a href="#" class="nav-sub-item">Laporan Insiden</a>
      </div>
    </div>
    <!-- ... dst -->
  </nav>

  <!-- Sidebar Footer -->
  <div class="sidebar-footer">
    <a href="#" class="sidebar-footer-btn">
      <i class="fas fa-gear"></i> Pengaturan
    </a>
    <a href="#" class="sidebar-footer-btn text-danger">
      <i class="fas fa-right-from-bracket"></i> Logout
    </a>
  </div>
</aside>
```

```css
/* Sidebar Styles */
.sidebar-logo {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 20px 20px 16px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}

.logo-icon {
  width: 40px; height: 40px;
  background: linear-gradient(135deg, var(--pandu-orange), var(--pandu-orange-light));
  border-radius: var(--radius-md);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 18px;
  box-shadow: 0 4px 12px rgba(230,81,0,0.35);
}

.logo-brand {
  font-size: 1.125rem; font-weight: 800;
  color: #FFFFFF; letter-spacing: 0.5px;
  display: block;
}
.logo-sub {
  font-size: 0.65rem; color: rgba(255,255,255,0.45);
  text-transform: uppercase; letter-spacing: 0.8px;
}

.sidebar-user {
  display: flex; align-items: center; gap: 10px;
  padding: 14px 16px;
  margin: 8px 12px;
  background: rgba(255,255,255,0.06);
  border-radius: var(--radius-md);
  border: 1px solid rgba(255,255,255,0.08);
}

.user-avatar {
  width: 36px; height: 36px;
  border-radius: 50%;
  border: 2px solid rgba(255,255,255,0.2);
  object-fit: cover;
}

.user-name {
  font-size: 0.8125rem; font-weight: 600;
  color: #FFF; display: block; line-height: 1.3;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px;
}

.nav-group-label {
  font-size: 0.625rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1.2px;
  color: rgba(255,255,255,0.3);
  padding: 16px 20px 6px;
}

.nav-item {
  display: flex; align-items: center; gap: 10px;
  padding: 10px 16px;
  margin: 2px 8px;
  border-radius: var(--radius-md);
  color: rgba(255,255,255,0.65);
  font-size: 0.875rem; font-weight: 500;
  text-decoration: none;
  transition: var(--transition-fast);
  cursor: pointer;
  position: relative;
}

.nav-item:hover {
  background: rgba(255,255,255,0.08);
  color: #FFF;
}

.nav-item.active {
  background: linear-gradient(135deg, var(--pandu-orange), #F57C00);
  color: #FFF;
  box-shadow: 0 4px 15px rgba(230,81,0,0.35);
}

.nav-item.active .nav-icon { color: #FFF; }

.nav-icon {
  width: 22px; text-align: center;
  font-size: 1rem;
  color: rgba(255,255,255,0.5);
  transition: var(--transition-fast);
  flex-shrink: 0;
}

.nav-badge {
  margin-left: auto;
  background: var(--color-danger);
  color: #fff; font-size: 0.6875rem;
  font-weight: 700; padding: 1px 6px;
  border-radius: var(--radius-pill);
  min-width: 20px; text-align: center;
}

.nav-sub-item {
  display: block; padding: 7px 16px 7px 48px;
  color: rgba(255,255,255,0.5);
  font-size: 0.8125rem; text-decoration: none;
  border-radius: 6px; margin: 1px 8px;
  transition: var(--transition-fast);
  position: relative;
}
.nav-sub-item::before {
  content: ''; position: absolute;
  left: 34px; top: 50%; transform: translateY(-50%);
  width: 5px; height: 5px;
  border-radius: 50%; background: rgba(255,255,255,0.25);
  transition: var(--transition-fast);
}
.nav-sub-item:hover {
  color: #FFF; background: rgba(255,255,255,0.06);
}
.nav-sub-item:hover::before { background: var(--pandu-orange-light); }

.sidebar-footer {
  padding: 12px;
  border-top: 1px solid rgba(255,255,255,0.08);
  margin-top: auto;
}
.sidebar-footer-btn {
  display: flex; align-items: center; gap: 8px;
  padding: 9px 14px;
  border-radius: var(--radius-md);
  color: rgba(255,255,255,0.5);
  font-size: 0.8125rem; text-decoration: none;
  transition: var(--transition-fast);
}
.sidebar-footer-btn:hover {
  background: rgba(255,255,255,0.07);
  color: rgba(255,255,255,0.85);
}
```

### 5.2 Top Bar

```html
<header class="pandu-topbar">
  <!-- Left: Toggle + Breadcrumb -->
  <div class="d-flex align-items-center gap-3">
    <button class="topbar-toggle" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 pandu-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan Bahaya</li>
      </ol>
    </nav>
  </div>

  <!-- Right: Actions -->
  <div class="topbar-actions">
    <!-- Search -->
    <div class="topbar-search">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Cari dokumen, laporan...">
    </div>

    <!-- Notifications -->
    <div class="dropdown">
      <button class="topbar-btn position-relative" data-bs-toggle="dropdown">
        <i class="fas fa-bell"></i>
        <span class="notif-dot">5</span>
      </button>
      <!-- Dropdown notif ... -->
    </div>

    <!-- User Dropdown -->
    <div class="dropdown">
      <button class="topbar-user-btn" data-bs-toggle="dropdown">
        <img src="{{ avatar }}" class="topbar-avatar" alt="">
        <span class="topbar-username d-none d-md-inline">{{ name }}</span>
        <i class="fas fa-chevron-down ms-1 small"></i>
      </button>
      <!-- Dropdown menu ... -->
    </div>
  </div>
</header>
```

```css
.topbar-toggle {
  background: none; border: none;
  width: 38px; height: 38px;
  border-radius: var(--radius-md);
  color: var(--gray-600); font-size: 1rem;
  transition: var(--transition-fast);
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
}
.topbar-toggle:hover {
  background: var(--gray-100); color: var(--gray-900);
}

.pandu-breadcrumb .breadcrumb-item a {
  color: var(--pandu-blue); text-decoration: none; font-size: 0.8125rem;
}
.pandu-breadcrumb .breadcrumb-item.active { font-size: 0.8125rem; font-weight: 600; }
.pandu-breadcrumb .breadcrumb-item + .breadcrumb-item::before { color: var(--gray-400); }

.topbar-search {
  display: flex; align-items: center; gap: 8px;
  background: var(--gray-100); border-radius: var(--radius-pill);
  padding: 7px 14px; border: 1px solid transparent;
  transition: var(--transition-fast);
}
.topbar-search:focus-within {
  background: #FFF; border-color: var(--pandu-blue);
  box-shadow: 0 0 0 3px rgba(21,101,192,0.1);
}
.topbar-search i { color: var(--gray-500); font-size: 0.875rem; }
.topbar-search input {
  border: none; background: none; outline: none;
  font-size: 0.8125rem; width: 180px; color: var(--gray-800);
}

.topbar-btn {
  background: none; border: none;
  width: 40px; height: 40px;
  border-radius: var(--radius-md);
  color: var(--gray-600); font-size: 1rem;
  cursor: pointer; transition: var(--transition-fast);
  display: flex; align-items: center; justify-content: center;
}
.topbar-btn:hover { background: var(--gray-100); color: var(--gray-900); }

.notif-dot {
  position: absolute; top: 4px; right: 4px;
  background: var(--color-danger); color: #fff;
  font-size: 0.5625rem; font-weight: 700;
  min-width: 16px; height: 16px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  border: 2px solid #fff;
}

.topbar-user-btn {
  display: flex; align-items: center; gap: 8px;
  background: none; border: none; cursor: pointer;
  padding: 4px 8px; border-radius: var(--radius-md);
  transition: var(--transition-fast);
}
.topbar-user-btn:hover { background: var(--gray-100); }

.topbar-avatar {
  width: 34px; height: 34px; border-radius: 50%;
  object-fit: cover; border: 2px solid var(--gray-200);
}

.topbar-username {
  font-size: 0.875rem; font-weight: 600; color: var(--gray-800);
}
```

---

## 6. KOMPONEN KARTU & PANEL

### 6.1 Card Standar

```html
<div class="pandu-card">
  <div class="pandu-card-header">
    <div class="card-header-left">
      <span class="card-header-icon"><i class="fas fa-triangle-exclamation"></i></span>
      <div>
        <h5 class="card-title-custom mb-0">Laporan Bahaya Aktif</h5>
        <p class="card-subtitle mb-0">Data 30 hari terakhir</p>
      </div>
    </div>
    <div class="card-header-right">
      <a href="#" class="btn-card-action">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
    </div>
  </div>
  <div class="pandu-card-body">
    <!-- content -->
  </div>
</div>
```

```css
.pandu-card {
  background: var(--bg-card);
  border-radius: var(--radius-lg);
  border: 1px solid var(--gray-200);
  box-shadow: var(--shadow-card);
  overflow: hidden;
  transition: var(--transition-fast);
}
.pandu-card:hover {
  box-shadow: var(--shadow-md);
  transform: translateY(-1px);
}

.pandu-card-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 16px 20px;
  border-bottom: 1px solid var(--gray-100);
}

.card-header-left {
  display: flex; align-items: center; gap: 12px;
}

.card-header-icon {
  width: 38px; height: 38px;
  border-radius: var(--radius-md);
  background: rgba(21,101,192,0.1);
  color: var(--pandu-blue);
  display: flex; align-items: center; justify-content: center;
  font-size: 1rem;
}

.card-subtitle {
  font-size: 0.75rem; color: var(--gray-500);
}

.btn-card-action {
  font-size: 0.8125rem; font-weight: 600;
  color: var(--pandu-blue); text-decoration: none;
  transition: var(--transition-fast);
}
.btn-card-action:hover { color: var(--pandu-blue-light); }

.pandu-card-body { padding: 20px; }
```

### 6.2 Stat Card (KPI Card)

```html
<div class="stat-card stat-card--danger">
  <div class="stat-card-header">
    <span class="stat-card-label">Insiden Bulan Ini</span>
    <div class="stat-card-icon">
      <i class="fas fa-circle-exclamation"></i>
    </div>
  </div>
  <div class="stat-card-body">
    <div class="stat-card-number">12</div>
    <div class="stat-card-trend trend--up">
      <i class="fas fa-arrow-trend-up"></i>
      <span>+3 dari bulan lalu</span>
    </div>
  </div>
  <div class="stat-card-footer">
    <div class="stat-progress">
      <div class="stat-progress-bar" style="width: 60%"></div>
    </div>
    <span class="stat-progress-label">60% dari target maksimum</span>
  </div>
</div>
```

```css
.stat-card {
  background: var(--bg-card);
  border-radius: var(--radius-lg);
  padding: 20px;
  border: 1px solid var(--gray-200);
  box-shadow: var(--shadow-card);
  position: relative; overflow: hidden;
  transition: var(--transition-base);
}
.stat-card::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 4px; height: 100%;
}
.stat-card--danger::before  { background: var(--color-danger); }
.stat-card--warning::before { background: var(--color-warning); }
.stat-card--success::before { background: var(--color-success); }
.stat-card--info::before    { background: var(--color-info); }
.stat-card--navy::before    { background: var(--pandu-navy); }

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-lg);
}

.stat-card-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 12px;
}

.stat-card-label {
  font-size: 0.75rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.8px;
  color: var(--gray-500);
}

.stat-card-icon {
  width: 42px; height: 42px; border-radius: var(--radius-md);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.125rem;
}
.stat-card--danger .stat-card-icon  { background:var(--color-danger-light); color:var(--color-danger); }
.stat-card--warning .stat-card-icon { background:var(--color-warning-light); color:var(--color-warning); }
.stat-card--success .stat-card-icon { background:var(--color-success-light); color:var(--color-success); }
.stat-card--info .stat-card-icon    { background:var(--color-info-light); color:var(--color-info); }

.stat-card-number {
  font-size: 2.5rem; font-weight: 800;
  color: var(--gray-900); line-height: 1;
  letter-spacing: -1.5px; margin-bottom: 6px;
}

.stat-card-trend {
  display: flex; align-items: center; gap: 5px;
  font-size: 0.8125rem; font-weight: 600;
}
.trend--up   { color: var(--color-danger); }
.trend--down { color: var(--color-success); }
.trend--flat { color: var(--gray-500); }

.stat-card-footer { margin-top: 16px; }
.stat-progress {
  height: 4px; background: var(--gray-100);
  border-radius: var(--radius-pill); overflow: hidden; margin-bottom: 6px;
}
.stat-progress-bar {
  height: 100%; border-radius: var(--radius-pill);
  background: linear-gradient(90deg, var(--pandu-blue), var(--pandu-blue-light));
  transition: width 0.8s ease;
}
.stat-card--danger .stat-progress-bar { background: linear-gradient(90deg, var(--color-danger), #E74C3C); }
.stat-progress-label { font-size: 0.6875rem; color: var(--gray-500); }
```

### 6.3 Alert Card (Notifikasi Kritis)

```html
<!-- Alert Card untuk bahaya kritis / emergency -->
<div class="alert-card alert-card--emergency">
  <div class="alert-card-pulse"></div>
  <div class="alert-card-icon">
    <i class="fas fa-triangle-exclamation"></i>
  </div>
  <div class="alert-card-content">
    <div class="alert-card-title">DARURAT: Kebakaran Area C3</div>
    <div class="alert-card-meta">2 menit yang lalu · Dilaporkan: Budi Santoso</div>
  </div>
  <a href="#" class="alert-card-action">Tangani <i class="fas fa-chevron-right"></i></a>
</div>
```

```css
.alert-card {
  display: flex; align-items: center; gap: 14px;
  padding: 14px 18px;
  border-radius: var(--radius-md);
  border: 1px solid;
  margin-bottom: 10px;
  position: relative; overflow: hidden;
  animation: slideInDown 0.3s ease;
}
.alert-card--emergency {
  background: rgba(192,57,43,0.06);
  border-color: rgba(192,57,43,0.3);
}
.alert-card-pulse {
  position: absolute; top: 50%; right: 14px; transform: translateY(-50%);
  width: 10px; height: 10px; border-radius: 50%;
  background: var(--color-danger);
  animation: pulse 1.5s infinite;
}
.alert-card--emergency .alert-card-icon {
  color: var(--color-danger);
  font-size: 1.25rem; flex-shrink: 0;
}
.alert-card-title { font-size: 0.875rem; font-weight: 700; color: var(--gray-900); }
.alert-card-meta  { font-size: 0.75rem; color: var(--gray-500); margin-top: 2px; }
.alert-card-action {
  margin-left: auto; padding-right: 24px;
  font-size: 0.8125rem; font-weight: 700;
  color: var(--color-danger); text-decoration: none;
  white-space: nowrap;
}

@keyframes pulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(192,57,43,0.6); }
  50%       { box-shadow: 0 0 0 8px rgba(192,57,43,0); }
}

@keyframes slideInDown {
  from { opacity: 0; transform: translateY(-10px); }
  to   { opacity: 1; transform: translateY(0); }
}
```

---

## 7. KOMPONEN FORM & INPUT

### 7.1 Input Standar

```css
/* Override Bootstrap form controls */
.form-control, .form-select {
  border: 1.5px solid var(--gray-300);
  border-radius: var(--radius-md);
  font-size: 0.875rem;
  padding: 9px 14px;
  color: var(--gray-800);
  background: #FFF;
  transition: var(--transition-fast);
}
.form-control:focus, .form-select:focus {
  border-color: var(--pandu-blue);
  box-shadow: 0 0 0 3px rgba(21,101,192,0.12);
  outline: none;
}
.form-control.is-invalid, .form-select.is-invalid {
  border-color: var(--color-danger);
}
.form-control.is-invalid:focus {
  box-shadow: 0 0 0 3px rgba(192,57,43,0.12);
}

.form-label {
  font-size: 0.8125rem; font-weight: 600;
  color: var(--gray-700); margin-bottom: 6px;
}

.form-text { font-size: 0.75rem; color: var(--gray-500); margin-top: 4px; }

.invalid-feedback { font-size: 0.75rem; color: var(--color-danger); }
```

### 7.2 Form Multi-Step (Laporan Insiden)

```html
<!-- Step Indicator -->
<div class="step-indicator">
  <div class="step-item completed">
    <div class="step-circle"><i class="fas fa-check"></i></div>
    <span class="step-label">Detail Insiden</span>
  </div>
  <div class="step-line completed"></div>
  <div class="step-item active">
    <div class="step-circle">2</div>
    <span class="step-label">Data Korban</span>
  </div>
  <div class="step-line"></div>
  <div class="step-item">
    <div class="step-circle">3</div>
    <span class="step-label">Analisis</span>
  </div>
  <div class="step-line"></div>
  <div class="step-item">
    <div class="step-circle">4</div>
    <span class="step-label">Tindakan</span>
  </div>
</div>
```

```css
.step-indicator {
  display: flex; align-items: center; margin-bottom: 32px;
}
.step-item {
  display: flex; flex-direction: column; align-items: center; gap: 6px;
  flex-shrink: 0;
}
.step-circle {
  width: 36px; height: 36px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.875rem; font-weight: 700;
  border: 2px solid var(--gray-300);
  color: var(--gray-500); background: #FFF;
  transition: var(--transition-base);
}
.step-item.active .step-circle {
  background: var(--pandu-blue); border-color: var(--pandu-blue);
  color: #FFF; box-shadow: 0 4px 12px rgba(21,101,192,0.35);
}
.step-item.completed .step-circle {
  background: var(--color-success); border-color: var(--color-success);
  color: #FFF;
}
.step-label { font-size: 0.6875rem; font-weight: 600; color: var(--gray-500); white-space: nowrap; }
.step-item.active .step-label { color: var(--pandu-blue); }
.step-item.completed .step-label { color: var(--color-success); }

.step-line {
  flex: 1; height: 2px;
  background: var(--gray-200); margin: 0 8px;
  margin-bottom: 22px;
  transition: var(--transition-base);
}
.step-line.completed { background: var(--color-success); }
```

### 7.3 Upload Foto Field

```html
<div class="photo-upload-area" id="photoUpload">
  <div class="photo-upload-icon"><i class="fas fa-camera"></i></div>
  <div class="photo-upload-text">
    <span class="fw-semibold">Klik untuk upload</span> atau drag & drop foto
  </div>
  <div class="photo-upload-hint">JPG, PNG, WEBP · Maks 5MB · Min 1, Maks 5 foto</div>
  <input type="file" accept="image/*" multiple class="d-none" id="photoInput">
</div>
<div class="photo-preview-grid mt-3" id="photoPreview"></div>
```

```css
.photo-upload-area {
  border: 2px dashed var(--gray-300);
  border-radius: var(--radius-lg);
  padding: 32px 24px;
  text-align: center; cursor: pointer;
  background: var(--gray-50);
  transition: var(--transition-fast);
}
.photo-upload-area:hover, .photo-upload-area.dragover {
  border-color: var(--pandu-blue);
  background: rgba(21,101,192,0.04);
}
.photo-upload-icon {
  width: 52px; height: 52px;
  background: rgba(21,101,192,0.1);
  border-radius: 50%; margin: 0 auto 12px;
  display: flex; align-items: center; justify-content: center;
  color: var(--pandu-blue); font-size: 1.25rem;
}
.photo-upload-text {
  font-size: 0.875rem; color: var(--gray-700); margin-bottom: 4px;
}
.photo-upload-hint { font-size: 0.75rem; color: var(--gray-500); }

.photo-preview-grid {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
  gap: 10px;
}
.photo-preview-item {
  position: relative; border-radius: var(--radius-md); overflow: hidden;
  aspect-ratio: 1; background: var(--gray-100);
}
.photo-preview-item img {
  width: 100%; height: 100%; object-fit: cover;
}
.photo-preview-remove {
  position: absolute; top: 4px; right: 4px;
  width: 22px; height: 22px; border-radius: 50%;
  background: rgba(0,0,0,0.6); color: #FFF;
  border: none; cursor: pointer; font-size: 0.625rem;
  display: flex; align-items: center; justify-content: center;
}
```

---

## 8. TABEL & DATA DISPLAY

### 8.1 Tabel Data Standar

```html
<div class="pandu-table-wrapper">
  <!-- Filter Bar -->
  <div class="table-filter-bar">
    <div class="table-filter-left">
      <div class="input-search-table">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Cari laporan...">
      </div>
      <select class="form-select form-select-sm filter-select">
        <option>Semua Status</option>
        <option>Open</option>
        <option>In Progress</option>
      </select>
      <select class="form-select form-select-sm filter-select">
        <option>Semua Area</option>
      </select>
    </div>
    <div class="table-filter-right">
      <span class="table-count">Menampilkan <strong>24</strong> data</span>
      <button class="btn-export"><i class="fas fa-file-export"></i> Export</button>
    </div>
  </div>

  <!-- Table -->
  <div class="table-responsive">
    <table class="table pandu-table">
      <thead>
        <tr>
          <th><input type="checkbox" class="form-check-input"></th>
          <th class="sortable">No. Laporan <i class="fas fa-sort"></i></th>
          <th class="sortable">Judul <i class="fas fa-sort"></i></th>
          <th>Area Kerja</th>
          <th>Kategori</th>
          <th class="sortable">Tingkat <i class="fas fa-sort"></i></th>
          <th>Status</th>
          <th class="sortable">Tanggal <i class="fas fa-sort"></i></th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input type="checkbox" class="form-check-input"></td>
          <td><span class="doc-number">HAZ-2025-00042</span></td>
          <td>
            <div class="td-main">Kabel Terkelupas Area Basah</div>
            <div class="td-sub">Dilaporkan oleh: Agus S.</div>
          </td>
          <td><span class="area-badge">Area B2 - Produksi</span></td>
          <td><span class="cat-badge cat-electrical"><i class="fas fa-bolt"></i> Listrik</span></td>
          <td><span class="risk-badge risk-high">Tinggi</span></td>
          <td><span class="status-badge status-in_progress">In Progress</span></td>
          <td>
            <div class="td-main">12 Jan 2025</div>
            <div class="td-sub">09:42 WIB</div>
          </td>
          <td>
            <div class="action-btns">
              <a href="#" class="btn-action btn-view" title="Lihat"><i class="fas fa-eye"></i></a>
              <a href="#" class="btn-action btn-edit" title="Edit"><i class="fas fa-pen"></i></a>
              <button class="btn-action btn-delete" title="Hapus"><i class="fas fa-trash"></i></button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="table-pagination">
    <span class="pagination-info">Halaman 1 dari 5 (total 73 data)</span>
    <nav><ul class="pagination pandu-pagination mb-0">...</ul></nav>
  </div>
</div>
```

```css
.pandu-table-wrapper {
  background: var(--bg-card); border-radius: var(--radius-lg);
  border: 1px solid var(--gray-200); overflow: hidden;
  box-shadow: var(--shadow-card);
}

.table-filter-bar {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 20px; border-bottom: 1px solid var(--gray-100);
  flex-wrap: wrap; gap: 12px;
}
.table-filter-left { display: flex; gap: 10px; flex-wrap: wrap; }

.input-search-table {
  display: flex; align-items: center; gap: 8px;
  background: var(--gray-50); border: 1.5px solid var(--gray-200);
  border-radius: var(--radius-md); padding: 7px 12px;
  transition: var(--transition-fast);
}
.input-search-table:focus-within {
  border-color: var(--pandu-blue); background: #FFF;
  box-shadow: 0 0 0 3px rgba(21,101,192,0.1);
}
.input-search-table i { color: var(--gray-500); font-size: 0.8125rem; }
.input-search-table input {
  border: none; background: none; outline: none;
  font-size: 0.8125rem; width: 200px;
}

.filter-select {
  font-size: 0.8125rem; border-color: var(--gray-200);
  border-radius: var(--radius-md); min-width: 130px;
}

.btn-export {
  display: flex; align-items: center; gap: 6px;
  background: none; border: 1.5px solid var(--gray-200);
  border-radius: var(--radius-md); padding: 7px 14px;
  font-size: 0.8125rem; font-weight: 600; color: var(--gray-700);
  cursor: pointer; transition: var(--transition-fast);
}
.btn-export:hover { background: var(--gray-50); border-color: var(--gray-300); }

.pandu-table { margin: 0; }
.pandu-table thead th {
  background: var(--gray-50); font-size: 0.75rem;
  font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px;
  color: var(--gray-600); padding: 12px 16px;
  border-bottom: 2px solid var(--gray-200); white-space: nowrap;
}
.pandu-table thead th.sortable { cursor: pointer; user-select: none; }
.pandu-table thead th.sortable:hover { color: var(--pandu-blue); }
.pandu-table thead th.sortable i { color: var(--gray-400); margin-left: 4px; }

.pandu-table tbody td {
  padding: 13px 16px; vertical-align: middle;
  border-bottom: 1px solid var(--gray-100); font-size: 0.875rem;
}
.pandu-table tbody tr:hover { background: rgba(21,101,192,0.025); }
.pandu-table tbody tr:last-child td { border-bottom: none; }

.td-main { font-weight: 600; color: var(--gray-800); }
.td-sub { font-size: 0.75rem; color: var(--gray-500); margin-top: 2px; }

.area-badge {
  display: inline-flex; align-items: center;
  background: rgba(21,101,192,0.08);
  color: var(--pandu-navy-mid); padding: 3px 10px;
  border-radius: var(--radius-pill); font-size: 0.75rem; font-weight: 600;
}

.action-btns { display: flex; gap: 6px; }
.btn-action {
  width: 30px; height: 30px; border-radius: var(--radius-md);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.75rem; border: none; cursor: pointer;
  text-decoration: none; transition: var(--transition-fast);
}
.btn-view   { background:rgba(21,101,192,0.1); color:var(--pandu-blue); }
.btn-edit   { background:rgba(230,126,34,0.1); color:var(--color-warning); }
.btn-delete { background:rgba(192,57,43,0.1); color:var(--color-danger); }
.btn-view:hover   { background:var(--pandu-blue); color:#FFF; }
.btn-edit:hover   { background:var(--color-warning); color:#FFF; }
.btn-delete:hover { background:var(--color-danger); color:#FFF; }

.table-pagination {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 20px; border-top: 1px solid var(--gray-100);
}
.pagination-info { font-size: 0.8125rem; color: var(--gray-500); }

.pandu-pagination .page-link {
  border: 1.5px solid var(--gray-200); color: var(--gray-700);
  border-radius: var(--radius-md) !important; margin: 0 2px;
  padding: 6px 12px; font-size: 0.8125rem; font-weight: 600;
}
.pandu-pagination .page-item.active .page-link {
  background: var(--pandu-blue); border-color: var(--pandu-blue);
}
```

---

## 9. BADGE, STATUS & INDIKATOR

### 9.1 Status Badge

```css
.status-badge {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 4px 10px; border-radius: var(--radius-pill);
  font-size: 0.6875rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.5px;
  white-space: nowrap;
}
.status-badge::before {
  content: ''; width: 6px; height: 6px; border-radius: 50%;
  background: currentColor;
}

.status-open            { background:#EBF5FB; color:#117A8B; }
.status-in_review       { background:#EBF5FB; color:#1565C0; }
.status-in_progress     { background:#FEF9E7; color:#E67E22; }
.status-pending_verification { background:#F5EEF8; color:#7D3C98; }
.status-resolved        { background:#EAFAF1; color:#1A7A4A; }
.status-closed          { background:#F2F3F4; color:#495057; }
.status-overdue         { background:#FDEDEC; color:#C0392B; }
.status-emergency       { background:#FDEDEC; color:#C0392B; animation: pulse-bg 1.5s infinite; }
.status-scheduled       { background:#EBF5FB; color:#1E88E5; }
.status-completed       { background:#EAFAF1; color:#1A7A4A; }
.status-cancelled       { background:#F2F3F4; color:#6C757D; }
.status-expired         { background:#FDEDEC; color:#C0392B; }
.status-expiring_soon   { background:#FEF9E7; color:#F57C00; }
.status-active          { background:#EAFAF1; color:#27AE60; }

@keyframes pulse-bg {
  0%, 100% { background: #FDEDEC; }
  50%       { background: rgba(192,57,43,0.15); }
}
```

### 9.2 Risk Level Badge

```css
.risk-badge {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 4px 10px; border-radius: var(--radius-pill);
  font-size: 0.6875rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.5px;
}
.risk-very_low  { background:rgba(39,174,96,0.1);  color:#1A7A4A; }
.risk-low       { background:rgba(130,224,170,0.2); color:#1D6A39; }
.risk-medium    { background:rgba(241,196,15,0.15); color:#A07800; }
.risk-high      { background:rgba(230,126,34,0.15); color:#B9540A; }
.risk-very_high, .risk-critical { background:rgba(192,57,43,0.12); color:#922B21; }
```

### 9.3 Kategori Bahaya Badge

```css
.cat-badge {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 4px 10px; border-radius: var(--radius-pill);
  font-size: 0.75rem; font-weight: 600;
}
.cat-electrical { background:rgba(243,156,18,0.12); color:#B7770D; }
.cat-mechanical { background:rgba(52,73,94,0.1);   color:#2C3E50; }
.cat-chemical   { background:rgba(155,89,182,0.1);  color:#7D3C98; }
.cat-fire       { background:rgba(231,76,60,0.1);   color:#C0392B; }
.cat-biological { background:rgba(39,174,96,0.1);   color:#1A7A4A; }
.cat-ergonomic  { background:rgba(52,152,219,0.1);  color:#1A6FA8; }
```

### 9.4 Priority Indicator

```html
<span class="priority-dot priority-emergency"></span>
<span class="priority-dot priority-urgent"></span>
<span class="priority-dot priority-normal"></span>
```

```css
.priority-dot {
  display: inline-block; width: 10px; height: 10px;
  border-radius: 50%; flex-shrink: 0;
}
.priority-emergency { background:var(--color-danger); animation:pulse 1.5s infinite; }
.priority-urgent    { background:var(--color-warning); }
.priority-normal    { background:var(--color-success); }
```

---

## 10. ALERT & NOTIFIKASI

### 10.1 SweetAlert2 — Konfigurasi Global

```javascript
// resources/js/swal-config.js

// Konfirmasi Hapus
window.confirmDelete = function(url, itemName = 'data ini') {
  Swal.fire({
    title: 'Hapus Data?',
    html: `Anda akan menghapus <strong>${itemName}</strong>.<br>Tindakan ini tidak dapat dibatalkan.`,
    icon: 'warning',
    iconColor: '#C0392B',
    showCancelButton: true,
    confirmButtonColor: '#C0392B',
    cancelButtonColor: '#6C757D',
    confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus!',
    cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
    customClass: {
      popup: 'pandu-swal-popup',
      confirmButton: 'pandu-swal-confirm',
      cancelButton: 'pandu-swal-cancel',
    },
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      // Buat form dan submit
      const form = document.createElement('form');
      form.method = 'POST'; form.action = url;
      form.innerHTML = `
        @csrf @method('DELETE')
      `;
      document.body.appendChild(form);
      form.submit();
    }
  });
};

// Konfirmasi Aksi Penting (Approve, Close, Reject)
window.confirmAction = function({ url, title, text, icon, confirmText, method = 'POST' }) {
  Swal.fire({
    title, html: text, icon,
    showCancelButton: true,
    confirmButtonColor: '#1565C0',
    cancelButtonColor: '#6C757D',
    confirmButtonText: confirmText || 'Ya, Lanjutkan',
    cancelButtonText: 'Batal',
    customClass: { popup: 'pandu-swal-popup' },
  }).then((result) => {
    if (result.isConfirmed) {
      const form = document.createElement('form');
      form.method = 'POST'; form.action = url;
      if (method !== 'POST') {
        form.innerHTML += `<input type="hidden" name="_method" value="${method}">`;
      }
      form.innerHTML += `<input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">`;
      document.body.appendChild(form);
      form.submit();
    }
  });
};

// Konfirmasi Panic Button
window.triggerPanicButton = function() {
  Swal.fire({
    title: '🚨 TOMBOL DARURAT',
    html: `<div style="text-align:center">
      <p style="font-size:1rem;color:#C0392B;font-weight:600">Apakah Anda yakin ingin mengaktifkan alarm darurat?</p>
      <p style="font-size:0.875rem;color:#666">Tim respons cepat akan segera diberitahu. Gunakan hanya dalam keadaan darurat nyata.</p>
    </div>`,
    icon: 'error',
    iconColor: '#C0392B',
    showCancelButton: true,
    confirmButtonColor: '#C0392B',
    cancelButtonColor: '#6C757D',
    confirmButtonText: '🚨 AKTIFKAN DARURAT',
    cancelButtonText: 'Batal',
    customClass: { popup: 'pandu-swal-popup pandu-swal-emergency' },
  }).then((result) => {
    if (result.isConfirmed) {
      // AJAX trigger panic button
    }
  });
};
```

```css
/* Custom SweetAlert2 Styling */
.pandu-swal-popup {
  border-radius: 16px !important;
  font-family: var(--font-primary) !important;
  padding: 28px !important;
}
.pandu-swal-emergency {
  border: 3px solid var(--color-danger) !important;
}
.swal2-title { font-weight: 700 !important; }
.swal2-html-container { font-size: 0.9rem !important; }
```

### 10.2 Flash Message dari Session (Blade)

```html
<!-- Letakkan di akhir <body> layout utama -->
@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session("success") }}',
    timer: 2500,
    timerProgressBar: true,
    showConfirmButton: false,
    toast: false,
    customClass: { popup: 'pandu-swal-popup' },
  });
</script>
@endif

@if(session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session("error") }}',
    confirmButtonColor: '#C0392B',
    confirmButtonText: 'Tutup',
    customClass: { popup: 'pandu-swal-popup' },
  });
</script>
@endif

@if(session('warning'))
<script>
  Swal.fire({
    icon: 'warning',
    title: 'Perhatian!',
    text: '{{ session("warning") }}',
    confirmButtonColor: '#E67E22',
    customClass: { popup: 'pandu-swal-popup' },
  });
</script>
@endif

@if(session('info'))
<script>
  Swal.fire({
    icon: 'info',
    title: 'Informasi',
    text: '{{ session("info") }}',
    confirmButtonColor: '#1565C0',
    customClass: { popup: 'pandu-swal-popup' },
  });
</script>
@endif
```

---

## 11. TOMBOL & CTA

```css
/* Base button reset */
.btn { font-family: var(--font-primary); font-weight: 600; border-radius: var(--radius-md); transition: var(--transition-fast); }

/* Primary */
.btn-pandu-primary {
  background: linear-gradient(135deg, var(--pandu-blue), var(--pandu-blue-light));
  color: #FFF; border: none; padding: 10px 20px;
  box-shadow: 0 4px 14px rgba(21,101,192,0.3);
}
.btn-pandu-primary:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(21,101,192,0.4); color: #FFF;
}
.btn-pandu-primary:active { transform: translateY(0); }

/* Danger */
.btn-pandu-danger {
  background: linear-gradient(135deg, var(--color-danger), var(--color-danger-mid));
  color: #FFF; border: none; padding: 10px 20px;
  box-shadow: 0 4px 14px rgba(192,57,43,0.3);
}
.btn-pandu-danger:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(192,57,43,0.4); color: #FFF;
}

/* Warning/Orange */
.btn-pandu-warning {
  background: linear-gradient(135deg, var(--color-warning), var(--pandu-orange-light));
  color: #FFF; border: none; padding: 10px 20px;
  box-shadow: 0 4px 14px rgba(230,126,34,0.3);
}

/* Success */
.btn-pandu-success {
  background: linear-gradient(135deg, var(--color-success), #27AE60);
  color: #FFF; border: none; padding: 10px 20px;
  box-shadow: 0 4px 14px rgba(26,122,74,0.3);
}

/* Outline */
.btn-pandu-outline {
  background: transparent; color: var(--pandu-blue);
  border: 1.5px solid var(--pandu-blue); padding: 9px 20px;
}
.btn-pandu-outline:hover { background: var(--pandu-blue); color: #FFF; }

/* Ghost */
.btn-pandu-ghost {
  background: var(--gray-100); color: var(--gray-700);
  border: 1.5px solid var(--gray-200); padding: 9px 20px;
}
.btn-pandu-ghost:hover { background: var(--gray-200); color: var(--gray-900); }

/* Panic Button — Special! */
.btn-panic {
  background: linear-gradient(135deg, #C0392B, #E74C3C);
  color: #FFF; border: none;
  padding: 16px 32px; font-size: 1.125rem;
  font-weight: 800; letter-spacing: 1px;
  border-radius: var(--radius-lg);
  box-shadow: 0 8px 25px rgba(192,57,43,0.5);
  animation: panic-pulse 2s infinite;
  width: 100%; text-transform: uppercase;
}

@keyframes panic-pulse {
  0%, 100% { box-shadow: 0 8px 25px rgba(192,57,43,0.5); }
  50%       { box-shadow: 0 12px 35px rgba(192,57,43,0.75); }
}
```

---

## 12. GRAFIK & VISUALISASI DATA

### 12.1 Konfigurasi Chart.js

```javascript
// Warna Palet PANDU K3
const PANDU_CHART = {
  colors: {
    navy:    '#0D2137',
    blue:    '#1565C0',
    blue2:   '#1E88E5',
    orange:  '#E65100',
    orange2: '#F57C00',
    danger:  '#C0392B',
    warning: '#E67E22',
    success: '#1A7A4A',
    info:    '#117A8B',
    gray:    '#ADB5BD',
  },
  gridColor: 'rgba(0,0,0,0.05)',
  fontFamily: "'Plus Jakarta Sans', sans-serif",
};

// Default global
Chart.defaults.font.family = PANDU_CHART.fontFamily;
Chart.defaults.color = '#6C757D';
Chart.defaults.plugins.legend.labels.usePointStyle = true;
Chart.defaults.plugins.legend.labels.padding = 16;
Chart.defaults.plugins.tooltip.backgroundColor = '#0D2137';
Chart.defaults.plugins.tooltip.titleColor = '#FFF';
Chart.defaults.plugins.tooltip.bodyColor = 'rgba(255,255,255,0.8)';
Chart.defaults.plugins.tooltip.padding = 12;
Chart.defaults.plugins.tooltip.cornerRadius = 10;
Chart.defaults.plugins.tooltip.titleFont = { weight: '700', size: 13 };

// Chart Tren Insiden (Line)
const incidentTrendChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
    datasets: [{
      label: 'Insiden',
      data: [...],
      borderColor: PANDU_CHART.colors.danger,
      backgroundColor: 'rgba(192,57,43,0.08)',
      borderWidth: 2.5,
      fill: true,
      tension: 0.4,
      pointBackgroundColor: PANDU_CHART.colors.danger,
      pointRadius: 5, pointHoverRadius: 7,
    }, {
      label: 'Laporan Bahaya',
      data: [...],
      borderColor: PANDU_CHART.colors.warning,
      backgroundColor: 'rgba(230,126,34,0.08)',
      borderWidth: 2.5, fill: true, tension: 0.4,
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { position: 'top' } },
    scales: {
      y: {
        beginAtZero: true,
        grid: { color: PANDU_CHART.gridColor },
        ticks: { stepSize: 1 },
      },
      x: { grid: { display: false } }
    }
  }
});

// Chart Distribusi Bahaya (Doughnut)
const hazardDistChart = new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: ['Listrik','Mekanikal','Kimia','Kebakaran','Ergonomi','Lainnya'],
    datasets: [{
      data: [...],
      backgroundColor: [
        '#F39C12','#2C3E50','#8E44AD','#C0392B','#1A6FA8','#95A5A6'
      ],
      borderWidth: 0, hoverOffset: 8,
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    cutout: '72%',
    plugins: {
      legend: { position: 'right' },
    }
  }
});
```

### 12.2 Risk Matrix Heatmap (HTML/CSS)

```html
<div class="risk-matrix-container">
  <div class="risk-matrix-title">Matriks Risiko 5×5</div>
  <div class="risk-matrix">
    <div class="matrix-y-label">← Keparahan (Severity)</div>
    <div class="matrix-grid">
      <!-- Header Probability -->
      <div class="matrix-corner"></div>
      <div class="matrix-header" v-for="p in 5">P{{p}}</div>
      <!-- Rows S5 → S1 -->
      <!-- Setiap cell berwarna berdasarkan score -->
      <div class="matrix-row-label">S5</div>
      <div class="matrix-cell risk-high">5</div>
      <div class="matrix-cell risk-high">10</div>
      <div class="matrix-cell risk-critical">15</div>
      <div class="matrix-cell risk-critical">20</div>
      <div class="matrix-cell risk-critical">25</div>
      <!-- ... dst S4, S3, S2, S1 -->
    </div>
    <div class="matrix-x-label">Probabilitas (Probability) →</div>
  </div>
</div>
```

```css
.risk-matrix-container { overflow-x: auto; }
.risk-matrix-grid { display: grid; grid-template-columns: 30px repeat(5, 1fr); gap: 4px; }
.matrix-cell {
  aspect-ratio: 1; border-radius: 6px;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.75rem; font-weight: 700; color: #FFF; cursor: default;
  transition: var(--transition-fast);
}
.matrix-cell:hover { transform: scale(1.1); box-shadow: var(--shadow-md); z-index: 1; }
.risk-very_low  { background: var(--risk-very-low); }
.risk-low       { background: var(--risk-low); color: #1D6A39; }
.risk-medium    { background: var(--risk-medium); color: #7A5900; }
.risk-high      { background: var(--risk-high); }
.risk-critical  { background: var(--risk-critical); }
```

---

## 13. DASHBOARD PER PERAN

### 13.1 Super Admin Dashboard

**Layout:** 2 kolom (grafik besar kiri, ringkasan kanan)

**Konten:**
- Header: Selamat datang + tanggal + nama perusahaan
- Row 1: 4 Stat Card (Total Insiden Bulan, KPI LTIFR, Jam Kerja Aman, Hazard Open)
- Row 2: Line Chart Tren 12 Bulan (besar, 8 col) + Ringkasan Eksekutif (4 col)
- Row 3: Bar Chart perbandingan site/area (6 col) + Doughnut distribusi bahaya (6 col)
- Row 4: Tabel insiden terbaru (8 col) + Status CAPA ringkasan (4 col)

### 13.2 HSE Manager Dashboard

**Layout:** 3 kolom fleksibel

**Konten:**
- Row 1: 5 Stat Card mini (Bahaya Open, CAPA Overdue, Inspeksi Due, Sertifikat Expired, Training Bulan)
- Row 2: Alert Cards — bahaya kritis yang belum ditangani (merah)
- Row 3: Line Chart insiden + Bar Chart CAPA status
- Row 4: Tabel HIRADC due review + Tabel Inspeksi terjadwal
- Row 5: Status kepatuhan per divisi (progress bars berwarna)

### 13.3 Supervisor Dashboard

**Layout:** Mobile-friendly, lebih sederhana

**Konten:**
- Row 1: 3 Stat Card (Laporan Baru Area Saya, CAPA Saya, Toolbox Meeting Minggu Ini)
- Row 2: Daftar laporan bahaya terbaru area saya (perlu tindakan)
- Row 3: Checklist inspeksi hari ini (mini card per item)
- Row 4: Status APD divisi + Toolbox meeting bulan ini

### 13.4 Worker Dashboard (Mobile-First)

**Layout:** Single column, besar & mudah tap

**Konten:**
- Greeting card dengan nama + shift
- **TOMBOL BESAR:** [📸 Laporkan Bahaya] [📋 Laporkan Insiden]
- **TOMBOL DARURAT:** [🚨 PANIC BUTTON] — merah mencolok
- Card: Pengumuman keselamatan terbaru
- Card: SOP wajib baca hari ini
- Card: Status laporan saya (3 terbaru)
- Card: Jadwal pelatihan saya

---

## 14. HALAMAN KHUSUS

### 14.1 Halaman Login

```css
/* Login Page — Desain Premium */
.auth-page {
  min-height: 100vh;
  display: grid; grid-template-columns: 1fr 1fr;
  background: var(--bg-page);
}

/* Left Panel — Branding */
.auth-left {
  background: linear-gradient(160deg, var(--pandu-navy) 0%, var(--pandu-navy-mid) 60%, #1A3A5C 100%);
  display: flex; flex-direction: column;
  justify-content: center; align-items: center;
  padding: 60px; position: relative; overflow: hidden;
}
.auth-left::before {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(circle at 20% 20%, rgba(230,81,0,0.15) 0%, transparent 50%),
    radial-gradient(circle at 80% 80%, rgba(21,101,192,0.2) 0%, transparent 50%);
}
/* Pattern grid overlay */
.auth-left::after {
  content: '';
  position: absolute; inset: 0;
  background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
  background-size: 40px 40px;
}

/* Right Panel — Form */
.auth-right {
  display: flex; align-items: center; justify-content: center;
  padding: 40px;
}
.auth-card {
  width: 100%; max-width: 420px;
  background: #FFF; border-radius: var(--radius-xl);
  padding: 40px; box-shadow: var(--shadow-lg);
  border: 1px solid var(--gray-200);
}
```

### 14.2 Halaman Detail Laporan Bahaya

**Konten Section:**
1. **Header Detail** — Nomor laporan, badge status, badge prioritas, tanggal
2. **Timeline/Progress** — Alur status dengan timeline visual
3. **Informasi Laporan** — Grid 2 kolom: Detail bahaya, Lokasi, Pelapor, dll.
4. **Galeri Foto** — Grid foto dengan lightbox
5. **Risk Assessment** — Matriks risiko mini
6. **CAPA Terkait** — Card status CAPA
7. **Riwayat Aktivitas** — Timeline aktivitas dengan ikon

### 14.3 Halaman Panic Button (Worker)

```html
<div class="panic-container">
  <div class="panic-header">
    <div class="panic-status-indicator"></div>
    <h2>SISTEM DARURAT K3</h2>
    <p>Tekan tombol di bawah jika terjadi keadaan darurat</p>
  </div>

  <div class="panic-instruction-cards">
    <div class="panic-tip"><i class="fas fa-fire"></i> Kebakaran</div>
    <div class="panic-tip"><i class="fas fa-person-falling"></i> Kecelakaan</div>
    <div class="panic-tip"><i class="fas fa-biohazard"></i> Tumpahan Kimia</div>
    <div class="panic-tip"><i class="fas fa-hospital"></i> Butuh Pertolongan</div>
  </div>

  <button class="btn-panic" onclick="triggerPanicButton()">
    <i class="fas fa-exclamation-triangle me-3"></i>
    TOMBOL DARURAT
    <i class="fas fa-exclamation-triangle ms-3"></i>
  </button>

  <div class="panic-contacts">
    <h5>Kontak Darurat Langsung</h5>
    <a href="tel:..." class="contact-card"><i class="fas fa-phone"></i> HSE Emergency: 112</a>
    <a href="tel:..." class="contact-card"><i class="fas fa-user-shield"></i> Security: 113</a>
  </div>
</div>
```

---

## 15. RESPONSIF & MOBILE

### 15.1 Breakpoints

```css
/* Menggunakan Bootstrap breakpoints + custom */
/* xs: 0-575px  | sm: 576-767px | md: 768-991px | lg: 992-1199px | xl: 1200px+ */

/* Mobile: Sidebar collapse menjadi overlay */
@media (max-width: 991.98px) {
  .pandu-sidebar {
    transform: translateX(-100%);
    transition: var(--transition-base);
  }
  .pandu-sidebar.show { transform: translateX(0); }
  .pandu-main { margin-left: 0; }
  .sidebar-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.5); z-index: 999;
  }
  .sidebar-overlay.show { display: block; }
}

/* Tabel: horizontal scroll di mobile */
@media (max-width: 767.98px) {
  .pandu-table-wrapper { border-radius: var(--radius-md); }
  .stat-card-number { font-size: 1.75rem; }
  .topbar-search { display: none; }
  .pandu-content { padding: 16px; }
}
```

### 15.2 Worker Interface (Mobile-Optimized)

```css
/* Layout Worker: Full mobile, tombol besar */
.worker-layout { max-width: 480px; margin: 0 auto; }

.worker-action-btn {
  display: flex; align-items: center; justify-content: center;
  gap: 12px; width: 100%;
  padding: 20px 24px; border-radius: var(--radius-lg);
  font-size: 1rem; font-weight: 700; letter-spacing: 0.3px;
  border: none; cursor: pointer; text-decoration: none;
  transition: var(--transition-base);
  box-shadow: var(--shadow-md);
}
.worker-action-btn i { font-size: 1.5rem; }
.worker-action-btn:active { transform: scale(0.97); }
```

---

## 16. ANIMASI & MICROINTERACTION

```css
/* Page Load Animation */
.fade-in-up {
  animation: fadeInUp 0.4s ease both;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* Staggered card loading */
.pandu-card:nth-child(1) { animation-delay: 0.05s; }
.pandu-card:nth-child(2) { animation-delay: 0.1s; }
.pandu-card:nth-child(3) { animation-delay: 0.15s; }
.pandu-card:nth-child(4) { animation-delay: 0.2s; }

/* Loading Skeleton */
.skeleton {
  background: linear-gradient(90deg, var(--gray-100) 25%, var(--gray-200) 50%, var(--gray-100) 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
  border-radius: var(--radius-sm);
}
@keyframes shimmer {
  0%   { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

/* Stat counter animation (dengan JS) */
.counter-animated { transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); }

/* Button loading state */
.btn-loading {
  position: relative; color: transparent !important;
  pointer-events: none;
}
.btn-loading::after {
  content: '';
  position: absolute; width: 16px; height: 16px;
  border: 2px solid rgba(255,255,255,0.3);
  border-top-color: #FFF; border-radius: 50%;
  animation: spin 0.75s linear infinite;
  top: 50%; left: 50%; transform: translate(-50%, -50%);
}
@keyframes spin { to { transform: translate(-50%, -50%) rotate(360deg); } }

/* Tooltip custom */
[data-pandu-tooltip] {
  position: relative; cursor: help;
}
[data-pandu-tooltip]::after {
  content: attr(data-pandu-tooltip);
  position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%);
  background: var(--gray-900); color: #FFF;
  font-size: 0.6875rem; font-weight: 500; padding: 5px 10px;
  border-radius: 6px; white-space: nowrap;
  opacity: 0; pointer-events: none; margin-bottom: 6px;
  transition: var(--transition-fast);
}
[data-pandu-tooltip]:hover::after { opacity: 1; }
```

---

## 17. CSS CUSTOM VARIABLES & UTILITIES

### 17.1 Utility Classes

```css
/* Spacing helpers */
.gap-custom { gap: var(--card-gap); }

/* Text helpers */
.text-pandu-primary { color: var(--pandu-blue) !important; }
.text-pandu-navy    { color: var(--pandu-navy) !important; }
.text-pandu-orange  { color: var(--pandu-orange) !important; }
.text-risk-critical { color: var(--color-danger) !important; font-weight: 700; }

/* Background helpers */
.bg-pandu-navy  { background: var(--pandu-navy) !important; }
.bg-page        { background: var(--bg-page) !important; }
.bg-danger-soft { background: var(--color-danger-light) !important; }
.bg-success-soft{ background: var(--color-success-light) !important; }

/* Divider */
.divider-light {
  border: none; border-top: 1px solid var(--gray-100); margin: 16px 0;
}

/* Icon wrapper */
.icon-box {
  width: 40px; height: 40px; border-radius: var(--radius-md);
  display: inline-flex; align-items: center; justify-content: center;
  font-size: 1rem; flex-shrink: 0;
}
.icon-box-sm { width: 30px; height: 30px; font-size: 0.75rem; }
.icon-box-lg { width: 52px; height: 52px; font-size: 1.25rem; }

/* Scrollbar custom */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb {
  background: var(--gray-300); border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover { background: var(--gray-400); }
```

---

## 18. TEMPLATE LAYOUT UTAMA

### 18.1 app.blade.php — Struktur Lengkap

```html
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') — PANDU K3</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- Custom CSS (inline atau file terpisah) -->
  <style>
    /* Tempel semua CSS dari design-pandu.md di sini */
    /* Atau gunakan: <link rel="stylesheet" href="{{ asset('css/pandu.css') }}"> */
  </style>

  @stack('styles')
</head>
<body>

<div class="pandu-wrapper">

  <!-- Sidebar Overlay (Mobile) -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- SIDEBAR -->
  <aside class="pandu-sidebar" id="panduSidebar">
    @include('layouts.partials.sidebar')
  </aside>

  <!-- MAIN -->
  <div class="pandu-main">

    <!-- TOP BAR -->
    <header class="pandu-topbar">
      @include('layouts.partials.topbar')
    </header>

    <!-- CONTENT -->
    <main class="pandu-content fade-in-up">
      <!-- Page Header -->
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h1 class="page-title mb-1">@yield('page-title')</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pandu-breadcrumb mb-0">
              @yield('breadcrumb')
            </ol>
          </nav>
        </div>
        <div class="d-flex gap-2">
          @yield('page-actions')
        </div>
      </div>

      @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="pandu-footer">
      <span>© {{ date('Y') }} PANDU K3 — Sistem Manajemen K3 Industri</span>
      <span>v1.0.0</span>
    </footer>

  </div><!-- /pandu-main -->

</div><!-- /pandu-wrapper -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
// Sidebar Toggle
const sidebarEl = document.getElementById('panduSidebar');
const overlayEl = document.getElementById('sidebarOverlay');
const toggleBtn = document.getElementById('sidebarToggle');

toggleBtn?.addEventListener('click', () => {
  sidebarEl.classList.toggle('show');
  overlayEl.classList.toggle('show');
});
overlayEl?.addEventListener('click', () => {
  sidebarEl.classList.remove('show');
  overlayEl.classList.remove('show');
});

// SweetAlert Flash Messages
@if(session('success'))
  Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, timerProgressBar:true, showConfirmButton:false, customClass:{popup:'pandu-swal-popup'} });
@endif
@if(session('error'))
  Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#C0392B', customClass:{popup:'pandu-swal-popup'} });
@endif
@if(session('warning'))
  Swal.fire({ icon:'warning', title:'Perhatian!', text:@json(session('warning')), confirmButtonColor:'#E67E22', customClass:{popup:'pandu-swal-popup'} });
@endif
</script>

@stack('scripts')

</body>
</html>
```

```css
/* Footer */
.pandu-footer {
  padding: 16px var(--content-padding);
  border-top: 1px solid var(--gray-200);
  display: flex; justify-content: space-between; align-items: center;
  font-size: 0.75rem; color: var(--gray-500);
  background: var(--bg-card);
}
```

---

### 18.2 Sidebar Menu Lengkap Per Peran

```blade
{{-- resources/views/layouts/partials/sidebar.blade.php --}}

@php
  $role = auth()->user()->role;
@endphp

@if(in_array($role, ['super_admin']))
{{-- SUPER ADMIN MENU --}}
<div class="nav-group-label">ANALITIK</div>
<a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
  <span class="nav-icon"><i class="fas fa-gauge-high"></i></span>
  <span class="nav-text">Dashboard Eksekutif</span>
</a>

<div class="nav-group-label">MANAJEMEN SISTEM</div>
<a href="{{ route('admin.users.index') }}" class="nav-item ...">
  <span class="nav-icon"><i class="fas fa-users-gear"></i></span>
  <span class="nav-text">Manajemen Pengguna</span>
</a>
<a href="{{ route('admin.companies.index') }}" class="nav-item ...">
  <span class="nav-icon"><i class="fas fa-building"></i></span>
  <span class="nav-text">Perusahaan & Lokasi</span>
</a>
{{-- ... dll --}}

@elseif(in_array($role, ['hse_manager']))
{{-- HSE MANAGER MENU --}}
<div class="nav-group-label">UTAMA</div>
{{-- Dashboard, Pelaporan, HIRADC, Inspeksi, CAPA, Audit, dll --}}

@elseif($role === 'supervisor')
{{-- SUPERVISOR MENU --}}

@else
{{-- WORKER MENU --}}
@endif
```

---

*Design-Pandu v1.0.0 — PANDU K3 System*
*Panduan desain ini wajib diikuti oleh seluruh tim frontend untuk menjaga konsistensi UI/UX sistem*
*Palet warna, tipografi, dan komponen yang tertera adalah standar resmi PANDU K3*
