<x-app-layout>

<!-- ==================== TOASTIFY ==================== -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<style>
    .input-box {
        background: #fff !important;
        border: 1px solid #d1d5db !important;
        border-radius: 6px !important;
        padding: 6px 10px !important;
        height: 38px !important;
        width: 100%;
    }
    .item-row {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
    }
    .bottom-row {
        display: flex;
        gap: 8px;
        margin-top: 8px;
    }
    .bottom-row > div { flex: 1; }
</style>

<div class="p-6">
    <div class="d-flex justify-content-between mb-4">
        <h2 class="text-xl font-bold">Tambah Pemasukan</h2>
        <a href="{{ route('dashboard') }}" class="text-blue-600 text-sm">Kembali</a>
    </div>

    <div class="bg-white p-6 rounded shadow max-w-5xl mx-auto">

        <button type="button" id="addRow" class="btn btn-primary mb-3">+ Tambah Baris</button>

        <form action="{{ route('pemasukan.store') }}" method="POST" id="formPemasukan">
            @csrf

            <div id="items-container"></div>

            <h4 class="mt-3 fw-bold">Subtotal: Rp <span id="subtotal">0</span></h4>
            <button type="submit" class="btn btn-success w-100 mt-3">Simpan</button>
        </form>
    </div>
</div>

<!-- ==================== TEMPLATE ==================== -->
<template id="item-row-template">
    <div class="item-row">

        <div class="d-flex flex-wrap gap-2">
            
            <div style="flex:2">
                <label class="small">Kategori</label>
                <select class="form-select input-box kategori" name="kategori[]">
                    <option value="">-- Pilih --</option>
                    <option value="layanan">Layanan</option>
                    <option value="minuman">Minuman</option>
                </select>
            </div>

            <div style="flex:2">
                <label class="small">Tanggal</label>
                <input type="date" class="form-control input-box tanggal" name="tanggal[]">
            </div>

            <div style="flex:3">
                <label class="small">Produk</label>
                <select class="form-select input-box produk" name="produk_id[]">
                    <option value="">-- Pilih --</option>
                </select>
            </div>

            <div style="flex:2">
                <label class="small plat-label">Plat</label>
                <input type="text" class="form-control input-box plat" name="plat[]">
            </div>

            <div style="flex:1">
                <label class="small d-block">&nbsp;</label>
                <button type="button" class="btn btn-danger width-auto remove-row">X</button>
            </div>
        </div>

        <div class="bottom-row">
            <div>
                <label class="small">Qty</label>
                <input type="number" min="1" class="form-control input-box qty" name="qty[]" value="1">
            </div>
            <div>
                <label class="small">Harga</label>
                <input type="number" class="form-control input-box harga" name="harga[]" readonly>
            </div>
            <div>
                <label class="small">Total</label>
                <input type="number" class="form-control input-box total" name="total[]" readonly>
            </div>
        </div>

    </div>
</template>

<script>

// ==================== TOAST FUNCTION ====================
function toast(msg, color="#2563eb") {
    Toastify({
        text: msg,
        duration: 3000,
        gravity: "top",        // tetap top
        position: "center",    // pindah ke tengah
        close: true,
        stopOnFocus: true,
        style: {
            background: color,
            fontFamily: "Poppins, sans-serif",
            borderRadius: "10px",
            padding: "12px 20px",
            fontSize: "14px",
            boxShadow: "0 4px 12px rgba(0,0,0,0.15)"
        }
    }).showToast();
}

