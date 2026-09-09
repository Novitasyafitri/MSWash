<x-app-layout :title="'Edit Karyawan'">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body { font-family: 'Poppins', sans-serif !important; }

/* CARD */
.card-modern {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    padding: 24px;
}

label { font-weight: 500; color: #111827; }

.form-control, .form-select {
    border-radius: 10px;
    padding: 10px 12px;
}

.section-title {
    font-weight: 600;
    margin-bottom: 16px;
    color: #2563eb;
}

/* BUTTON */
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

/* ALERT NONAKTIF */
.alert-nonaktif {
    background: #fffbeb;
    border-left: 4px solid #f59e0b;
    color: #92400e;
    padding: 12px 14px;
    border-radius: 10px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}
.alert-nonaktif i {
    font-size: 16px;
    color: #f59e0b;
}
/* =========================
   SWEETALERT MODERN STYLE
========================= */
.swal-modern {
    border-radius: 14px !important;
    font-family: 'Poppins', sans-serif !important;
}

.swal-title {
    font-size: 17px !important;
    font-weight: 600 !important;
    color: #111827 !important;
    margin-bottom: 4px !important;
}

.swal-text {
    font-size: 13px !important;
    color: #6b7280 !important;
    line-height: 1.5;
}

/* ICON */
.swal2-icon {
    transform: scale(0.75);
    margin: 10px auto 6px !important;
}

/* BUTTON */
.swal-btn-confirm {
    background: #2563eb;
    color: #ffffff;
    border-radius: 10px;
    padding: 7px 18px;
    font-size: 13px;
    font-weight: 500;
    border: none;
}

.swal-btn-cancel {
    background: #e5e7eb;
    color: #374151;
    border-radius: 10px;
    padding: 7px 18px;
    font-size: 13px;
    font-weight: 500;
    border: none;
    margin-left: 8px;
}


/* PASSWORD */
.password-wrapper { position: relative; }
.password-wrapper input { padding-right: 46px; }

.toggle-password {
    position: absolute;
    top: 50%;
    right: 14px;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #6b7280;
    display: flex;
    align-items: center;
}
.toggle-password:hover { color: #2563eb; }
@media (max-width: 576px) {
    .card-modern {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 20px !important;
        overflow: visible !important; /* penting untuk dropdown */
    }

    .card-modern form {
        width: 100%;
    }

    .page-title {
        margin-top: 50px !important;
    }

    .form-wrapper-mobile {
        margin-top: 45px !important;
    }

    .form-select {
        position: relative;
        z-index: 20;
    }
}
</style>

@php
    $nonaktif = $karyawan->status === 'nonaktif';
@endphp

<div class="container pt-4 d-flex justify-content-center form-wrapper-mobile">
<div class="card-modern" style="width:100%; max-width:900px;">

<h4 class="fw-bold mb-4">Edit Karyawan</h4>

<form action="{{ route('karyawan.update',$karyawan->id) }}" method="POST">
@csrf
@method('PUT')

<div class="row">

{{-- ================= KIRI ================= --}}
<div class="col-md-6">
<h6 class="section-title">Data Karyawan</h6>

<div class="mb-3">
<label>Nama Karyawan</label>
<input type="text" name="nama" class="form-control"
       value="{{ $karyawan->nama }}" required>
</div>

<div class="mb-3">
<label>Jabatan</label>
<select id="jabatan" class="form-select" disabled>
    <option value="" disabled>— Pilih Jabatan —</option>
    <option value="kasir" {{ $karyawan->jabatan === 'kasir' ? 'selected' : '' }}>Kasir</option>
    <option value="karyawan" {{ $karyawan->jabatan === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
</select>
<input type="hidden" name="jabatan" value="{{ $karyawan->jabatan }}">
</div>

<div class="mb-3">
<label>Umur</label>
<input type="number" name="umur" class="form-control"
       value="{{ $karyawan->umur }}" min="17" max="70" required>
</div>

<div class="mb-3">
<label>Tanggal Masuk</label>
<input type="date" name="tanggal_masuk" class="form-control"
       value="{{ $karyawan->tanggal_masuk }}" required>
</div>
</div>

{{-- ================= KANAN : LOGIN ================= --}}
<div class="col-md-6" id="loginSection">
<h6 class="section-title">Akun Login (Kasir)</h6>

@if($nonaktif)
<div class="alert-nonaktif">
    <i class="bi bi-lock-fill"></i>
    Akun kasir sedang <strong>NONAKTIF</strong>
</div>
@endif

<div class="mb-3">
<label>Email Login</label>
<input type="email" name="email" id="email"
       class="form-control"
       value="{{ $karyawan->user->email ?? '' }}"
       {{ $nonaktif ? 'disabled' : '' }}>
</div>

<div class="mb-3">
<label>Password Baru</label>
<div class="password-wrapper">
<input type="password" name="password" id="password"
       class="form-control"
       placeholder="Kosongkan jika tidak diganti"
       {{ $nonaktif ? 'disabled' : '' }}>

@if(!$nonaktif)
<button type="button" class="toggle-password"
        onclick="togglePassword('password',this)">
<i class="bi bi-eye"></i>
</button>
@endif
</div>
</div>

<div class="mb-3">
<label>Ulangi Password Baru</label>
<div class="password-wrapper">
<input type="password" name="password_confirmation"
       id="password_confirmation"
       class="form-control"
       placeholder="Kosongkan jika tidak diganti"
       {{ $nonaktif ? 'disabled' : '' }}>

@if(!$nonaktif)
<button type="button" class="toggle-password"
        onclick="togglePassword('password_confirmation',this)">
<i class="bi bi-eye"></i>
</button>
@endif
</div>
</div>
</div>

</div>

<div class="mt-4">
<button class="btn btn-primary">Simpan </button>
<a href="{{ route('karyawan.index') }}" class="btn btn-secondary ms-2">Kembali</a>
</div>

</form>
</div>
</div>

<script>
const ORIGINAL_EMAIL = "{{ $karyawan->user->email ?? '' }}";
let HAS_USER = {{ $karyawan->user ? 'true' : 'false' }};

const jabatan = document.getElementById('jabatan');
const loginSection = document.getElementById('loginSection');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('password_confirmation');

let lastJabatan = jabatan.value;

function toggleLoginSection() {
    if (jabatan.value === 'kasir') {
        loginSection.style.display = 'block';

         // 🔴 WAJIB ISI SAAT JADI KASIR
    email.required = true;
    password.required = true;
    password2.required = true;

        // 🔥 KUNCI: kembalikan email lama
        if (HAS_USER && ORIGINAL_EMAIL !== '') {
            email.value = ORIGINAL_EMAIL;
        }

    } else {
        loginSection.style.display = 'none';
        password.value = '';
        password2.value = '';
    }
}


jabatan.addEventListener('change', () => {
    if (lastJabatan === 'kasir' && jabatan.value === 'karyawan') {
       Swal.fire({
    icon: 'warning',
    title: 'Ubah jadi karyawan?',
    text: 'Akun login akan dihapus dan tidak bisa digunakan lagi.',
    showCancelButton: true,

    confirmButtonText: 'Ya, lanjut',
    cancelButtonText: 'Batal',

    // === UKURAN & STYLE ===
    width: 360,
    padding: '18px 20px',
    heightAuto: false,

    // === BUTTON STYLE ===
    buttonsStyling: false,
    customClass: {
        popup: 'swal-modern',
        title: 'swal-title',
        htmlContainer: 'swal-text',
        confirmButton: 'swal-btn-confirm',
        cancelButton: 'swal-btn-cancel'
    }
}).then(res => {
            if (res.isConfirmed) {
                HAS_USER = false;
                toggleLoginSection();
                lastJabatan = jabatan.value;
            } else {
                jabatan.value = lastJabatan;
            }
        });
    } else {
    if (jabatan.value === 'kasir') {
        HAS_USER = true;
    }
    toggleLoginSection();
    lastJabatan = jabatan.value;
}
});

toggleLoginSection();

function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye','bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash','bi-eye');
    }
}
</script>

</x-app-layout>
