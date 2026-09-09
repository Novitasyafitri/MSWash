<x-app-layout :title="'Dashboard Kasir'">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ============================================================
   GLOBAL FONT
============================================================ */
body {
    font-family: 'Poppins', sans-serif !important;
}

/* ============================================================
   TOPBAR
============================================================ */
.topbar-modern {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 1.5rem;
}

.topbar-modern .search-box {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    border-radius: 999px;
    padding: 8px 14px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
    flex: 1;
    max-width: 420px;
}

.topbar-modern .search-box i {
    font-size: 16px;
    color: #9ca3af;
}

.topbar-modern .search-box input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 14px;
    color: #111827;
}

.topbar-modern .search-box input::placeholder {
    color: #9ca3af;
    font-weight: 400;
}

/* ============================================================
   CARD & LAYOUT STYLING
============================================================ */
.summary-card,
.pemasukan-row,
.chart-card,
.donut-card,
.card-detail,
.modern-card {
    font-family: 'Poppins', sans-serif !important;
}

/* Kartu umum – gaya profesional */
.modern-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
}

.card-header-title {
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.02em;
    text-transform: uppercase;
    color: #6b7280;
}
.summary-item {
    padding: 8px 0;
    border-bottom: 1px dashed #e5e7eb;
}
.summary-card h6 {
    color: #2563eb;
    font-weight: 700;
}
.item-title {
    font-size: 14px;
    color: #374151;
}

.pemasukan-row {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 3px 10px rgba(0,0,0,0.03);
    padding: 18px 20px;
}

.subtotal-box .label {
    color: #6b7280;
    font-size: 13px;
}

.subtotal-box .value {
    color: #111827;
    font-weight: 600;
    font-size: 15px;
}

.modal-body {
    padding: 12px 18px !important;
}

/* ============================================================
   STAT CARDS (Pemasukan / Pengeluaran / Pesanan)
============================================================ */
.card-detail {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 18px 20px;
    min-height: 110px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}

.card-detail .card-header-title {
    font-size: 13px;
    text-transform: none;
    margin-bottom: 4px;
    color: #4b5563;
}

.card-detail h4 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #111827;
}

.icon-detail {
    font-size: 22px;
}

.btn-circle-sm {
    border-radius: 999px;
    width: 28px;
    height: 28px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    line-height: 1;
}

.btn-primary-light {
    background: #eff6ff;
    border-color: #dbeafe;
    color: #1d4ed8;
}

.btn-danger-light {
    background: #fef2f2;
    border-color: #fee2e2;
    color: #b91c1c;
}

/* ============================================================
   DONUT CHART WRAPPER
============================================================ */
.chart-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}

.chart-card h5 {
    font-size: 15px;
    margin-bottom: 10px;
    color: #111827;
}

.donut-card {
    min-height: 260px;
}

.donut-wrapper {
    background: transparent;
    border-radius: 18px;
    padding: 0;
    border: none;
    box-shadow: none;
    height: 100%;
}

.donut-wrapper canvas {
    height: 220px !important;
}

#donutChart {
    height: 220px !important;
    width: 100% !important;
}

/* ===============================
   CARD GLASS EFFECT (LIGHT MODE)
=============================== */

/* LIGHT MODE (normal) */
.modern-card,
.card-detail,
.chart-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
}
.dashboard-inner {
    background: #eef1f6 !important;
}
/* Light mode pnl box */
/* Wave biru pada card total saldo */
.card-wave {
    position: relative;
    overflow: hidden;
}

.card-wave::before {
    content: "";
    position: absolute;
    top: -40px;
    left: -60px;
    width: 280px;
    height: 280px;
    background: #2563eb;
    border-radius: 50%;
    filter: blur(90px);
    opacity: 0.18;
    z-index: 0;
}

/* Wave kedua */
.card-wave::after {
    content: "";
    position: absolute;
    bottom: -50px;
    right: -50px;
    width: 220px;
    height: 220px;
    background: #1e40af;
    border-radius: 50%;
    filter: blur(110px);
    opacity: 0.15;
    z-index: 0;
}

/* Pastikan isi card tetap tampil di atas wave */
.card-wave > * {
    position: relative;
    z-index: 2;
}
/* HILANGKAN BAYANGAN BIRU (WAVE) TOTAL */
.card-wave::before,
.card-wave::after {
    display: none !important;
}
/* Foto Profil */
.welcome-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.7);
    box-shadow: 0 4px 10px rgba(0,0,0,0.25);
}
/* Dropdown */
.profile-dropdown {
    position: absolute;
    top: 70px;
    right: 25px;
    background: #ffffff;
    border-radius: 10px;
    padding: 8px;
    display: none;
    flex-direction: column;
    min-width: 150px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    z-index: 50;
}

.profile-dropdown a {
    padding: 8px;
    border-radius: 6px;
    font-size: 14px;
    color: #111827;
    text-decoration: none;
}

.profile-dropdown a:hover {
    background: #f3f4f6;
}

.profile-dropdown.show {
    display: flex;
}
/* ===============================
   WELCOME BOX CONTAINER (TOPBAR)
=============================== */
.welcome-box {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
    padding: 14px 24px;

    /* === Background putih soft (glass) === */
    background: rgba(255, 255, 255, 0.55);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);

    /* === Border biru soft === */
    border: 2px solid rgba(37, 99, 235, 0.40); /* biru lembut */

    border-radius: 16px;

    /* Shadow lembut */
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.12);

    margin-bottom: 20px;
}

/* ===============================
   TEXT SECTION
=============================== */
.welcome-horizontal {
    display: flex;
    align-items: center;
    gap: 6px;
    line-height: 1.2;
}

.welcome-small {
    font-size: 16px;
    color: #4b5563;
    font-weight: 500;
}

.welcome-name {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
}

/* ===============================
   AVATAR CIRCLE
=============================== */
.avatar-circle {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #2563eb;
    color: #fff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);
}

/* ===============================
   ANIMASI MASUK DARI KANAN (SEKALI SAJA)
=============================== */
.welcome-scroll-container {
    width: 100%;
    overflow: hidden;
    position: relative;
    height: 40px;
    display: flex;
    align-items: center;
}

/* TEKS BERGERAK FULL KOTAK */
.welcome-scroll-text {
    position: absolute;
    white-space: nowrap;
    min-width: 100%;
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 0.3px;
    color: #374151;
}

/* MASUK SEKALI */
.welcome-scroll-text.enter {
    animation: enterSoft 0.3s ease-out forwards;
}

