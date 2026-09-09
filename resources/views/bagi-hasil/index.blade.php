<x-app-layout title="Bagi Hasil">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

{{-- ================= FONT ================= --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body { font-family:'Poppins',sans-serif !important; }

/* ================= CARD DASHBOARD ================= */
.card-dashboard {
    background:#ffffff;
    border-radius:20px;
    padding:22px 24px;
    box-shadow:0 10px 28px rgba(0,0,0,.08);
    margin-bottom:24px;
}

/* ================= SUMMARY GRID ================= */
.summary-grid {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:22px;
    margin-bottom:28px; 
}

/* CARD UTAMA */
.summary-card {
    position:relative;
    border-radius:18px;
    padding:22px 26px;
    min-height:140px;               /* ⬅️ tinggi kayak contoh */
    color:#ffffff;
    overflow:hidden;
}

/* BACKGROUND GRADIENT */
.bg-gradient-green { background:linear-gradient(135deg,#15803d,#16a34a); }
.bg-gradient-red   { background:linear-gradient(135deg,#b91c1c,#dc2626); }
.bg-gradient-blue  { background:linear-gradient(135deg,#1d4ed8,#2563eb); }

/* TEKS */
.summary-card small {
    font-size:13px;
    opacity:1 !important;
    font-weight:500;
}

.summary-card h3 {
    margin-top:10px;
    font-size:28px;
    font-weight:700;
    letter-spacing:.3px;
}

/* ICON */
.summary-icon {
    position:absolute;
    top:18px;
    right:20px;
    width:42px;
    height:42px;
    border-radius:12px;
    background:rgba(255,255,255,.18);
    display:flex;
    align-items:center;
    justify-content:center;
}

.summary-icon svg {
    width:20px;
    height:20px;
    stroke:white;
    opacity:.9;
}

/* ================= TABS ================= */
.tab-wrapper {
    display:flex;
    gap:10px;
    margin-bottom:18px;
}
/* ================= TABLE ================= */
.table-modern {
    width:100%;
    border-collapse:separate;
    border-spacing:0;
}

.table-modern th,
.table-modern td {
    padding:12px 14px;          /* SAMA */
    font-size:14px;             /* SAMA */
    font-weight:400;            /* SAMA */
    line-height:1.6;            /* SAMA */
    color:#000000;              /* SAMA */
}

.table-modern thead th {
    background:#1e40af;          /* biru solid */
    color:#ffffff;
    font-weight:700;
    letter-spacing:.3px;
}

.table-modern td {
    color:#0f172a;               /* slate-900 */
    font-weight:500;
}

.table-modern tbody tr:hover {
    background:#e5e7eb;
}
.btn-secondary.btn-pill {
    background:#e5e7eb;
    color:#1f2933;
    border:none;
}

.btn-primary.btn-pill {
    background:#2563eb;
    box-shadow:0 10px 20px rgba(37,99,235,.35);
}
.table-modern td.text-success {
    color:#15803d;      /* green lebih dalam */
    font-weight:700;
}

/* ================= TABLE WRAPPER (SAMAIN LAYANAN) ================= */
.table-wrapper {
    background:#ffffff;
    border-radius:16px;
    border:1px solid #e5e7eb;
    overflow:hidden; /* ini kunci */
}

/* header biru rounded */
.table-wrapper thead th:first-child {
    border-top-left-radius:16px;
}
.table-wrapper thead th:last-child {
    border-top-right-radius:16px;
}

/* tabel lebih halus */
.table-wrapper table {
    width:100%;
    border-collapse:separate;
    border-spacing:0;
}

.table-wrapper tbody tr:last-child td {
    border-bottom:none;
}


/* ================= TEXT ================= */
.text-success { color:#16a34a; font-weight:600; }
.text-danger  { color:#dc2626; font-weight:600; }
.text-primary { color:#2563eb; font-weight:600; }

.form-control {
    border-radius:12px;
    padding:12px;
}

/* ================= TAB BUTTON (SAMAIN STOK BARANG) ================= */
.tab-wrapper {
    display:flex;
    gap:12px;
    margin-bottom:20px;

    overflow-x:auto;          /* ⬅️ INI KUNCINYA */
    white-space:nowrap;
    padding-bottom:6px;

    scrollbar-width:none;     /* Firefox */
}
.tab-wrapper::-webkit-scrollbar {
    display:none;             /* Chrome */
}

.tab-content-wrapper {
    min-height:420px; /* ⬅️ TAMBAH INI */
}

.btn-pill {
    border-radius:999px;
    padding:12px 26px;   /* ⬅️ lebih tinggi & lebar */
    font-weight:600;
    font-size:15px;      /* ⬅️ teks sedikit lebih besar */
    line-height:1;       /* ⬅️ biar rapi tengah */
}

/* KHUSUS tombol simpan & status kasir */
#btnSimpanKasir,
.kasir-saved {
    height: 44px;              /* ⬅️ LEBIH KECIL */
    padding: 0 16px;           /* ⬅️ RAPI */
    font-size: 14px;           /* ⬅️ LEBIH HALUS */
    font-weight: 600;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius:12px;        /* kotak halus */
}
.filter-group .btn {
    border-radius: 999px;
    padding: 8px 18px;
    font-weight: 600;
}
.tab-content-wrapper {
    margin-top: -10px;
}
.kasir-box {
    background:#f8fafc;
    border-radius:16px;
    padding:16px 18px;
}

.kasir-row {
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:10px 0;
    border-bottom:1.5px solid #94a3b8; /* slate-400 */
    
}

.kasir-row:last-child {
    border-bottom:none;
}
.kasir-total {
    background:#ecfdf5;
    border:2.5px solid #15803d;
    box-shadow:0 4px 10px rgba(22,163,74,.15);
    border-radius:14px;
    padding:14px 16px; 
    margin-top:16px;
}

.kasir-total label {
    font-size:14px;
    font-weight:600;
    color:#166534;
}

.kasir-total input {
    border:none;
    background:transparent;
    font-size:20px;
    font-weight:800;
    color:#15803d;
}
.kasir-saved {
    background:#e5e7eb;        /* abu lebih pekat */
    width:100%;
    border:1px solid #9ca3af;  /* border abu tegas */
    color:#374151;           
    border-radius:12px;
    padding:12px;
    font-weight:600;
    text-align:center;
    border-left: none;
}

.btn-progress {
    position: relative;
    overflow: hidden;
}

/* STRIP PROGRESS DARI KIRI */
#btnSimpanKasir.btn-progress::after {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;

    background: #86efac;
    animation: btn-strip 1.2s linear forwards;
}


@keyframes btn-strip {
    from { width: 0; }
    to   { width: 100%; }
}

.btn-disabled {
    pointer-events: none;
    opacity: .95;
}

/* tombol hijau konsisten */
.btn-success {
    background:#dcfce7;
    color:#166534;
    box-shadow:0 8px 18px rgba(142, 216, 146, 0.35);
}
.btn-success:hover {
    background:#86efac;   /* hijau soft, TIDAK gelap */
    color:#166534;        /* teks tetap sama */
}

/* STRIP KIRI – PERSIS KAYAK KASIR-SAVED */
#btnSimpanKasir {
    border-left: 6px solid #16a34a;
}
/* ================= PEMILIK (OWNER) ================= */
.owner-wrapper {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.owner-box {
    background:#f8fafc;
    border-radius:16px;
    padding:18px 20px;
    border:1px solid #e5e7eb;
}

.owner-box h4 {
    font-size:15px;
    font-weight:700;
    margin-bottom:14px;
    color:#0f172a;
}

.owner-row {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:10px 0;
    border-bottom:1px solid #e5e7eb;
    font-size:14px;
}

.owner-row:last-child {
    border-bottom:none;
}

.owner-total {
    margin-top:24px;
    padding:22px;
    border-radius:18px;
    text-align:center;
}

.owner-total small {
    display:block;
    font-size:13px;
    margin-bottom:6px;
    opacity:.8;
}

.owner-total h2 {
    font-size:30px;
    font-weight:800;
    margin:0;
}

.owner-total.plus {
    background:#ecfdf5;
    border:2px solid #16a34a;
    color:#15803d;
}

.owner-total.minus {
    background:#fff1f2;
    border:2px solid #dc2626;
    color:#b91c1c;
}
.tab-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}

/* ================= TUTUP PERIODE ================= */
/* ================= TUTUP PERIODE ================= */
.btn.btn-tutup-periode {
    border: none !important;
    outline: none !important;

    background: #ee4f4fff;
    color: #ffffff !important;

    border-radius: 12px;
    padding: 12px 26px;
    font-weight: 600;
    font-size: 15px;

    /* shadow sama terus */
    box-shadow: 0 8px 18px rgba(220,38,38,.30);

    transition: background .2s ease;
}

/* HOVER – CUMA WARNA, TANPA ANGKAT */
.btn.btn-tutup-periode:hover:not(:disabled) {
    background: #c02727ff;        /* sedikit lebih terang */
    color: #ffffff !important;  /* teks tetap putih */
}

/* FOCUS – HALUS */
.btn.btn-tutup-periode:focus,
.btn.btn-tutup-periode:focus-visible {
    outline: none !important;
    color: #ffffff !important;
    box-shadow: 0 0 0 2px rgba(220,38,38,.25);
}

/* DISABLED */
.btn.btn-tutup-periode:disabled {
    background: #e5e7eb;
    color: #6b7280 !important;
    box-shadow: 0 6px 14px rgba(0,0,0,.08);
    cursor: not-allowed;
    opacity: 1;
}
.row-kasbon-error {
    background: #fff1f2;
    border-left: 4px solid #dc2626;
}
@keyframes blinkError {
    0%,100% { background:#fff1f2; }
    50% { background:#fecaca; }
}

.row-kasbon-error {
    animation: blinkError 1.5s ease-in-out infinite;
}
.tab-header-sticky {
    position: relative;
    z-index: 50; /* lebih tinggi dari konten, tapi aman */
}
.toastify {
    z-index: 30 !important;
}
/* === RESPONSIVE: SUMMARY GRID === */
@media (max-width: 992px) {
    .summary-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .summary-grid {
        grid-template-columns: 1fr;
    }
}
/* === RESPONSIVE: OWNER WRAPPER === */
@media (max-width: 768px) {
    .owner-wrapper {
        grid-template-columns: 1fr;
    }
}
/* === RESPONSIVE: KASIR ROW === */
@media (max-width: 600px) {
    .kasir-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .kasir-row input {
        width: 100%;
    }
}
/* === RESPONSIVE: TAB HEADER === */
@media (max-width: 640px) {
     .tab-header {
        flex-direction: row; /* tetap row supaya sejajar */
        flex-wrap: wrap;     /* jika terlalu banyak, bisa pindah baris */
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .btn-tutup-periode {
        width: 100%;
    }
}
/* === RESPONSIVE: TABLE === */
@media (max-width: 768px) {
    .table-wrapper {
        overflow-x: auto;
    }

    .table-modern th,
    .table-modern td {
        white-space: nowrap;
        font-size: 13px;
        padding: 10px 12px;
    }
}
@media (max-width: 480px) {
    .table-modern th,
    .table-modern td {
        font-size: 14px !important;
        padding: 14px 16px !important;
    }

    .summary-card h3 {
        font-size: 24px !important;
    }

    .summary-card small {
        font-size: 12px !important;
    }
}
@media (max-width: 600px) {
    .summary-grid {
        grid-template-columns: 1fr;
        margin-top: 20px; /* ⬅️ geser card ke bawah supaya burger kelihatan */
    }
}

</style>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="summary-grid">

    {{-- KARYAWAN --}}
  <div class="summary-card bg-gradient-green">
    <small>Total Bagi Hasil Karyawan</small>
    <h3>
        Rp {{
            number_format(
                collect($dataKaryawan)
                    ->filter(fn($k) => $k['diterima'] > 0)
                    ->sum('diterima'),
                0, ',', '.'
            )
        }}
    </h3>


    <div class="summary-icon">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
             d="M15 19a4 4 0 00-8 0m8 0v-1a4 4 0 00-4-4h0a4 4 0 00-4 4v1m8 0h4m-4-10a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
    </div>
</div>

    {{-- KASIR --}}
   <div class="summary-card bg-gradient-red">
    <small>Total Gaji Kasir</small>
    @php
    $kasirDiterima = ($gajiKasir ?? 0) - ($kasbonKasir ?? 0);
    $kasirDibayar  = $kasirDiterima > 0 ? $kasirDiterima : 0;
@endphp

<h3>
    Rp {{ number_format($kasirDibayar,0,',','.') }}
</h3>

    <div class="summary-icon">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
             d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m4-4h-6a2 2 0 000 4h6a2 2 0 000-4z"/>
        </svg>
    </div>
</div>

    {{-- PEMILIK --}}
  <div class="summary-card bg-gradient-blue">
    <small>Total Diterima Pemilik</small>
    <h3>Rp {{ number_format($dataPemilik['total'] ?? 0,0,',','.') }}</h3>

    <div class="summary-icon">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
             d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3
             3-1.343 3-3-1.343-3-3-3z"/>
        </svg>
    </div>
</div>

</div>

{{-- ================= TABS ================= --}}
<div class="tab-header tab-header-sticky">

    <div class="tab-wrapper">
        <button class="btn btn-secondary btn-pill"
            onclick="showTab('karyawan', this)">
            Karyawan
        </button>

        <button class="btn btn-secondary btn-pill"
            onclick="showTab('kasir', this)">
            Kasir
        </button>

        <button class="btn btn-secondary btn-pill"
            onclick="showTab('pemilik', this)">
            Pemilik
        </button>
    </div>

    @if(auth()->user()->role === 'pemilik')
<form method="POST" action="{{ route('periode.tutup') }}">
    @csrf

    <button
    type="submit"
    class="btn btn-pill btn-tutup-periode"
    {{ !$gajiKasirSudahDisimpan ? 'disabled' : '' }}
    title="{{ !$gajiKasirSudahDisimpan ? 'Simpan gaji kasir terlebih dahulu' : '' }}"
>
    Tutup Periode
</button>

</form>
@endif

</div>

<div class="tab-content-wrapper">

{{-- ================= KARYAWAN ================= --}}

<div id="tab-karyawan" class="card-dashboard" style="display:none;">
    <div class="table-wrapper">
        <table class="table-modern">

            <thead>
                <tr>
                    <th>Nama</th>
<th>Hasil 40%</th>
<th>Kupon</th>
<th>Kasbon</th>
<th>Diterima</th>

                </tr>
            </thead>

            <tbody>
    @forelse($dataKaryawan as $k)
    <tr class="{{ $k['status_kasbon'] === 'ERROR' ? 'row-kasbon-error' : '' }}">
                    <td>{{ $k['nama'] }}</td>
                    <td>Rp {{ number_format($k['hasil40'],0,',','.') }}</td>
                    <td class="text-primary">
                        + Rp {{ number_format($k['kupon'],0,',','.') }}
                    </td>
                   <td class="text-danger">
    - Rp {{ number_format($k['kasbon'],0,',','.') }}
</td>
<td class="text-success">
    Rp {{ number_format($k['diterima'],0,',','.') }}
</td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" align="center">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

{{-- ================= KASIR ================= --}}
<div id="tab-kasir" class="card-dashboard" style="display:none;">

    <div class="kasir-box">

        {{-- Gaji Kasir --}}
        <div class="kasir-row">
            <strong>Gaji Kasir</strong>
            
            <input type="text"
       id="gajiKasir"
       class="form-control"
       value="{{ number_format($gajiKasir ?? 0,0,',','.') }}"
       oninput="formatRupiah(this)"
       {{ auth()->user()->role !== 'pemilik' || $gajiKasirSudahDisimpan ? 'readonly' : '' }}>
        </div>

        {{-- Kasbon --}}
        <div class="kasir-row">
            <strong>Kasbon Kasir</strong>
            <span class="text-danger">
                Rp {{ number_format($kasbonKasir ?? 0,0,',','.') }}
            </span>
        </div>

        <div class="kasir-total">
    <label>Diterima</label>
    <input type="text"
           id="diterimaKasir"
           readonly
           class="form-control fw-bold {{ (($gajiKasir ?? 0) - ($kasbonKasir ?? 0)) < 0 ? 'text-danger' : 'text-success' }}"
           value="Rp {{ number_format(
                max(0, ($gajiKasir ?? 0) - ($kasbonKasir ?? 0)),
                0, ',', '.'
           ) }}">
</div>


        {{-- TOMBOL / STATUS --}}
        @if(auth()->user()->role === 'pemilik')
        @if(!$gajiKasirSudahDisimpan)
<form method="POST"
      action="{{ route('bagi-hasil.simpan-gaji') }}"
      class="mt-3"
      onsubmit="
        localStorage.setItem('activeTab','kasir');
        document.getElementById('gajiKasirHidden').value =
        angkaBersih(document.getElementById('gajiKasir').value);
      ">

                @csrf
                <input type="hidden"
                       name="gaji_kasir"
                       id="gajiKasirHidden">

                <button type="submit"
        id="btnSimpanKasir"
        class="btn btn-success w-100 btn-pill">
                    Simpan Gaji Kasir
                </button>
            </form>
        @else
            <div class="kasir-saved mt-3">
                Gaji kasir periode ini sudah disimpan
            </div>
        @endif
        @endif
    </div>
</div>
{{-- ================= PEMILIK ================= --}}
<div id="tab-pemilik" class="card-dashboard" style="display:none;">

    <div class="owner-wrapper">

        {{-- PEMASUKAN --}}
        <div class="owner-box">
            <h4>Pemasukan Pemilik</h4>

            <div class="owner-row">
                <span>60% Total Layanan</span>
                <span class="text-primary">
                    Rp {{ number_format($dataPemilik['hasil60'] ?? 0,0,',','.') }}
                </span>
            </div>
             <div class="owner-row">
                <span>Penjualan Minuman</span>
                <span class="text-primary">
                    Rp {{ number_format($dataPemilik['minuman'] ?? 0,0,',','.') }}
                </span>
            </div>

        </div>

        {{-- POTONGAN --}}
        <div class="owner-box">
            <h4>Potongan</h4>

             <div class="owner-row">
                <span>Kupon</span>
                <span class="text-danger">
                    - Rp {{ number_format($dataPemilik['kupon'] ?? 0,0,',','.') }}
                </span>
            </div>

            <div class="owner-row">
                <span>Operasional</span>
                <span class="text-danger">
                    - Rp {{ number_format($dataPemilik['operasional'] ?? 0,0,',','.') }}
                </span>
            </div>

            <div class="owner-row">
                <span>Gaji Kasir</span>
                <span class="text-danger">
                    - Rp {{ number_format($dataPemilik['gaji_kasir'] ?? 0,0,',','.') }}
                </span>
            </div>
        </div>

    </div>

    {{-- TOTAL --}}
    <div class="owner-total {{ ($dataPemilik['total'] ?? 0) < 0 ? 'minus' : 'plus' }}">
        <small>Total Diterima Pemilik</small>
        <h2>
            Rp {{ number_format($dataPemilik['total'] ?? 0,0,',','.') }}
        </h2>
    </div>

</div>
<!-- SCRIPT LOADING UNTUK TOMBOL SIMPAN GAJI KASIR -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const formKasir = document.querySelector('form[action="{{ route('bagi-hasil.simpan-gaji') }}"]');
    if (!formKasir) return;

    formKasir.addEventListener("submit", () => {
        const btn = document.getElementById("btnSimpanKasir");

        btn.classList.add("btn-progress", "btn-disabled");
        btn.innerText = "Menyimpan...";
    });
});
</script>


<script>
function showTab(tab, btn){
    localStorage.setItem('activeTab', tab); 
    ['karyawan','kasir','pemilik'].forEach(t=>{
        document.getElementById('tab-'+t).style.display =
            (t === tab ? 'block' : 'none');
    });

    document.querySelectorAll('.tab-wrapper .btn').forEach(b=>{
        b.classList.remove('btn-primary');
        b.classList.add('btn-secondary');
    });

    btn.classList.remove('btn-secondary');
    btn.classList.add('btn-primary');
}

function angkaBersih(val){return parseInt(val.replace(/[^\d]/g,''))||0;}
function formatRupiah(input){
let angka=angkaBersih(input.value);
input.value=angka.toLocaleString('id-ID');
document.getElementById('gajiKasirHidden').value=angka;
hitungKasir();
}
function hitungKasir(){
    let gajiInput = document.getElementById('gajiKasir').value;
    let gaji = angkaBersih(gajiInput);
    let kasbon = {{ $kasbonKasir ?? 0 }};

    const f = document.getElementById('diterimaKasir');
    const btn = document.getElementById('btnSimpanKasir');
    if (!btn) return;

    // 🔹 BELUM INPUT APA-APA
    if (gajiInput.trim() === '' || gaji === 0) {
        f.value = 'Rp 0';
        f.className = 'form-control fw-bold text-success';

        btn.disabled = true;
        btn.innerText = 'Masukkan gaji kasir';
        btn.classList.add('btn-disabled');
        return;
    }

    // 🔹 SUDAH INPUT → HITUNG
    let diterima = gaji - kasbon;

    f.value = (diterima < 0 ? '- Rp ' : 'Rp ')
        + Math.abs(diterima).toLocaleString('id-ID');

    f.className = 'form-control fw-bold ' +
        (diterima < 0 ? 'text-danger' : 'text-success');

    // 🔹 ERROR LOGIS
    if (diterima < 0) {
        btn.disabled = true;
        btn.innerText = 'Kasbon lebih besar dari gaji';
        btn.classList.add('btn-disabled');
    } 
    // 🔹 VALID
    else {
        btn.disabled = false;
        btn.innerText = 'Simpan Gaji Kasir';
        btn.classList.remove('btn-disabled');
    }
}

function startProgress(btn) {
    btn.classList.add('btn-progress', 'btn-disabled');
    btn.innerText = 'Menyimpan...';

    // setelah progress penuh → berhenti & ganti teks
    setTimeout(() => {
        btn.classList.remove('btn-progress');
        btn.innerText = 'Gaji kasir periode ini sudah disimpan';
    }, 1200);
}
document.addEventListener('DOMContentLoaded', () => {
    const activeTab = localStorage.getItem('activeTab') || 'karyawan';

    const btn = document.querySelector(
        `.tab-wrapper button[onclick*="${activeTab}"]`
    );

    if (btn) {
        showTab(activeTab, btn);
    }

    if (typeof hitungKasir === 'function') {
        hitungKasir();
    }
});
</script>
@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', () => {
Toastify({
    text: `
        <div style="display:flex; gap:12px; align-items:flex-start; position:relative;">
            
            <!-- ICON -->
            <div style="
                background:#fee2e2;
                color:#991b1b;
                border-radius:10px;
                padding:6px 9px;
                font-size:14px;
                line-height:1;
            ">⚠️</div>

            <!-- TEXT -->
            <div style="flex:1;">
                <div style="font-weight:700; color:#7f1d1d; margin-bottom:4px;">
                    Periode belum bisa ditutup
                </div>
                <div style="font-size:13px; color:#991b1b; line-height:1.5;">
                    {{ session('error') }}
                </div>
            </div>

            <!-- CLOSE -->
            <div onclick="this.closest('.toastify').remove()"
                 style="
                    cursor:pointer;
                    color:#991b1b;
                    font-weight:700;
                    font-size:16px;
                    line-height:1;
                    padding-left:6px;
                 ">
                ✕
            </div>

        </div>
    `,
    duration: 6000,
    gravity: "top",
    position: "right",
    offset: { x: 24, y: 72 },
    escapeMarkup: false,
    style: {
        background: "#fff1f2",
        borderRadius: "18px",
        padding: "16px 18px",
        boxShadow: "0 18px 40px rgba(0,0,0,.15)",
        borderLeft: "6px solid #dc2626",
        maxWidth: "380px",
        animation: "slideIn .35s ease-out"
    }
}).showToast();
    @if(session('error_tab'))
        const tab = "{{ session('error_tab') }}";
        const btn = document.querySelector(
            `.tab-wrapper button[onclick*="${tab}"]`
        );

        if (btn) {
            showTab(tab, btn);

            // 🔥 SCROLL KE BARIS ERROR (FIX PASTI JALAN)
@if(session('error_tab') === 'karyawan')
setTimeout(() => {
    const row = document.querySelector('.row-kasbon-error');
    if (!row) return;

    row.getBoundingClientRect();

    window.scrollTo({
        top: row.offsetTop - 180,
        behavior: 'smooth'
    });
}, 500);
@endif

        }
    @endif
});
</script>
@endif

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', () => {
Toastify({
    text: `
        <div style="display:flex; gap:12px; align-items:flex-start; position:relative;">
            
            <!-- ICON -->
            <div style="
                background:#dcfce7;
                color:#166534;
                border-radius:10px;
                padding:6px 9px;
                font-size:14px;
                line-height:1;
            ">✅</div>

            <!-- TEXT -->
            <div style="flex:1;">
                <div style="font-weight:700; color:#14532d; margin-bottom:4px;">
                    Berhasil
                </div>
                <div style="font-size:13px; color:#166534; line-height:1.5;">
                    {{ session('success') }}
                </div>
            </div>

            <!-- CLOSE -->
            <div onclick="this.closest('.toastify').remove()"
                 style="
                    cursor:pointer;
                    color:#166534;
                    font-weight:700;
                    font-size:16px;
                    line-height:1;
                    padding-left:6px;
                 ">
                ✕
            </div>

        </div>
    `,
    duration: 4000,
    gravity: "top",
    position: "right",
    offset: { x: 24, y: 72 },
    escapeMarkup: false,
    style: {
        background: "#ecfdf5",
        borderRadius: "18px",
        padding: "16px 18px",
        boxShadow: "0 18px 40px rgba(0,0,0,.15)",
        borderLeft: "6px solid #16a34a",
        maxWidth: "380px",
        animation: "slideIn .35s ease-out"
    }
}).showToast();
});
</script>
@endif


</x-app-layout>
