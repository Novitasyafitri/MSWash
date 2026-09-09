<x-app-layout :title="'Kasbon Karyawan'">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
body { font-family: 'Poppins', sans-serif !important; }

h2 {
    font-weight: 600;
    font-size: 22px;
    color: #111827;
}

/* TABLE STYLE — SAMA PENGELUARAN */
.table-wrapper {
    border-radius: 16px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    overflow: hidden;
}

.table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table-modern thead th {
    background: color-mix(in srgb, #0d6efd 70%, white);
    color: #ffffff;
    border: none;
    padding: 12px 14px;
    font-size: 14px;
    font-weight: 600;
    vertical-align: middle;
}

.table-modern td {
    padding: 16px 16px;
    font-size: 14px;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
}

.table-modern tbody tr:hover td {
    background: #e5e7eb;
    cursor: pointer;
}
.table-responsive {
    width: 100%;
    overflow-x: auto;               /* scroll horizontal */
    -webkit-overflow-scrolling: touch; /* smooth scroll iOS */
}
@media (max-width: 640px) {
    .container {
        padding-left: 12px;
        padding-right: 12px;
    }
    .table-modern th,
.table-modern td {
    min-width: 120px;   /* contoh nilai minimal */
    white-space: nowrap; /* teks tidak pecah ke baris baru */
}
.page-title, h3 {
        margin-top: 40px; /* biar aman, tidak ketutupan hamburger */
    }
/* Kalau mau spesifik per kolom */
.table-modern th:nth-child(2),
.table-modern td:nth-child(2) { min-width: 180px; } /* Nama Karyawan */
.table-modern th:nth-child(3),
.table-modern td:nth-child(3) { min-width: 120px; } /* Nominal */
.table-modern thead th {
    position: sticky;
    top: 0;
    z-index: 5;
    color: white;
}

}


</style>

<div class="container pt-3">

<h3 class="mb-3">Kasbon Karyawan</h3>

<div class="table-wrapper table-responsive">
    <table class="table-modern">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
           @forelse($kasbons as $k)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $k->nama }}</td>
    <td>
        Rp {{ number_format($k->total_kasbon,0,',','.') }}
    </td>
</tr>
@empty
<tr>
    <td colspan="3" class="text-center text-muted py-4">
        Tidak ada data kasbon
    </td>
</tr>
@endforelse
        </tbody>
    </table>
</div>

 <h2 class="mt-3 fw-bold">
        Total:
        <span class="text-primary">
            Rp {{ number_format($totalSemuaKasbon,0,',','.') }}
        </span>
    </h2>


</div>

</x-app-layout>