/* JALAN NORMAL (TIDAK RESET) */
.welcome-scroll-text.run {
    animation: scrollFull 14s linear infinite;
}

/* ===============================
   MINI GRAPH DI CARD SALDO
=============================== */
.card-saldo-graph {
    position: relative;
    overflow: hidden;
}

/* canvas grafik jadi background */
#saldoMiniChart {
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100% !important;
    height: 65% !important;

    opacity: 0.35;          /* halus */
    pointer-events: none;
    z-index: 0;
}

/* isi card di atas grafik */
.card-saldo-graph > * {
    position: relative;
    z-index: 2;
}
/* Animasi masuk pertama */
@keyframes enterSoft {
    0% { opacity: 0; transform: translateX(100%); }
    100% { opacity: 1; transform: translateX(0); }
}

/* Animasi jalan 1 arah penuh */
@keyframes scrollFull {
    0%   { transform: translateX(100vw); }
    100% { transform: translateX(-100%); }
}
/* ===============================
   FIX: BACKDROP BIKIN GELAP
=============================== */

/* backdrop bootstrap → lebih terang */
.modal-backdrop.show {
    background: rgba(0, 0, 0, 0.25); !important;
}

#modalAksiStok .modal-content {
    opacity: 1 !important;
    filter: none !important;
}
/* ===============================
   FIX TOTAL: TOMBOL GA BISA DIKLIK
=============================== */

/* backdrop jangan nangkap klik */
.modal-backdrop {
    pointer-events: none !important;
}

/* modal aksi stok HARUS bisa nerima klik */
#modalAksiStok,
#modalAksiStok * {
    pointer-events: auto !important;
}

/* ===============================
   BLUR BACKGROUND SAAT MODAL (FINAL)
=============================== */
.modal-blur-layer {
    position: fixed;
    inset: 0;
    backdrop-filter: blur(6px) saturate(120%);
    -webkit-backdrop-filter: blur(6px) saturate(120%);
    background: rgba(0, 0, 0, 0.25);;
    z-index: 1048;
    display: none;
    pointer-events: none;
}

/* 🔥 AKTIF UNTUK SEMUA MODAL (TERMASUK MODAL KE-2 / KE-3) */
body:has(.modal.show) .modal-blur-layer {
    display: block;
}

/* modal selalu di atas blur */
.modal {
    z-index: 1055 !important;
}

/* modal aksi stok paling atas */
#modalAksiStok {
    z-index: 1060 !important;
}

/* isi modal tetap tajam */
.modal-content,
.modal-content * {
    filter: none !important;
    backdrop-filter: none !important;
}
.summary-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}
.summary-card .summary-item:last-child {
    border-bottom: none;
}
.summary-card h6 {
    position: relative;
    padding-bottom: 10px;
    margin-bottom: 14px;
}

.summary-card h6::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(
        90deg,
        #2563eb,
        rgba(37, 99, 235, 0.2)
    );
    border-radius: 999px;
}
/* 🔥 FIX TEKS PANJANG DI RINGKASAN */
.summary-card,
.summary-item {
    overflow-wrap: anywhere;
    word-break: break-word;
    white-space: normal;
}
/* ===============================
   FIX WELCOME BOX KENA BURGER (MOBILE ONLY)
=============================== */
@media (max-width: 768px) {
    .welcome-box {
        margin-top: 12px; /* turunin di HP */
    }
    
}
/* ===============================
   FIX MODAL PEMASUKAN & PENGELUARAN (HP)
=============================== */
@media (max-width: 768px) {
    .modal-body,
    .offcanvas-body,
    .drawer-body {
        padding-top: 72px; /* tinggi header modal */
    }
}
@media (max-width: 600px) {
    main {
        padding-top: 0 !important;
    }

    .dashboard-inner {
        padding-top: 16px !important; /* jarak napas ideal */
    }
}

</style>

<script>
function toast(msg, color = "#2563eb") {
    Toastify({
        text: msg,
        duration: 3000,
        gravity: "top",
        position: "right",
        close: true,

        style: {
            background: color,
            fontFamily: "Poppins, sans-serif",
            borderRadius: "12px",
            padding: "14px 22px",
            fontSize: "15px",
            fontWeight: "500",
            boxShadow: "0 8px 20px rgba(0,0,0,0.18)",
            letterSpacing: "0.3px",
        },

        offset: {
            x: 20,
            y: 20
        },

        stopOnFocus: true,
    }).showToast();
}
</script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

{{-- ================= TOPBAR ================= --}}
<div class="welcome-box">

    <div class="welcome-scroll-container">
       <div class="welcome-scroll-text enter" id="welcomeText">
            Selamat Datang, <b>{{ Auth::user()->role }}</b>
        </div>
    </div>

    <button id="avatarBtn" class="avatar-circle">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </button>

    
</div>

{{-- ================= BARIS ATAS: SALDO + DONUT ================= --}}
<div class="row g-4 mb-4 align-items-stretch mt-4">

    <div class="col-lg-7">
<div class="modern-card card-colored card-saldo-graph h-100 p-4 d-flex flex-column justify-content-between">

 <canvas id="saldoMiniChart"></canvas>

    <div class="card-header-title">Total Saldo (Estimasi)</div>

    <div class="d-flex justify-content-between align-items-end mt-3">

        <div class="fw-bold" style="font-size: 28px;">
            Rp {{ number_format( $saldoBerjalan ?? 0,0,',','.') }}
        </div>

        <small class="text-success fw-bold">
    Rp {{ number_format($pemasukanHariIni ?? 0,0,',','.') }}
</small>


    </div>

</div>

    </div>

    <div class="col-lg-5">
        <div class="chart-card donut-card h-100">
            <h5 class="fw-bold mb-2">Analisis Kategori</h5>
            <div class="donut-wrapper">
                <canvas id="donutChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ================= KOTAK PEMASUKAN / PENGELUARAN / PESANAN ================= --}}
