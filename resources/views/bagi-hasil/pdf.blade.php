<!DOCTYPE html>
@php
    $logoPath = public_path('logo-icon.png');
    $logoBase64 = base64_encode(file_get_contents($logoPath));
@endphp

<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Bagi Hasil</title>

<style>
@page { margin: 32px; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #111827;
}

/* TABLE GLOBAL */
table {
    width: 100%;
    border-collapse: collapse;
}

/* HEADER */
.header-title {
    font-size: 19px;
    font-weight: 700;
    letter-spacing: 0.6px;
}

/* GARIS */
.divider {
    border-top: 2px solid #111827;
    margin: 6px 0 10px;
}

/* SECTION */
.section { margin-bottom: 18px; }
.section-title {
    font-weight: bold;
    margin-bottom: 6px;
}

/* TABLE DATA */
th, td {
    border: 1px solid #e5e7eb;
    padding: 8px 10px;
    font-size: 12px;
}
th {
    background: #f3f4f6;
    text-align: left;
}
.text-right {
    text-align: right;
    white-space: nowrap;
}
.bold { font-weight: bold; }
.muted { color:#6b7280; }
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
            LAPORAN BAGI HASIL
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

<!-- GARIS HITAM BAWAH JUDUL (WAJIB ADA) -->
<div style="
    border-bottom:2px solid #111827;
    margin:6px 0 12px;
"></div>
<!-- SUB INFO -->
<div style="font-size:11px; margin-bottom:16px;">
    <strong>Tanggal:</strong>
    {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d M Y') }}
    s/d
    {{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d M Y') }}
</div>

<!-- ================= PEMASUKAN ================= -->
<div class="section">
    <div class="section-title">Ringkasan Pemasukan</div>
    <table>
        <tr>
            <td>Total Layanan</td>
            <td class="text-right">Rp {{ number_format($totalLayanan,0,',','.') }}</td>
        </tr>

        <tr class="bold">
            <td>Total Pemasukan</td>
            <td class="text-right">Rp {{ number_format($totalPemasukan,0,',','.') }}</td>
        </tr>
    </table>
</div>

<!-- ================= KARYAWAN ================= -->
<div class="section">
    <div class="section-title">Rincian Karyawan</div>
    <div style="
    margin-bottom:8px;
    font-size:12px;
    font-weight:400;
">
    Total 40% Layanan (Hak Karyawan):
    Rp {{ number_format($totalLayanan * 0.4,0,',','.') }}
</div>


    <table>
        <thead>
            
            <tr>
                <th>Nama</th>
                <th class="text-right"> Hasil 40% </th>
                <th class="text-right">Kupon</th>
                <th class="text-right">Kasbon</th>
                <th class="text-right">Diterima</th>
            </tr>
        </thead>
        <tbody>
        @forelse($dataKaryawan as $k)
            <tr>
                <td>{{ $k->nama }}</td>
                <td class="text-right">Rp {{ number_format($k->hasil40 ?? 0,0,',','.') }}</td>
                <td class="text-right">Rp {{ number_format($k->kupon ?? 0,0,',','.') }}</td>
                <td class="text-right">Rp {{ number_format($k->kasbon ?? $k->kasbon_awal ?? 0,0,',','.') }}</td>
                <td class="text-right bold">Rp {{ number_format($k->diterima ?? 0,0,',','.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="muted" style="text-align:center;">
                    Tidak ada data karyawan
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<!-- ================= KASIR ================= -->
<div class="section">
    <div class="section-title">Kasir</div>
    <table>
        <tr>
            <td>Gaji Kasir</td>
            <td class="text-right">
                Rp {{ number_format($kasirData['gaji'],0,',','.') }}
            </td>
        </tr>
        <tr>
            <td>Kasbon Kasir</td>
            <td class="text-right">
                Rp {{ number_format($kasirData['kasbon'],0,',','.') }}
            </td>
        </tr>
        <tr class="bold">
            <td>Diterima Kasir</td>
            <td class="text-right">
                Rp {{ number_format($kasirData['diterima'],0,',','.') }}
            </td>
        </tr>
    </table>
</div>
<!-- ================= PEMILIK ================= -->
<div class="section">
    <div class="section-title">Diterima Pemilik</div>
    <table>

        <tr>
            <td>+ 60% Total Layanan</td>
            <td class="text-right">
                Rp {{ number_format($hasil60,0,',','.') }}
            </td>
        </tr>

        <tr>
            <td>+ Total Minuman</td>
            <td class="text-right">Rp {{ number_format($totalMinuman,0,',','.') }}</td>
        </tr>

        <tr>
            <td>- Operasional</td>
            <td class="text-right">
                Rp {{ number_format($operasional,0,',','.') }}
            </td>
        </tr>
         <tr>
            <td>- Kupon</td>
            <td class="text-right">Rp {{ number_format($totalKupon,0,',','.') }}</td>
        </tr>
         <tr>
            <td>- Gaji Kasir</td>
            <td class="text-right">Rp {{ number_format($gajiKasir,0,',','.') }}</td>
        </tr>

        <tr class="bold">
            <td>Diterima Pemilik</td>
            <td class="text-right">
                Rp {{ number_format($pemilikTerima,0,',','.') }}
            </td>
        </tr>

    </table>
</div>
</body>
</html>
