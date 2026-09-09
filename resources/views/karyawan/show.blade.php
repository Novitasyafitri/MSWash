<x-app-layout :title="'Detail Karyawan'">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Poppins', sans-serif !important; }

    /* MODE TERANG */
    h4 {
        font-weight: 600;
        font-size: 22px;
        color: #111827;
    }

    .card-detail {
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 4px 15px rgba(15,23,42,0.08);
    }

    .text-muted {
        color: #6b7280 !important;
    }

    table th {
        font-weight: 600;
        font-size: 14px;
    }

    table td {
        font-size: 14px;
        vertical-align: middle;
    }

    .table > :not(caption) > * > * {
        background-color: #ffffff;
        color: #111827;
        border-color: #e5e7eb;
    }

    .table thead.table-light th {
        background-color: #f9fafb !important;
        color: #111827 !important;
        border-color: #e5e7eb !important;
    }

    .table tbody tr:hover > * {
        background-color: #f3f4ff !important;
    }

    .badge.bg-success {
        background-color: #22c55e !important;
        color: #ffffff;
    }

    .badge.bg-warning {
        background-color: #facc15 !important;
        color: #6b4f00;
    }

</style>

<div class="container my-4">

    <div class="card-detail mb-3">
        <h4 class="fw-bold mb-2">{{ $karyawan->nama }}</h4>
        <p><b>Jabatan:</b> {{ ucfirst($karyawan->jabatan) }}</p>
        <p><b>Tanggal Masuk:</b> {{ $karyawan->tanggal_masuk }}</p>
    </div>

    <div class="card-detail">
        <h5 class="mt-1 mb-3">Riwayat Kasbon</h5>

        <table class="table table-bordered table-hover mt-2">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($karyawan->kasbon as $k)
                <tr>
                    <td>{{ $k->tanggal }}</td>
                    <td>Rp {{ number_format($k->nominal,0,',','.') }}</td>
                    <td>{{ $k->keterangan ?? '-' }}</td>
                    <td>
                        @if($k->lunas)
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-warning">Belum Lunas</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

</x-app-layout>