<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="modern-card card-detail h-100">
            <div>
                <i class="bi bi-arrow-up-circle-fill text-success icon-detail mb-2"></i>
                <div class="card-header-title">Total Pemasukan</div>
                <h4 class="mt-1">Rp {{ number_format($pemasukanTotal?? 0,0,',','.') }}</h4>
            </div>
            <div class="mt-2">
                <button class="btn btn-sm btn-primary-light btn-circle-sm"
                    data-bs-toggle="modal" data-bs-target="#modalPemasukan">+</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="modern-card card-detail h-100">
            <div>
                <i class="bi bi-arrow-down-circle-fill text-danger icon-detail mb-2"></i>
                <div class="card-header-title">Total Pengeluaran</div>
                <h4 class="mt-1">Rp {{ number_format( $pengeluaranTotal ?? 0,0,',','.') }}</h4>
            </div>
            <div class="mt-2">
                <button class="btn btn-sm btn-danger-light btn-circle-sm"
                    data-bs-toggle="modal" data-bs-target="#modalPengeluaran">+</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="modern-card card-detail h-100">
            <div>
                <i class="bi bi-cart-check-fill text-info icon-detail mb-2"></i>
                <div class="card-header-title">Cucian Masuk</div>
                <h4 class="mt-1">{{ $totalPesanan ?? 0 }}</h4>
            </div>
        </div>
    </div>

</div>
{{-- ======================================================================================
                                    MODAL PEMASUKAN
   ====================================================================================== --}}
<div class="modal fade" id="modalPemasukan" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('pemasukan.store') }}"
              class="modal-content" id="formPemasukan">
            @csrf

            <div class="modal-header border-0">
                <h5 class="card-header-title mb-0">Tambah Pemasukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
<div class="modal-body row gx-4 gy-2">
    <!-- ================= LEFT: INPUT FORM ================= -->
    <div class="col-md-8 pe-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0 fw-bold">Daftar Item</h6>
            <button type="button" id="btnAddPemasukan"
                class="btn btn-sm btn-primary">Tambah Baris</button>
        </div>

        <div id="itemsContainer"></div>

       <div class="subtotal-box mt-3 text-end">
    <span class="label">Total</span>
    <span id="subtotalDisplay" class="value">Rp 0</span>
</div>

    </div>

    <!-- ================= RIGHT: SUMMARY CARD ================= -->
    <div class="col-md-4 ps-3">
        <div class="summary-card p-3">
            <h6 class="fw-bold mb-3">Ringkasan</h6>

            <div id="summaryList" class="small"></div>
        </div>
    </div>

</div>

            
            <div class="modal-footer border-0 d-flex justify-content-start">
    <button class="btn btn-success px-4" type="submit">Simpan</button>
</div>


        </form>
    </div>
</div>

{{-- ======================================================================================
                                    MODAL PENGELUARAN
   ====================================================================================== --}}
<div class="modal fade" id="modalPengeluaran" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('pengeluaran.store') }}"
              class="modal-content" id="formPengeluaran">
            @csrf

            <div class="modal-header border-0">
                <h5 class="card-header-title mb-0">Tambah Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row gx-4 gy-2">

    <!-- LEFT FORM -->
    <div class="col-md-8 pe-3">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0 fw-bold">Daftar Pengeluaran</h6>
        </div>

        <div id="pengeluaranRows"></div>

        <div class="mt-3 text-end fw-semibold" id="totalPengeluaranWrapper">
    Total: <span id="totalPengeluaranDisplay">Rp 0</span>
</div>

    </div>

    <!-- RIGHT SUMMARY CARD -->
    <div class="col-md-4 ps-3">
        <div class="summary-card p-3">
            <h6 class="fw-bold mb-3">Ringkasan</h6>

            <div id="summaryListPengeluaran" class="small"></div>
        </div>
    </div>

</div>

            <div class="modal-footer border-0 d-flex justify-content-start">
    <button class="btn btn-success px-4" type="submit">Simpan</button>
</div>


        </form>
    </div>
</div>
<!-- Modal Aksi Stok -->
<div class="modal fade" id="modalAksiStok" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">

            <p class="text-center mb-3">
                Barang <span id="aksiStokNama" class="fw-bold"></span> sudah ada di stok.
            </p>

            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success w-50" id="btnStokTambah">
                    Tambah Stok
                </button>

                <button type="button" class="btn btn-danger w-50" id="btnStokKurangi">
                    Kurangi Stok
                </button>
            </div>

        </div>
    </div>
</div>


