<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProdukController extends Controller
{
   public function index(Request $request)
{
    $kategori = $request->kategori ?? 'layanan';

    // 🔒 kunci sub default
    $sub = $request->sub ?? 'stok_barang';

    if ($kategori === 'stok') {
        $query = Produk::whereRaw('LOWER(kategori) = ?', [$sub]);

        $produk = $query->orderBy('nama')->get();
        $activeKategori = 'stok';
    } else {
        $produk = Produk::whereRaw('LOWER(kategori) = ?', ['layanan'])
            ->orderBy('nama')
            ->get();

        $activeKategori = 'layanan';
    }

    return view('produk.index', compact('produk', 'activeKategori', 'sub'));
}

public function create(Request $request)
{
    // KUNCI: hanya layanan
    if (($request->kategori ?? 'layanan') !== 'layanan') {
        abort(404);
    }

    return view('produk.create');
}
public function store(Request $request)
{
    $request->validate([
        'nama'   => 'required',
        'harga'  => 'required|numeric',
        'kategori' => 'required'
    ]);

    Produk::create([
        'nama'     => $request->nama,
        'kategori' => 'layanan',
        'harga'    => $request->harga,
        'stok'     => 0
    ]);

    return redirect()
        ->route('produk.index', ['kategori' => 'layanan'])
        ->with('success', 'Layanan berhasil ditambahkan');
}

  public function edit($id)
{
    $produk = Produk::findOrFail($id);
    $kategori = strtolower($produk->kategori);

    // hanya layanan & minuman boleh edit
    if (!in_array($kategori, ['layanan', 'minuman'])) {
        return redirect()
            ->route('produk.index', ['kategori' => 'stok'])
            ->with('error', 'Produk ini tidak bisa diedit');
    }

    return view('produk.edit', compact('produk'));
}
public function update(Request $request, $id)
{
    $produk = Produk::findOrFail($id);
    $kategori = strtolower($produk->kategori);

    // hanya layanan & minuman boleh update
    if (!in_array($kategori, ['layanan', 'minuman'])) {
        abort(403);
    }

    $request->validate([
        'nama'  => 'required',
        'harga' => 'required|numeric',
    ]);

    $produk->update([
        'nama'  => $request->nama,
        'harga' => $request->harga,
    ]);

    return redirect()
        ->route('produk.index', [
            'kategori' => $kategori === 'layanan' ? 'layanan' : 'stok',
            'sub'      => $kategori === 'minuman' ? 'minuman' : null
        ])
        ->with('success', 'Produk berhasil diperbarui');
}

    public function destroy($id)
{
    Produk::findOrFail($id)->delete();

    return response()->json([
        'status' => 'ok'
    ]);
}

    /* API: Get produk sesuai kategori */
    public function getByKategori($kategori)
{
    return Produk::whereRaw('LOWER(kategori) = ?', [strtolower($kategori)])
        ->get(['id','nama','harga','stok']);
}


    public function search(Request $request)
    {
        $q = $request->q;
        $id = $request->id;

        $query = Produk::query();

        if ($id) {
            return $query->where('id', $id)
                ->get(['id','nama','stok','kategori']);
        }

       return $query
    ->whereIn(DB::raw('LOWER(kategori)'), ['stok_barang', 'minuman'])
    ->where('nama', 'LIKE', "%{$q}%")
    ->get(['id','nama','stok','kategori']);

    }
} 