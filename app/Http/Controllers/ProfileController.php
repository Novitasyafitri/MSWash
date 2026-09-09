<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // ===============================
    // SHOW EDIT PROFILE PAGE
    // ===============================
 public function edit(Request $request)
{
    $user = $request->user();

    // Cari karyawan berdasarkan jabatan = role user
    $karyawan = \App\Models\Karyawan::where('jabatan', $user->role)->first();

    return view('profile.edit', compact('user', 'karyawan'));
}
    // ===============================
    // UPDATE PROFILE (name + email)
    // ===============================
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    // ===============================
    // UPLOAD PROFILE PHOTO
    // ===============================
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $user = $request->user();

        $karyawan = \App\Models\Karyawan::where('nama', $user->name)->first();

        if (!$karyawan) {
            return back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        // hapus foto lama
        if ($karyawan->foto && file_exists(public_path('foto-profil/'.$karyawan->foto))) {
            @unlink(public_path('foto-profil/'.$karyawan->foto));
        }

        // simpan foto baru
        $filename = time().'.'.$request->foto->extension();
        $request->foto->move(public_path('foto-profil'), $filename);

        $karyawan->foto = $filename;
        $karyawan->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    // ===============================
    // SHOW CHANGE PASSWORD PAGE
    // ===============================
    public function passwordPage(): View
    {
        return view('profile.password');
    }

    // ===============================
    // CHANGE PASSWORD PROCESS
    // ===============================
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = $request->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama salah.');
        }

        $user->password = \Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    // ===============================
    // DELETE ACCOUNT
    // ===============================
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