{{-- ============================ SCRIPTS (modal pemasukan + pengeluaran) ============================ --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    const formatRp = n => new Intl.NumberFormat('id-ID').format(Number(n || 0));
    const toNumber = v => parseFloat(v || 0);

    /* =========================================================
                    PEMASUKAN — FINAL FIX (modal)
    ========================================================= */
    (function () {
    const container = document.getElementById('itemsContainer');
    const btnAdd = document.getElementById('btnAddPemasukan');
    const subtotalDisplay = document.getElementById('subtotalDisplay');

    let nextId = 1;

    function recalcSubtotal() {
    let sum = 0;

    container.querySelectorAll('.pemasukan-row').forEach(row => {
        if (row.dataset.active !== "1") return;

        const val = parseFloat(
            row.querySelector('.total-input')?.value || 0
        );
        sum += val;
    });

    subtotalDisplay.textContent = "Rp " + sum.toLocaleString("id-ID");
}
function renumberItems() {
    container.querySelectorAll('.pemasukan-row').forEach((row, index) => {
        const title = row.querySelector('.item-title');
        if (title) {
            title.textContent = `Item ${index + 1}`;
        }
    });
}

    function createRow() {
        const id = nextId++;
        const div = document.createElement('div');
        div.className = "modern-card p-3 mb-3 pemasukan-row";
        div.dataset.active = "1";
        div._isDeleted = false; 

        div.innerHTML = `
            <div class="item-title mb-2 fw-semibold">Item</div>

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Kategori</label>
                    <select name="items[${id}][kategori]"
                            class="form-select kategoriSelect" required>
                        <option value="">Pilih</option>
                        <option value="layanan">Layanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control"
                           name="items[${id}][tanggal]"
                           value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Total</label>
                    <input type="number" class="form-control total-input" readonly>
                </div>

                <div class="col-12 mt-2 detail-col"></div>

                <!-- TOMBOL BAWAH -->
                <div class="col-12 mt-3 d-flex justify-content-start">
    <button type="button" class="btn btn-outline-danger btn-sm removeRow">
        Hapus
    </button>

<!--
<button type="button" class="btn btn-success btn-sm saveRow">
    Simpan
</button>
-->

                </div>

            </div>
        `;

        const kategori = div.querySelector('.kategoriSelect');
        const detailCol = div.querySelector('.detail-col');
        const totalInput = div.querySelector('.total-input');
     
        kategori.addEventListener('change', async () => {
            div.dataset.active = "1";
            const val = kategori.value;
            detailCol.innerHTML = "";

            /* =================== LAYANAN =================== */
 if (val === "layanan") {
    const res = await fetch('/api/produk/layanan');
    const data = await res.json();

    let opsi = data.map(p =>
        `<option value="${p.id}" data-harga="${p.harga}">${p.nama}</option>`
    ).join("");

    detailCol.innerHTML = `
        <label class="form-label">Jenis Layanan</label>
        <select class="form-select produkSelect"
        name="items[${id}][produk_id]"
        size="4"
        required>

            <option value="">-- pilih layanan --</option>
            ${opsi}
        </select>

        <label class="form-label mt-2 plat-label">Plat</label>
        <input type="text" class="form-control platInput"
               name="items[${id}][plat]" required>

        <input type="hidden" name="items[${id}][qty]" value="1">
    `;

    const produkSelect = div.querySelector('.produkSelect');
    const platInput = div.querySelector('.platInput');
    // === Cek gratis setiap plat berubah ===
platInput.addEventListener("input", () => {
    updateTotals();
});

// === Hitung ulang setiap layanan diganti ===
produkSelect.addEventListener("change", () => {
    updateTotals();
});

    const platLabel = div.querySelector('.plat-label');

   produkSelect.addEventListener("change", () => {
    const nama = produkSelect.selectedOptions[0]?.text.toLowerCase() || "";

    // DETEKSI LAYANAN KARPET (lebih aman)
    const isKarpet = nama.includes("karpet");

    // ==== HIDE/SHOW PLAT ====
    if (isKarpet) {
        platInput.style.display = "none";
        platLabel.style.display = "none";
        platInput.removeAttribute("required");
        platInput.value = "";
    } else {
        platInput.style.display = "block";
        platLabel.style.display = "block";
        platInput.setAttribute("required", "required");
    }

    // ==== QTY KHUSUS KARPET ====
    let qtyInput = detailCol.querySelector(".qtyInput");

    if (isKarpet) {
        if (!qtyInput) {
            detailCol.insertAdjacentHTML("beforeend", `
                <label class="form-label mt-2">Jumlah Karpet</label>
                <input type="number" min="1" value="1"
                       class="form-control qtyInput"
                       name="items[${id}][qty]" required>
            `);
        }
    } else {
        if (qtyInput) qtyInput.remove();
    }

    updateTotals();
});

    updateTotals();
}
            /* =================== MINUMAN =================== */
            if (val === "minuman") {
                const res = await fetch('/api/produk/minuman');
                const data = await res.json();

                let opsi = data.map(p =>
                    `<option value="${p.id}" data-harga="${p.harga}" data-stok="${p.stok}">
                        ${p.nama} (Stok: ${p.stok})
                    </option>`
                ).join("");

                detailCol.innerHTML = `
                    <label class="form-label">Produk</label>
                    <select class="form-select produkSelect"
                            name="items[${id}][produk_id]" required>
                        <option value="">-- pilih produk --</option>
                        ${opsi}
                    </select>

                    <label class="form-label mt-2">Jumlah</label>
                    <input type="number" min="1" value="1"
                           class="form-control qtyInput"
                           name="items[${id}][qty]" required>
                `;
            }
            // === EVENT UNTUK MINUMAN (Hitung Total) ===
const produkSelect = div.querySelector('.produkSelect');
const qtyInput     = div.querySelector('.qtyInput');

if (produkSelect) {
    produkSelect.addEventListener("change", updateTotals);
}

if (qtyInput) {
    qtyInput.addEventListener("input", updateTotals);
}


            updateTotals();
            // ================= BATASI STOK =================
// ================= BATASI STOK (khusus minuman) =================
const produkSelectMinuman = div.querySelector('.produkSelect');
const qtyMinuman = div.querySelector('.qtyInput');

if (produkSelectMinuman && qtyMinuman) {
    produkSelectMinuman.addEventListener("change", () => {
        const stok = parseInt(produkSelectMinuman.selectedOptions[0]?.dataset.stok || 0);

        if (qtyMinuman.value > stok) {
            qtyMinuman.value = stok;
            toast(`Jumlah melebihi stok! Maksimal ${stok}`, "#ef4444");
        }
    });

    qtyMinuman.addEventListener("input", () => {
        const stok = parseInt(produkSelectMinuman.selectedOptions[0]?.dataset.stok || 0);

        if (qtyMinuman.value > stok) {
            qtyMinuman.value = stok;
            toast(`Stok hanya ${stok}`, "#ef4444");
        }
    });
}
        });

async function updateTotals() {

    // 🔥🔥🔥 GUARD FINAL 🔥🔥🔥
    if (div._isDeleted) return;
    if (!div.isConnected) return;

    const produkSelect = div.querySelector('.produkSelect');
    const harga = produkSelect?.selectedOptions[0]?.dataset.harga || 0;
    const qty   = div.querySelector('.qtyInput')?.value || 1;

    let total = harga * qty;

    const kategori = div.querySelector('.kategoriSelect')?.value;

    if (kategori === "layanan") {
        const plat = div.querySelector('.platInput')?.value || "";
        const produk_id = produkSelect?.value || "";

        if (plat && produk_id) {
            const res = await fetch(`/cek-cuci-gratis?plat=${plat}&produk_id=${produk_id}`);
            const data = await res.json();

            // 🔥 CEK ULANG SETELAH ASYNC
            if (div._isDeleted || !div.isConnected) return;

            if (data.gratis === true) {
                total = 0;
                toast("Paket mobil ke-6 GRATIS!", "#2563eb");
            }
        }
    }

    totalInput.value = total;
    recalcSubtotal();
    updateSummary();
}

        container.appendChild(div);
        recalcSubtotal();

     div.querySelector('.removeRow').addEventListener('click', () => {

    const allRows = container.querySelectorAll('.pemasukan-row');

    // 🔥 JIKA BUKAN ITEM PERTAMA → HAPUS TOTAL
    if (allRows.length > 1 && allRows[0] !== div) {
        div.dataset.active = "0";
        div.remove();

        recalcSubtotal();
        updateSummary();
        toast("Item dihapus", "#ef4444");
        return;
    }

    // 🔥 JIKA ITEM PERTAMA → RESET & NONAKTIF
    div.dataset.active = "0";
    div.querySelector(".kategoriSelect").value = "";
    div.querySelector(".detail-col").innerHTML = "";
    div.querySelector(".total-input").value = 0;

    recalcSubtotal();
    updateSummary();
    toast("Item dihapus", "#ef4444");
});
    }

    btnAdd.addEventListener('click', () => {
        createRow();
        renumberItems(); 
        toast("Baris baru ditambahkan", "#2196f3");
    });

    document.getElementById('modalPemasukan')
        .addEventListener('show.bs.modal', () => {
            container.innerHTML = '';
            nextId = 1;
            subtotalDisplay.textContent = "Rp 0";
            createRow();
            renumberItems(); 
        });

})();
/* =========================================================
   PENGELUARAN — FINAL CLEAN VERSION
========================================================= */
(function () {

    const container = document.getElementById('pengeluaranRows');
    const totalDisplay = document.getElementById('totalPengeluaranDisplay');

    let nextId = 1;

    const formatRp = n => new Intl.NumberFormat('id-ID').format(Number(n || 0));
    const toNumber = v => parseFloat(v || 0);

function recalcTotal() {
    let sum = 0;

    container.querySelectorAll('.pengeluaran-total')
        .forEach(el => sum += toNumber(el.value));

    const adaKurangi = [...container.querySelectorAll(".modern-card")]
        .some(row =>
            row.querySelector(".kategoriSelect")?.value === "stok_barang" &&
            row.querySelector(".stokActionInput")?.value === "kurangi"
        );

    const totalLeft  = document.getElementById("totalPengeluaranWrapper");

    // ===== MODE KURANGI → TOTAL HILANG =====
    if (adaKurangi) {
        if (totalLeft)  totalLeft.style.display  = "none";
        return;
    }

    // ===== MODE NORMAL =====
    if (totalLeft)  totalLeft.style.display  = "block";

    document.getElementById("totalPengeluaranDisplay").textContent =
        "Rp " + formatRp(sum);
}

    // === MODE KURANGI STOK BARANG ===
function setModeKurangi(row, stokMax) {
    const stokActionInput = row.querySelector('.stokActionInput');
    if (stokActionInput) stokActionInput.value = "kurangi";

    const qtyWrapper = row.querySelector('.qty-wrapper');
    const nominalWrapper = row.querySelector('.nominal-wrapper');
    const qtyInput = row.querySelector('.qtyInput');
    const nominalInput = row.querySelector('.nominalInput');

    if (!qtyWrapper || !nominalWrapper || !qtyInput || !nominalInput) return;

    qtyWrapper.style.display = "block";
    nominalWrapper.style.display = "none";
    nominalInput.value = "";
    nominalInput.removeAttribute("required");

    qtyInput.max = stokMax;

    qtyInput.addEventListener("input", () => {
        if (+qtyInput.value > stokMax) qtyInput.value = stokMax;
    });

    // Sembunyikan kolom total per-row
    const totalCol = row.querySelector(".pengeluaran-total")?.closest(".col-md-3");
    if (totalCol) totalCol.style.display = "none";

    // 🔥🔥🔥 FIX UTAMA 🔥🔥🔥
    recalcTotal();
    updateSummaryPengeluaran();

    toast("Kurangi Stok", "#ef4444");
}

    function createPengeluaranRow() {
        const id = nextId++;
        const row = document.createElement('div');
        row.className = "modern-card p-3 mb-3";

       row.innerHTML = `
    <div class="row g-3">

        <div class="col-md-4">
            <label class="form-label">Kategori</label>
            <select name="items[${id}][kategori]" class="form-select kategoriSelect" required>
                <option value="">Pilih</option>
                <option value="stok_barang">Stok Barang</option>
                <option value="minuman">Minuman</option>
                <option value="kasbon">Kasbon</option>
                <option value="makan_karyawan">Makan Karyawan</option>
                <option value="minum_karyawan">Minum Karyawan</option>
                <option value="tagihan">Tagihan</option>
                <option value="lain_lain">Lain-lain</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control"
                   name="items[${id}][tanggal]"
                   value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Total</label>
            <input type="number" class="form-control pengeluaran-total" readonly>
        </div>

        <!-- DETAIL FORM -->
        <div class="col-12 mt-2 detail-col"></div>

        <!-- TOMBOL HAPUS (BENAR DI SINI) -->
        <div class="col-12 mt-3 d-flex justify-content-start">
        </div>

    </div>
`;


        const kategori   = row.querySelector('.kategoriSelect');
        const detailCol  = row.querySelector('.detail-col');
        const totalInput = row.querySelector('.pengeluaran-total');

        // ==== HANDLE PERUBAHAN KATEGORI ====
        kategori.addEventListener('change', async () => {

            const val = kategori.value;
            detailCol.innerHTML = '';

            /* ======================================================
                KASBON
            ====================================================== */
          if (val === 'kasbon') {
    const res = await fetch('/pengeluaran/karyawan');
    const data = await res.json();

    detailCol.innerHTML = `
        <label class="form-label">Karyawan</label>
        <select name="items[${id}][karyawan_id]"
                class="form-select karyawanSelect">
            <option value="">-- pilih karyawan --</option>
            ${data.map(k => `<option value="${k.id}">${k.nama}</option>`).join('')}
        </select>

        <label class="form-label mt-2">Nominal</label>
        <input type="number"
            class="form-control nominalInput"
            name="items[${id}][nominal]"
            min="0"
            required>

            <div class="mt-1">
       <small class="text-muted kasbonInfo d-block">
            Maksimal kasbon Rp 300.000 (akumulatif)
        </small>
        </div>

        <div class="mt-3">
        <label class="form-label">Keterangan</label>
        <input type="text" class="form-control"
            name="items[${id}][keterangan]"placeholder="Opsional">
            </div>
    `;

    const karyawanSelect = detailCol.querySelector(".karyawanSelect");
    const nominalInput  = detailCol.querySelector(".nominalInput");
    const infoText      = detailCol.querySelector(".kasbonInfo");

    // ✅ INI INTI LOGIKANYA
    karyawanSelect.addEventListener("change", async () => {
        const karyawanId = karyawanSelect.value;
        if (!karyawanId) return;

        const res = await fetch(`/kasbon/sisa/${karyawanId}`);
        const data = await res.json();

        if (data.sisa <= 0) {
            nominalInput.value = 0;
            nominalInput.disabled = true;
            infoText.textContent = "Kasbon karyawan ini sudah mencapai limit";
            toast("Kasbon sudah mencapai batas", "#ef4444");
        } else {
            nominalInput.disabled = false;
            nominalInput.max = data.sisa;
            infoText.textContent =
                `Sisa kasbon: Rp ${data.sisa.toLocaleString("id-ID")}`;
        }
    });
}
            /* ======================================================
                STOK BARANG (barang fisik)
            ====================================================== */
            if (val === 'stok_barang') {

                detailCol.innerHTML = `
                    <label class="form-label">Nama Barang</label>
                    <input type="text" class="form-control namaItemInput"
                        name="items[${id}][nama_item]" placeholder="Contoh: Sabun" required>

                    <div class="suggestion-list mt-1"></div>

                    <input type="hidden" class="produkIdInput" name="items[${id}][produk_id]">

                    <div class="qty-wrapper" style="display:none;">
                        <label class="form-label mt-2">Jumlah</label>
                        <input type="number" min="1" value="1"
                            class="form-control qtyInput"
                            name="items[${id}][qty]">
                    </div>

                    <input type="hidden" class="stokActionInput"
                        name="items[${id}][stok_action]" value="tambah">

                    <div class="nominal-wrapper" style="display:none;">
                        <label class="form-label mt-2">Nominal</label>
                       <input type="number" class="form-control nominalInput"
       name="items[${id}][nominal]"
       step="1" min="0">
                    </div>

                    <label class="form-label mt-2">Keterangan</label>
                    <input type="text" class="form-control"
                        name="items[${id}][keterangan]" placeholder="Opsional">
                `;

                const namaInput     = row.querySelector('.namaItemInput');
                const produkIdInput = row.querySelector('.produkIdInput');
                const suggestionBox = row.querySelector('.suggestion-list');
                const qtyWrapper    = row.querySelector('.qty-wrapper');
                const qtyInput      = row.querySelector('.qtyInput');
                const nominalWrapper= row.querySelector('.nominal-wrapper');
                const nominalInput  = row.querySelector('.nominalInput');
                const stokAction    = row.querySelector('.stokActionInput');

                const modalAksi = new bootstrap.Modal(document.getElementById('modalAksiStok'));
                const teksNama  = document.getElementById('aksiStokNama');
                const btnTambah = document.getElementById('btnStokTambah');
                const btnKurangi= document.getElementById('btnStokKurangi');

                // jika produkId kosong → NULL saat submit (backend aman)
                row.addEventListener("input", () => {
                
                    if (produkIdInput && (produkIdInput.value === "" || produkIdInput.value === " ")) {
                        produkIdInput.value = null;
                    }
                });

                let timer;

                namaInput.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
        runSearch();
    }, 600); // tunda 600ms setelah berhenti mengetik
});
                async function runSearch() {
    const q = namaInput.value.trim().toLowerCase();

    // jangan cari apa-apa sebelum minimal 2 huruf
    if (q.length < 2) return;

    produkIdInput.value = "";
    suggestionBox.innerHTML = "";
    suggestionBox.style.display = "none";

    const res  = await fetch(`/search-stok-barang?q=${encodeURIComponent(q)}`);
    const data = await res.json();

    // barang baru (tidak ada yang cocok)
    if (data.length === 0) {
        qtyWrapper.style.display = "block";
        nominalWrapper.style.display = "block";
        nominalInput.required = true;
        stokAction.value = "tambah";
        return;
    }

    const barang = data[0];
    const namaBarang = barang.nama.toLowerCase();

    // ❗ Jangan munculkan popup jika user BELUM selesai ngetik
    // contoh: user baru ketik "ka", tapi barang "kanebo"
    if (!namaBarang.startsWith(q)) return;

    // ❗ Hanya munculkan popup jika user sudah mengetik NAMA LENGKAP
    if (q !== namaBarang) return;

    // ======= Popup benar-benar ditampilkan di sini =======
    teksNama.textContent = barang.nama;
    modalAksi.show();

    // === TAMBAH STOK ===
    btnTambah.onclick = () => {
        stokAction.value = "tambah";
        namaInput.value     = barang.nama;
        produkIdInput.value = barang.id;

        qtyWrapper.style.display = "block";
        nominalWrapper.style.display = "block";

        qtyInput.value     = 1;
        qtyInput.removeAttribute("max");
        nominalInput.value = "";
        nominalInput.required = true;

        modalAksi.hide();
        toast("Tambah Stok", "#2563eb");
    };

    // === KURANGI STOK ===
    btnKurangi.onclick = () => {
        namaInput.value     = barang.nama;
        produkIdInput.value = barang.id;

        setModeKurangi(row, barang.stok);

        qtyInput.value = 1;
        modalAksi.hide();
        toast("Kurangi Stok", "#ef4444");
    };
}

            }

            /* ======================================================
                MINUMAN — stok minuman (SELALU TAMBAH STOK)
            ====================================================== */
            if (val === 'minuman') {

                detailCol.innerHTML = `
                    <label class="form-label">Nama Minuman</label>
                    <input type="text" class="form-control namaItemInput"
                        name="items[${id}][nama_item]" placeholder="Contoh: Aqua" required>

                    <div class="suggestion-list mt-1"></div>

                    <input type="hidden" class="produkIdInput" name="items[${id}][produk_id]">

                    <label class="form-label mt-2">Jumlah</label>
                    <input type="number" min="1" value="1"
                        class="form-control qtyInput"
                        name="items[${id}][qty]" required>

                    <label class="form-label mt-2">Nominal</label>
                    <input type="number" class="form-control nominalInput"
       name="items[${id}][nominal]"
       step="1" min="0">

                    <label class="form-label mt-2">Keterangan</label>
                    <input type="text" class="form-control"
                        name="items[${id}][keterangan]" placeholder="Opsional">

                    <input type="hidden" class="stokActionInput"
                        name="items[${id}][stok_action]" value="tambah">
                `;

                const namaInput     = row.querySelector('.namaItemInput');
                const produkIdInput = row.querySelector('.produkIdInput');
                const suggestionBox = row.querySelector('.suggestion-list');

                let timer;
                namaInput.addEventListener('keyup', () => {
                    clearTimeout(timer);
                    timer = setTimeout(runMinumanSearch, 200);
                });

                async function runMinumanSearch() {
                    const q = namaInput.value.trim();

                    suggestionBox.innerHTML = "";
                    produkIdInput.value = null;

                    if (!q) return;

                    const res  = await fetch(`/search-minuman?q=${encodeURIComponent(q)}`);
                    let data   = await res.json();

                    data = data.filter(p =>
                        p.nama.toLowerCase().startsWith(q.toLowerCase())
                    );

                    if (data.length === 0) return;

                    suggestionBox.innerHTML = data.map(p => `
                        <div class="suggestion-item p-2 border-bottom"
                            data-id="${p.id}" data-nama="${p.nama}" data-stok="${p.stok}">
                            ${p.nama} <small class="text-muted">(stok: ${p.stok})</small>
                        </div>
                    `).join('');

                    suggestionBox.style.border = "1px solid #ddd";

                    suggestionBox.querySelectorAll(".suggestion-item").forEach(item => {
                        item.addEventListener("click", () => {
                            namaInput.value     = item.dataset.nama;
                            produkIdInput.value = item.dataset.id;

                            const stok = parseInt(item.dataset.stok);

                            suggestionBox.innerHTML = "";
                            suggestionBox.style.border = "none";

                            if (stok <= 5) {
                                toast(`Stok ${item.dataset.nama} tinggal ${stok}`, "#ef4444");
                            }
                        });
                    });
                }
            }

            /* ======================================================
                TAGIHAN / MAKAN / MINUM / LAINNYA
            ====================================================== */
            if (
                val === "makan_karyawan" ||
                val === "minum_karyawan" ||
                val === "tagihan" ||
                val === "lain_lain"
            ) {
                detailCol.innerHTML = `
                    <label class="form-label">Nominal</label>
                    <input type="number" class="form-control nominalInput"
       name="items[${id}][nominal]"
       step="1" min="0">

                    <label class="form-label mt-2">Keterangan</label>
                    <input type="text" class="form-control"
                        name="items[${id}][keterangan]" placeholder="Opsional">
                `;
            }

            recalcTotal();
        });

        
        // === HITUNG TOTAL OTOMATIS PER ROW ===
       row.addEventListener("input", () => {

       const kategori = row.querySelector(".kategoriSelect")?.value;
const nominalInput = row.querySelector(".nominalInput");

    const nominalRaw = row.querySelector(".nominalInput")?.value || "0";

    // pastikan nominal selalu angka utuh
    const nominal = parseInt(nominalRaw.replace(/[^\d]/g, "")) || 0;

    const stokAction = row.querySelector(".stokActionInput")?.value;

    let total = 0;

    if (kategori === "minuman") {
        total = nominal;
    }

    if (kategori === "stok_barang" && stokAction === "tambah") {
        total = nominal;
    }

   if (kategori === "stok_barang" && stokAction === "kurangi") {
    total = 0;

    const totalCol = row.querySelector(".pengeluaran-total")?.closest(".col-md-3");
    if (totalCol) totalCol.style.display = "none";

} else if (stokAction !== "kurangi") {
    const totalCol = row.querySelector(".pengeluaran-total")?.closest(".col-md-3");
    if (totalCol) totalCol.style.display = "block";
}


    if (
        kategori === "kasbon" ||
        kategori === "makan_karyawan" ||
        kategori === "minum_karyawan" ||
        kategori === "tagihan" ||
        kategori === "lain_lain"
    ) {
        total = nominal;
    }

    totalInput.value = total;

    recalcTotal();
    updateSummaryPengeluaran();
});


        container.appendChild(row);
        recalcTotal();
    }

    document.getElementById('modalPengeluaran')
        .addEventListener('show.bs.modal', () => {
            container.innerHTML = '';
            nextId = 1;
            totalDisplay.textContent = "Rp 0";
            createPengeluaranRow();
            updateSummaryPengeluaran();
        });

})();

    // ================= FLASH MESSAGE (backend) =================
    @if(session('success'))
        toast(@json(session('success')), "#2563eb");
    @endif

    @if(session('error'))
        toast(@json(session('error')), "#2563eb");
    @endif

});
// =============== DONUT CHART BULANAN ===============
const pemasukan = {{ $donut['pemasukan'] }};
const pengeluaran = {{ $donut['pengeluaran'] }};

