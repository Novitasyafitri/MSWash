<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class PemasukanController extends Controller
{
   public function index(Request $request)
{
    $tanggal = $request->tanggal;
    $isFilterMode = $request->filter ? true : false;

    // Jika klik Add Filter (filter mode aktif)
    if ($isFilterMode && !$tanggal) {
        $pemasukan = Pemasukan::orderBy('tanggal', 'DESC')->get();
    }
    // Jika memilih tanggal
    else if ($tanggal) {
        $pemasukan = Pemasukan::whereDate('tanggal', $tanggal)
            ->orderBy('tanggal', 'DESC')
            ->get();
    }
    // Default awal: semua data
    // Default awal: tampil HANYA periode aktif
else {
    $periode = \DB::table('periode')->where('status', 'aktif')->first();

    if ($periode) {
        $pemasukan = Pemasukan::where('periode_id', $periode->id)
            ->orderBy('tanggal', 'DESC')
            ->get();
    } else {
        $pemasukan = collect(); // kosong kalau tidak ada periode aktif
    }
}

    $totalPemasukan = $pemasukan->sum('total');

    return view('kasir.pemasukan.index', compact(
        'pemasukan',
        'totalPemasukan',
        'tanggal',
        'isFilterMode'
    ));
}
    public function create()
    {
        return view('kasir.pemasukan.create');
    }

    public function store(Request $request)
{
    $periode = \DB::table('periode')
        ->where('status', 'aktif')
        ->first();

    if (!$periode) {
        return back()->with('error', 'Tidak ada periode aktif');
    }

    $items = $request->items ?? [];

        foreach ($items as $item) {

            $produk = Produk::find($item['produk_id'] ?? null);
            if (!$produk) continue;

            $kategori = strtolower($produk->kategori);
            $qty      = intval($item['qty'] ?? 1);
            $tanggal  = $item['tanggal'] ?? date('Y-m-d');
            $plat     = $item['plat'] ?? null;

            $harga = $produk->harga;
            $total = $harga * $qty;
            $cuciGratis = false;

            // --- Validasi stok minuman ---
            if ($kategori === 'minuman' && $produk->stok < $qty) {
                return back()->with('error', "Stok {$produk->nama} tidak cukup! Sisa: {$produk->stok}")
                             ->withInput();
            }

            // --- Cek cuci gratis khusus 'cuci mobil' ---
            if ($kategori === 'layanan' && $plat) {

                // ==== CEK PAKET MOBIL (AMAN, ADA FALLBACK) ====
$isPaketMobil =
    ($produk->jenis === 'paket_mobil')
    || str_starts_with(strtolower($produk->nama), 'paket mobil');

if ($kategori === 'layanan' && $plat && $isPaketMobil) {

    $jumlahCuci = Pesanan::where('plat', $plat)
    ->whereHas('produk', function ($q) {
        $q->where('kategori', 'Layanan')
          ->where(function ($qq) {
              $qq->where('jenis', 'paket_mobil')
                 ->orWhere('nama', 'like', 'Paket Mobil%');
          });
    })
    ->count();


    if ((($jumlahCuci + 1) % 6) === 0) {
        $cuciGratis = true;
        $harga = 0;
        $total = 0;
    }
}

            }

            // --- Simpan pemasukan ---
            if (in_array($kategori, ['layanan','minuman'])) {
                Pemasukan::create([
                    'kategori'   => $kategori,
                    'item'       => $produk->nama,
                    'deskripsi'  => $produk->nama,
                    'qty'        => $qty,
                    'harga'      => $harga,
                    'total'      => $total,
                    'tanggal'    => $tanggal,
                    'plat'       => $plat,
                    'produk_id'  => $produk->id,
                    'kasir_id'   => Auth::id(),
                    'karyawan_id' => $item['karyawan_id'] ?? null,
                     'cuci_ke_6_gratis' => $cuciGratis ? 1 : 0,
                     'periode_id' => $periode->id,

                ]);
            }

            // --- Update stok minuman ---
            if ($kategori === 'minuman') {
                $produk->stok -= $qty;
                $produk->save();
            }

            // --- Simpan pesanan layanan ---
            if ($kategori === 'layanan') {
                Pesanan::create([
                    'tanggal'   => $tanggal,
                    'produk_id' => $produk->id,
                    'deskripsi' => $produk->nama,
                    'kategori'  => 'layanan',
                    'plat'      => $plat,
                    'harga'     => $harga,
                    'jumlah'    => $qty,
                    'kasir_id'  => Auth::id(),
                    'karyawan_id' => $item['karyawan_id'] ?? null,
                     'cuci_ke_6_gratis' => $cuciGratis ? 1 : 0,
                ]);
            }
        }

return redirect()->route('dashboard')
    ->with('success', 'Pemasukan berhasil ditambahkan.');

    }

    public function getByKategori($kategori)
    {
        return Produk::where('kategori', $kategori)
            ->select('id', 'nama', 'harga', 'stok')
            ->get();
    }

   public function cekCuciGratis(Request $request)
{
    $plat = $request->plat;
    $produkId = $request->produk_id;

    $produk = Produk::find($produkId);
    if (!$produk) {
        return response()->json(['gratis' => false]);
    }

    // ==== CEK APAKAH INI PAKET MOBIL ====
    $isPaketMobil =
        ($produk->jenis === 'paket_mobil')
        || str_starts_with(strtolower($produk->nama), 'paket mobil');

    if (!$isPaketMobil) {
        return response()->json(['gratis' => false]);
    }

    // ==== HITUNG SEMUA PAKET MOBIL (BASIC + SUPER) ====
    $jumlah = Pesanan::where('plat', $plat)
        ->whereHas('produk', function ($q) {
            $q->where('kategori', 'Layanan')
              ->where(function ($qq) {
                  $qq->where('jenis', 'paket_mobil')
                     ->orWhere('nama', 'like', 'Paket Mobil%');
              });
        })
        ->count();

    $ke = $jumlah + 1;

    return response()->json([
        'gratis' => ($ke % 6 === 0),
        'ke' => $ke
    ]);
}

  public function export(Request $request)
{
    if (Auth::user()->role !== 'pemilik') {
        abort(403, 'Anda tidak memiliki izin untuk mengakses fitur ini.');
    }

    $tanggal = $request->tanggal;

    if (!$tanggal) {
        $data = Pemasukan::orderBy('tanggal', 'DESC')->get();
        $tanggalInfo = "SEMUA";
    } else {
        $data = Pemasukan::whereDate('tanggal', $tanggal)->get();
        $tanggalInfo = $tanggal;
    }

    $pdf = \PDF::loadView('kasir.pemasukan.pdf', [
        'data' => $data,
        'tanggal' => $tanggalInfo
    ])->setPaper('A4');

    return $pdf->download("Pemasukan-$tanggalInfo.pdf");
}

}
