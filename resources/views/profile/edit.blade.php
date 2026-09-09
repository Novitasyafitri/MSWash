<x-app-layout :title="'Edit Profil'">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: "Poppins", sans-serif !important;
    background: radial-gradient(circle at top left, #dce8ff 0%, transparent 60%),
                radial-gradient(circle at bottom right, #e8f0ff 0%, transparent 70%);
}

.profile-wrapper {
    max-width: 900px;
    margin: 30px auto;
}

.profile-card {
    background: linear-gradient(145deg, #ffffff, #f0f6ff);
    border-radius: 20px;
    padding: 35px;
    border: 1px solid #d9e6ff;
    box-shadow: 0 6px 18px rgba(37, 99, 235, 0.08);
    margin-bottom: 35px;
}

.card-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #1e293b;
}

input {
    width: 100%;
    padding: 12px 15px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #d1d5db;
    font-size: 15px;
}

input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.22);
}

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}

.btn-save {
    background: #2563eb;
    color: white;
    padding: 12px 18px;
    border-radius: 12px;
    border: none;
    font-weight: 600;
}

.btn-delete {
    background: transparent;
    border: 1px solid #dc2626;
    color: #dc2626;
    padding: 10px 18px;
    border-radius: 12px;
    font-weight: 600;
}
</style>

<div class="profile-wrapper">

    {{-- FOTO PROFIL --}}
    <div class="profile-card" style="text-align:center;">
        <div class="card-title">Foto Profil</div>

        <form action="{{ route('profile.uploadPhoto') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <img id="previewFoto"
                 src="{{ ($karyawan && $karyawan->foto) ? asset('foto-profil/'.$karyawan->foto) : '/default-avatar.png' }}"
                 style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:4px solid #2563eb; margin-bottom:20px;">

            <br>

            <label for="foto"
                style="background:#2563eb; color:white; padding:10px 18px; border-radius:10px; cursor:pointer; font-weight:600;">
                Pilih Foto
            </label>

            <input type="file" id="foto" name="foto" accept="image/*" style="display:none">

            <button class="btn-save" style="margin-top:15px;">Simpan Foto</button>
        </form>
    </div>

    {{-- EDIT PROFIL --}}
    <div class="profile-card">
        <div class="card-title">Edit Profil</div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="grid-2">
                <div>
                    <label>Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <br>
            <button class="btn-save">Simpan</button>
        </form>
    </div>

    {{-- UBAH PASSWORD --}}
    <div class="profile-card">
        <div class="card-title">Ubah Kata Sandi</div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <div class="grid-2">
                <div>
                    <label>Password Lama</label>
                    <input type="password" name="current_password" required>
                </div>

                <div>
                    <label>Password Baru</label>
                    <input type="password" name="password" required>
                </div>

                <div>
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>
            </div>

            <br>
            <button class="btn-save">Simpan</button>
        </form>
    </div>

    {{-- HAPUS AKUN --}}
    <div class="profile-card">
        <div class="card-title" style="color:#dc2626;">Hapus Akun</div>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <label>Password</label>
            <input type="password" name="password" required style="max-width:300px;">

            <br><br>

            <button class="btn-delete">Hapus Akun</button>
        </form>
    </div>

</div>

<script>
document.getElementById("foto").addEventListener("change", e => {
    const file = e.target.files[0];
    if (file) document.getElementById("previewFoto").src = URL.createObjectURL(file);
});
</script>

</x-app-layout>
