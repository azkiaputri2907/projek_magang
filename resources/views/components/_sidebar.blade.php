<style>
/* ======================== CSS SIDEBAR MODERN ======================== */

/* SIDEBAR WRAPPER */
#sidebar {
    position: fixed;
    top: 0;
    left: -280px; /* Sedikit lebih lebar agar lega */
    height: 100%;
    width: 280px;
    background-color: #ffffff;
    /* Bayangan lebih halus dan menyebar */
    box-shadow: 4px 0 25px rgba(0,0,0,0.05);
    z-index: 1000;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); /* Animasi lebih smooth */
    padding: 25px 0;
    border-radius: 0 25px 25px 0;
    display: flex;
    flex-direction: column;
    font-family: 'Poppins', sans-serif;
}

#sidebar.active { left: 0; }

/* OVERLAY */
#sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,30,60, 0.4); /* Warna overlay agak biru gelap */
    backdrop-filter: blur(3px); /* Efek blur di belakang */
    z-index: 999;
    display: none;
    transition: opacity 0.3s;
}
#sidebar.active + #sidebar-overlay { display: block; }

/* PROFILE SECTION (CARD STYLE) */
.sidebar-profile {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    margin: 0 20px 30px 20px;
    background: linear-gradient(to right, #f8f9fa, #e9ecef);
    border-radius: 15px;
    border: 1px solid #dee2e6;
}

.sidebar-profile img {
    width: 50px; 
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.sidebar-profile .profile-info {
    display: flex;
    flex-direction: column;
}

.sidebar-profile .profile-name { 
    font-size: 14px; 
    color: #003366; 
    font-weight: 700; 
    line-height: 1.2;
}
.sidebar-profile .profile-role { 
    font-size: 11px; 
    color: #30E3BC; 
    font-weight: 600; 
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 2px;
}

/* MENU LABEL */
.menu-label {
    padding: 0 25px;
    margin-bottom: 10px;
    font-size: 11px;
    font-weight: 700;
    color: #adb5bd;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* LINKS (PILL STYLE) */
.sidebar-link {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    margin: 4px 15px; /* Margin kiri kanan agar seperti kapsul */
    text-decoration: none;
    color: #555;
    font-size: 14px;
    font-weight: 500;
    border-radius: 12px; /* Sudut membulat */
    transition: all 0.3s ease;
    position: relative;
}

.sidebar-link i { 
    width: 25px;
    text-align: center;
    margin-right: 12px; 
    font-size: 16px;
    transition: transform 0.2s;
    color: #888;
}

/* Hover Effect */
.sidebar-link:hover { 
    background-color: #F0F4F8; 
    color: #003366;
    transform: translateX(5px); /* Gerakan sedikit ke kanan */
}
.sidebar-link:hover i {
    color: #30E3BC;
    transform: scale(1.1);
}

/* Active State - GRADIENT & SHADOW */
.sidebar-link.active {
    background: linear-gradient(135deg, #003366 0%, #00509d 100%);
    color: #fff;
    box-shadow: 0 8px 20px rgba(0, 51, 102, 0.25); /* Bayangan biru halus */
}

.sidebar-link.active i {
    color: #30E3BC; /* Ikon jadi warna tosca saat aktif */
}

/* FOOTER */
.sidebar-footer {
    padding: 0 20px;
    margin-top: auto;
    margin-bottom: 30px; 
}

.btn-keluar {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    padding: 12px;
    background: #fff;
    color: #dc3545;
    border: 2px solid #f8d7da;
    border-radius: 12px;
    font-weight: 700;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-keluar:hover {
    background: #dc3545;
    color: #fff;
    border-color: #dc3545;
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    transform: translateY(-2px);
}
.btn-keluar:active { transform: translateY(0); }

</style>

<div id="sidebar">
    {{-- PROFILE SECTION --}}
    <div class="sidebar-profile">
        <img src="{{ asset('images/avatar_admin.jpg') }}" alt="Avatar">
        <div class="profile-info">
            <span class="profile-name">{{ Auth::user()->name ?? 'Administrator' }}</span>
            <span class="profile-role">Admin</span>
        </div>
    </div>

    {{-- MENU LINKS --}}
    <div class="menu-label">Menu Utama</div>

    <a href="{{ url('/admin/dashboard') }}" class="sidebar-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> 
        <span>Beranda</span>
    </a>
    <a href="{{ url('/admin/pengunjung') }}" class="sidebar-link {{ Request::is('admin/pengunjung*') ? 'active' : '' }}">
        <i class="fas fa-users"></i> 
        <span>Data Pengunjung</span>
    </a>
    <a href="{{ url('/admin/skm') }}" class="sidebar-link {{ Request::is('admin/skm') ? 'active' : '' }}">
        <i class="fas fa-file-signature"></i> 
        <span>Data SKM</span>
    </a>

    <div class="menu-label" style="margin-top: 20px;">Lainnya</div>

    <a href="{{ url('/admin/laporan') }}" class="sidebar-link {{ Request::is('admin/laporan*') ? 'active' : '' }}">
        <i class="fas fa-chart-pie"></i> 
        <span>Laporan & Statistik</span>
    </a>

    {{-- FOOTER / LOGOUT --}}
    <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-keluar">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>     
    </div>
</div>

{{-- OVERLAY --}}
<div id="sidebar-overlay"></div>

{{-- SCRIPT --}}
<script>
document.addEventListener("DOMContentLoaded", function(){
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const toggle = document.getElementById('menuToggle');

    // Fungsi buka tutup sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('active');
        if (sidebar.classList.contains('active')) {
            overlay.style.display = 'block';
            setTimeout(() => overlay.style.opacity = '1', 10); // Fade in
        } else {
            overlay.style.opacity = '0'; // Fade out
            setTimeout(() => overlay.style.display = 'none', 300);
        }
    }

    if(toggle) {
        toggle.addEventListener('click', toggleSidebar);
    }

    if(overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.style.opacity = '0';
            setTimeout(() => overlay.style.display = 'none', 300);
        });
    }
});
</script>