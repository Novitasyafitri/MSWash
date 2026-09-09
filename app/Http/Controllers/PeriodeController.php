<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodeController extends Controller
{
    public function tutup(Request $request)
    {
        DB::beginTransaction();

        try {

            /* =====================================================
                1. AMBIL PERIODE AKTIF
            ===================================================== */
            $periode = DB::table('periode')->where('status', 'aktif')->first();
            if (!$periode) {
                return back()->with('error', 'Tidak ada periode aktif');
            }

            /* =====================================================
                2. SIMPAN GAJI KARYAWAN (HASIL BAGI HASIL)
            ===================================================== */
            $karyawans = DB::table('karyawans')
                ->where('jabatan', 'like', '%karyawan%')
                ->where('status', 'aktif')
                ->get();

            $totalLayanan = DB::table('pemasukan')
                ->where('kategori', 'layanan')
                ->where('periode_id', $periode->id)
                ->sum('total');

            $hasil40 = $totalLayanan * 0.4;
            $perKaryawan = $karyawans->count() > 0
                ? $hasil40 / $karyawans->count()
                : 0;

            /* =====================================================
               2B. SIMPAN KUPON GRATIS KARYAWAN (ARSIP PERIODE)
            ===================================================== */

            $transaksiKupon = DB::table('pesanan')
                ->where('kategori', 'layanan')
                ->where('harga', 0)
                ->where('kupon_dibayar', 0)
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

                // 1 kupon = 24.000 untuk tiap karyawan aktif
$nilaiKupon = 24000;

foreach ($aktifSaatItu as $k) {
    $bonusKupon[$k->id] += $nilaiKupon;
}
            }

            foreach ($bonusKupon as $karyawanId => $nilai) {
                if ($nilai <= 0) continue;

                DB::table('pengeluarans')->insert([
                    'jenis'        => 'kupon_karyawan',
                    'karyawan_id'  => $karyawanId,
                    'periode_id'   => $periode->id,
                    'total'        => $nilai,
                    'tanggal'      => now(),
                    'lunas'        => 1,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }


            foreach ($karyawans as $karyawan) {
                DB::table('pengeluarans')->insert([
                    'jenis'        => 'gaji_karyawan',
                    'karyawan_id'  => $karyawan->id,
                    'periode_id'   => $periode->id,
                    'total'        => $perKaryawan,
                    'tanggal'      => now(),
                    'lunas'        => 0,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }

            /* =====================================================
               3B. POTONG KASBON KARYAWAN
            ===================================================== */

            foreach ($karyawans as $karyawan) {

                $sisaGaji = $perKaryawan;

                $kasbons = DB::table('pengeluarans')
                    ->where('jenis', 'kasbon')
                    ->where('karyawan_id', $karyawan->id)
                    ->where('lunas', 0)
                    ->orderBy('tanggal')
                    ->get();

                foreach ($kasbons as $kasbon) {
                    if ($sisaGaji <= 0) break;

                    $sisaKasbon = $kasbon->sisa_kasbon ?? $kasbon->total;

                    // potong sesuai kemampuan gaji
                    $potong = min($sisaKasbon, $sisaGaji);
                    if ($potong > 0) {
                        DB::table('pengeluarans')->insert([
                            'jenis' => 'potong_kasbon_karyawan',
                            'karyawan_id'  => $karyawan->id,
                            'periode_id'   => $periode->id,
                            'total'        => $potong,
                            'tanggal'      => now(),
                            'lunas'        => 1,
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ]);
                    }

                    $sisaKasbon -= $potong;
                    $sisaGaji   -= $potong;

                    DB::table('pengeluarans')
                        ->where('id', $kasbon->id)
                        ->update([
                            'sisa_kasbon' => $sisaKasbon,
                            'lunas' => $sisaKasbon == 0 ? 1 : 0,
                            'updated_at' => now(),
                        ]);
                }
            }

            /* =====================================================
                4. SIMPAN & POTONG KASBON KASIR
            ===================================================== */
/* =====================================================
   4. SIMPAN & POTONG KASBON KASIR (FINAL URUT)
===================================================== */

// 1️⃣ Ambil draft gaji kasir
$draftKasir = DB::table('pengeluarans')
    ->where('jenis', 'draft_gaji_kasir')
    ->where('periode_id', $periode->id)
    ->first();

if (!$draftKasir || $draftKasir->total <= 0) {
    throw new \Exception('Gaji kasir belum valid');
}

// 2️⃣ Nilai gaji kasir
$gajiKasirAsli = $draftKasir->total;
$sisaGajiKasir = $gajiKasirAsli;

// 3️⃣ Inisialisasi kasbon yang sisa_kasbon masih NULL
DB::table('pengeluarans')
    ->where('jenis', 'kasbon')
    ->where(function ($q) {
        $q->where('lunas', 0)
          ->orWhereNull('lunas');
    })
    ->whereNull('sisa_kasbon')
    ->update([
        'sisa_kasbon' => DB::raw('total')
    ]);

// 4️⃣ Ambil ID kasir
$kasirId = DB::table('karyawans')
    ->where('jabatan', 'kasir')
    ->where('status', 'aktif')
    ->value('id');

if (!$kasirId) {
    throw new \Exception('Kasir aktif tidak ditemukan');
}

// 5️⃣ 🔥 ARSIP KASBON AWAL KASIR (SEBELUM DIPOTONG)
$kasbonAwalKasir = DB::table('pengeluarans')
    ->where('jenis', 'kasbon')
    ->where('karyawan_id', $kasirId)
    ->where(function ($q) {
        $q->where('lunas', 0)
          ->orWhereNull('lunas');
    })
    ->sum(DB::raw('COALESCE(sisa_kasbon, total)'));

DB::table('pengeluarans')->updateOrInsert(
    [
        'jenis'      => 'kasbon_awal_kasir',
        'periode_id' => $periode->id,
    ],
    [
        'karyawan_id' => $kasirId,
        'total'       => $kasbonAwalKasir,
        'tanggal'     => now(),
        'lunas'       => 0,
        'created_at'  => now(),
        'updated_at'  => now(),
    ]
);

// 6️⃣ Ambil kasbon kasir untuk dipotong
$kasbonKasir = DB::table('pengeluarans')
    ->where('jenis', 'kasbon')
    ->where('karyawan_id', $kasirId)
    ->where(function ($q) {
        $q->where('lunas', 0)
          ->orWhereNull('lunas');
    })
    ->orderBy('tanggal')
    ->limit(1)   // ⬅️ PENTING
    ->get();

// 7️⃣ Proses potong kasbon kasir
foreach ($kasbonKasir as $kasbon) {

    if ($sisaGajiKasir <= 0) {
        break;
    }

    $sisaKasbon = $kasbon->sisa_kasbon ?? $kasbon->total;
    $potong = min($sisaKasbon, $sisaGajiKasir);

    if ($potong > 0) {
        DB::table('pengeluarans')->insert([
            'jenis'        => 'potong_kasbon_kasir',
            'karyawan_id'  => $kasirId,
            'periode_id'   => $periode->id,
            'total'        => $potong,
            'tanggal'      => now(),
            'lunas'        => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }

    $sisaKasbon   -= $potong;
    $sisaGajiKasir -= $potong;

    DB::table('pengeluarans')
        ->where('id', $kasbon->id)
        ->update([
            'sisa_kasbon' => $sisaKasbon,
            'lunas'       => $sisaKasbon == 0 ? 1 : 0,
            'updated_at'  => now(),
        ]);
}

// 8️⃣ Simpan gaji kasir
DB::table('pengeluarans')->insert([
    'jenis'        => 'gaji_kasir',
    'periode_id'   => $periode->id,
    'karyawan_id'  => $kasirId,
    'total'        => $gajiKasirAsli,
    'tanggal'      => now(),
    'lunas'        => 1,
    'created_at'   => now(),
    'updated_at'   => now(),
]);

// 9️⃣ Hapus draft gaji kasir
DB::table('pengeluarans')
    ->where('jenis', 'draft_gaji_kasir')
    ->where('periode_id', $periode->id)
    ->delete();

// 10️⃣ Tandai kupon sudah dibayar
DB::table('pesanan')
    ->where('kategori', 'layanan')
    ->where('harga', 0)
    ->where('kupon_dibayar', 0)
    ->update([
        'kupon_dibayar' => 1,
        'updated_at' => now()
    ]);
/* =====================================================
   🔒 GUARD: KASBON WAJIB LUNAS PER PERIODE
===================================================== */

$kasbonBelumLunasKaryawan = DB::table('pengeluarans')
    ->where('jenis', 'kasbon')
    ->where(function ($q) {
        $q->where('lunas', 0)
          ->orWhere('sisa_kasbon', '>', 0);
    })
    ->whereIn('karyawan_id', function ($q) {
        $q->select('id')
          ->from('karyawans')
          ->where('jabatan', 'like', '%karyawan%')
          ->where('status', 'aktif');
    })
    ->exists();

// cek kasbon kasir
$kasirId = DB::table('karyawans')
    ->where('jabatan', 'kasir')
    ->where('status', 'aktif')
    ->value('id');

$kasbonBelumLunasKasir = DB::table('pengeluarans')
    ->where('jenis', 'kasbon')
    ->where('karyawan_id', $kasirId)
    ->where(function ($q) {
        $q->where('lunas', 0)
          ->orWhere('sisa_kasbon', '>', 0);
    })
    ->exists();

if ($kasbonBelumLunasKaryawan || $kasbonBelumLunasKasir) {
    DB::rollBack();

    if ($kasbonBelumLunasKasir) {
        return redirect()->back()->with([
            'error' => 'Kasbon kasir belum lunas. Periode tidak bisa ditutup.',
            'error_tab' => 'kasir'
        ]);
    }

    return redirect()->back()->with([
        'error' => 'Masih ada kasbon karyawan yang belum lunas.',
        'error_tab' => 'karyawan'
    ]);
}

$totalKupon = DB::table('pengeluarans')
    ->where('jenis', 'kupon_karyawan')
    ->where('periode_id', $periode->id)
    ->sum('total');

DB::table('periode')->where('id', $periode->id)->update([
    'updated_at'  => now(),
]);

/* =====================================================
   5. TUTUP & BUKA PERIODE
===================================================== */
DB::table('periode')->where('id', $periode->id)->update([
    'status' => 'selesai',
    'tanggal_selesai' => now(), // ⬅️ INI YANG WAJIB ADA
    'updated_at' => now(),
]);
$periodeBaruId = DB::table('periode')->insertGetId([
    'nama' => 'Periode ' . now()->format('M Y'),
    'tanggal_mulai' => now(),
    'status' => 'aktif',
    'saldo_awal' => 0,
    'saldo_akhir' => 0,
    'created_at' => now(),
    'updated_at' => now(),
]);
            DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Periode ditutup. Gaji & kasbon BERES.');

        } catch (\Throwable $e) {
    DB::rollBack();
    dd($e->getMessage());
}
    }
}