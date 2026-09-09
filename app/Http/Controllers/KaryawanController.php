<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;


class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with(['kasbon', 'user'])
    ->orderByRaw("
        CASE
            WHEN status = 'aktif' AND jabatan = 'kasir' THEN 1
            WHEN status = 'aktif' AND jabatan = 'karyawan' THEN 2
            WHEN status = 'nonaktif' THEN 3
            ELSE 4
        END
    ")
    ->orderBy('nama')
    ->get();

        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
{
    $kasirAktif = Karyawan::where('jabatan', 'kasir')
        ->where('status', 'aktif')
        ->exists();

    return view('karyawan.create', compact('kasirAktif'));
}

   public function store(Request $request)
{
    $request->validate([
        'nama'          => 'required|string|max:255',
        'jabatan'       => 'required|in:kasir,karyawan',
        'umur'          => 'required|integer|min:17|max:70',
        'tanggal_masuk' => 'required|date',

        // login hanya untuk kasir
     'email'    => 'nullable|required_if:jabatan,kasir|email|unique:users,email',
    'password' => 'nullable|required_if:jabatan,kasir|confirmed|min:6',

    ]);

    // 🔒 CEK KASIR AKTIF (CUMA 1 BOLEH AKTIF)
if ($request->jabatan === 'kasir') {

    $kasirAktif = Karyawan::where('jabatan', 'kasir')
        ->where('status', 'aktif')
        ->exists();

    if ($kasirAktif) {
        return back()
            ->withInput()
            ->with('error', 'Mohon maaf, kasir aktif sudah ada. Nonaktifkan kasir lama terlebih dahulu.');
    }
}

    // =========================
    // BUAT DATA KARYAWAN
    // =========================
    $karyawan = Karyawan::create([
        'nama'          => $request->nama,
        'jabatan'       => $request->jabatan,
        'umur'          => $request->umur,
        'tanggal_masuk' => $request->tanggal_masuk,
        'status'        => 'aktif',
    ]);

    // =========================
    // JIKA KASIR → BUAT USER BARU
    // =========================
    if ($request->jabatan === 'kasir') {

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'kasir',
            'active'   => 1,
        ]);

        $karyawan->update([
            'user_id' => $user->id,
        ]);
    }

    return redirect()
        ->route('karyawan.index')
        ->with('success', 'Karyawan berhasil ditambahkan!');
}

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        if ($karyawan->kasbon()->where('lunas', false)->exists()) {
            return back()->with(
                'error',
                'Tidak bisa menghapus karyawan karena masih memiliki kasbon belum lunas.'
            );
        }

        $karyawan->delete();

        return back()->with('success', 'Karyawan berhasil dihapus.');
    }

   public function nonaktifkanKaryawan($id)
{
    $karyawan = Karyawan::with('user')->findOrFail($id);

    // 🔒 MATIKAN LOGIN KASIR
    if ($karyawan->user) {
        $karyawan->user->update([
            'active' => 0,
        ]);
         DB::table('sessions')
        ->where('user_id', $karyawan->user->id)
        ->delete();
}

    // 🧑‍🔧 NONAKTIFKAN DATA KERJA
    $karyawan->update([
        'status' => 'nonaktif',
    ]);
    

    return back()->with('success', 'Karyawan berhasil dinonaktifkan.');
}


    public function aktifkanKaryawan($id)
{
    $karyawan = Karyawan::with('user')->findOrFail($id);

    if ($karyawan->user) {
        $karyawan->user->update([
            'active' => 1,
        ]);
    }

    $karyawan->update([
        'status' => 'aktif',
    ]);

    return back()->with('success', 'Karyawan berhasil diaktifkan kembali.');
}

    public function edit($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return view('karyawan.edit', compact('karyawan'));
    }

  public function update(Request $request, $id)
{
    $karyawan = Karyawan::with('user')->findOrFail($id);

    $request->validate([
        'nama'          => 'required|string|max:255',
        'umur'          => 'required|integer|min:17|max:70',
        'tanggal_masuk' => 'required|date',
        // jabatan sengaja tidak divalidasi karena sudah disabled
    ]);

    // Jika dia kasir, update email & password opsional
    if ($karyawan->jabatan === 'kasir' && $karyawan->user) {

        $request->validate([
            'email'    => 'required|email|unique:users,email,' . $karyawan->user_id,
            'password' => 'nullable|confirmed|min:6',
        ]);

        // Update email
        $karyawan->user->update([
            'email' => $request->email,
        ]);

        // Update password kalau diisi
        if ($request->filled('password')) {
            $karyawan->user->update([
                'password' => Hash::make($request->password),
            ]);
        }
    }

    // Update data dasarnya
    $karyawan->update([
        'nama'          => $request->nama,
        'umur'          => $request->umur,
        'tanggal_masuk' => $request->tanggal_masuk,
    ]);

    return redirect()
        ->route('karyawan.index')
        ->with('success', 'Data karyawan berhasil diperbarui.');
}
}
