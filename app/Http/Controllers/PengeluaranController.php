<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Produk;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PengeluaranController extends Controller
{
public function index(Request $request)
{
    // Ambil periode aktif
    $periode = DB::table('periode')
        ->where('status', 'aktif')
        ->first();

    if (!$periode) {
        return back()->with('error', 'Tidak ada periode aktif');
    }

$query = Pengeluaran::query()
    ->whereNotIn('jenis', [
        'gaji_karyawan',
        'gaji_kasir',
        'draft_gaji_kasir',
        'potong_kasbon_karyawan',
        'kasbon_awal_kasir',
        'potong_kasbon_kasir',
        'kupon_karyawan'
    ]);

// =====================
// TANPA FILTER → pakai periode
// =====================
if (!$request->filled('tanggal')) {
    $query->where('periode_id', $periode->id);
}

// =====================
// FILTER TANGGAL → abaikan periode
// =====================
if ($request->filled('tanggal')) {
    $query->whereDate('tanggal', $request->tanggal);
}


    $pengeluarans = $query->orderBy('tanggal', 'DESC')->get();
    $totalPengeluaran = $query->sum('total');

    return view('kasir.pengeluaran.index', compact('pengeluarans', 'totalPengeluaran'));
}


    /* ================================================================
        STORE — FINAL FIXED VERSION
    ================================================================ */
  public function store(Request $request)
{
    $request->validate([
        'items' => 'required|array|min:1',
    ]);

    $periode = DB::table('periode')
        ->where('status', 'aktif')
        ->first();

    if (!$periode) {
        return back()->with('error', 'Tidak ada periode aktif');
    }

    DB::beginTransaction();

        try {

            $LIMIT_KASBON = 300000;

            foreach ($request->items as $item) {

                $kategori   = strtolower($item['kategori']);
                $tanggal    = $item['tanggal'] ?? now();
                $nominal    = $item['nominal'] ?? 0;
                $keterangan = $item['keterangan'] ?? null;
                $qty        = $item['qty'] ?? 1;
                $aksi       = $item['stok_action'] ?? 'tambah';

                /* ====================================================
                    1️⃣ KASBON
                ==================================================== */
              if ($kategori === 'kasbon') {

    // ===============================
    // 1. Tentukan peminjam (karyawan / kasir)
    // ===============================
    $peminjamKaryawanId = $item['karyawan_id']
    ?? Karyawan::where('user_id', Auth::id())->value('id');

if (!$peminjamKaryawanId) {
    throw new \Exception('Kasir belum terdaftar sebagai karyawan');
}

    // ===============================
    // 2. Hitung total kasbon sebelumnya
    // ===============================
    $totalKasbonSebelumnya = Pengeluaran::where('jenis', 'kasbon')
    ->where('lunas', 0)
    ->where('karyawan_id', $peminjamKaryawanId)
    ->sum(DB::raw('COALESCE(sisa_kasbon, total)'));


    $totalSetelahPinjam = $totalKasbonSebelumnya + $nominal;

    // ===============================
    // 3. CEK LIMIT
    // ===============================
    if ($totalSetelahPinjam > $LIMIT_KASBON) {
        $sisa = max(0, $LIMIT_KASBON - $totalKasbonSebelumnya);

        throw new \Exception(
            'Kasbon melebihi batas Rp 300.000. ' .
            'Sisa limit: Rp ' . number_format($sisa, 0, ',', '.')
        );
    }

    // ===============================
    // 4. Simpan kasbon
    // ===============================
   Pengeluaran::create([
    'jenis'        => 'kasbon',
    'karyawan_id'  => $peminjamKaryawanId, // ⬅️ WAJIB ADA
    'nominal'      => $nominal,
    'total'        => $nominal,
    'sisa_kasbon'  => $nominal,
    'keterangan'   => $keterangan,
    'tanggal'      => $tanggal,
    'lunas'        => 0,
    'periode_id'   => $periode->id,
]);

    continue;
}

                /* ====================================================
                    2️⃣ UPDATE / TAMBAH / KURANGI STOK PRODUK
                ==================================================== */

                $produkBahan = null;
                $namaItem    = strtolower($item['nama_item'] ?? '');

                // A. Jika pilih dari suggestion → produk_id dipakai
                if (!empty($item['produk_id'])) {

                    $produkBahan = Produk::find($item['produk_id']);

                    if ($produkBahan) {
                        if ($aksi === 'kurangi') {
                            $produkBahan->stok = max(0, $produkBahan->stok - $qty);
                        } else {
                            $produkBahan->stok += $qty;
                        }
                        $produkBahan->save();
                    } else {
                        $produkBahan = null;;
                    }
                }

                // B. Tambah/Kurangi stok_barang manual
                else if ($kategori === 'stok_barang') {

                    $produkBahan = Produk::whereRaw("LOWER(nama) = ?", [$namaItem])->first();

                    if ($produkBahan) {
                        if ($aksi === 'kurangi') {
                            $produkBahan->stok = max(0, $produkBahan->stok - $qty);
                        } else {
                            $produkBahan->stok += $qty;
                        }
                        $produkBahan->save();
                    } else {
                        $produkBahan = Produk::create([
                            'nama'     => $namaItem,
                            'stok'     => ($aksi === 'kurangi') ? 0 : $qty,
                            'harga'    => 0,
                            'kategori' => 'stok_barang',
                        ]);
                    }
                }

                // C. MINUMAN — buat produk baru jika belum ada
                else if ($kategori === 'minuman') {

                    // Jika dari suggestion → produk_id ada → sudah ditangani blok atas
                    // ↓ Jika tidak pilih suggestion = minuman baru
                    $produkBahan = Produk::create([
                        'nama'     => $namaItem,
                        'stok'     => $qty,
                        'harga'    => 0,
                        'kategori' => 'minuman',
                    ]);
                }

                /* ====================================================
                    3️⃣ TENTUKAN JENIS PENGELUARAN
                ==================================================== */
                $jenis = match ($kategori) {
                    'stok_barang'   => 'stok_barang',
                    'minuman'       => 'minuman',
                    'makan_karyawan'=> 'makan_karyawan',
                    'minum_karyawan'=> 'minum_karyawan',
                    'tagihan'       => 'tagihan',
                    'lain_lain'     => 'lain_lain',
                    default         => 'lainnya',
                };

                /* ====================================================
                    4️⃣ AMANKAN produk_id
                ==================================================== */
                $produkId = $produkBahan->id ?? null;

                if ($produkId !== null && !Produk::find($produkId)) {
                    $produkId = null;
                }
                
                if ($kategori === 'stok_barang' && $aksi === 'kurangi') {
                continue; // ← STOP, jangan simpan pengeluaran
                }
                /* ====================================================
                    5️⃣ SIMPAN PENGELUARAN
                ==================================================== */
                Pengeluaran::create([
                    'jenis'        => $jenis,
                    'nama_item'    => $item['nama_item'] ?? null,
                    'nominal'      => $nominal,
                    'total'        => $nominal,
                    'sisa_kasbon'  => null,
                    'keterangan'   => $keterangan,
                    'tanggal'      => $tanggal,
                    'produk_id'    => $produkId,
                    'lunas'        => 1,
                    'periode_id' => $periode->id,

                ]);
            }

            DB::commit();
            return back()->with('success', 'Pengeluaran berhasil disimpan.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /* ================================================================
        SEARCH
    ================================================================ */

public function listKaryawan()
{
    return Karyawan::where('status', 'aktif')
        ->select('id', 'nama')
        ->orderBy('nama')
        ->get();
}


    public function searchStokBarang(Request $request)
    {
        $q = strtolower($request->q);

        return Produk::where('kategori', 'stok_barang')
            ->whereRaw("LOWER(nama) LIKE ?", ["%$q%"])
            ->get(['id', 'nama', 'stok']);
    }

    public function searchMinuman(Request $request)
    {
        $q = strtolower($request->q);

        return Produk::where('kategori', 'minuman')
            ->whereRaw("LOWER(nama) LIKE ?", ["%$q%"])
            ->get(['id', 'nama', 'stok']);
    }
     public function export(Request $request)
{
    $tanggal = $request->tanggal;

    $query = Pengeluaran::with('karyawan')
    ->whereNotIn('jenis', [
        'gaji_karyawan',
        'gaji_kasir',
        'draft_gaji_kasir',
        'potong_kasbon_karyawan',
        'kasbon_awal_kasir',
        'potong_kasbon_kasir',
        'kupon_karyawan'
    ]);

    if ($tanggal) {
        $query->whereDate('tanggal', $tanggal);
    }

    $pengeluarans = $query->orderBy('tanggal')->get();
    $totalPengeluaran = $pengeluarans->sum('total');

    $pdf = Pdf::loadView(
        'kasir.pengeluaran.pdf',
        compact('pengeluarans', 'tanggal', 'totalPengeluaran')
    );

    return $pdf->download('pengeluaran.pdf');
}

public function sisaKasbon($karyawanId)
{
    $LIMIT_KASBON = 300000;

    $total = Pengeluaran::where('jenis', 'kasbon')
    ->where('lunas', 0)
    ->where('karyawan_id', $karyawanId)
    ->sum(DB::raw('COALESCE(sisa_kasbon, total)'));


    return response()->json([
        'total' => $total,
        'sisa'  => max(0, $LIMIT_KASBON - $total),
        'limit' => $LIMIT_KASBON,
    ]);
}


}