let nilaiDonut = [pemasukan, pengeluaran];

if (pemasukan === 0 && pengeluaran === 0) {
    nilaiDonut = [1, 1];
}

new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: ['Total Pemasukan', 'Total Pengeluaran'],
        datasets: [{
            data: nilaiDonut,
            backgroundColor: ['#2563eb', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: "60%",
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(ctx){
                        if (pemasukan === 0 && pengeluaran === 0)
                            return ctx.label + ": Rp 0";

                        return ctx.label + ": Rp " + Number(ctx.raw).toLocaleString("id-ID");
                    }
                }
            }
        }
    }
});


// ====================================================
// FIX WAJIB: produk_id kosong harus jadi NULL sebelum submit
// ====================================================
document.getElementById('formPengeluaran')
    .addEventListener('submit', () => {
        document.querySelectorAll('.produkIdInput').forEach(el => {
            if (el.value === "" || el.value.trim() === "") {
                el.value = null;
            }
        });
    });
    function updateSummary() {
    const list = document.getElementById("summaryList");
    list.innerHTML = "";

    let index = 1;

    document.querySelectorAll("#itemsContainer .pemasukan-row").forEach(row => {

        // ⛔ SKIP YANG TIDAK AKTIF
        if (row.dataset.active !== "1") return;

        const totalItem = Number(
            row.querySelector(".total-input")?.value || 0
        );

       const isGratis = totalItem === 0;

        const kategori = row.querySelector(".kategoriSelect")?.value || "-";
        const tanggal  = row.querySelector('input[type="date"]')?.value || "-";

        let jenis = "-";
        const produkSelect = row.querySelector(".produkSelect");
        if (produkSelect?.selectedOptions.length) {
            jenis = produkSelect.selectedOptions[0].text;
        }

        let plat = "";
        if (kategori === "layanan") {
            plat = row.querySelector(".platInput")?.value || "";
        }

        let qty = "";
        const qtyInput = row.querySelector(".qtyInput");
        if (qtyInput) qty = qtyInput.value;

        list.insertAdjacentHTML("beforeend", `
            <div class="summary-item">
                <strong>Item ${index++}</strong><br>
                Kategori: ${kategori}<br>
                Jenis: ${jenis}<br>
                ${plat ? `Plat: ${plat}<br>` : ""}
                ${qty ? `Qty: ${qty}<br>` : ""}
                Tanggal: ${tanggal}<br>
                <div class="fw-semibold">
                    Rp ${totalItem.toLocaleString("id-ID")}
                </div>
            </div>
        `);
    });
}

