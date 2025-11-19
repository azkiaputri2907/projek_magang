@extends('layouts.app')

@section('title', 'Data SKM | Disdik Kab.Banjar')

@section('content')
<style>
/* ======================== GLOBAL ======================== */
body {
    background-color: #DFEDFE;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    /* PENYESUAIAN: Menghapus padding-top 50px */
    padding-top: 0rem; 
    min-height: 100vh;
    overflow-x: hidden;
}

/* LOGO */
.logo-header {
    position: absolute;
    top: 18px; /* Lebih ke atas */
    right: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 100;
}
.logo-header img { height: 50px; } /* Lebih kecil */

/* SIDEBAR - Pertahankan Gaya Asli */
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

/* DASHBOARD MAIN - Mengadopsi style Data Pengunjung yang dirapikan */
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
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    min-height: 580px;
    width: 100%;
}

/* ================= LEFT PANEL (KONTEN) ================= */
.dashboard-left {
    flex: 2.1; 
    padding: 40px 50px;
    display: flex;
    flex-direction: column;
    position: relative;
    gap: 20px;
}

/* Title Card */
.title-card {
    background: transparent; 
    border-radius: 0; 
    padding: 0; 
    font-size: 2rem; 
    font-weight: 800;
    color: #003366; 
    margin-bottom: 15px; 
    display: flex;
    align-items: center;
    gap: 15px;
}
.title-card span {
    color: #30E3BC; 
}


/* MENU ICON */
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


/* TABLE CARD */
.data-card {
    background: #fff;
    border-radius: 15px;
    padding: 0; 
    box-shadow: 0 6px 15px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    border: 1px solid #eee;
    overflow: hidden;
}

.data-card h3 {
    margin: 15px 10px 0 15px;
    font-size: 1.1rem;
    font-weight: 700;
    color: #003366;
}

/* HEADER TABEL */
.data-table-header,
.data-table-row {
    display: flex;
    padding: 8px 10px; 
    align-items: center;
    /* Dihapus: min-width: max-content; width: 100%; karena ini hanya dibutuhkan di tabel Jawaban yang kolomnya sangat banyak */
}
.data-table-header {
    font-weight: 700; 
    border-bottom: 2px solid #007BFF; 
    color: #333;
    font-size: .9rem;
    background-color: #f8f9fa;
}
.data-table-row {
    border-bottom: 1px solid #ddd; 
    color: #444;
    font-size: .85rem;
}
.data-table-row:last-child {
    border-bottom: none;
}


/* Column Flex Properties - RAPAT KIRI DAN PROPORSI KOLOM SKM */
.data-table-header > span,
.data-table-row > span {
    text-align: left; 
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap; 
    flex-grow: 1;
    flex-shrink: 0;
}

.checkbox-col { flex: 0.1; min-width: 30px; }
/* Proporsi Kolom SKM disesuaikan agar rata */
.col-usia { flex: 1; min-width: 50px;}
.col-jk { flex: 2; min-width: 100px; }
.col-pendidikan { flex: 2.5; min-width: 150px; }
.col-pekerjaan { flex: 2.5; min-width: 150px; }
.col-layanan { flex: 3.5; min-width: 200px; }


/* Wrapper untuk container yang bisa di-scroll */
.tabel-container {
    flex-grow: 1;
    overflow-y: auto;
    /* Tidak perlu overflow-x: auto; di sini karena kolomnya sedikit */
    padding-right: 6px;
    margin-top: 5px;
}

/* Dihapus: data-table-wrapper karena tidak diperlukan di sini */


/* BUTTON ACTION - Mengadopsi style Data Pengunjung */
.action-buttons {
    padding: 15px 10px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    border-top: 1px solid #eee;
}
.btn-action {
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    text-transform: uppercase;
    font-size: 0.85rem;
    transition: 0.2s ease;
}

.btn-simpan { 
    background: #30E3BC; 
    color: #fff; 
    box-shadow: 0 3px 8px rgba(48, 227, 188, 0.4);
}
.btn-edit { 
    background-color: #20c997; 
    color: #fff; 
    box-shadow: 0 3px 8px rgba(32, 201, 151, 0.4);
}
.btn-hapus { 
    background-color: #dc3545; 
    color: #fff; 
    box-shadow: 0 3px 8px rgba(220, 53, 69, 0.4);
}

