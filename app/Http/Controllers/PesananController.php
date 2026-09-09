<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
public function index(Request $request)
{
    $query = DB::table('pesanan');

    // =========================
    // KHUSUS KASIR (TANPA BATAS TANGGAL)
    // =========================
if (auth()->user()->role == 'kasir') {

    if ($request->filled('tanggal')) {
        // 🔥 KASIR PILIH TANGGAL → SEMUA STATUS
        $query->whereDate('tanggal', $request->tanggal);
    } else {
        // 🔥 DEFAULT KASIR → HANYA MENUNGGU
        $query->where('status', 'menunggu');
    }

} else {

    // =========================
    // PEMILIK (TANPA DEFAULT TANGGAL)
    // =========================
    if ($request->filled('tanggal')) {
        $query->whereDate('tanggal', $request->tanggal);
    } else {
        $query->whereDate('tanggal', now()->toDateString());
    }
}

    $pesanan = $query
        ->orderBy('tanggal', 'desc')
        ->orderBy('id', 'desc')
        ->get();

  $tanggal = $request->tanggal;

    return view('pesanan.index', compact('pesanan', 'tanggal'));
}

   public function siap($id)
{
    DB::table('pesanan')->where('id', $id)->update([
        'status' => 'siap',
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('pesanan_siap', true);
}


}