function updateSummaryPengeluaran() {

    const adaKurangi = [...document.querySelectorAll("#pengeluaranRows .modern-card")]
        .some(row =>
            row.querySelector(".kategoriSelect")?.value === "stok_barang" &&
            row.querySelector(".stokActionInput")?.value === "kurangi"
        );


    const list  = document.getElementById("summaryListPengeluaran");

    if (!list) return;

    list.innerHTML = "";
    let subtotal = 0;

    document.querySelectorAll("#pengeluaranRows .modern-card").forEach((row, i) => {

        const kategori = row.querySelector(".kategoriSelect")?.value || "-";
        const tanggal  = row.querySelector('input[type="date"]')?.value || "-";
        const action   = row.querySelector(".stokActionInput")?.value;

        /* =======================================================
                        MODE KURANGI STOK BARANG
        ======================================================= */
        if (kategori === "stok_barang" && action === "kurangi") {
            const nama  = row.querySelector(".namaItemInput")?.value || "-";
            const qty   = parseInt(row.querySelector(".qtyInput")?.value || 0);
            const stokAwal = parseInt(row.querySelector(".qtyInput")?.max || 0);
            const sisa  = stokAwal - qty;

            list.innerHTML += `
                <div class="summary-item">
                    <strong>Item ${i+1} (Kurangi Stok)</strong><br>
                    Barang: ${nama} <br>
                    Stok Awal: ${stokAwal} <br>
                    Dikurangi: ${qty} <br>
                    Sisa: ${sisa} <br>
                    Tanggal: ${tanggal}
                </div>
            `;
            return; // mode kurangi tidak menambah total
        }

        /* =======================================================
                        MODE TAMBAH STOK BARANG
        ======================================================= */
        if (kategori === "stok_barang" && action === "tambah") {
            const nama  = row.querySelector(".namaItemInput")?.value || "-";
            const qty   = row.querySelector(".qtyInput")?.value || "-";
            const nominal = parseFloat(row.querySelector(".nominalInput")?.value || 0);
            const ket = row.querySelector("[name*='keterangan']")?.value || "-";

            subtotal += nominal;

            list.innerHTML += `
                <div class="summary-item">
                    <strong>Item ${i+1} (Tambah Stok)</strong><br>
                    Barang: ${nama} <br>
                    Jumlah: ${qty} <br>
                    Nominal: Rp ${nominal.toLocaleString("id-ID")} <br>
                    Keterangan: ${ket} <br>
                    Tanggal: ${tanggal}
                </div>
            `;
            return;
        }

        /* =======================================================
                        KASBON
        ======================================================= */
        if (kategori === "kasbon") {
            const karyawan = row.querySelector("[name*='karyawan_id']")?.selectedOptions[0]?.text || "-";
            const nominal  = parseFloat(row.querySelector(".nominalInput")?.value || 0);
            const ket      = row.querySelector("[name*='keterangan']")?.value || "-";

            subtotal += nominal;

            list.innerHTML += `
                <div class="summary-item">
                    <strong>Item ${i+1} — Kasbon</strong><br>
                    Karyawan: ${karyawan} <br>
                    Nominal: Rp ${nominal.toLocaleString("id-ID")} <br>
                    Keterangan: ${ket} <br>
                    Tanggal: ${tanggal}
                </div>
            `;
            return;
        }

        /* =======================================================
                        MINUMAN (Stok Minuman)
        ======================================================= */
        if (kategori === "minuman") {
            const nama    = row.querySelector(".namaItemInput")?.value || "-";
            const qty     = row.querySelector(".qtyInput")?.value || "-";
            const nominal = parseFloat(row.querySelector(".nominalInput")?.value || 0);
            const ket     = row.querySelector("[name*='keterangan']")?.value || "-";

            subtotal += nominal;

            list.innerHTML += `
                <div class="summary-item">
                    <strong>Item ${i+1} — Minuman</strong><br>
                    Nama: ${nama} <br>
                    Jumlah: ${qty} <br>
                    Nominal: Rp ${nominal.toLocaleString("id-ID")} <br>
                    Keterangan: ${ket} <br>
                    Tanggal: ${tanggal}
                </div>
            `;
            return;
        }

        /* =======================================================
                        KATEGORI UMUM
                makan/minum karyawan, tagihan, lain-lain
        ======================================================= */
        const nominal = parseFloat(row.querySelector(".nominalInput")?.value || 0);
        const ket     = row.querySelector("[name*='keterangan']")?.value || "-";

        subtotal += nominal;

        list.innerHTML += `
            <div class="summary-item">
                <strong>Item ${i+1}</strong><br>
                Kategori: ${kategori} <br>
                Nominal: Rp ${nominal.toLocaleString("id-ID")} <br>
                Keterangan: ${ket} <br>
                Tanggal: ${tanggal}
            </div>
        `;
    });
}

