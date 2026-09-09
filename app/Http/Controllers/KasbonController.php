<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class KasbonController extends Controller
{
    public function index()
    {
        $kasbons = DB::table('pengeluarans')
            ->join('karyawans', 'pengeluarans.karyawan_id', '=', 'karyawans.id')
            ->where('pengeluarans.jenis', 'kasbon')
            ->where('pengeluarans.lunas', 0) // ✅ HANYA KASBON AKTIF
            ->select(
                'karyawans.id',
                'karyawans.nama',

                // ✅ JUMLAH SISA KASBON YANG SEBENARNYA
                DB::raw('SUM(COALESCE(pengeluarans.sisa_kasbon, pengeluarans.total)) as total_kasbon'),

                // ✅ GABUNG KETERANGAN (OPSIONAL)
                DB::raw("
                    GROUP_CONCAT(
                        DISTINCT pengeluarans.keterangan
                        SEPARATOR ', '
                    ) as keterangan
                ")
            )
            ->groupBy('karyawans.id', 'karyawans.nama')
            ->orderBy('karyawans.nama')
            ->get();

        $totalSemuaKasbon = $kasbons->sum('total_kasbon');

        return view('kasbon.index', compact(
            'kasbons',
            'totalSemuaKasbon'
        ));
    }
}
