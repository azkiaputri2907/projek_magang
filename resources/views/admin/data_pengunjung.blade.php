@extends('layouts.app')

@section('title', 'Data Pengunjung | Admin')

@section('content')
<style>
/* ======================== GLOBAL ======================== */
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

/* === DASHBOARD CONTENT (EFEK 3D CARD) === */
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
    height: 620px; 
    width: 100%;
    
    /* EFEK TIMBUL: Shadow Berlapis & Border Tebal Bawah */
    box-shadow: 
        0 20px 50px rgba(0, 0, 0, 0.15),
        0 5px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(255,255,255,0.6);
    border-bottom: 6px solid #e1e8f0;
}

/* ================= LEFT PANEL (GAMBAR) ================= */
.dashboard-left-image {
    flex: 0.9;
    background-image: url('{{ asset("images/admin1.jpg") }}');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    flex-direction: column;
    position: relative;
    padding: 80px 40px 40px;
    box-shadow: 5px 0 15px rgba(0,0,0,0.1); 
    z-index: 2;
}

.dashboard-left-image::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.35) 10%, transparent 60%);
    z-index: 1;
}

.dashboard-left-image h1 {
    position: relative;
    font-size: 2.2rem;
    font-weight: 800;
    color: #fff;
    margin-top: 40px;
    margin-bottom: 30px;
    z-index: 2;
    text-shadow: 0 4px 8px rgba(0,0,0,0.6);
    text-align: center;
}
.dashboard-left-image h1 span { color: #30E3BC; }

/* ================= RIGHT PANEL (KONTEN) ================= */
.dashboard-right-content {
    flex: 2.1;
    padding: 40px 50px;
    display: flex;
    flex-direction: column;
    position: relative;
    gap: 20px;
    background-color: #F8FBFF;
    z-index: 1;
}

/* Title Card */
.title-card {
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

/* === TABLE SECTION (Data Card) === */
.data-table-section {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    /* Pastikan tidak overflow keluar card utama */
    min-height: 0; 
}

/* DATA CARD (Container Tabel) */
.data-card {
    background: #fff;
    border-radius: 15px;
    padding: 0;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    overflow: hidden; /* Penting untuk scroll dalam card */
    box-shadow: 
        0 4px 6px rgba(0,0,0,0.02),
        inset 0 0 0 1px #e0e6ed;
}

/* TABLE HEADER (Style Bar Timbul) */
.data-table-header {
    display: flex;
    padding: 12px 10px;
    font-weight: 700;
    background: linear-gradient(to right, #007BFF, #0056b3);
    color: #fff;
    font-size: .9rem;
    box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2);
    /* Sticky Header Properties */
    position: sticky;
    top: 0;
    z-index: 10;
    /* Min-width agar header ikut lebar container saat di-scroll */
    min-width: 1200px; /* <--- Diperlebar agar memicu scroll horizontal */
}

.data-table-row {
    display: flex;
    padding: 10px 10px;
    border-bottom: 1px solid #f0f0f0;
    color: #444;
    font-size: .85rem;
    transition: background 0.2s;
    /* Min-width agar row ikut lebar container saat di-scroll */
    min-width: 1200px; /* <--- Diperlebar sama dengan header */
}
.data-table-row:hover { background-color: #f0f7ff; }
.data-table-row:last-child { border-bottom: none; }

/* Column Flex Properties */
.data-table-header > span, .data-table-row > span {
    text-align: left;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.checkbox-col { flex: 0.1; min-width: 30px; display: flex; align-items: center; }
.col-tanggal { flex: 1; min-width: 80px;} 
.col-nama { flex: 2; min-width: 150px; font-weight: 600; color: #333; }
.col-instansi { flex: 1.5; min-width: 100px; }
.col-layanan { flex: 2.5; min-width: 150px; }
.col-keperluan { flex: 3; min-width: 200px; }
.col-hp { flex: 1.2; min-width: 90px; }

/* Checkbox Style */
input[type="checkbox"] {
    accent-color: #30E3BC;
    cursor: pointer;
    width: 16px;
    height: 16px;
}

/* Scroll Container */
.tabel-container {
    flex-grow: 1;
    /* Ubah ke auto agar bisa scroll X dan Y */
    overflow: auto; 
    padding-right: 0px; /* Reset padding right agar scrollbar rapi */
    background-color: #fff;
    /* Custom Scrollbar */
    scrollbar-width: thin;
    scrollbar-color: #ccc #f1f1f1;
}

.tabel-container::-webkit-scrollbar { width: 8px; height: 8px; }
.tabel-container::-webkit-scrollbar-track { background: #f1f1f1; }
.tabel-container::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }

/* Action Buttons (3D Push Buttons) */
.action-buttons {
    padding: 15px 20px;
    display: flex;
    /* justify-content: space-between untuk memisahkan teks total dan tombol */
    justify-content: space-between; 
    align-items: center;
    gap: 15px;
    border-top: 1px solid #eee;
    background-color: #fafbfc;
    min-height: 70px; /* Tinggi fix untuk tombol */
    /* Z-index agar shadow header tidak tertutup saat scroll paling bawah (opsional) */
    position: relative;
    z-index: 11;
}

/* Total Data Text */
.total-data-text {
    font-size: 0.85rem;
    color: #666;
    font-weight: 500;
}

.btn-group {
    display: flex;
    gap: 15px;
}

.btn-action {
    padding: 10px 25px;
    border: none;
    border-radius: 50px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    position: relative;
    top: 0;
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

/* Responsive */
@media (max-width: 992px) {
    .dashboard-card { flex-direction: column; height: auto; }
    .dashboard-left-image { 
        order: 1; height: 260px; padding-top: 40px; 
        border-radius: 20px 20px 0 0; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .dashboard-right-content { order: 2; padding: 30px 20px; }
    .title-card { font-size: 1.8rem; }
    .container-dashboard { margin-top: 10px; }
    .logo-header { top: 10px; right: 10px; }
    .logo-header img { height: 40px; }
}
@media (max-width: 600px) {
    /* Di mobile, kita biarkan scroll horizontal bekerja, jadi tidak perlu display:none untuk kolom */
    /* .col-hp, .col-keperluan { display: none; } */ 
    
    .data-table-header span, .data-table-row span { font-size: .75rem; }
    .action-buttons { flex-direction: row; justify-content: space-between; align-items: center; } 
    .btn-action { padding: 10px 15px; font-size: 0.7rem; }
    .btn-group { gap: 10px; }
}
</style>

{{-- === HEADER LOGO === --}}
<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

{{-- === SIDEBAR === --}}
@include('components._sidebar')

{{-- === KONTEN UTAMA === --}}
<div class="container-dashboard">
    <div class="dashboard-card">
        
        {{-- PANEL KIRI --}}
        <div class="dashboard-left-image">
            <h1>Data <span>Pengunjung</span> Admin</h1>
        </div>

        {{-- PANEL KANAN --}}
        <div class="dashboard-right-content">
            
            {{-- ALERT NOTIFIKASI --}}
            @if(session('success'))
            <div style="background: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 8px; margin-bottom: 10px; font-size: 0.9rem;">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div style="background: #f8d7da; color: #842029; padding: 10px; border-radius: 8px; margin-bottom: 10px; font-size: 0.9rem;">
                {{ session('error') }}
            </div>
            @endif

            <div class="title-card">
                {{-- ID menuToggle untuk trigger sidebar mobile --}}
                <div class="menu-icon" id="menuToggle"><span></span><span></span><span></span></div>
                Data <span>Pengunjung</span>
            </div>

            <div class="data-table-section">
                
                <div class="data-card">
                    
                    {{-- FORM BATCH ACTION --}}
                    {{-- Form moved to wrap entire content including header for logic consistency --}}
                    <form id="batchForm" method="POST" action="" style="display:flex; flex-direction:column; flex-grow:1; overflow:hidden;">
                        @csrf
                        
                        {{-- TABEL CONTAINER (Handles X and Y Scroll) --}}
                        <div class="tabel-container">
                            
                            {{-- HEADER TABLE (Moved Inside Container & Made Sticky) --}}
                            <div class="data-table-header">
                                <span class="checkbox-col"><input type="checkbox" id="checkAll"></span>
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
                                    {{-- Value checkbox = ID Baris Sheet (misal: 2, 5, 100) --}}
                                    <span class="checkbox-col">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}">
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
                                <div style="padding: 20px; text-align: center; color: #888; min-width: 1200px;">
                                    <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 10px; color: #ddd;"></i>
                                    <p>Data tidak ditemukan di Google Sheets.</p>
                                </div>
                            @endif
                        </div>

                        <div class="action-buttons">
                            {{-- Info Total Data (Pengganti Pagination) --}}
                            <div class="total-data-text">
                                Total: {{ $pengunjung->count() }} Data
                            </div>

                            {{-- BUTTONS --}}
                            <div class="btn-group">
                                <button type="button" class="btn-action btn-edit" id="batchEdit">Edit</button>
                                <button type="button" class="btn-action btn-hapus" id="batchDelete">Hapus</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

@include('components._footer')

<script>
document.addEventListener('DOMContentLoaded', function() {

    // === CHECKBOX & BUTTON LOGIC ===
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('input[name="ids[]"]');
    const batchForm = document.getElementById('batchForm');
    const batchEdit = document.getElementById('batchEdit');
    const batchDelete = document.getElementById('batchDelete');

    function updateButtonState() {
        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);

        if (anyChecked) {
            batchEdit.style.pointerEvents = "auto";
            batchDelete.style.pointerEvents = "auto";
            batchEdit.style.opacity = "1";
            batchDelete.style.opacity = "1";
            batchEdit.style.cursor = "pointer";
            batchDelete.style.cursor = "pointer";
        } else {
            batchEdit.style.pointerEvents = "none";
            batchDelete.style.pointerEvents = "none";
            batchEdit.style.opacity = "0.6"; 
            batchDelete.style.opacity = "0.6";
            batchEdit.style.cursor = "not-allowed";
            batchDelete.style.cursor = "not-allowed";
            batchEdit.style.boxShadow = "none";
            batchDelete.style.boxShadow = "none";
        }
        
        if(anyChecked) {
            batchEdit.style.boxShadow = "";
            batchDelete.style.boxShadow = "";
        }
    }

    // Init state
    updateButtonState();

    checkAll.addEventListener('change', () => {
        checkboxes.forEach(cb => cb.checked = checkAll.checked);
        updateButtonState();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateButtonState);
    });

    // === ACTION HANDLERS ===
    
    // HAPUS
    batchDelete.addEventListener('click', () => {
        const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
        if(selected.length === 0) return alert('Pilih data dulu!');
        
        if(confirm('Yakin mau hapus ' + selected.length + ' data yang dipilih dari Google Sheets?')) {
            // Arahkan form ke route batchDelete
            batchForm.action = "{{ route('admin.pengunjung.batchDelete') }}"; 
            batchForm.submit();
        }
    });

    // EDIT
    batchEdit.addEventListener('click', () => {
        const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
        if(selected.length === 0) return alert('Pilih data dulu!');
        
        // Redirect ke halaman edit dengan query string IDs
        window.location.href = "{{ route('admin.pengunjung.editMultiple') }}?ids=" + selected.join(',');
    });
});
</script>
@endsection