// ===============================
// AUTO CLEAN NOMINAL INPUT
// ===============================
document.addEventListener("input", function (e) {
    if (e.target.classList.contains("nominalInput")) {

        // ambil nilai
        let val = e.target.value;

        // hilangkan titik, koma, spasi
        val = val.replace(/[.,\s]/g, "");

        // simpan kembali
        e.target.value = val;

        // trigger change event untuk update total
        e.target.dispatchEvent(new Event("change"));
    }
});
document.querySelectorAll(".nominalInput").forEach(el => {
    el.addEventListener("blur", () => {
        el.value = el.value.replace(/[^\d]/g, "");
        el.dispatchEvent(new Event("change"));
    });
});

document.getElementById("avatarBtn").addEventListener("click", function () {
    document.getElementById("profileMenu").classList.toggle("show");
});


const ctxSaldo = document.getElementById('saldoMiniChart');

if (ctxSaldo) {
    new Chart(ctxSaldo, {
        type: 'line',
        data: {
            labels: ['','','','','','',''],
            datasets: [{
                data: [20, 35, 25, 45, 30, 55, 40], // dummy dulu
                fill: true,
                tension: 0.45,
                borderWidth: 2,
                borderColor: '#2563eb',
                backgroundColor: 'color-mix(in srgb, #0d6efd 70%, white)',
                pointRadius: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            },
            scales: {
                x: { display: false },
                y: { display: false }
            }
        }
    });
}
(function () {
    const text = document.getElementById("welcomeText");
    if (!text) return;

    // 🔒 CEGAH RESTART ANIMASI
    if (text.dataset.started === "1") return;
    text.dataset.started = "1";

    setTimeout(() => {
        text.classList.remove("enter");
        text.classList.add("run");
    }, 350);
})();
</script>
<div class="modal-blur-layer"></div>

</x-app-layout> 