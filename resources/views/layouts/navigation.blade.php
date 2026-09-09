<div class="sidebar-modern px-3 py-4">
<style>
/* ================= SIDEBAR ================= */
.sidebar-modern {
    width: 230px;
    height: 100vh;
    background: color-mix(in srgb, #0d6efd 70%, white);
    padding: 18px 14px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.sidebar-dropdown {
    margin-bottom: 10px; /* ⬅️ Ini bagian yang kamu tambah */
}
/* ================= SCROLL AREA ================= */
.sidebar-menu {
    flex: 1;
    overflow-y: auto;
    padding-right: 4px;
    visibility: hidden; /* ⬅️ anti kedip */
}

/* Scrollbar */
.sidebar-menu::-webkit-scrollbar { width: 6px; }
.sidebar-menu::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,.3);
    border-radius: 6px;
}

/* ================= LOGO ================= */
.sidebar-brand {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
}
.sidebar-brand img {
    width: 160px;
    transform: scale(1.25);
}

/* ================= TITLE ================= */
.sidebar-title {
    color: rgba(255,255,255,.7);
    font-size: 11px;
    font-weight: 600;
    margin: 8px 6px 6px;
}

/* ================= ITEM ================= */
.sidebar-link,
.dropdown-toggle-custom {
    padding: 8px 12px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,.14);
    color: rgba(255,255,255,.9);
    margin-bottom: 6px;
    font-size: 14px;
    border: 1px solid rgba(255,255,255,.18);
    transition: .25s;
}

.sidebar-link:hover,
.dropdown-toggle-custom:hover {
    background: rgba(255,255,255,.35);
}

/* ACTIVE */
.sidebar-link.active,
.dropdown-toggle-custom.active {
    background: #ffffff;
    color: #2563eb;
    font-weight: 600;
}

/* ================= DROPDOWN ================= */
.dropdown-menu-custom {
    display: none;
    flex-direction: column;
    margin-left: 10px;
    margin-top: 6px;
    gap: 6px;
}
.dropdown-menu-custom.show {
    display: flex;
}

.sidebar-sublink {
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 13px;
    color: rgba(255,255,255,.9);
    transition: .25s;
}
.sidebar-sublink:hover {
    background: rgba(255,255,255,.2);
    padding-left: 16px;
}
.sidebar-sublink.active {
    background: #ffffff;
    color: #2563eb;
    font-weight: 600;
}

/* ================= LOGOUT ================= */
.sidebar-link.logout {
    background: rgba(255,255,255,.2);
    color: #ef4444;
    border: 2px solid rgba(239,68,68,.6);
    font-weight: 600;
}
/* ============================
   MOBILE SIDEBAR MODE
============================ */
@media (max-width: 768px) {
    .sidebar-modern {
        position: fixed;
        top: -100vh;
        left: 0;
 background: linear-gradient(
        180deg,
        #6fa8ff 0%,
        #5c9cff 40%,
        #4a8cf5 100%
    );
        width: 100%;
        height: 100dvh;
        z-index: 1300;
        transition: top .35s ease;
        border-radius: 0;
    }

    .sidebar-modern.show {
        top: 0;
    }
    .sidebar-link,
    .dropdown-toggle-custom {
        font-size: 16px;       /* 🔥 font dibesarkan */
        padding: 14px 18px;    /* 🔥 kotakan lebih besar */
        margin-bottom: 12px;   /* 🔥 spasi antar menu */
        gap: 12px;             /* jarak icon-ke-text */
        border-radius: 10px;
    }

    /* Dropdown submenu */
    .sidebar-sublink {
        font-size: 15px;       /* 🔥 sub-menu lebih besar */
        padding: 12px 20px;
        margin-bottom: 10px;
        border-radius: 10px;
    }
    .sidebar-dropdown {
        margin-bottom: 18px;
    }
}
/* =========================
   MOBILE: HILANGKAN LOGO
========================= */
@media (max-width: 768px) {
    .sidebar-brand {
        display: none !important;
    }
}
/* =========================
   MOBILE: JARAK MENU ATAS
========================= */
@media (max-width: 768px) {
    .sidebar-menu > .sidebar-link:first-child {
        margin-top: 26px; /* atur jarak ke bawah */
    }
}
</style>

{{-- LOGO --}}
<div class="sidebar-brand">
    <img src="/logo-icon.png" alt="MSWash">
</div>

<small class="sidebar-title">NAVIGASI</small>

