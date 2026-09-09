<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class BagiHasilController extends Controller
{
    public function index()
    {
        $periode = DB::table('periode')
            ->where('status', 'aktif')
            ->first();

        if (!$periode) {
            $periode = (object) [
                'id' => null,
                'tanggal_mulai' => now()->toDateString()
            ];
        }

        $tanggalKupon = $periode->tanggal_mulai;

        /* ===============================
           PEMASUKAN
        =============================== */
        $totalLayanan = DB::table('pemasukan')
            ->where('kategori', 'layanan')
            ->when($periode->id, fn($q) => $q->where('periode_id', $periode->id))
            ->sum('total');

        $totalMinuman = DB::table('pemasukan')
            ->where('kategori', 'minuman')
            ->when($periode->id, fn($q) => $q->where('periode_id', $periode->id))
            ->sum('total');

        /* ===============================
           KARYAWAN (40%)
        =============================== */
        $karyawans = DB::table('karyawans')
            ->where('jabatan', 'like', '%karyawan%')
            ->where('status', 'aktif')
            ->get();

        $transaksiKupon = DB::table('pesanan')
            ->where('kategori', 'layanan')
            ->where('harga', 0)
            ->where('kupon_dibayar', 0)
            ->whereBetween('tanggal', [
                $periode->tanggal_mulai,
                $periode->tanggal_selesai ?? now()
            ])
            ->select('tanggal')
            ->get();

        $bonusKuponPerKaryawan = [];
foreach ($karyawans as $k) {
    $bonusKuponPerKaryawan[$k->id] = 0;
}

foreach ($transaksiKupon as $trx) {
    $aktifSaatItu = $karyawans->filter(fn($k) => $k->tanggal_masuk <= $trx->tanggal);
    if ($aktifSaatItu->count() === 0) continue;

    // Setiap karyawan aktif mendapat 24.000
    foreach ($aktifSaatItu as $k) {
        $bonusKuponPerKaryawan[$k->id] += 24000;
    }
}


        $hasil40 = $totalLayanan * 0.4;
        $perKaryawan = $karyawans->count() > 0 ? $hasil40 / $karyawans->count() : 0;
        $dataKaryawan = $karyawans->map(function ($k) use ($perKaryawan, $bonusKuponPerKaryawan, $periode) {

$kasbonAwal = DB::table('pengeluarans')
    ->where('jenis','kasbon')
    ->where('karyawan_id',$k->id)
    ->where('periode_id', $periode->id)
    ->sum('total');

$kupon = $bonusKuponPerKaryawan[$k->id] ?? 0;

$hak = (int) ($perKaryawan + $kupon);

if ($kasbonAwal > $hak) {
    $sisaKasbon = $kasbonAwal - $hak;
    $diterima   = 0;

    $statusKasbon = 'ERROR'; // indikator
} else {
    $sisaKasbon = 0;
    $diterima   = $hak - $kasbonAwal;

    $statusKasbon = 'OK';
}

return [
    'id'          => $k->id,
    'nama'        => $k->nama,
    'hasil40'     => $perKaryawan,
    'kupon'       => $kupon,
    'kasbon'      => $kasbonAwal,
    'sisa_kasbon' => $sisaKasbon,
    'status_kasbon' => $statusKasbon,
    'diterima'    => $diterima,
];

        });

        $totalKasbonKaryawan = DB::table('pengeluarans as p')
            ->join('karyawans as k', 'k.id', '=', 'p.karyawan_id')
            ->where('p.jenis', 'kasbon')
            ->where('k.jabatan', 'like', '%karyawan%')
           ->where('p.periode_id', $periode->id)
->sum('p.total');


        /* ===============================
           KASIR (GAJI + KASBON)
        =============================== */
        $draftKasir = DB::table('pengeluarans')
            ->where('jenis', 'draft_gaji_kasir')
            ->where('periode_id', $periode->id)
            ->first();

        $gajiKasir = DB::table('pengeluarans')
    ->whereIn('jenis', ['draft_gaji_kasir', 'gaji_kasir'])
    ->where('periode_id', $periode->id)
    ->sum('total');


        // ✅ SYARAT TOMBOL TUTUP PERIODE
        $gajiKasirSudahDisimpan = $draftKasir && $draftKasir->total > 0;

        /* =====================================================
           ✅ KASBON KASIR (FIX FINAL – TANPA PERIODE)
        ===================================================== */
$kasirId = DB::table('karyawans')
    ->where('jabatan', 'like', '%kasir%')
    ->where('status', 'aktif')
    ->value('id');
$kasbonKasir = DB::table('pengeluarans')
    ->where('jenis', 'kasbon')
    ->where('karyawan_id', $kasirId)
    ->where('periode_id', $periode->id)
    ->sum('total');

$diterimaKasir   = max($gajiKasir - $kasbonKasir, 0);
$sisaKasbonKasir = max($kasbonKasir - $gajiKasir, 0);


        /* ===============================
           OPERASIONAL
        =============================== */
        $operasional = DB::table('pengeluarans')
            ->whereIn('jenis', ['makan_karyawan', 'minum_karyawan', 'tagihan', 'lain_lain'])
            ->when($periode->id, fn($q) => $q->where('periode_id', $periode->id))
            ->sum('total');

            $totalKupon = array_sum($bonusKuponPerKaryawan);

        /* ===============================
           PEMILIK
        =============================== */
        $dataPemilik = [
            'hasil60' => $totalLayanan * 0.6,
            'minuman' => $totalMinuman,
            'kupon' => $totalKupon,  

            // ❗ hanya INFORMASI
            'kasbon_karyawan' => $totalKasbonKaryawan,
            'kasbon_kasir'    => $kasbonKasir,

            // potongan
            'operasional' => $operasional,
            'gaji_kasir'  => $gajiKasir,

            // ✅ RUMUS FINAL PEMILIK
            'total' =>
                ($totalLayanan * 0.6)
                + $totalMinuman
                 - $totalKupon 
                - $operasional
                - $gajiKasir,
        ];

return view('bagi-hasil.index', compact(
    'dataKaryawan',
    'gajiKasir',
    'kasbonKasir',
    'diterimaKasir',
    'sisaKasbonKasir',
    'dataPemilik',
    'gajiKasirSudahDisimpan'
));

    }

    public function simpanGajiKasir(Request $request)
    {
        $periode = DB::table('periode')
    ->where('status', 'aktif')
    ->first();

$gajiKasir = (int) $request->gaji_kasir;

$kasirId = DB::table('karyawans')
    ->where('jabatan', 'like', '%kasir%')
    ->where('status', 'aktif')
    ->value('id');

$kasbonKasir = DB::table('pengeluarans')
    ->where('jenis', 'kasbon')
    ->where('karyawan_id', $kasirId)
    ->where('periode_id', $periode->id)
    ->sum('total');

// 🔒 GUARD WAJIB
if ($gajiKasir < $kasbonKasir) {
    return back()->with([
        'error' => 'Bagi hasil tidak bisa disimpan karena kasbon lebih besar dari gaji',
        'error_tab' => 'kasir'
    ]);
}

        $request->validate([
            'gaji_kasir' => 'required|integer|min:0'
        ]);

        $periode = DB::table('periode')->where('status', 'aktif')->first();

        DB::table('pengeluarans')->updateOrInsert(
            [
                'jenis' => 'draft_gaji_kasir',
                'periode_id' => $periode?->id
            ],
            [
                'nominal' => $request->gaji_kasir,
                'total' => $request->gaji_kasir,
                'tanggal' => now(),
                'lunas' => 0,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return back()->with('success', 'Bagi hasil berhasil disimpan periode ini akan segera berakhir');
    }

    public function pdf($periodeId)
    {
        /* ===============================
           1. PERIODE
        =============================== */
        $periode = DB::table('periode')->where('id', $periodeId)->first();
        if (!$periode) abort(404);

        /* ===============================
           2. PEMASUKAN (ARSIP)
        =============================== */
        $totalLayanan = DB::table('pemasukan')
            ->where('kategori','layanan')
            ->where('periode_id',$periodeId)
            ->sum('total');

        $totalMinuman = DB::table('pemasukan')
            ->where('kategori','minuman')
            ->where('periode_id',$periodeId)
            ->sum('total');

        $totalPemasukan = $totalLayanan + $totalMinuman;

        /* ===============================
           3. KARYAWAN (ARSIP)
        =============================== */
        $isFinal = $periode->status === 'selesai';

        if ($isFinal) {
            // 🔒 DATA FINAL (SETELAH TUTUP PERIODE)
            $dataKaryawan = DB::table('karyawans as k')
                ->leftJoin('pengeluarans as g', function($q) use ($periodeId){
                    $q->on('k.id','=','g.karyawan_id')
                      ->where('g.jenis','gaji_karyawan')
                      ->where('g.periode_id',$periodeId);
                })
                ->leftJoin('pengeluarans as ku', function($q) use ($periodeId){
                    $q->on('k.id','=','ku.karyawan_id')
                      ->where('ku.jenis','kupon_karyawan')
                      ->where('ku.periode_id', $periodeId);
                })
                  ->leftJoin('pengeluarans as ka', function($q) use ($periodeId){
    $q->on('k.id','=','ka.karyawan_id')
      ->where('ka.jenis','kasbon')
      ->where('ka.periode_id', $periodeId);
})

                ->where('k.jabatan','like','%karyawan%')
                ->where('k.status','aktif') 
                ->whereDate('k.tanggal_masuk','<=',$periode->tanggal_selesai)

                ->select(
                    'k.nama',
                    DB::raw('COALESCE(g.total,0) as hasil40'),
                    DB::raw('SUM(COALESCE(ku.total,0)) as kupon'),
                    DB::raw('SUM(ka.total) as kasbon_awal')
                )
                ->groupBy('k.id','k.nama','g.total')
                ->get();
$dataKaryawan = $dataKaryawan->map(function ($k) {

    $hak = (int) ($k->hasil40 + $k->kupon);
    $kasbonAwal = (int) ($k->kasbon_awal ?? 0);

    if ($kasbonAwal > $hak) {
        $k->sisa_kasbon = $kasbonAwal - $hak;
        $k->diterima = 0;
    } else {
        $k->sisa_kasbon = 0;
        $k->diterima = $hak - $kasbonAwal;
    }

    return $k;
});


        } else {
            // 🔥 DATA AKTIF (SAMA DENGAN index)
            $karyawans = DB::table('karyawans')
                ->where('jabatan','like','%karyawan%')
                ->where('status','aktif')
                ->get();

            // === HITUNG KUPON ===
            $transaksiKupon = DB::table('pesanan')
                ->where('kategori','layanan')
                ->where('harga',0)
                ->where('kupon_dibayar',0)
                ->whereBetween('tanggal', [
                    $periode->tanggal_mulai,
                    $periode->tanggal_selesai ?? now()
                ])
                ->select('tanggal')
                ->get();

            $bonusKupon = [];
            foreach ($karyawans as $k) {
                $bonusKupon[$k->id] = 0;
            }

            foreach ($transaksiKupon as $trx) {
                $aktifSaatItu = $karyawans->filter(
                    fn($k) => $k->tanggal_masuk <= $trx->tanggal
                );

                if ($aktifSaatItu->count() === 0) continue;

               foreach ($aktifSaatItu as $k) {
    $bonusKupon[$k->id] += 24000;
}

            }
            $totalKupon = array_sum($bonusKupon);

            // === HITUNG 40% ===
            $hasil40 = $totalLayanan * 0.4;
            $perKaryawan = $karyawans->count() > 0
                ? $hasil40 / $karyawans->count()
                : 0;

            $dataKaryawan = $karyawans->map(function ($k) use ($perKaryawan, $bonusKupon, $periodeId) {

   $kasbon = DB::table('pengeluarans')
        ->where('jenis','kasbon')
        ->where('karyawan_id',$k->id)
        ->where('periode_id', $periodeId)
        ->sum(DB::raw('COALESCE(sisa_kasbon, total)'));

                $kupon = $bonusKupon[$k->id] ?? 0;

                $hak = $perKaryawan + $kupon;

$kasbon = (int) $kasbon;
$hak    = (int) ($perKaryawan + $kupon);

$sisaKasbon = max($kasbon - $hak, 0);
$diterima   = max($hak - $kasbon, 0);

return (object)[
    'id'          => $k->id,
    'nama'        => $k->nama,
    'hasil40'     => $perKaryawan,
    'kupon'       => $kupon,
    'kasbon'      => $kasbon,
    'sisa_kasbon' => $sisaKasbon,
    'diterima'    => $diterima,
];
            });
        }

        $totalGajiKaryawan = DB::table('pengeluarans')
            ->where('jenis','gaji_karyawan')
            ->where('periode_id',$periodeId)
            ->sum('total');


        /* ===============================
           4. KASIR (ARSIP)
        =============================== */
$kasir = DB::table('karyawans')
    ->where('jabatan', 'kasir')
    ->first();

$gajiKasir = DB::table('pengeluarans')
    ->where('jenis', 'gaji_kasir')
    ->where('periode_id', $periodeId)
    ->sum('total');

if ($periode->status === 'selesai') {
    // 🔒 DATA ARSIP
    $kasbonKasir = DB::table('pengeluarans')
        ->where('jenis', 'kasbon_awal_kasir')
        ->where('periode_id', $periodeId)
        ->sum('total');
} else {
    // 🔥 DATA LIVE
    $kasirId = DB::table('karyawans')
        ->where('jabatan', 'kasir')
        ->where('status', 'aktif')
        ->value('id');

    $kasbonKasir = DB::table('pengeluarans')
        ->where('jenis', 'kasbon')
        ->where('karyawan_id', $kasirId)
        ->where('periode_id', $periodeId)
        ->sum('total');
}

$diterimaKasir = max($gajiKasir - $kasbonKasir, 0);
$sisaKasbonKasir = max($kasbonKasir - $gajiKasir, 0);

$kasirData = [
    'nama'        => $kasir->nama,
    'gaji'        => $gajiKasir,
    'kasbon'      => $kasbonKasir,
    'sisa_kasbon' => $sisaKasbonKasir,
    'diterima'    => $diterimaKasir,
];
        /* ===============================
           5. OPERASIONAL
        =============================== */
        $operasional = DB::table('pengeluarans')
            ->whereIn('jenis',['makan_karyawan','minum_karyawan','tagihan','lain_lain'])
            ->where('periode_id',$periodeId)
            ->sum('total');

        /* ===============================
           6. PEMILIK (FIX FINAL)
        =============================== */

        // 1️⃣ hitung 60% layanan
        $hasil60 = $totalLayanan * 0.6;

        // 2️⃣ hitung kasbon karyawan
        $totalKasbonKaryawan = DB::table('pengeluarans as p')
            ->join('karyawans as k','k.id','=','p.karyawan_id')
            ->where('p.jenis','kasbon')
            ->where('p.periode_id',$periodeId)
            ->where('k.jabatan','like','%karyawan%')
            ->sum('p.sisa_kasbon');

        $totalKupon = DB::table('pengeluarans')
    ->where('jenis', 'kupon_karyawan')
    ->where('periode_id', $periode->id)
    ->sum('total');
    
        // 3️⃣ total diterima pemilik
        $pemilikTerima =
            $hasil60
            + $totalMinuman
             - $totalKupon 
            - $operasional
            - $gajiKasir;

$totalKupon = DB::table('pengeluarans')
    ->where('jenis', 'kupon_karyawan')
    ->where('periode_id', $periode->id)
    ->sum('total');
        /* ===============================
           7. PDF
        =============================== */
        return Pdf::loadView('bagi-hasil.pdf', compact(
            'periode',
            'totalLayanan',
            'totalMinuman',
            'totalPemasukan',
            'dataKaryawan',
            'totalGajiKaryawan',
            'gajiKasir',       // ⬅️ WAJIB
            'kasbonKasir', 
            'kasirData',
            'operasional',
            'hasil60',
            'totalKasbonKaryawan',
            'pemilikTerima',
            'totalKupon'
        ))->stream('laporan-bagi-hasil.pdf');
    }

 public function laporan()
{
    $periodes = DB::table('periode')
        ->when(request('periode'), function ($q) {
            [$year, $month] = explode('-', request('periode'));
            $q->whereYear('tanggal_mulai', $year)
              ->whereMonth('tanggal_mulai', $month);
        }, function ($q) {
            // DEFAULT: tahun sekarang
            $q->whereYear('tanggal_mulai', now()->year);
        })
        ->orderByRaw("CASE WHEN status = 'aktif' THEN 0 ELSE 1 END") 
        ->orderByDesc('tanggal_mulai')
        ->get();

    return view('bagi-hasil.laporan', compact('periodes'));
}

}