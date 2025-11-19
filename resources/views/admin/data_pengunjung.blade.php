@extends('layouts.app')

@section('title', 'Data Pengunjung | Disdik Kab.Banjar')

@section('content')
<style>
/* ======================== GLOBAL ======================== */
body {
    background-color: #DFEDFE;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    /* Mengubah body agar konten tidak sepenuhnya centered, memberi ruang untuk header/sidebar */
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
}

.logo-header img {
    height: 50px;
}

/* SIDEBAR - Pertahankan Gaya Asli dari file Admin */
#sidebar {
    position: fixed;
    top: 0;
    left: -250px;
    height: 100%;
    width: 250px;
    background-color: #fff;
    box-shadow: 2px 0 15px rgba(0,0,0,0.3);
    z-index: 1000;
    transition: left 0.3s ease;
    padding: 20px 0;
    border-radius: 0 20px 20px 0;
    display: flex;
    flex-direction: column;
}

#sidebar.active { 
    left: 0; 
}

#sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    display: none;
}

#sidebar.active + #sidebar-overlay { 
    display: block; 
}

/* PROFILE DI SIDEBAR */
.sidebar-profile {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 15px 20px 15px;
    border-bottom: 1px solid #eee;
    margin-bottom: 10px;
    text-align: center;
}

.sidebar-profile img {
    width: 60px; 
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
}

.sidebar-profile div { 
    font-size: 14px; 
    color: #333; 
}

.sidebar-profile div span { 
    display: block; 
    font-size: 12px; 
    color: #666; 
}


/* MENU LINK */
.sidebar-link {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    text-decoration: none;
    color: #333;
    font-size: 14px;
    margin: 5px 0;
    transition: background 0.2s ease;
}

.sidebar-link i { 
    margin-right: 10px; 
}

.sidebar-link:hover { 
    background-color: rgba(220,53,69,0.05); 
}

.sidebar-link.active {
    background-color: rgba(195, 222, 255, 0.909);
    border-left: 4px solid #CFDDF7;
    font-weight: bold;
    border-radius: 0 8px 8px 0;
    margin-left: 0;
    margin-right: 20px;
    padding-left: 20px;
}


/* FOOTER / LOGOUT */
.sidebar-footer {
    padding: 15px;
    margin-top: auto;
    margin-bottom: 40px;
}

.sidebar-footer form button {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    background-color: #EF4444;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
}


/* === DASHBOARD CONTENT - Mengadopsi container-bukutamu/bukutamu-card === */
.container-dashboard {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    width: 95%;
    max-width: 1300px;
    margin: 0 auto;
    /* PENYESUAIAN MAKSIMAL: Mengurangi padding-top menjadi margin-top 5px */
    padding-top: 0; 
    margin-top: 5px; 
    padding-bottom: 20px;
}

.dashboard-card {
    display: flex;
    background-color: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    height: 580px; 
    width: 100%;
}

/* ================= LEFT PANEL (GAMBAR) - Mengadopsi bukutamu-left ================= */
.dashboard-left-image {
    flex: 0.9;
    background-image: url('{{ asset("images/admin1.jpg") }}'); /* Menggunakan gambar admin */
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    flex-direction: column;
    position: relative;
    padding: 80px 40px 40px;
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
    text-shadow: 0 3px 8px rgba(0,0,0,0.55);
    text-align: center;
}

.dashboard-left-image h1 span {
    color: #30E3BC;
}

/* ================= RIGHT PANEL (KONTEN) - Mengadopsi bukutamu-right ================= */
.dashboard-right-content {
    flex: 2.1;
    padding: 40px 50px;
    display: flex;
    flex-direction: column;
    position: relative;
    gap: 20px; /* Tambahkan gap */
}

/* Title Card (Diubah agar mirip h1 Buku Tamu tapi tetap mempertahankan menu) */
.title-card {
    background: transparent; 
    border-radius: 0; 
    padding: 0; 
    font-size: 2rem; /* Sedikit lebih kecil dari h1 */
    font-weight: 800;
    color: #003366; /* Mengadopsi warna h1 */
    margin-bottom: 15px; 
    display: flex;
    align-items: center;
    gap: 15px;
}

.title-card span {
    color: #30E3BC; 
}

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


/* === TABLE SECTION (Data Card) - Mengadopsi tabel-section === */
.data-table-section {
    flex-grow: 1; /* Pastikan mengambil ruang yang tersedia */
    display: flex;
    flex-direction: column;
}

/* Mengganti date-box dengan filter/search (jika ada, saat ini tidak ada filter) */
.filter-box {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-bottom: 15px;
}

/* Struktur Tabel */
.data-card {
    background: #fff;
    border-radius: 15px;
    padding: 0; /* Menghapus padding agar header/row bisa diatur terpisah */
    box-shadow: 0 6px 15px rgba(0,0,0,0.05); /* Mengurangi shadow */
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    border: 1px solid #eee; /* Tambahkan border tipis */
    overflow: hidden;
}

.data-table-header, .data-table-row {
    display: flex;
    padding: 8px 10px;
}
.data-table-header {
    font-weight: 700; /* Mengadopsi font-weight 700 */
    border-bottom: 2px solid #007BFF; /* Mengadopsi warna border */
    color: #333;
    font-size: .9rem; 
    background-color: #f8f9fa; /* Latar belakang untuk header */
}
.data-table-row {
    border-bottom: 1px solid #ddd; /* Mengubah dari dashed */
    color: #444;
    font-size: .85rem;
}
.data-table-row:last-child {
    border-bottom: none;
}

/* Column Flex Properties - RAPAT KIRI DAN PROPORSI KOLOM */
.data-table-header > span, .data-table-row > span {
    text-align: left; /* PENTING: Untuk rata kiri */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap; /* Mencegah teks turun baris */
}

