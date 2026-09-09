<x-app-layout :title="'Tambah Karyawan'">

{{-- FONT --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Poppins', sans-serif !important; }

    .page-title {
        font-weight: 600;
        font-size: 22px;
        color: #111827;
        margin-bottom: 20px;
    }

    .card-modern {
        border-radius: 16px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        padding: 25px;
    }

    .grid-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    label {
        font-weight: 500;
        color: #111827;
        margin-bottom: 6px;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
    }

    .box-title {
        font-weight: 600;
        color: #2563eb;
        margin-bottom: 10px;
    }

    .btn-primary {
        background: #2563eb;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 500;
    }

    .btn-secondary {
        background: #9ca3af;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 500;
    }
    /* ============================
   RESPONSIVE KHUSUS HP
===============================*/
@media (max-width: 768px) {

    .container {
        padding-left: 15px !important;
        padding-right: 15px !important;
        margin-top: 60px !important; /* 🔥 solusi utama */
    }

    .card-modern {
        margin-top: 0 !important; 
    }

    .grid-wrapper {
        grid-template-columns: 1fr !important;
        gap: 18px;
    }

    label {
        font-size: 14px;
    }

    .form-control,
    .form-select {
        font-size: 14px;
        padding: 10px 12px;
    }

    .form-select {
        max-width: 100% !important;
        width: 100% !important;
        overflow-x: hidden;
    }

    .btn-primary,
    .btn-secondary {
        width: 100%;
        margin-bottom: 10px;
    }
}
/* =========================
   TOAST ERROR
========================= */
.toast-error {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #dc2626;
    color: white;
    padding: 14px 18px;
    border-radius: 12px;
    font-size: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    opacity: 0;
    pointer-events: none;
    transform: translateY(-10px);
    transition: all 0.35s ease;
    z-index: 9999;
}

.toast-error.show {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
}

</style>

<div class="container pt-3" style="max-width: 950px;">
    <div class="card-modern">
        @if ($errors->any())
    <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:10px; margin-bottom:16px;">
        <ul style="margin:0; padding-left:18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:10px; margin-bottom:16px;">
        {{ session('error') }}
    </div>
@endif

        <form action="{{ route('karyawan.store') }}" method="POST">
            @csrf

            <div class="grid-wrapper">

                {{-- =======================
                        KOLOM KIRI
                   ======================= --}}
                <div>
                    <h6 class="box-title">Data Karyawan</h6>

                    <div class="mb-3">
                        <label>Nama Karyawan</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Jabatan</label>
                        <select name="jabatan" class="form-select" id="jabatanSelect" required>
    <option value="" selected disabled>— Pilih Jabatan —</option>
    <option value="kasir">Kasir</option>
    <option value="karyawan">Karyawan</option>
</select>

                    </div>

                    <div class="mb-3">
                        <label>Umur</label>
                        <input type="number" name="umur" min="17" max="70" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control"value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>


                {{-- =======================
                        KOLOM KANAN LOGIN
                   ======================= --}}
                <div>
                    <h6 class="box-title">Akun Login</h6>

                    <div id="loginFields">

                        <div class="mb-3">
                            <label>Email Login</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Password Login</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Ulangi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                    </div>

                    {{-- Kalau bukan kasir, tampilkan info --}}
                    <div id="noLoginNotice" style="display:none; color:#6b7280;">
                        Jabatan <strong>karyawan biasa</strong> tidak membutuhkan akun login.
                    </div>

                </div>

            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>

        </form>

    </div>

</div>
<!-- TOAST ERROR -->
<div id="toastError" class="toast-error">
    <strong>Mohon maaf</strong><br>
    Kasir aktif sudah ada.<br>
    Nonaktifkan kasir lama terlebih dahulu.
</div>

<script>
const jabatan = document.getElementById("jabatanSelect");
const loginFields = document.getElementById("loginFields");
const notice = document.getElementById("noLoginNotice");
const toast = document.getElementById("toastError");

const kasirAktif = @json($kasirAktif);

function showToast() {
    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);
}

function toggleLogin() {
    if (jabatan.value === "kasir") {

        if (kasirAktif) {
            showToast();

            jabatan.value = "";
            loginFields.style.display = "none";
            notice.style.display = "none";
            return;
        }

        loginFields.style.display = "block";
        notice.style.display = "none";

        document.querySelector("input[name=email]").required = true;
        document.querySelector("input[name=password]").required = true;
        document.querySelector("input[name=password_confirmation]").required = true;

    } else if (jabatan.value === "karyawan") {
        loginFields.style.display = "none";
        notice.style.display = "block";

        document.querySelector("input[name=email]").required = false;
        document.querySelector("input[name=password]").required = false;
        document.querySelector("input[name=password_confirmation]").required = false;
    }
}

jabatan.addEventListener("change", toggleLogin);
</script>
</x-app-layout>
