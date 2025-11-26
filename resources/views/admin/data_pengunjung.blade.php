@extends('layouts.app')

@section('title', 'Data Pengunjung | Disdik Kab.Banjar')

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
    height: 620px; /* Sedikit lebih tinggi untuk tabel */
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
    
    /* Bayangan pemisah */
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
}

/* DATA CARD (Container Tabel) */
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

/* TABLE HEADER (Style Bar Timbul) */
.data-table-header {
    display: flex;
    padding: 12px 10px;
    font-weight: 700;
    background: linear-gradient(to right, #007BFF, #0056b3); /* Gradient Biru */
    color: #fff;
    font-size: .9rem;
    box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2);
    z-index: 2;
}

.data-table-row {
    display: flex;
    padding: 10px 10px;
    border-bottom: 1px solid #f0f0f0;
    color: #444;
    font-size: .85rem;
    transition: background 0.2s;
}

.data-table-row:hover {
    background-color: #f0f7ff;
}

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
    overflow-y: auto;
    padding-right: 6px;
    background-color: #fff;
}

/* Action Buttons (3D Push Buttons) */
.action-buttons {
    padding: 15px 20px;
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    border-top: 1px solid #eee;
    background-color: #fafbfc;
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

/* Tombol Keluar Sidebar (Merah) */
.btn-keluar {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    background: linear-gradient(135deg, #EF4444 0%, #b91c1c 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 0 #991b1b;
    transition: all 0.1s;
}
.btn-keluar:active { transform: translateY(4px); box-shadow: none; }

/* ================= RESPONSIVE MODE ==================== */
@media (max-width: 992px) {
    .dashboard-card { flex-direction: column; height: auto; }
    
    .dashboard-left-image { 
        order: 1;
        height: 260px; 
        padding-top: 40px; 
        border-radius: 20px 20px 0 0; 
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .dashboard-left-image h1 { font-size: 1.8rem; margin-top: 10px; }
    
    .dashboard-right-content { order: 2; padding: 30px 20px; }
    .title-card { font-size: 1.8rem; }
    .container-dashboard { margin-top: 10px; }
    .logo-header { top: 10px; right: 10px; }
    .logo-header img { height: 40px; }
}

@media (max-width: 600px) {
    .dashboard-left-image h1 { font-size: 1.5rem; }
    .title-card { font-size: 1.5rem; }
    
    /* Header tabel responsif - sembunyikan kolom kurang penting */
    .col-hp, .col-keperluan { display: none; } 
    
    .data-table-header span, .data-table-row span { font-size: .75rem; }
    .action-buttons { padding: 15px; gap: 10px; flex-direction: column; }
    .btn-action { width: 100%; }
    
    .dashboard-card { border-radius: 15px; }
    .dashboard-left-image { border-radius: 15px 15px 0 0; }
}
</style>

<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

{{-- === PANGGIL SIDEBAR DARI COMPONENT === --}}
@include('components._sidebar')

{{-- KONTEN UTAMA --}}
<div class="container-dashboard">
    <div class="dashboard-card">
        
        <div class="dashboard-left-image">
            <h1>Data <span>Pengunjung</span> Admin</h1>
        </div>

        <div class="dashboard-right-content">
            
            <div class="title-card">
                <div class="menu-icon" id="menuToggle"><span></span><span></span><span></span></div>
                Data <span>Pengunjung</span>
            </div>

            <div class="data-table-section">
                
                <div class="data-card">
                    <div class="data-table-header">
                        <span class="checkbox-col"><input type="checkbox" id="checkAll"></span>
                        <span class="col-tanggal">Tanggal</span>
                        <span class="col-nama">Nama / NIP</span>
                        <span class="col-instansi">Instansi</span>
                        <span class="col-layanan">Layanan</span>
                        <span class="col-keperluan">Keperluan</span>
                        <span class="col-hp">No. Hp</span>
                    </div>

                    <form id="batchForm" method="POST" action="" style="display:flex; flex-direction:column; flex-grow:1; overflow:hidden;">
                        @csrf
                        <div class="tabel-container">
                            @foreach($pengunjung as $item)
                            <div class="data-table-row">
                                <span class="checkbox-col"><input type="checkbox" name="ids[]" value="{{ $item->id }}"></span>
                                <span class="col-tanggal">{{ $item->tanggal }}</span>
                                <span class="col-nama">{{ $item->nama_nip }}</span>
                                <span class="col-instansi">{{ $item->instansi }}</span>
                                <span class="col-layanan">{{ $item->layanan }}</span>
                                <span class="col-keperluan">{{ $item->keperluan }}</span>
                                <span class="col-hp">{{ $item->no_hp }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="action-buttons">
                            <button type="button" class="btn-action btn-edit" id="batchEdit">Edit</button>
                            <button type="button" class="btn-action btn-hapus" id="batchDelete">Hapus</button>
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
            batchEdit.style.opacity = "0.6"; // Sedikit lebih terang dari 0.5
            batchDelete.style.opacity = "0.6";
            batchEdit.style.cursor = "not-allowed";
            batchDelete.style.cursor = "not-allowed";
            // Hilangkan shadow saat disabled agar terlihat flat
            batchEdit.style.boxShadow = "none";
            batchDelete.style.boxShadow = "none";
        }
        
        // Kembalikan shadow jika enabled (reset inline style)
        if(anyChecked) {
            batchEdit.style.boxShadow = "";
            batchDelete.style.boxShadow = "";
        }
    }

    updateButtonState();

    checkAll.addEventListener('change', () => {
        checkboxes.forEach(cb => cb.checked = checkAll.checked);
        updateButtonState();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateButtonState);
    });

    batchDelete.addEventListener('click', () => {
        const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
        if(selected.length === 0) return alert('Pilih data dulu!');
        if(confirm('Yakin mau hapus data yang dipilih?')) {
            batchForm.action = "{{ route('pengunjung.batchDelete') }}";
            batchForm.submit();
        }
    });

    batchEdit.addEventListener('click', () => {
        const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
        if(selected.length === 0) return alert('Pilih data dulu!');
        window.location.href = "{{ route('pengunjung.editMultiple') }}?ids=" + selected.join(',');
    });
});
</script>
@endsection