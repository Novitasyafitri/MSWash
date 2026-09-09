<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>

<style>
@page {
    margin: 28px;
}

body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 12px;
    color: #111827;
}

/* INFO */
.info {
    font-size: 11px;
    margin-bottom: 12px;
    color: #374151;
}

/* TABLE DATA */
table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    padding: 8px 6px;
    font-size: 11px;
    font-weight: 700;
    text-align: left;
}

tbody td {
    border: 1px solid #e5e7eb;
    padding: 7px 6px;
    font-size: 11px;
}

tbody tr:nth-child(even) {
    background: #fafafa;
}

.text-right { text-align: right; }
.text-center { text-align: center; }

/* TOTAL (TANPA GARIS ATAS) */
.total-box {
    margin-top: 14px;
    font-size: 13px;
    font-weight: 700;
    text-align: right;
}
</style>
</head>

<body>

<!-- ================= HEADER ================= -->
<table width="100%" cellpadding="0" cellspacing="0"
       style="margin-bottom:6px; border:none;">
<tr>

    <!-- LOGO -->
    <td width="64" valign="middle"
        style="padding:0 6px 0 0; border:none;">
        <div style="
            width:56px;
            height:56px;
            border-radius:50%;
            overflow:hidden;
            border:2px solid #e5e7eb;
        ">
            <img src="{{ public_path('logo-icon.png') }}"
                 style="width:100%; height:100%; object-fit:cover;">
        </div>
    </td>

    <!-- TEXT -->
    <td valign="middle" style="padding:0; border:none;">
        <div style="
            font-size:18px;
            font-weight:700;
            letter-spacing:0.6px;
            text-transform:uppercase;
            line-height:1.1;
        ">
            LAPORAN PENGELUARAN
        </div>

        <div style="
            font-size:11px;
            color:#6b7280;
            margin-top:2px;
        ">
        </div>
    </td>

</tr>
</table>

<!-- GARIS HITAM BAWAH JUDUL (DIPERTAHANKAN) -->
<div style="
    border-bottom:2px solid #111827;
    margin:6px 0 12px;
"></div>

<!-- ================= INFO ================= -->
<div class="info">
    <strong>Periode:</strong>
    {{ $tanggal ? $tanggal : 'Semua Data' }}
</div>

<!-- ================= TABLE ================= -->
<table>
<thead>
<tr>
    <th width="16%">Tanggal</th>
    <th width="18%">Jenis</th>
    <th width="24%">Nama</th>
    <th width="26%">Deskripsi</th>
    <th width="16%" class="text-right">Total</th>
</tr>
</thead>

<tbody>
@forelse($pengeluarans as $p)
<tr>
    <td>{{ $p->tanggal }}</td>
    <td>{{ ucwords(str_replace('_',' ', $p->jenis)) }}</td>

    <td>
        @if($p->jenis === 'kasbon')
            {{ $p->karyawan->nama ?? '-' }}
        @else
            {{ $p->nama_item ?? '-' }}
        @endif
    </td>

    <td>{{ $p->keterangan ?: '-' }}</td>

    <td class="text-right">
        Rp {{ number_format($p->total,0,',','.') }}
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center" style="padding:12px;color:#6b7280;">
        Tidak ada data pengeluaran
    </td>
</tr>
@endforelse
</tbody>
</table>

<!-- ================= TOTAL ================= -->
<div class="total-box">
    Total Pengeluaran:
    Rp {{ number_format($totalPengeluaran,0,',','.') }}
</div>

</body>
</html>
