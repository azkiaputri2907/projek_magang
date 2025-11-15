@extends('layouts.app')

@section('title', 'Data SKM | Disdik Kab.Banjar')

@section('content')
<style>
body {
    background-color: #DFEDFE;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding-top: 50px;
    min-height: 100vh;
}

/* LOGO */
.logo-header {
    position: absolute;
    top: 25px;
    right: 45px;
    display: flex;
    gap: 10px;
    z-index: 100;
}
.logo-header img { height: 55px; }

/* === SIDEBAR === */
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
}
#sidebar.active { left: 0; }
#sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    display: none;
}
#sidebar.active + #sidebar-overlay { display: block; }

.sidebar-profile {
    display: flex;
    align-items: center;
    padding: 0 15px 20px 15px;
    border-bottom: 1px solid #eee;
    margin-bottom: 10px;
}
.sidebar-profile img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
}
.sidebar-profile div { font-size: 14px; color: #333; }
.sidebar-profile div span { display: block; font-size: 12px; color: #666; }

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
.sidebar-link:hover {
    background-color: rgba(220,53,69,0.05);
}
.sidebar-link i { margin-right: 10px; }

.sidebar-link.active {
    background-color: rgba(220,53,69,0.1);
    border-left: 4px solid #dc3545;
    font-weight: bold;
    border-radius: 0 5px 5px 0;
}

.sidebar-footer {
    padding: 15px;
}
.sidebar-footer a {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    text-decoration: none;
    color: #fff;
    background-color: #dc3545;
    font-weight: bold;
    border-radius: 5px;
    font-size: 14px;
}

/* DASHBOARD MAIN */
.container-dashboard {
    display: flex;
    justify-content: center;
    width: 95%;
    max-width: 1300px;
    margin-top: 20px;
}

.dashboard-card {
    display: flex;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    width: 100%;
    min-height: 700px;
}

.dashboard-left {
    flex: 2.2;
    padding: 20px 30px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.title-card {
    background: #fff;
    border-radius: 12px;
    padding: 10px 20px;
    font-size: 1.5rem;
    font-weight: 800;
    color: #007BFF;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 15px;
}

/* MENU ICON */
.menu-icon {
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 22px;
    height: 18px;
}
.menu-icon span {
    height: 3px;
    background: #333;
    border-radius: 2px;
}

/* TABLE CARD */
.data-card {
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    gap: 15px;
    font-size: 0.85rem;
}

.data-card h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #003366;
}

/* HEADER TABEL */
.data-table-header,
.data-table-row {
    display: flex;
    padding: 10px;
    align-items: center;
}
.data-table-header {
    font-weight: 600;
    border-bottom: 2px solid #eee;
    color: #333;
}
.data-table-row {
    border-bottom: 1px dashed #ddd;
    color: #444;
}
.data-table-header > span,
.data-table-row > span {
    flex: 1;
    text-align: left !important;
}

.checkbox-col { flex: .2 !important; }

/* BUTTON ACTION */
.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 15px;
}
.btn-action {
    padding: 10px 20px;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    cursor: pointer;
}
.btn-simpan { background: #FFD76B; color: #333; }
.btn-edit { background-color: #20c997; color: #fff; }
.btn-hapus { background-color: #dc3545; color: #fff; }

/* RIGHT PANEL */
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
    padding: 60px 20px 20px;
    position: relative;
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
    overflow: hidden;
}

.dashboard-right::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.25) 20%, transparent 60%);
    z-index: 1;
}
.dashboard-right h1 {
    z-index: 2;
    color: white;
    font-size: 2rem;
    font-weight: 800;
    margin-top: 40px;
}
.dashboard-right h1 span { color: #30E3BC; }

</style>


<!-- LOGO -->
<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}">
</div>



<!-- === SIDEBAR === -->
<div id="sidebar">
    <div class="sidebar-profile">
        <img src="{{ asset('images/avatar_admin.png') }}" alt="Avatar">
        <div>
            Jamilatul Azkia Putri
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

<!-- DASHBOARD -->
<div class="container-dashboard">
    <div class="dashboard-card">

        <div class="dashboard-left">
            <div class="title-card">
                <div class="menu-icon" id="menuToggle">
                    <span></span><span></span><span></span>
                </div>
                Data SKM
            </div>

            <div class="data-card">
                <h3>📊 Data SKM</h3>

                <div class="data-table-header">
                    <span class="checkbox-col"></span>
                    <span>Usia</span>
                    <span>Jenis Kelamin</span>
                    <span>Pendidikan</span>
                    <span>Pekerjaan</span>
                    <span>Layanan Diterima</span>
                </div>

                {{-- ROWS --}}
                @foreach($skm as $item)
                <div class="data-table-row">
                    <span class="checkbox-col">
                        <input type="checkbox" class="row-check" value="{{ $item->id }}">
                    </span>
                    <span>{{ $item->usia }}</span>
                    <span>{{ $item->jenis_kelamin }}</span>
                    <span>{{ $item->pendidikan_terakhir }}</span>
                    <span>{{ $item->pekerjaan }}</span>
                    <span>{{ $item->jenis_layanan_diterima }}</span>
                </div>
                @endforeach

<!-- ACTION BUTTONS -->
<div class="action-buttons">

    <!-- EDIT (disabled awal) -->
    <a id="btnEdit"
       href="javascript:void(0)"
       class="btn-action btn-edit disabled"
       style="pointer-events:none; opacity:0.5; text-decoration:none;">
        Edit
    </a>

    <!-- HAPUS (disabled awal) -->
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

    <!-- PERTANYAAN -->
    <a href="/admin/skm/pertanyaan"
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



<!-- SCRIPT: Sidebar Toggle -->
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


<!-- SCRIPT: AKTIFKAN TOMBOL EDIT & HAPUS -->
<script>
document.addEventListener("DOMContentLoaded", function(){

    const checkboxes = document.querySelectorAll('.row-check');
    const btnEdit = document.getElementById('btnEdit');
    const btnDelete = document.getElementById('btnDelete');
    const deleteForm = document.getElementById('deleteForm');

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function(){

            let checked = document.querySelector('.row-check:checked');

            if (checked) {
                let id = checked.value;

                btnEdit.style.pointerEvents = "auto";
                btnDelete.style.pointerEvents = "auto";
                btnEdit.style.opacity = "1";
                btnDelete.style.opacity = "1";

                btnEdit.classList.remove("disabled");
                btnDelete.classList.remove("disabled");

                btnEdit.href = "/admin/skm/" + id + "/edit";

                deleteForm.action = "/admin/skm/" + id;

            } else {

                btnEdit.style.pointerEvents = "none";
                btnDelete.style.pointerEvents = "none";
                btnEdit.style.opacity = "0.5";
                btnDelete.style.opacity = "0.5";

                btnEdit.classList.add("disabled");
                btnDelete.classList.add("disabled");
            }
        });
    });

});
</script>

@endsection
