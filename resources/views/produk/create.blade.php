<x-app-layout :title="'Tambah Layanan'">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<style>
body {
    font-family: 'Poppins', sans-serif !important;
}

/* FORM WRAPPER */
.form-wrapper {
    max-width: 600px;
    margin-left: 80px;
    margin-top: 40px;
}

/* TITLE */
.page-title {
    font-weight: 600;
    font-size: 26px;
    margin-bottom: 22px;
    color: #1e293b;
}

/* CARD */
.card-modern {
    border-radius: 16px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
}
.card-modern .card-body {
    padding: 28px !important;
}

/* FORM */
.form-label {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.form-control {
    border-radius: 12px;
    padding: 12px 14px;
    border: 1px solid #d1d5db;
    font-size: 15px;
}

/* BUTTON */
.btn {
    padding: 10px 22px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 15px;
}

.btn-primary {
    background-color: #2563eb;
    border: none;
    color: white;
}
.btn-primary:hover {
    background-color: #1d4ed8;
}

.btn-secondary {
    background-color: #e5e7eb;
    color: #374151;
    border: none;
    margin-left: 6px;
}
/* ============================
   RESPONSIVE ONLY FOR MOBILE
   ============================ */
@media (max-width: 640px) {
    /* FORM TETAP DI TENGAH */
    .form-wrapper {
        margin: 70px auto 0 auto !important; /* auto = center */
        padding: 0 16px;
        max-width: 100% !important;
    }

    /* GESER JUDUL AJA, BUKAN FORM */
    .page-title {
        margin-left: 8px;  /* geser judul supaya tidak kena hamburger */
        font-size: 22px;
    }

    .card-modern .card-body {
        padding: 20px !important;
    }

    .form-label {
        font-size: 13px;
    }

    .form-control {
        font-size: 14px;
        padding: 10px 12px;
    }

    .btn {
        width: 100%; /* tombol full width */
        margin-bottom: 10px;
        font-size: 14px;
        padding: 10px 0;
    }

    .btn-secondary {
        margin-left: 0 !important;
    }
}

</style>

<div class="container form-wrapper">

    <h4 class="page-title">Tambah Layanan</h4>

    <div class="card-modern">
        <div class="card-body">

            <form id="formTambahLayanan"
                  action="{{ route('produk.store') }}"
                  method="POST">
                @csrf

                {{-- KATEGORI DIKUNCI --}}
                <input type="hidden" name="kategori" value="layanan">

                {{-- NAMA --}}
                <div class="mb-4">
                    <label class="form-label">Nama Layanan</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           required>
                </div>

                {{-- HARGA --}}
                <div class="mb-4">
                    <label class="form-label">Harga</label>
                    <input type="number"
                           name="harga"
                           class="form-control"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>

                <a href="{{ route('produk.index', ['kategori' => 'layanan']) }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>

</x-app-layout>
