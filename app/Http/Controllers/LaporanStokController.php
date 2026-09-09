<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanStokController extends Controller
{
    public function index(Request $request)
{
    $kategori = $request->kategori;

    $stok = DB::table('produk')
        // 🔒 KUNCI: hanya stok_barang & minuman
        ->whereIn('kategori', ['stok_barang', 'minuman'])
        ->when($kategori, function ($q) use ($kategori) {
            $q->where('kategori', $kategori);
        })
        ->orderBy('nama')
        ->get();

    $totalStok = $stok->sum('stok');

    return view('stok.index', compact(
        'stok',
        'kategori',
        'totalStok'
    ));
}

public function export(Request $request)
{
    $kategori = $request->kategori;

    $stok = DB::table('produk')
        // 🔒 KUNCI: hanya stok_barang & minuman
        ->whereIn('kategori', ['stok_barang', 'minuman'])
        ->when($kategori, function ($q) use ($kategori) {
            $q->where('kategori', $kategori);
        })
        ->orderBy('nama')
        ->get();

    $totalStok = $stok->sum('stok');

    return Pdf::loadView('stok.pdf', compact(
        'stok',
        'kategori',
        'totalStok'
    ))->download('laporan-stok.pdf');
}

}