.btn-edit:hover { background-color: #1a9c7b; }
.btn-hapus:hover { background-color: #c82333; }
.btn-simpan:hover { background-color: #27C4A1; }


/* RIGHT PANEL (Image) - Mengadopsi dashboard-left-image Data Pengunjung */
.dashboard-right {
    flex: 0.9;
    background-color: #C9E1FF;
    background-image: url('{{ asset('images/admin1.jpg') }}');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 80px 40px 40px; /* Padding disesuaikan */
    position: relative;
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
    overflow: hidden;
}

.dashboard-right::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.35) 10%, transparent 60%);
    z-index: 1;
}
.dashboard-right h1 {
    z-index: 2;
    color: white;
    font-size: 2.2rem;
    font-weight: 800;
    margin-top: 40px;
    text-shadow: 0 3px 8px rgba(0,0,0,0.55);
}
.dashboard-right h1 span { color: #30E3BC; }


/* ================= RESPONSIVE MODE ==================== */
@media (max-width: 992px) {

    .dashboard-card { flex-direction: column; min-height: auto; }

    /* Mengubah urutan untuk mobile: Gambar di atas */
    .dashboard-right { 
        order: 1;
        height: 260px; 
        padding-top: 40px; 
        border-radius: 20px 20px 0 0; 
        border-bottom-right-radius: 0;
    }

    .dashboard-right h1 { font-size: 1.8rem; margin-top: 10px; }
    
    .dashboard-left {
        order: 2;
        padding: 30px 20px;
    }

    .title-card {
        font-size: 1.8rem;
    }
    
    .container-dashboard {
        margin-top: 10px; 
    }

    .logo-header {
        top: 10px;
        right: 10px;
    }

    .logo-header img {
        height: 40px;
    }
    
    /* Pada mobile, lebar tabel masih horizontal tapi lebih sempit */
    .data-table-header {
        font-size: 0.8rem;
    }
    .data-table-row {
        font-size: 0.75rem;
    }
}

/* === MOBILE STACKED CARD VIEW (DI BAWAH 600PX) === */
@media (max-width: 600px) {
    
    /* 1. TABLE HEADER HILANG */
    .data-table-header {
        display: none; 
    }

    /* 2. BARIS DATA MENJADI CARD STACKED */
    .data-table-row {
        flex-direction: column;
        align-items: flex-start;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        height: auto;
    }
    .data-table-row:last-child {
        margin-bottom: 0;
    }

    .data-table-row span {
        /* Reset flex */
        flex: 1 1 100%; 
        width: 100%;
        text-align: left !important;
        white-space: normal; /* Biarkan teks panjang turun baris */
        text-overflow: clip;
        padding: 4px 0;
        border-bottom: 1px dotted #eee;
    }
    
    /* LABEL DARI DATA-LABEL */
    .data-table-row span:before {
        content: attr(data-label) ": ";
        font-weight: 600;
        color: #003366;
        min-width: 100px;
        display: inline-block;
        margin-right: 5px;
    }
    .data-table-row span:last-child {
        border-bottom: none;
    }
    
    /* Checkbox Styling */
    .checkbox-col {
        order: -1; 
        min-width: unset;
        width: auto;
        padding-bottom: 10px !important;
    }
    .checkbox-col input {
        margin-right: 8px;
    }
    .checkbox-col:before {
        content: 'Pilih Data';
        color: #30E3BC;
        font-weight: 700;
        display: inline-block;
    }
    .data-table-row .checkbox-col:before {
        content: 'Responden #';
    }


    /* TAMPILAN UMUM MOBILE */
    .dashboard-right h1 {
        font-size: 1.5rem;
    }
    
    .title-card {
        font-size: 1.5rem;
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
    .dashboard-right {
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

        <div class="dashboard-left">
            <div class="title-card">
                <div class="menu-icon" id="menuToggle">
                    <span></span><span></span><span></span>
                </div>
                Data <span>SKM</span>
            </div>

            <div class="data-card">
                <h3>📊 Data Responden Survey Kepuasan Masyarakat</h3>

                <div class="tabel-container">
                    <div class="data-table-header">
                        <span class="checkbox-col"></span>
                        <span class="col-usia">Usia</span>
                        <span class="col-jk">Jenis Kelamin</span>
                        <span class="col-pendidikan">Pendidikan</span>
                        <span class="col-pekerjaan">Pekerjaan</span>
                        <span class="col-layanan">Layanan Diterima</span>
                    </div>

                    {{-- ROWS --}}
                    @foreach($skm as $index => $item)
                    <div class="data-table-row">
                        <span class="checkbox-col" data-label="Responden #{{ $index + 1 }}">
                            <input type="checkbox" class="row-check" value="{{ $item->id }}">
                        </span>
                        <span class="col-usia" data-label="Usia">{{ $item->usia }}</span>
                        <span class="col-jk" data-label="Jenis Kelamin">{{ $item->jenis_kelamin }}</span>
                        <span class="col-pendidikan" data-label="Pendidikan">{{ $item->pendidikan_terakhir }}</span>
                        <span class="col-pekerjaan" data-label="Pekerjaan">{{ $item->pekerjaan }}</span>
                        <span class="col-layanan" data-label="Layanan Diterima">{{ $item->jenis_layanan_diterima }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="action-buttons">

                    <a id="btnEdit"
                        href="javascript:void(0)"
                        class="btn-action btn-edit disabled"
                        style="pointer-events:none; opacity:0.5; text-decoration:none;">
                        Edit
                    </a>

                    <form id="deleteForm" action="#" method="POST" style="display:inline-block; margin:0;">
                        @csrf
                        @method('DELETE')
                        <button id="btnDelete"
                                class="btn-action btn-hapus disabled"
                                style="pointer-events:none; opacity:0.5;"
                                onclick="return confirm('Yakin mau hapus data yang dipilih?')">
                            Hapus
                        </button>
                    </form>

                    <a href="{{ url('/admin/skm/pertanyaan') }}"
                        class="btn-action btn-simpan"
                        style="text-decoration:none;">
                        Pertanyaan
                    </a>

                </div>
            </div>
        </div>

        <div class="dashboard-right">
            <h1>Data <span>SKM</span></h1>
        </div>

    </div>
</div>

@include('components._footer')



<script>
document.addEventListener("DOMContentLoaded", function(){
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
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function(){

    const checkboxes = document.querySelectorAll('.row-check');
    const btnEdit = document.getElementById('btnEdit');
    const btnDelete = document.getElementById('btnDelete');
    const deleteForm = document.getElementById('deleteForm');

    // Mencegah multiple check
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if (this.checked) {
                checkboxes.forEach(otherCb => {
                    if (otherCb !== this) {
                        otherCb.checked = false;
                    }
                });
            }
            updateButtonState();
        });
    });

    function updateButtonState() {
        let checked = document.querySelector('.row-check:checked');

        if (checked) {
            let id = checked.value;

            btnEdit.style.pointerEvents = "auto";
            btnDelete.style.pointerEvents = "auto";
            btnEdit.style.opacity = "1";
            btnDelete.style.opacity = "1";

            btnEdit.classList.remove("disabled");
            btnDelete.classList.remove("disabled");

            // PERBAIKAN: Menggunakan rute yang benar untuk Edit SKM Responden
            btnEdit.href = "{{ url('/admin/skm') }}/" + id + "/edit";

            // PERBAIKAN: Menggunakan rute yang benar untuk Delete SKM Responden
            deleteForm.action = "{{ url('/admin/skm') }}/" + id;

        } else {

            btnEdit.style.pointerEvents = "none";
            btnDelete.style.pointerEvents = "none";
            btnEdit.style.opacity = "0.5";
            btnDelete.style.opacity = "0.5";

            btnEdit.classList.add("disabled");
            btnDelete.classList.add("disabled");
        }
    }
    
    // Set initial state
    updateButtonState();
});
</script>

@endsection