@extends('layouts.app')

@section('title', 'Data Pengunjung | Disdik Kab.Banjar')

@section('content')
<style>
body {
    background-color: #DFEDFE;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding-top: 50px;
    min-height: 100vh;
}
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

/* === DASHBOARD === */
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

/* === TABLE === */
.data-card {
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    gap: 15px;
    font-size: 0.8rem;
}
.data-table-header, .data-table-row {
    display: flex;
    padding: 8px;
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
.data-table-header > span, .data-table-row > span {
    flex: 1;
    text-align: left;
}
.checkbox-col { flex: 0.1; }

.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 15px;
}
.btn-action {
    padding: 10px 20px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
}
.btn-edit { background-color: #20c997; color: #fff; }
.btn-hapus { background-color: #dc3545; color: #fff; }

.btn-item {
    flex: 1;
    font-weight: 600;
    padding: 12px 20px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}
.btn-item:hover { transform: translateY(-1px); }
.btn-laporan { background-color: #dfefff; color: #444; }
.btn-keluar { background-color: #EF4444; color: #fff; }

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

    /* TAMBAHAN INI BIAR UJUNG KANAN ATAS & BAWAH MELENGKUNG */
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
    overflow: hidden; /* wajib biar fotonya ngikut bentuk radius */
}

.dashboard-right::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3) 15%, transparent 60%);
}
.dashboard-right h1 {
    position: relative;
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    text-align: center;
    z-index: 2;
    margin-top: 40px;
    text-shadow: 0 2px 6px rgba(0,0,0,0.5);
}
.dashboard-right h1 span { color: #30E3BC; }

@media (max-width:992px) {
    .dashboard-card { flex-direction: column; }
    .dashboard-right { width: 100%; margin-top: 20px; }
}
</style>

<!-- Logo -->
<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
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

<!-- === DASHBOARD CONTENT === -->
<div class="container-dashboard">
    <div class="dashboard-card">
        <div class="dashboard-left">
            <div class="title-card">
                <div class="menu-icon" id="menuToggle"><span></span><span></span><span></span></div>
                Data Pengunjung
            </div>

            <div class="data-card">
                <div class="data-table-header">
                    <span class="checkbox-col"><input type="checkbox" id="checkAll"></span>
                    <span>Tanggal</span>
                    <span>Nama / NIP</span>
                    <span>Instansi</span>
                    <span>Layanan</span>
                    <span>Keperluan</span>
                    <span>No. Hp</span>
                </div>

                <form id="batchForm" method="POST" action="">
                    @csrf
                    @foreach($pengunjung as $item)
                    <div class="data-table-row">
                        <span class="checkbox-col"><input type="checkbox" name="ids[]" value="{{ $item->id }}"></span>
                        <span>{{ $item->tanggal }}</span>
                        <span>{{ $item->nama_nip }}</span>
                        <span>{{ $item->instansi }}</span>
                        <span>{{ $item->layanan }}</span>
                        <span>{{ $item->keperluan }}</span>
                        <span>{{ $item->no_hp }}</span>
                    </div>
                    @endforeach

                    <div class="action-buttons">
                        <button type="button" class="btn-action btn-edit" id="batchEdit">Edit</button>
                        <button type="button" class="btn-action btn-hapus" id="batchDelete">Hapus</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="dashboard-right">
            <h1>Data <span>Pengunjung!</span></h1>
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
