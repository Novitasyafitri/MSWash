<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'pemilik') {
            return $this->dashboardPemilik();
        }

        return $this->dashboardKasir();
    }

private function dashboardPemilik()
{
    // =============================
    // AMBIL PERIODE AKTIF
    // =============================
    $periode = DB::table('periode')
    ->where('status', 'aktif')
    ->first();

if (!$periode) {
    // 🔥 AUTO BUAT PERIODE BARU
    $id = DB::table('periode')->insertGetId([
        'nama' => 'Periode ' . now()->format('M Y'),
        'tanggal_mulai' => now(),
        'status' => 'aktif',
        'saldo_awal' => 0,
        'saldo_akhir' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $periode = DB::table('periode')->where('id', $id)->first();
}


    if (!$periode) {
        // fallback aman
        return view('dashboard_pemilik', [
            'saldoTotal' => 0,
            'pemasukanPeriodeAktif' => 0,
            'pengeluaranPeriodeAktif' => 0,
            'pelangganHariIni' => 0,
            'periodeAktif' => '-',
            'combined' => [],
            'harian' => [
                'pemasukan' => 0,
                'pengeluaran' => 0
            ]
        ]);
    }

    // =============================
    // HITUNG PEMASUKAN & PENGELUARAN
    // =============================
    $pemasukanPeriodeAktif = DB::table('pemasukan')
        ->where('periode_id', $periode->id)
        ->sum('total');

    $pengeluaranPeriodeAktif = DB::table('pengeluarans')
        ->where('periode_id', $periode->id)
        ->whereIn('jenis', [
            'stok_barang',
            'minuman',
            'kasbon',
            'makan_karyawan',
            'minum_karyawan',
            'tagihan',
            'lain_lain',
            'gaji_karyawan',
            'gaji_kasir',
            'penarikan_pemilik',
        ])
        ->sum('total');

    // =============================
    // SALDO PERIODE AKTIF
    // =============================
    $saldoTotal =
    ($periode->saldo_awal ?? 0)
    + $pemasukanPeriodeAktif
    - $pengeluaranPeriodeAktif;

    $pelangganPeriodeAktif = DB::table('pesanan')
    ->whereDate('tanggal', '>=', $periode->tanggal_mulai)
    ->whereDate(
        'tanggal',
        '<=',
        $periode->tanggal_selesai ?? now()
    )
    ->count();

    // =============================
    // DATA GRAFIK (HISTORI PERIODE)
    // =============================
    $combined = DB::table('periode')
    ->orderBy('tanggal_mulai')
    ->get()
    ->map(function ($p) {

        $pemasukan = DB::table('pemasukan')
            ->where('periode_id', $p->id)
            ->sum('total');

        $pengeluaran = DB::table('pengeluarans')
            ->where('periode_id', $p->id)
            ->sum('total');

        // 🔥 INI KUNCINYA
        $tanggalAkhir = (
    empty($p->tanggal_selesai) ||
    $p->tanggal_selesai === '0000-00-00'
)
    ? now()
    : $p->tanggal_selesai;


       // 🔥 TAMBAH HITUNG PELANGGAN DI SINI
$pelanggan = DB::table('pesanan')
    ->whereDate('tanggal', '>=', $p->tanggal_mulai)
    ->whereDate('tanggal', '<=', $tanggalAkhir)
    ->count();

return [
    'label' =>
        Carbon::parse($p->tanggal_mulai)->format('d M Y')
        . ' – ' .
        Carbon::parse($tanggalAkhir)->format('d M Y'),

    'pemasukan'   => $pemasukan,
    'pengeluaran' => $pengeluaran,

    // 🔥 INI YANG BARU
    'pelanggan'   => $pelanggan,
];
    });
// =============================
// DATA GRAFIK HARIAN (BARU)
// =============================
$tahunAktif = Carbon::now()->year;

$harianChart = DB::table('pemasukan')
    ->whereYear('tanggal', $tahunAktif) // 🔥 INI KUNCINYA
    ->select(
        DB::raw('DATE(tanggal) as tanggal'),
        DB::raw('SUM(total) as pemasukan')
    )
    ->groupBy(DB::raw('DATE(tanggal)'))
    ->orderBy('tanggal')
    ->get()
   ->map(function ($row) {

    $pengeluaran = DB::table('pengeluarans')
        ->whereDate('tanggal', $row->tanggal)
        ->sum('total');

    // 🔥 TAMBAH INI
    $pelanggan = DB::table('pesanan')
        ->whereDate('tanggal', $row->tanggal)
        ->count();

    return [
        'label' => Carbon::parse($row->tanggal)->translatedFormat('d M Y'),
        'pemasukan' => (int) $row->pemasukan,
        'pengeluaran' => (int) $pengeluaran,
        'pelanggan' => $pelanggan, // ⬅️ BARU
    ];
});
    // =============================
    // DONUT
    // =============================
    $harian = [
        'pemasukan'   => $pemasukanPeriodeAktif,
        'pengeluaran' => $pengeluaranPeriodeAktif,
    ];

    // =============================
// DATA GRAFIK BULANAN
// =============================
$tahunAktif = Carbon::parse($periode->tanggal_mulai)->year;

$bulanan = DB::table('periode')
    ->whereYear('tanggal_mulai', $tahunAktif) // 🔥 INI KUNCINYA
    ->select(
        DB::raw("MONTH(tanggal_mulai) as bulan"),
        DB::raw("SUM((SELECT IFNULL(SUM(total),0) FROM pemasukan WHERE periode_id = periode.id)) as pemasukan"),
        DB::raw("SUM((SELECT IFNULL(SUM(total),0) FROM pengeluarans WHERE periode_id = periode.id)) as pengeluaran")
    )
    ->groupBy('bulan')
    ->orderBy('bulan')
    ->get()
->map(function ($row) use ($tahunAktif) {

    $awal = Carbon::create($tahunAktif, $row->bulan, 1)->startOfMonth();
    $akhir = Carbon::create($tahunAktif, $row->bulan, 1)->endOfMonth();

    $pelanggan = DB::table('pesanan')
        ->whereBetween('tanggal', [$awal, $akhir])
        ->count();

    return [
        'label' => Carbon::create($tahunAktif, $row->bulan, 1)->translatedFormat('M Y'),
        'pemasukan' => (int) $row->pemasukan,
        'pengeluaran' => (int) $row->pengeluaran,
        'pelanggan' => $pelanggan,
    ];
});

    // =============================
// DATA GRAFIK TAHUNAN
// =============================
$tahunan = DB::table('periode')
    ->select(
        DB::raw("YEAR(tanggal_mulai) as tahun"),
        DB::raw("SUM((SELECT IFNULL(SUM(total),0) FROM pemasukan WHERE periode_id = periode.id)) as pemasukan"),
        DB::raw("SUM((SELECT IFNULL(SUM(total),0) FROM pengeluarans WHERE periode_id = periode.id)) as pengeluaran")
    )
    ->groupBy('tahun')
    ->orderBy('tahun')
    ->get()
->map(function ($row) {

    $awal = Carbon::create($row->tahun, 1, 1)->startOfYear();
    $akhir = Carbon::create($row->tahun, 12, 31)->endOfYear();

    $pelanggan = DB::table('pesanan')
        ->whereBetween('tanggal', [$awal, $akhir])
        ->count();

    return [
        'label' => (string) $row->tahun,
        'pemasukan' => (int) $row->pemasukan,
        'pengeluaran' => (int) $row->pengeluaran,
        'pelanggan' => $pelanggan,
    ];
});

    return view('dashboard_pemilik', compact(
        'saldoTotal',
        'pemasukanPeriodeAktif',
        'pengeluaranPeriodeAktif',
        'pelangganPeriodeAktif',
        'combined',
        'harian',
        'harianChart',
        'bulanan',
        'tahunan'
    ));
}

 private function dashboardKasir()
{
    // =============================
    // AMBIL PERIODE AKTIF
    // =============================
    $periode = DB::table('periode')
    ->where('status', 'aktif')
    ->first();

if (!$periode) {
    // 🔥 AUTO BUAT PERIODE BARU
    $id = DB::table('periode')->insertGetId([
        'nama' => 'Periode ' . now()->format('M Y'),
        'tanggal_mulai' => now(),
        'status' => 'aktif',
        'saldo_awal' => 0,
        'saldo_akhir' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $periode = DB::table('periode')->where('id', $id)->first();
}


    if (!$periode) {
        return view('dashboard_kasir', [
            'saldoBerjalan' => 0,
            'pemasukanTotal' => 0,
            'pengeluaranTotal' => 0,
            'totalPesanan' => 0,
            'donut' => [
                'pemasukan' => 0,
                'pengeluaran' => 0,
            ],
            'pemasukanHariIni' => 0,
        ]);
    }

    // =============================
    // PEMASUKAN & PENGELUARAN PERIODE AKTIF
    // =============================
    $pemasukanTotal = DB::table('pemasukan')
        ->where('periode_id', $periode->id)
        ->sum('total');

    $pengeluaranTotal = DB::table('pengeluarans')
        ->where('periode_id', $periode->id)
        ->whereIn('jenis', [
            'stok_barang',
            'minuman',
            'kasbon',
            'makan_karyawan',
            'minum_karyawan',
            'tagihan',
            'lain_lain',
            'gaji_karyawan',
            'gaji_kasir',
            'penarikan_pemilik',
        ])
        ->sum('total');

    // =============================
    // SALDO BERJALAN (PERIODE)
    // =============================
    $saldoBerjalan = $pemasukanTotal - $pengeluaranTotal;

    // =============================
    // PESANAN MENUNGGU
    // =============================
    $totalPesanan = DB::table('pesanan')
        ->where('kategori', 'layanan')
        ->where('status', 'menunggu')
        ->count();

    // =============================
    // PEMASUKAN HARI INI (INFO)
    // =============================
    $pemasukanHariIni = DB::table('pemasukan')
        ->where('periode_id', $periode->id)
        ->whereDate('tanggal', now())
        ->sum('total');

    // =============================
    // DONUT
    // =============================
    $donut = [
        'pemasukan'   => $pemasukanTotal,
        'pengeluaran' => $pengeluaranTotal,
    ];

    return view('dashboard_kasir', compact(
        'saldoBerjalan',
        'pemasukanTotal',
        'pengeluaranTotal',
        'totalPesanan',
        'donut',
        'pemasukanHariIni'
    ));
}
}