<div class="sidebar-menu">

    <a href="{{ route('dashboard') }}"
       class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <small class="sidebar-title">MENU UTAMA</small>

    <a href="{{ route('produk.index',['kategori'=>'layanan']) }}"
       class="sidebar-link {{ request('kategori')==='layanan'?'active':'' }}">
        <i class="bi bi-droplet-half"></i> Daftar Layanan
    </a>

    <a href="{{ route('produk.index',['kategori'=>'stok']) }}"
       class="sidebar-link {{ request('kategori')==='stok'?'active':'' }}">
        <i class="bi bi-box-seam"></i> Daftar Stok
    </a>

    <a href="{{ route('karyawan.index') }}"
       class="sidebar-link {{ request()->is('karyawan*')?'active':'' }}">
        <i class="bi bi-person-badge"></i> Karyawan
    </a>

    <a href="{{ route('pesanan.index') }}"
       class="sidebar-link {{ request()->is('pesanan*')?'active':'' }}">
        <i class="bi bi-receipt"></i> Transaksi
    </a>

    <a href="{{ route('kasbon.index') }}"
       class="sidebar-link {{ request()->is('kasbon*')?'active':'' }}">
        <i class="bi bi-cash"></i> Kasbon
    </a>

    {{-- DROPDOWN LAPORAN --}}
    <div class="sidebar-dropdown">
        <div id="dropdownLaporan"
             class="dropdown-toggle-custom {{ request()->is('pemasukan*','pengeluaran*','stok*','bagi-hasil.laporan') ? 'active' : '' }}">
            <i class="bi bi-file-text"></i> Laporan
            <i class="bi bi-chevron-down ms-auto"></i>
        </div>

        <div class="dropdown-menu-custom {{ request()->is('pemasukan*','pengeluaran*','stok*','bagi-hasil.laporan') ? 'show' : '' }}">
            <a href="{{ route('pemasukan.index') }}"
               class="sidebar-sublink {{ request()->is('pemasukan*')?'active':'' }}">Pemasukan</a>

            <a href="{{ route('pengeluaran.index') }}"
               class="sidebar-sublink {{ request()->is('pengeluaran*')?'active':'' }}">Pengeluaran</a>

            <a href="{{ route('stok.index') }}"
               class="sidebar-sublink {{ request()->is('stok*')?'active':'' }}">Stok</a>

@if(Auth::user()->role === 'pemilik')
            <a href="{{ route('bagi-hasil.laporan') }}"
               class="sidebar-sublink {{ request()->is('bagi-hasil.laporan')?'active':'' }}">Bagi Hasil</a>@endif
        </div>
    </div>

    <a href="{{ route('bagi-hasil.index') }}"
       class="sidebar-link {{ request()->routeIs('bagi-hasil.index') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-line"></i> Bagi Hasil
    </a>

    <div class="mt-auto pt-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="sidebar-link logout w-100 text-start"
        onclick="sessionStorage.clear()">
    <i class="bi bi-box-arrow-right"></i> Logout
</button>
        </form>
    </div>

</div>
</div>

<script>
const sidebar = document.querySelector('.sidebar-menu');
const dropdownBtn = document.getElementById('dropdownLaporan');
const dropdownMenu = dropdownBtn?.nextElementSibling;

if (sidebar) {
    const scrollPos = sessionStorage.getItem('sidebarScroll');
    const dropdownOpen = sessionStorage.getItem('laporanOpen') === 'true';

    requestAnimationFrame(() => {

        // restore dropdown
        if (dropdownBtn && dropdownMenu && dropdownOpen) {
            dropdownBtn.classList.add('active');
            dropdownMenu.classList.add('show');
        }

        // restore scroll
        if (scrollPos !== null) {
            sidebar.scrollTop = scrollPos;
        }

        // ⬅️ tampilkan sidebar (anti kedip)
        sidebar.style.visibility = 'visible';
    });

    sidebar.addEventListener('scroll', () => {
        sessionStorage.setItem('sidebarScroll', sidebar.scrollTop);
    });
}

// toggle dropdown manual
dropdownBtn?.addEventListener('click', e => {
    e.preventDefault();
    const open = dropdownMenu.classList.toggle('show');
    dropdownBtn.classList.toggle('active', open);
    sessionStorage.setItem('laporanOpen', open);
});

// submenu jangan nutup dropdown
document.querySelectorAll('.sidebar-sublink').forEach(link => {
    link.addEventListener('click', () => {
        sessionStorage.setItem('laporanOpen', 'true');
    });
});

</script>