.checkbox-col { flex: 0.1; min-width: 30px; }
/* PENTING: Penyesuaian proporsi flex agar tabel rata */
.col-tanggal { flex: 1; min-width: 80px;} 
.col-nama { flex: 2; min-width: 150px; } /* Ditingkatkan menjadi 2 */
.col-instansi { flex: 1.5; min-width: 100px; }
.col-layanan { flex: 2.5; min-width: 150px; } /* Ditingkatkan menjadi 2.5 */
.col-keperluan { flex: 3; min-width: 200px; } /* Ditingkatkan menjadi 3 */
.col-hp { flex: 1.2; min-width: 90px; }


/* Wrapper untuk container yang bisa di-scroll */
.tabel-container {
    flex-grow: 1;
    overflow-y: auto;
    padding-right: 6px;
    margin-top: 5px;
}

/* Action Buttons - Diadaptasi dari .action-buttons sebelumnya */
.action-buttons {
    padding: 15px 10px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    border-top: 1px solid #eee;
}
.btn-action {
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s ease;
    text-transform: uppercase;
    font-size: 0.85rem;
}
.btn-edit { 
    background-color: #20c997; /* Hijau */
    color: #fff; 
    box-shadow: 0 3px 8px rgba(32, 201, 151, 0.4);
}
.btn-edit:hover { background-color: #1a9c7b; }

.btn-hapus { 
    background-color: #dc3545; /* Merah */
    color: #fff; 
    box-shadow: 0 3px 8px rgba(220, 53, 69, 0.4);
}
.btn-hapus:hover { background-color: #c82333; }

/* ===================================================== */
/* ================= RESPONSIVE MODE ==================== */
/* ===================================================== */
@media (max-width: 992px) {

    .dashboard-card { flex-direction: column; height: auto; }

    /* Mengubah urutan untuk mobile: Gambar di atas */
    .dashboard-left-image { 
        order: 1;
        height: 260px; 
        padding-top: 40px; 
        border-radius: 20px 20px 0 0; 
    }

    .dashboard-left-image h1 { font-size: 1.8rem; margin-top: 10px; }
    
    .dashboard-right-content {
        order: 2;
        padding: 30px 20px;
    }

    .title-card {
        font-size: 1.8rem;
    }
    
    .container-dashboard {
        margin-top: 10px; /* Dikecilkan lagi untuk mobile */
    }

    .logo-header {
        top: 10px;
        right: 10px;
    }

    .logo-header img {
        height: 40px;
    }
}

@media (max-width: 600px) {
    .dashboard-left-image h1 {
        font-size: 1.5rem;
    }
    
    .title-card {
        font-size: 1.5rem;
    }
    
    .data-table-header span,
    .data-table-row span {
        font-size: .7rem; /* Lebih kecil agar muat */
    }

    .action-buttons {
        padding: 10px;
        gap: 5px;
    }
    .btn-action {
        padding: 8px 10px;
        font-size: 0.7rem;
    }
    
    /* Radius untuk mobile */
    .dashboard-card {
        border-radius: 15px;
    }
    .dashboard-left-image {
        border-radius: 15px 15px 0 0;
    }
}
</style>

<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

<div id="sidebar">
    <div class="sidebar-profile">
        <img src="{{ asset('images/avatar_admin.jpg') }}" alt="Avatar">
        <div>
            {{ Auth::user()->name ?? 'Admin' }}
            <span>Admin</span>
        </div>

    </div>

    <a href="{{ url('/admin/dashboard') }}" class="sidebar-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Beranda
    </a>
    <a href="{{ url('/admin/pengunjung') }}" class="sidebar-link {{ Request::is('admin/pengunjung') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Data Pengunjung
    </a>
    <a href="{{ url('/admin/skm') }}" class="sidebar-link {{ Request::is('admin/skm') ? 'active' : '' }}">
        <i class="fas fa-file-alt"></i> Data SKM
    </a>
        <a href="{{ url('/admin/skm/pertanyaan') }}" class="sidebar-link {{ Request::is('admin/skm/pertanyaan') ? 'active' : '' }}">
        <i class="fas fa-file-alt"></i> Data SKM Pertanyaan
    </a>
    <a href="{{ url('/admin/laporan') }}" class="sidebar-link {{ Request::is('admin/laporan') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> Laporan
    </a>

    <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-item btn-keluar">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>     
    </div>
</div>
<div id="sidebar-overlay"></div>

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

                    <form id="batchForm" method="POST" action="">
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
    // === SIDEBAR TOGGLE ===
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const toggle = document.getElementById('menuToggle');

    toggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
    });
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.style.display = 'none';
    });

    // === CHECKBOX ===
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('input[name="ids[]"]');
    const batchForm = document.getElementById('batchForm');
    const batchEdit = document.getElementById('batchEdit');
    const batchDelete = document.getElementById('batchDelete');

    // fungsi untuk ngecek apakah ada yang dicentang
    function updateButtonState() {
        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);

        if (anyChecked) {
            // aktifkan
            batchEdit.style.pointerEvents = "auto";
            batchDelete.style.pointerEvents = "auto";
            batchEdit.style.opacity = "1";
            batchDelete.style.opacity = "1";
            batchEdit.style.cursor = "pointer";
            batchDelete.style.cursor = "pointer";
        } else {
            // nonaktif
            batchEdit.style.pointerEvents = "none";
            batchDelete.style.pointerEvents = "none";
            batchEdit.style.opacity = "0.5";
            batchDelete.style.opacity = "0.5";
            batchEdit.style.cursor = "not-allowed";
            batchDelete.style.cursor = "not-allowed";
        }
    }

    // Set awal: disable kedua tombol
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