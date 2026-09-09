<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
@page { margin: 32px; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #111827;
}

/* INFO */
.info {
    font-size: 11px;
    margin-bottom: 12px;
    color: #374151;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
}

th {
    background: #f3f4f6;
    font-size: 11px;
    padding: 8px;
    border: 1px solid #d1d5db;
    text-align: left;
}

td {
    padding: 8px;
    border: 1px solid #e5e7eb;
    font-size: 11px;
}

tbody tr:nth-child(even) {
    background: #f9fafb;
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
            LAPORAN STOK BARANG
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
    <strong>Kategori:</strong>
    {{ $kategori ? ucwords(str_replace('_',' ', $kategori)) : 'Semua Kategori' }}
</div>

<!-- ================= TABLE ================= -->
<table>
<thead>
<tr>
    <th width="34%">Nama Produk</th>
    <th width="20%">Kategori</th>
    <th width="16%">Stok</th>
</tr>
</thead>

<tbody>
@forelse($stok as $s)
<tr>
    <td>{{ $s->nama }}</td>
    <td>{{ ucwords(str_replace('_',' ', $s->kategori)) }}</td>
    <td>{{ $s->stok }}</td>
</tr>
@empty
<tr>
    <td colspan="3" style="text-align:center; padding:12px; color:#6b7280;">
        Tidak ada data stok
    </td>
</tr>
@endforelse
</tbody>
</table>

</body>
</html>
