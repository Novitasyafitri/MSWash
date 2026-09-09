<x-app-layout :title="'Dashboard Pemilik'">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ============================================================
   BLUE WAVES (EFEK MELENGKUNG KIRI ATAS & BAWAH)
============================================================ */
.bg-left-wave {
    position: fixed;
    top: 0;
    left: 0;
    width: 380px;
    height: 380px;
    background: color-mix(in srgb, #0d6efd 70%, white);
    border-bottom-right-radius: 75%;
    z-index: -1;
    opacity: 1;
}

.bg-left-wave-bottom {
    position: fixed;
    bottom: -280px;   /* TURUNKAN LEBIH DALAM */
    left: 0;
    width: 500px;
    height: 500px;
    background: color-mix(in srgb, #0d6efd 70%, white);
    border-top-right-radius: 75%;
    z-index: -1;
    opacity: 1;
}


/* ============================================================
   CARD & LAYOUT NORMAL (tidak diubah logic)
============================================================ */
.header-box {
    background: #ffffff;
    padding: 28px 32px;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    margin-bottom: 28px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}

.header-title { font-size: 28px; font-weight: 700; color: #2563eb; }
.header-subtitle { font-size: 14px; color: #4b5563; margin-top: 4px; }

.metric-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 16px 18px;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 12px;
    min-height: 110px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.metric-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 18px;
    color: white;
}

.metric-title { font-size: 13px; color: #6b7280; font-weight: 600; }
.metric-value { font-size: 22px; font-weight: 700; white-space: nowrap; }

.chart-card {
    background: #ffffff;
    padding: 22px;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    height: 360px !important;    /* PERBAIKAN TINGGI IDEAL */
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
}
.chart-card canvas {
    height: 240px !important;   /* tinggi normal & enak dilihat */
}


.header-box {
    margin-top: -14px;  /* header naik 10px */
}
.dashboard-inner {
    background: #eef1f6 !important;
    border-radius: 60px 0 0 60px;
    padding: 20px;
}
.metric-card,
.chart-card,
.header-box {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
}
@media (max-width: 600px) {
    .header-box {
        margin-top: 0; /* geser turun 60px, sesuaikan dengan tinggi navbar/burger */
    }
}
/* FILTER MODERN */
.filter-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    padding: 6px 10px;
    border-radius: 999px;
}

.filter-box i {
    color: #2563eb;
    font-size: 14px;
}

.filter-select {
    border: none;
    background: transparent;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    outline: none;
    cursor: pointer;
}

.filter-nav {
    display: flex;
    gap: 6px;
}

.filter-nav button {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    border: 1px solid #e5e7eb;
    background: white;
    cursor: pointer;
    font-weight: bold;
}

.filter-nav button:hover {
    background: #2563eb;
    color: white;
}
/* Glow garis melengkung */
.chart-card canvas {
filter: drop-shadow(0 0 3px rgba(68, 91, 156, 0.4));
}
/* ====== RESPONSIVE FILTER FIX ====== */
@media (max-width: 600px) {

    .filter-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 8px 12px;
        width: 100%;
        border-radius: 14px;
    }

    /* select jadi melebar tapi tetap STAY di baris yang sama */
    .filter-select {
        flex: 1;           /* ambil ruang tersisa */
        min-width: 0;      /* biar ga maksa melebar */
        font-size: 12px;
    }

    /* tombol tetap sejajar di kanan */
    .filter-nav {
        display: flex;
        flex-shrink: 0;    /* jangan turun */
        gap: 6px;
    }

    .filter-nav button {
        width: 26px;
        height: 26px;
        padding: 0;
        font-size: 14px;
    }

    /* icon disembunyikan */
    .filter-box i {
        display: none;
    }
}
/* ===== CARD PELANGGAN RAPI ===== */
.metric-content {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.metric-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

/* filter versi kecil biar ga bikin card tinggi */
.small-filter {
    padding: 4px 8px;
}

.small-filter .filter-select {
    font-size: 12px;
}
/* hapus icon filter khusus card pelanggan */
.metric-card .filter-box i {
    display: none;
}
.metric-header {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* judul jangan turun baris */
.metric-title {
    white-space: nowrap;
}
.small-filter {
    padding: 2px 8px;
    height: 26px;
    display: flex;
    align-items: center;
}

.small-filter .filter-select {
    font-size: 11px;
    height: 22px;
    line-height: 22px;
}
/* Hapus icon khusus card jumlah pelanggan */
.metric-card:has(#pelangganMode) .metric-icon {
    display: none;
}
.metric-card:has(#pelangganMode) .metric-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.metric-card:has(#pelangganMode) .metric-title {
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
}
.metric-card:has(#pelangganMode) .small-filter {
    padding: 2px 10px;
    height: 28px;
    border-radius: 999px;
}

.metric-card:has(#pelangganMode) .small-filter select {
    font-size: 12px;
    font-weight: 600;
    height: 24px;
}
/* SUB FILTER – SOFT & PROFESIONAL */
.pelanggan-sub-center {
    appearance: none;

    background: #f8fafc;            /* ⬅️ BUKAN PUTIH */
    border: 1px solid #e5e7eb;      /* abu soft */
    color: #475569;

    font-size: 11px;
    font-weight: 600;

    padding: 4px 20px 4px 10px;
    height: 24px;                   /* ⬅️ lebih tipis */
    line-height: 16px;

    border-radius: 999px;
    max-width: 180px;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;

    box-shadow: none;               /* ⬅️ HILANGKAN KESAN TOMBOL */
}

/* hover LEMBUT */
.pelanggan-sub-center:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

.pelanggan-sub-center:focus {
    outline: none;
    border-color: #2563eb;
}
/* MODE FILTER (ATAS) — MODERN, TETAP TINGGI */
#pelangganMode {
    appearance: none;
    background-color: transparent;
    border: none;
    font-size: 12px;
    font-weight: 700;
    color: #0f172a;
    padding-right: 18px; /* ruang panah */
    cursor: pointer;

    background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%236b7280' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right center;
    background-size: 12px;
}

#pelangganMode:focus {
    outline: none;
}
/* ===== FIX CARD PELANGGAN JADI TIDAK KEGEDAN ===== */
.pelanggan-value-wrapper {
    position: relative;
    display: flex;
    justify-content: center;
}

/* dropdown mengambang, tidak makan tinggi */
.pelanggan-value-wrapper .pelanggan-sub-center {
    position: absolute;
    top: 100%;                 /* tepat di bawah angka */
    left: 50%;
    transform: translateX(-50%);
    margin-top: 16px;
    z-index: 20;
}
.chart-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

/* HP MODE */
@media (max-width: 600px) {
    .chart-header {
        flex-direction: column;
        align-items: stretch;
    }

    .chart-header h5 {
        text-align: left;
        font-size: 16px;
    }
}
@media (max-width: 600px) {

    .filter-box {
        width: 100%;
        max-width: 100%;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 10px;
        border-radius: 14px;
    }

    .filter-select {
        flex: 1;
        min-width: 0;
        font-size: 12px;
    }

    .filter-nav {
        display: flex;
        gap: 4px;
        flex-shrink: 0;
    }

    .filter-nav button {
        width: 28px;
        height: 28px;
        font-size: 14px;
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

{{-- ============================================================
      BACKGROUND WAVES
============================================================ --}}
<div class="bg-left-wave"></div>
<div class="bg-left-wave-bottom"></div>

<div class="dashboard-inner">

    {{-- HEADER --}}
    <div class="header-box">
        <div>
            <div class="header-title">Dashboard MSWash</div>
            <div class="header-subtitle">
                Lihat performa saldo, pemasukan dan pengeluaran berdasarkan 2 periode dalam 1 bulan (awal & akhir bulan).
            </div>
        </div>
    </div>

    {{-- METRIC CARDS --}}
    <div class="row gx-4 gy-3 align-items-stretch">

        <div class="col-lg-3 col-md-6">
            <div class="metric-card">
                <div class="metric-icon" style="background:#2563eb;">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <div class="metric-title">Saldo (estimasi)</div>
                    <div class="metric-value text-primary">
                        Rp {{ number_format($saldoTotal,0,',','.') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="metric-card">
                <div class="metric-icon" style="background:#16a34a;">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div>
                    <div class="metric-title">Total Pemasukan </div>
                    <div class="metric-value text-success">
                        Rp {{ number_format($pemasukanPeriodeAktif,0,',','.') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="metric-card">
                <div class="metric-icon" style="background:#dc2626;">
                    <i class="bi bi-graph-down"></i>
                </div>
                <div>
                    <div class="metric-title">Total Pengeluaran</div>
                    <div class="metric-value text-danger">
                        Rp {{ number_format($pengeluaranPeriodeAktif,0,',','.') }}
                    </div>
                </div>
            </div>
        </div>

<div class="col-lg-3 col-md-6">
    <div class="metric-card">
        <div class="metric-icon" style="background:#10b981;">
            <i class="bi bi-people-fill"></i>
        </div>

        <div>
            <div class="metric-title">Jumlah Pelanggan</div>
            <div class="metric-value text-success" id="pelangganValue">
    {{ $pelangganPeriodeAktif }}
</div>
        </div>
    </div>
</div>

    {{-- CHARTS --}}
    <div class="row gx-4 gy-4 mt-1">

        <div class="col-lg-8">
            <div class="chart-card">
               <div class="chart-header">
    <h5 class="fw-bold mb-0">Statistik Pendapatan</h5>

   <div class="filter-box">
    <i class="bi bi-funnel"></i>

    <select id="modeSelect" class="filter-select" aria-label="Pilih Periode Statistik">
        <option value="harian">Per Hari</option>
        <option value="periode" selected>Per Periode</option>
        <option value="bulanan">Per Bulan</option>
        <option value="tahunan">Per Tahun</option>
    </select>

    <div class="filter-nav">
        <button id="btnPrev" onclick="prevPage()">‹</button>
        <button id="btnNext" onclick="nextPage()">›</button>
    </div>
</div>

</div>

<canvas id="weeklyChart"></canvas>

            </div>
        </div>

        <div class="col-lg-4">
            <div class="chart-card">
                <h5 class="mb-3 fw-bold">Analisis Kategori</h5>
                <canvas id="donutChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script>

const pelangganEl = document.getElementById('pelangganValue');
const pelangganAwal = pelangganEl.innerText;

document.getElementById('weeklyChart')
.addEventListener('mousemove', function (evt) {

    const points = chart.getElementsAtEventForMode(
    evt,
    'index',
    { intersect: false },
    true
);

    if (!points.length) return;

    const index = points[0].index;
    const data = getPageData()[index];

    if (data && data.pelanggan !== undefined) {
        pelangganEl.innerText = data.pelanggan.toLocaleString('id-ID');
    }
});

document.getElementById('weeklyChart')
.addEventListener('mouseleave', function () {
    pelangganEl.innerText = pelangganAwal;
});
    const bulanNama = [
    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
];
const datasets = {
    periode: @json($combined),
    harian: @json($harianChart),
    bulanan: @json($bulanan),
    tahunan: @json($tahunan),
};


let currentMode = 'periode';
let allData = datasets[currentMode];
let pageSize = 5;

function setPageSize() {
    if (currentMode === 'harian') {
        pageSize = 7;
    } else if (currentMode === 'periode') {
        pageSize = 5;
    } else if (currentMode === 'bulanan') {
        pageSize = 6;
    } else if (currentMode === 'tahunan') {
        pageSize = 5;
    }
}
let currentPage = 0;
document.getElementById('modeSelect').addEventListener('change', function () {
    currentMode = this.value;
    currentPage = 0;

    if (currentMode === 'harian') {
        allData = datasets.harian; // 🔥 langsung pakai data tahun ini
    } else {
        allData = datasets[currentMode];
    }

    setPageSize();
    renderChart();
});
// ambil data per halaman (6)
function getPageData() {
    const start = currentPage * pageSize;
    return allData.slice(start, start + pageSize);
}

// ========== ANIMASI AWAL (DUMMY DATA) ==========
const dummyData = {
    pemasukan: Array(12).fill().map(() => Math.floor(Math.random() * 100)),
    pengeluaran: Array(12).fill().map(() => Math.floor(Math.random() * 50))
};
// ========== PLUGIN ANIMASI SEQUENCIAL (BAR GERAK SATU2) ==========
const delayedAnimation = {
    id: 'delayedAnimation',
    beforeDraw(chart, args, options) {
        chart.$animationDelay = true;
    },
    afterDraw(chart, args, options) {
        chart.$animationDelay = false;
    }
};
// Plugin: garis selisih warna biru kalau +, merah kalau -
const dynamicColorPlugin = {
    id: 'dynamicLineColor',
    afterDatasetsDraw(chart, args, opts) {
        const ctx = chart.ctx;
        const dataset = chart.data.datasets[2]; // dataset garis trend (selisih)
        const meta = chart.getDatasetMeta(2);

        ctx.save();
        ctx.lineWidth = dataset.borderWidth;

        meta.data.forEach((point, index) => {
            if (index === 0) return;

            const prev = meta.data[index - 1];

            const val = dataset.data[index];

            ctx.beginPath();
            ctx.strokeStyle = val >= 0 ? '#2563eb' : '#ef4444';
            ctx.moveTo(prev.x, prev.y);
            ctx.lineTo(point.x, point.y);
            ctx.stroke();
        });

        ctx.restore();

        // hilangkan garis default
        dataset.borderColor = 'rgba(0,0,0,0)';
    }
};

const chart = new Chart(document.getElementById('weeklyChart'), {
    type: 'bar',

    data: {
        labels: [],

        // GRAFIK AWAL = DUMMY
        datasets: [
           {
    label: 'Pemasukan',
    data: dummyData.pemasukan,
    backgroundColor: '#2563eb',
    hoverBackgroundColor: '#1d4ed8', // 🔥 lebih gelap pas hover
    borderColor: '#1e40af',
    borderWidth: 0,
    hoverBorderWidth: 2,
    borderRadius: 8
},
{
    label: 'Pengeluaran',
    data: dummyData.pengeluaran,
    backgroundColor: '#ef4444',
    hoverBackgroundColor: '#b91c1c', // 🔥 merah tegas
    borderColor: '#7f1d1d',
    borderWidth: 0,
    hoverBorderWidth: 2,
    borderRadius: 8
},
           {
    label: 'Selisih',
    type: 'line',
    yAxisID: 'ySelisih', // ⬅️ TAMBAHAN PENTING
    data: dummyData.pemasukan,
    borderColor: '#0d6efd',
    borderWidth: 3,
    tension: 0.4,
    pointRadius: 0,
    fill: false
}
        ]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false,
    interaction: {
    mode: 'index',
    intersect: false
},
hover: {
    animationDuration: 200
},

    animation: {
    duration: 900,
    easing: "easeOutQuart",
    delay: (ctx) => {
        let i = ctx.dataIndex;
        let d = ctx.datasetIndex;
        return (i + d) * 120; // batang muncul satu-satu (120ms)
    }
},
plugins: {
    tooltip: {
        backgroundColor: '#0f172a',
        titleColor: '#ffffff',
        bodyColor: '#e5e7eb',
        borderColor: '#2563eb',
        borderWidth: 1,
        padding: 10,
        cornerRadius: 8
    }
},
    scales: {
    y: {
        beginAtZero: true
    },
    ySelisih: {
        position: 'right',
        grid: {
            drawOnChartArea: false // ⬅️ garis grid tidak ganggu bar
        }
    },
x: {
    ticks: {
        display: window.innerWidth >= 600, // ⬅️ HP HILANG, DESKTOP TAMPIL
        autoSkip: true
    }
}

    }
}

});
const btnPrev = document.getElementById('btnPrev');
const btnNext = document.getElementById('btnNext');

function updateButtons() {
    const show = ['harian','periode','bulanan','tahunan'].includes(currentMode);

    btnPrev.style.display = show ? 'inline-block' : 'none';
    btnNext.style.display = show ? 'inline-block' : 'none';

    if (!show) return;

    btnPrev.disabled = currentPage === 0;
    btnNext.disabled = (currentPage + 1) * pageSize >= allData.length;
}
// render isi chart
function renderChart() {
    const pageData = getPageData();

chart.data.labels = pageData.map(d => {

    // MODE HARIAN → langsung tampil
    if (currentMode === 'harian') {
        return d.label;
    }

    // MODE PERIODE → dipendekin
    const parts = d.label.split('–');

    if (parts.length === 2) {
        const start = parts[0].trim();
        const end   = parts[1].trim();

        const startDay = start.split(' ')[0];
        const endParts = end.split(' ');
        const endDay   = endParts[0];
        const month    = endParts[1];
        const year     = endParts[2];

        if (window.innerWidth < 600) {
    return `${startDay}–${endDay} ${month} ${year}`;
}

        return `${startDay}–${endDay} ${month} ${year}`;
    }

    return d.label;
});

chart.data.datasets[0].data = pageData.map(d => Number(d.pemasukan) || 0);
chart.data.datasets[1].data = pageData.map(d => Number(d.pengeluaran) || 0);
chart.data.datasets[2].data = pageData.map(d =>
    (Number(d.pemasukan) || 0) - (Number(d.pengeluaran) || 0)
);
    chart.update({
    duration: 1000,
    easing: 'easeInOutQuart'
});

    updateButtons(); // ⬅️ TAMBAHAN
}

// tombol next
function nextPage() {

    // ===== BULANAN → ganti tahun =====
    if (currentMode === 'bulanan') {
        activeYear++;
        allData = datasets.bulanan.filter(d => d.tahun == activeYear);
        currentPage = 0;
        renderChart();
        return;
    }
    if (currentMode === 'tahunan') {
    currentPage++;
    renderChart();
    return;
}

    // ===== MODE LAIN (lama) =====
    if ((currentPage + 1) * pageSize < allData.length) {
        currentPage++;
        renderChart();
    }
}

// tombol prev
function prevPage() {

    // ===== BULANAN → ganti tahun =====
    if (currentMode === 'bulanan') {
        activeYear--;
        allData = datasets.bulanan.filter(d => d.tahun == activeYear);
        currentPage = 0;
        renderChart();
        return;
    }
    if (currentMode === 'tahunan' && currentPage > 0) {
    currentPage--;
    renderChart();
    return;
}

    // ===== MODE LAIN (lama) =====
    if (currentPage > 0) {
        currentPage--;
        renderChart();
    }
}

setPageSize();
renderChart();

const donutData = @json($harian);
let nilai = [donutData.pemasukan, donutData.pengeluaran];

let isZero = nilai[0] === 0 && nilai[1] === 0;
if (isZero) nilai = [1, 1];

new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: [
            'Pemasukan',
            'Pengeluaran'
        ],
        datasets: [{
            data: nilai,
            backgroundColor: ['#2563eb', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        cutout: "60%",
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(ctx){
                        if (isZero) return ctx.label + ": Rp 0";
                        return ctx.label + ": Rp " + Number(ctx.raw).toLocaleString("id-ID");
                    }
                }
            }
        }
    }
});

window.addEventListener('resize', () => {
    chart.options.scales.x.ticks.display = window.innerWidth >= 600;
    chart.update();
});

</script>

</x-app-layout>
