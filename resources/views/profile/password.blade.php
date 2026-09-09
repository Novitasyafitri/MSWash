<x-app-layout :title="'Ubah Kata Sandi'">

<div class="profile-wrapper">

    <div class="profile-card">
        <div class="card-title">Ubah Kata Sandi</div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <label>Password Lama</label>
            <input type="password" name="current_password" required>

            <label>Password Baru</label>
            <input type="password" name="password" required>

            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>

            <button class="btn-save">Simpan</button>
        </form>
    </div>

</div>

</x-app-layout>
