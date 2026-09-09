<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }}</title>

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="description" content="Sistem Informasi Manajemen Operasional dan Layanan Carwash MSWash.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ==========================================
           GLOBAL PAGE BACKGROUND
        ========================================== */
        body {
            background: color-mix(in srgb, #0d6efd 70%, white); /* biru tepi */
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
        }

        /* ==========================================
           WRAPPER LAYOUT
        ========================================== */
        .dashboard-layout {
            display: flex;
            height: 100%;
            width: 100%;
        }

        /* ==========================================
           CONTENT AREA
        ========================================== */
        main {
            flex: 1;
            height: 100%;
            padding: 0 !important;
            background: transparent !important;
        }

        /* Card container (slot) */
        .card-container {
            width: 100%;
        }

        .dashboard-inner {
            width: 100%;
            min-height: 100vh;
            height: auto;
            background: #ffffff;

            border-radius: 60px 0 0 60px;
            padding: 30px 40px;

            box-sizing: border-box;
            margin-bottom: 40px;
        }

        /* Hilangkan garis putih di samping sidebar */
        .dashboard-layout {
            border: none !important;
        }

        .sidebar-modern {
            border-right: none !important;
            box-shadow: none !important;
        }
        .page-stabilizer {
    position: fixed;
    inset: 0;
    background: color-mix(in srgb, #0d6efd 70%, white);
    z-index: 0;
}

.dashboard-layout {
    position: relative;
    z-index: 1;
}
@media (max-width: 768px) {
    main {
        margin-left: 0 !important;
        width: 100%;
    }

    main {
        width: 100%;
    }

    .dashboard-inner {
        border-radius: 24px;
        padding: 16px;
    }
    }

.burger-btn {
    position: fixed;
    top: 16px;
    left: 16px;
    z-index: 1300;
    background: #ffffff;
    border: none;
    border-radius: 12px;
    padding: 10px 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
}
/* ===== OVERLAY ===== */
.sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.35);
    z-index: 1190;
    opacity: 0;
    pointer-events: none;
    transition: .3s;
}

body.sidebar-open .sidebar-overlay {
    opacity: 1;
    pointer-events: auto;
}

/* kunci scroll */
body.sidebar-open {
    overflow: hidden;
}

/* =========================
   MOBILE CLEAN MODE
========================= */
@media (max-width: 768px) {

    /* ❌ matikan background biru body */
    body {
        background: #ffffff !important;
    }

    /* ❌ matikan layer biru */
    .page-stabilizer {
        display: none !important;
    }

    /* ❌ hilangkan lengkungan */
    .dashboard-inner {
        border-radius: 0 !important;
        padding: 12px 20px 20px 20px;
        margin-bottom: 0;
        min-height: 100dvh;
    }

    /* ✅ pastikan full tinggi layar */
    main {
        min-height: 100dvh;
    }
}
/* icon default */
.burger-btn .close-icon {
    display: none;
}

/* saat sidebar terbuka */
body.sidebar-open .burger-btn .burger-icon {
    display: none;
}

body.sidebar-open .burger-btn .close-icon {
    display: inline;
}

.mobile-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;

    height: 56px;
    background: #5d9cff;

    z-index: 1300;
}
@media (max-width: 768px) {
    .mobile-header {
        position: relative !important; /* ⬅️ ini kuncinya */
    }
}

/* logo BENAR-BENAR TENGAH */
.mobile-logo {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}

.mobile-logo img {
    height: 26px;
    object-fit: contain;
}

/* burger */
.mobile-header .burger-btn {
    position: static;
    background: #ffffff;
    border: none;
    border-radius: 10px;
    width: 40px;
    height: 40px;

    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 12px;

    box-shadow: 0 4px 10px rgba(0,0,0,.15);
}
@media (max-width: 768px) {
    .dashboard-inner h1,
    .dashboard-inner h2,
    .dashboard-inner h3,
    .dashboard-inner h4,
    .dashboard-inner h5 {
        margin-top: 0 !important;
    }
}
/* =========================
   DESKTOP MODE (ikon tetap ada)
========================= */
@media (min-width: 769px) {

    /* header tidak fixed di desktop */
    .mobile-header {
        position: relative !important;
        height: auto;
        background: transparent;
        padding: 16px 24px;
    }

    /* tombol ikut alur layout */
    .mobile-burger {
        position: relative !important;
        left: auto;
        top: auto;
        transform: none;
        box-shadow: none;
    }
}
.mobile-header {
    display: flex;
    align-items: center;
    height: 68px;
    padding: 0 14px;
    background: #5d9cff;
    gap: 10px;
}
.mobile-burger {
    flex-shrink: 0;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: #fff;
    border: none;

    display: flex;
    align-items: center;
    justify-content: center;
}
.mobile-profile {
    flex-shrink: 0;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #ffffff;
    color: #2563eb;

    display: flex;
    align-items: center;
    justify-content: center;

    font-weight: 700;
}
.mobile-title-wrapper {
    flex: 1;
    min-width: 0; /* 🔥 WAJIB */
    overflow: hidden;
}
.mobile-title {
    font-weight: 600;
    color: #ffffff;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.mobile-subtitle {
    font-size: 11px;
    line-height: 1.1;
    color: rgba(255,255,255,.85);
    margin-top: 2px;
}
@media (max-width: 768px) {
    .mobile-header {
        background: linear-gradient(
            135deg,
            #698ec7
        #5c9cff 
        #4a8cf5    /* biru dalam */
        );

        display: flex;
        align-items: center;
        height: 56px;
        padding: 0 14px;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    /* aksen air */
    .mobile-header::after {
        content: "";
        position: absolute;
        bottom: -24px;
        left: -30%;
        width: 160%;
        height: 44px;
        background: rgba(255,255,255,.18);
        border-radius: 100%;
        filter: blur(12px);
    }
}

    </style>
</head>

<body class="font-sans antialiased">
<div class="mobile-header d-md-none">

    <button class="mobile-burger" onclick="toggleSidebar()" aria-label="Buka Menu">
        <i class="bi bi-list"></i>
    </button>

    <div class="mobile-title-wrapper">
        <div class="mobile-title">MSWash</div>
         <div class="mobile-subtitle">Operasional Carwash Lebih Efisien</div>
    </div>

    <div class="mobile-profile">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>

</div>



<div class="page-stabilizer"></div>
<div class="dashboard-layout">

    {{-- =================== SIDEBAR =================== --}}
    @include('layouts.navigation')

    {{-- =================== PAGE CONTENT =================== --}}
    <main>
        <div class="dashboard-inner">
            {{ $slot }}
        </div>
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    document.body.classList.toggle('sidebar-open');
    document.querySelector('.sidebar-modern').classList.toggle('show');
}

function closeSidebar() {
    document.body.classList.remove('sidebar-open');
    document.querySelector('.sidebar-modern').classList.remove('show');
}
</script>


</body>
</html>