document.addEventListener("DOMContentLoaded", () => {

    const itemsContainer = document.getElementById("items-container");
    const addRowBtn = document.getElementById("addRow");
    const subtotalDisplay = document.getElementById("subtotal");

    // ========================================
    // ADD ROW POPUP
    // ========================================
    addRowBtn.addEventListener("click", () => {
        addRow();
        toast("Baris baru ditambahkan!", "#2196f3");
    });

    function addRow() {
        const template = document.getElementById("item-row-template");
        const clone = template.content.cloneNode(true);
        const row = clone.querySelector(".item-row");
        setupRowEvents(row);
        itemsContainer.appendChild(row);
        updateSubtotal();
    }

    function setupRowEvents(row) {

        const kategori = row.querySelector(".kategori");
        const produk = row.querySelector(".produk");
        const qty = row.querySelector(".qty");
        const harga = row.querySelector(".harga");
        const total = row.querySelector(".total");
        const tanggal = row.querySelector(".tanggal");
        const plat = row.querySelector(".plat");
        const platLabel = row.querySelector(".plat-label");
        const removeBtn = row.querySelector(".remove-row");

        tanggal.value = "{{ date('Y-m-d') }}";

        // ==================== LOAD PRODUK ====================
        kategori.addEventListener("change", async () => {

            produk.innerHTML = `<option>Loading...</option>`;
            qty.value = 1;
            harga.value = "";
            total.value = "";

            const res = await fetch(`/api/produk/${kategori.value}`);
            const data = await res.json();

            produk.innerHTML = `<option value="">-- Pilih Produk --</option>`;
            data.forEach(p => {
                produk.innerHTML += `<option value="${p.id}" data-harga="${p.harga}" data-stok="${p.stok}">${p.nama}</option>`;
            });

            // plat logic
            platLabel.style.display = kategori.value === "layanan" ? "block" : "none";
            plat.style.display = kategori.value === "layanan" ? "block" : "none";
        });

        // ==================== PRODUK DIPILIH ====================
        produk.addEventListener("change", () => {

            const selected = produk.selectedOptions[0];
            if (!selected) return;

            harga.value = selected.dataset.harga;

            qty.max = selected.dataset.stok;

            if (selected.text.toLowerCase().includes("karpet")) {
                platLabel.style.display = "none";
                plat.style.display = "none";
                plat.value = "";
            }

            if (selected.dataset.stok <= 5) {
                toast(`⚠ Stok ${selected.text} tinggal ${selected.dataset.stok}!`, "#ff9800");
            }

            updateTotal();
        });

        // ==================== CEK CUCI GRATIS ====================
        plat.addEventListener("input", async () => {
            if (kategori.value !== "layanan") return;
            const selected = produk.selectedOptions[0];
            if (!selected) return;

            const res = await fetch(`/cek-cuci-gratis?plat=${plat.value}&produk_id=${selected.value}`);
            const data = await res.json();

            if (data.gratis) {
                toast("🎉 Cuci Gratis ke-6!", "#4caf50");
            }

            harga.value = data.gratis ? 0 : selected.dataset.harga;
            updateTotal();
        });

        // ==================== BATAS QTY ====================
        qty.addEventListener("input", () => {
            const selected = produk.selectedOptions[0];
            if (!selected) return;

            const stok = parseInt(selected.dataset.stok);
            const val = parseInt(qty.value);

            if (val > stok) {
                qty.value = stok;
                toast(`Qty melebihi stok! Sisa ${stok}.`, "#f44336");
            }

            updateTotal();
        });

        function updateTotal() {
            total.value = (qty.value * (harga.value || 0));
            updateSubtotal();
        }

        removeBtn.addEventListener("click", () => {
            row.remove();
            updateSubtotal();
        });
    }

    // ==================== SUBTOTAL ====================
    function updateSubtotal(){
        let subtotal = 0;
        document.querySelectorAll(".total").forEach(i => {
            subtotal += parseFloat(i.value || 0);
        });
        subtotalDisplay.textContent = subtotal.toLocaleString("id-ID");
    }

    addRow();

    // ==================== SUBMIT VALIDASI ====================
    document.getElementById("formPemasukan").addEventListener("submit", (e) => {

        let valid = true;

        document.querySelectorAll(".kategori").forEach(el => {
            if (el.value === "") valid = false;
        });
        document.querySelectorAll(".produk").forEach(el => {
            if (el.value === "") valid = false;
        });

        if (!valid) {
            e.preventDefault();
            toast("Lengkapi semua data sebelum simpan!", "#f44336");
        }
    });

    // ==================== FLASH MESSAGE (BACKEND) ====================
    @if(session('success'))
        toast("{{ session('success') }}", "#4caf50");
    @endif

    @if(session('error'))
        toast("{{ session('error') }}", "#f44336");
    @endif

});

</script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</x-app-layout>

