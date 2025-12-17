@extends('layouts.app')

@section('title', 'Data Pengunjung | Admin')

@section('content')
<style>
/* ======================== GLOBAL STYLE (Sesuai Referensi SKM) ======================== */
body {
    background-color: #DFEDFE;
    background-image: 
        linear-gradient(135deg, rgba(255,255,255,0.18) 25%, transparent 25%),
        linear-gradient(225deg, rgba(255,255,255,0.18) 25%, transparent 25%),
        linear-gradient(45deg, rgba(255,255,255,0.18) 25%, transparent 25%),
        linear-gradient(315deg, rgba(255,255,255,0.18) 25%, #DFEDFE 25%);
    background-position: 20px 0, 20px 0, 0 0, 0 0;
    background-size: 20px 20px;
    background-repeat: repeat;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding-top: 0rem; 
    min-height: 100vh;
    overflow-x: hidden;
}

/* LOGO */
.logo-header {
    position: absolute;
    top: 18px;
    right: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 100;
    filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
}
.logo-header img { height: 50px; }

/* ================= DASHBOARD CONTENT (3D CARD) ================= */
.container-dashboard {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    width: 95%;
    max-width: 1300px;
    margin: 0 auto;
    padding-top: 0; 
    margin-top: 5px; 
    padding-bottom: 20px;
}

.dashboard-card {
    display: flex;
    background-color: #fff;
    border-radius: 20px;
    overflow: hidden;
    
    /* EFEK TIMBUL 3D */
    box-shadow: 
        0 20px 50px rgba(0, 0, 0, 0.15),
        0 5px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(255,255,255,0.6);
    border-bottom: 6px solid #e1e8f0;
    
    min-height: 620px;
    width: 100%;
}

/* ================= LEFT PANEL (CONTENT) - Posisi di KIRI sesuai SKM ================= */
.dashboard-left {
    flex: 0.9; 
    padding: 40px 40px;
    display: flex;
    flex-direction: column;
    position: relative;
    gap: 20px;
    background-color: #F8FBFF; /* Background konten */
    z-index: 1;
}

/* Title Card */
.title-card {
    background: transparent; 
    border-radius: 0; 
    padding: 0; 
    font-size: 2rem; 
    font-weight: 800;
    color: #003366; 
    margin-bottom: 5px; 
    display: flex;
    align-items: center;
    gap: 15px;
    text-shadow: 0 2px 3px rgba(0,0,0,0.05);
}
.title-card span { color: #30E3BC; }

.menu-icon {
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 22px;
    height: 18px;
    min-width: 22px;
}
.menu-icon span {
    height: 3px;
    background: #003366;
    border-radius: 2px;
}

/* === DATA CARD (TABLE CONTAINER) === */
.data-card {
    background: #fff;
    border-radius: 15px;
    padding: 0; 
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    overflow: hidden;

    /* Efek Timbul Inset Halus */
    box-shadow: 
        0 4px 6px rgba(0,0,0,0.02),
        inset 0 0 0 1px #e0e6ed;
}

.data-card h3 {
    margin: 15px 20px 5px 20px;
    font-size: 1.1rem;
    font-weight: 700;
    color: #003366;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.total-data {
    font-size: 0.8rem;
    color: #888;
    font-weight: 500;
}

/* HEADER TABEL (Style Bar Timbul) */
.data-table-header {
    display: flex;
    padding: 12px 10px;
    font-weight: 700;
    background: linear-gradient(to right, #007BFF, #0056b3);
    color: #fff;
    font-size: .9rem;
    box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2);
    z-index: 2;
    align-items: center;
    /* Sticky */
    position: sticky;
    top: 0;
    min-width: 1000px; /* Trigger scroll X jika layar kecil */
}

.data-table-row {
    display: flex;
    padding: 10px 10px;
    border-bottom: 1px solid #f0f0f0;
    color: #444;
    font-size: .85rem;
    transition: background 0.2s;
    align-items: center;
    min-width: 1000px; /* Trigger scroll X jika layar kecil */
}
.data-table-row:hover { background-color: #f0f7ff; }
.data-table-row:last-child { border-bottom: none; }

/* Column Flex Properties (Disesuaikan untuk Data Pengunjung) */
.data-table-header > span, .data-table-row > span {
    text-align: left; 
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap; 
    padding-right: 5px;
}

/* Definisikan Lebar Kolom Pengunjung */
.checkbox-col   { flex: 0.1; min-width: 40px; display: flex; align-items: center; justify-content: center; }
.col-tanggal    { flex: 0.8; min-width: 90px; }
.col-nama       { flex: 1.5; min-width: 140px; font-weight: 600; color: #003366; }
.col-instansi   { flex: 1.2; min-width: 120px; }
.col-layanan    { flex: 1.2; min-width: 120px; }
.col-keperluan  { flex: 2.0; min-width: 180px; }
.col-hp         { flex: 0.8; min-width: 90px; }

/* Checkbox */
input[type="checkbox"] {
    accent-color: #30E3BC;
    cursor: pointer;
    width: 16px;
    height: 16px;
}

/* Scroll Container */
.tabel-container {
    flex-grow: 1;
    overflow: auto; /* Enable X and Y scroll */
    padding-right: 0px;
    margin-top: 0;
    scrollbar-width: thin;
}
.tabel-container::-webkit-scrollbar { width: 8px; height: 8px; }
.tabel-container::-webkit-scrollbar-track { background: #f1f1f1; }
.tabel-container::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }

/* === BUTTON ACTION (3D PUSH BUTTONS) === */
.action-buttons {
    padding: 15px 20px;
    display: flex;
    justify-content: flex-end; /* Tombol rata kanan */
    gap: 15px;
    border-top: 1px solid #eee;
    background-color: #fafbfc;
    z-index: 5;
}

.btn-action {
    padding: 10px 25px;
    border-radius: 50px;
    border: none;
    font-weight: 700;
    cursor: pointer;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    top: 0;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Edit Button (Green) */
.btn-edit { 
    background: linear-gradient(135deg, #20c997 0%, #17a078 100%);
    color: #fff; 
    box-shadow: 0 4px 0 #138563, 0 5px 10px rgba(32, 201, 151, 0.3);
}
.btn-edit:hover { transform: translateY(-2px); box-shadow: 0 6px 0 #138563, 0 8px 15px rgba(32, 201, 151, 0.4); }
.btn-edit:active { top: 4px; box-shadow: 0 0 0 #138563, 0 2px 5px rgba(32, 201, 151, 0.3); }

/* Delete Button (Red) */
.btn-hapus { 
    background: linear-gradient(135deg, #EF4444 0%, #b91c1c 100%);
    color: #fff; 
    box-shadow: 0 4px 0 #991b1b, 0 5px 10px rgba(239, 68, 68, 0.3);
}
.btn-hapus:hover { transform: translateY(-2px); box-shadow: 0 6px 0 #991b1b, 0 8px 15px rgba(239, 68, 68, 0.4); }
.btn-hapus:active { top: 4px; box-shadow: 0 0 0 #991b1b, 0 2px 5px rgba(239, 68, 68, 0.3); }

/* Disabled State */
.disabled {
    background: #ccc !important;
    box-shadow: none !important;
    color: #666 !important;
    transform: none !important;
    top: 0 !important;
    cursor: not-allowed !important;
}

/* ================= RIGHT PANEL (IMAGE) - Posisi di KANAN sesuai SKM ================= */
.dashboard-right {
    flex: 1.1;
    background-color: #C9E1FF;
    /* Pastikan gambar ada */
    background-image: url('{{ asset("images/admin1.jpg") }}');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 60px 5px 20px; 
    position: relative;
    
    /* Bayangan pemisah */
    box-shadow: inset 15px 0 20px -10px rgba(0,0,0,0.15);
    z-index: 2;
}

.dashboard-right::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.35) 10%, transparent 60%);
    z-index: 1;
}
.dashboard-right h1 {
    position: relative;
    z-index: 2;
    color: white;
    font-size: 1.5rem;
    font-weight: 800;
    margin-top: 40px;
    text-shadow: 0 4px 8px rgba(0,0,0,0.6);
    text-align: center;
}
.dashboard-right h1 span { color: #30E3BC; }


/* ================= RESPONSIVE MODE ==================== */
@media (max-width: 992px) {
    .dashboard-card { flex-direction: column; min-height: auto; }

    /* Mobile: Image on Top */
    .dashboard-right { 
        order: 1;
        height: 260px; 
        padding-top: 40px; 
        border-radius: 20px 20px 0 0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .dashboard-right h1 { font-size: 1.8rem; margin-top: 10px; }
    
    .dashboard-left { order: 2; padding: 30px 20px; }
    .title-card { font-size: 1.8rem; }
    .container-dashboard { margin-top: 10px; }
    .logo-header { top: 10px; right: 10px; }
    .logo-header img { height: 40px; }
}

@media (max-width: 600px) {
    .action-buttons { flex-direction: column; gap: 10px; padding: 15px; }
    .btn-action { width: 100%; }
}
</style>

{{-- === LOGO === --}}
<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

{{-- === PANGGIL SIDEBAR === --}}
@include('components._sidebar')

<div class="container-dashboard">
    <div class="dashboard-card">

        {{-- === PANEL KIRI: KONTEN (Sesuai Layout SKM) === --}}
        <div class="dashboard-left">
            
            {{-- Flash Message --}}
            @if(session('success'))
                <div style="background: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 8px; font-size: 0.9rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: #f8d7da; color: #842029; padding: 10px; border-radius: 8px; font-size: 0.9rem;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="title-card">
                <div class="menu-icon" id="menuToggle">
                    <span></span><span></span><span></span>
                </div>
                Data <span>Pengunjung</span>
            </div>

            <div class="data-card">
                <h3>
                    📊 Daftar Tamu / Pengunjung
                    <span class="total-data">Total: {{ $pengunjung->count() }}</span>
                </h3>

                {{-- FORM UNTUK BATCH ACTION (Dibungkus agar Edit/Hapus Multiple Berjalan) --}}
                <form id="batchForm" method="POST" action="" style="display:flex; flex-direction:column; flex-grow:1; overflow:hidden;">
                    @csrf
                    
                    {{-- TABEL CONTAINER --}}
                    <div class="tabel-container">
                        <div class="data-table-header">
                            <span class="checkbox-col">
                                <input type="checkbox" id="checkAll">
                            </span>
                            <span class="col-tanggal">Tanggal</span>
                            <span class="col-nama">Nama / NIP</span>
                            <span class="col-instansi">Instansi</span>
                            <span class="col-layanan">Layanan</span>
                            <span class="col-keperluan">Keperluan</span>
                            <span class="col-hp">No. Hp</span>
                        </div>

                        {{-- DATA ROWS --}}
                        @if($pengunjung->count() > 0)
                            @foreach($pengunjung as $item)
                            <div class="data-table-row">
                                <span class="checkbox-col">
                                    {{-- Menggunakan array ids[] untuk support multiple delete --}}
                                    <input type="checkbox" name="ids[]" class="row-check" value="{{ $item->id }}">
                                </span>
                                <span class="col-tanggal">{{ $item->tanggal }}</span>
                                <span class="col-nama">{{ $item->nama_nip }}</span>
                                <span class="col-instansi">{{ $item->instansi }}</span>
                                <span class="col-layanan">{{ $item->layanan }}</span>
                                <span class="col-keperluan">{{ $item->keperluan }}</span>
                                <span class="col-hp">{{ $item->no_hp }}</span>
                            </div>
                            @endforeach
                        @else
                            <div style="padding: 30px; text-align: center; color: #888; min-width: 1000px;">
                                <p>Tidak ada data pengunjung.</p>
                            </div>
                        @endif
                    </div>

                    {{-- ACTION BUTTONS (Style 3D SKM) --}}
                    <div class="action-buttons">
                        
                        {{-- Tombol Edit Multiple --}}
                        <button type="button" id="batchEdit" class="btn-action btn-edit disabled" style="pointer-events:none; opacity:0.5;">
                            Edit
                        </button>

                        {{-- Tombol Hapus Multiple --}}
                        <button type="button" id="batchDelete" class="btn-action btn-hapus disabled" style="pointer-events:none; opacity:0.5;">
                            Hapus
                        </button>

                    </div>
                </form>

            </div>
        </div>

        {{-- === PANEL KANAN: GAMBAR (Sesuai Layout SKM) === --}}
        <div class="dashboard-right">
            <h1>Data <span>Pengunjung</span></h1>
        </div>

    </div>
</div>

@include('components._footer')

<script>
document.addEventListener("DOMContentLoaded", function(){

    // LOGIC CHECKBOX MULTIPLE / BATCH
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('.row-check');
    const batchEdit = document.getElementById('batchEdit');
    const batchDelete = document.getElementById('batchDelete');
    const batchForm = document.getElementById('batchForm');

    function updateButtonState() {
        // Cek apakah ada setidaknya satu checkbox yang dicentang
        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);

        if (anyChecked) {
            // Aktifkan Tombol (Hapus class disabled & style opacity)
            batchEdit.style.pointerEvents = "auto";
            batchDelete.style.pointerEvents = "auto";
            batchEdit.style.opacity = "1";
            batchDelete.style.opacity = "1";
            batchEdit.classList.remove("disabled");
            batchDelete.classList.remove("disabled");
            
            // Restore Shadow
            batchEdit.style.boxShadow = "";
            batchDelete.style.boxShadow = "";
        } else {
            // Nonaktifkan Tombol
            batchEdit.style.pointerEvents = "none";
            batchDelete.style.pointerEvents = "none";
            batchEdit.style.opacity = "0.5";
            batchDelete.style.opacity = "0.5";
            batchEdit.classList.add("disabled");
            batchDelete.classList.add("disabled");

            batchEdit.style.boxShadow = "none";
            batchDelete.style.boxShadow = "none";
        }
    }

    // Event Listener Check All
    if(checkAll){
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = checkAll.checked);
            updateButtonState();
        });
    }

    // Event Listener Individual Checkbox
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateButtonState);
    });

    // Inisialisasi awal
    updateButtonState();

    // === ACTION HANDLER ===
    
    // HAPUS BATCH
    if(batchDelete){
        batchDelete.addEventListener('click', function() {
            const selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            if(selectedCount === 0) return;

            if(confirm('Yakin mau hapus ' + selectedCount + ' data pengunjung yang dipilih?')) {
                // Set action form ke route delete batch
                // Pastikan route ini ada di web.php Anda
                batchForm.action = "{{ route('admin.pengunjung.batchDelete') }}";
                batchForm.submit();
            }
        });
    }

    // EDIT BATCH
    if(batchEdit){
        batchEdit.addEventListener('click', function() {
            const selectedIds = Array.from(checkboxes)
                                    .filter(cb => cb.checked)
                                    .map(cb => cb.value);
            
            if(selectedIds.length === 0) return;

            // Redirect ke halaman edit dengan query string IDs
            // Pastikan route ini ada di web.php Anda
            window.location.href = "{{ route('admin.pengunjung.editMultiple') }}?ids=" + selectedIds.join(',');
        });
    }
});
</script>
@endsection