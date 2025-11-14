<div id="sidebar-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 999; display: none;"></div>

<div id="sidebar" class="sidebar" style="position: fixed; top: 0; left: -250px; height: 100%; width: 250px; background-color: white; padding: 20px 0; box-shadow: 2px 0 15px rgba(0,0,0,0.3); z-index: 1000; box-sizing: border-box; transition: left 0.3s ease;">

    <div style="display: flex; align-items: center; padding: 0 15px 20px 15px; border-bottom: 1px solid #eee; margin-bottom: 10px;">
        <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #f0f0f0; margin-right: 10px; overflow: hidden;">
            <img src="URL_AVATAR_ANDA" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div>
            <div style="font-weight: bold; color: #333; font-size: 14px;">Jamilatul Azkia Putri</div>
            <div style="color: #666; font-size: 12px;">Admin</div>
        </div>
    </div>
    
    <a href="{{ url('/admin/dashboard') }}" style="display: flex; align-items: center; padding: 12px 15px; text-decoration: none; color: #333; font-size: 14px; margin: 5px 0; 
        {{ Request::is('admin/dashboard') ? 'background-color: rgba(220, 53, 69, 0.1); border-radius: 0 5px 5px 0; border-left: 4px solid #dc3545; font-weight: bold;' : '' }}">
        <i class="fas fa-home" style="margin-right: 10px;"></i> Beranda
    </a>
    
    <a href="{{ url('/admin/pengunjung') }}" style="display: flex; align-items: center; padding: 12px 15px; text-decoration: none; color: #333; font-size: 14px; margin: 5px 0; 
        {{ Request::is('admin/pengunjung') ? 'background-color: rgba(220, 53, 69, 0.1); border-radius: 0 5px 5px 0; border-left: 4px solid #dc3545; font-weight: bold;' : '' }}">
        <i class="fas fa-users" style="margin-right: 10px;"></i> Data Pengunjung
    </a>
    
    <a href="{{ url('/admin/skm') }}" style="display: flex; align-items: center; padding: 12px 15px; text-decoration: none; color: #333; font-size: 14px; margin: 5px 0;
        {{ Request::is('admin/skm') ? 'background-color: rgba(220, 53, 69, 0.1); border-radius: 0 5px 5px 0; border-left: 4px solid #dc3545; font-weight: bold;' : '' }}">
        <i class="fas fa-file-alt" style="margin-right: 10px;"></i> Data SKM
    </a>
    
    <a href="{{ url('/admin/laporan') }}" style="display: flex; align-items: center; padding: 12px 15px; text-decoration: none; color: #333; font-size: 14px; margin: 5px 0;
        {{ Request::is('admin/laporan') ? 'background-color: rgba(220, 53, 69, 0.1); border-radius: 0 5px 5px 0; border-left: 4px solid #dc3545; font-weight: bold;' : '' }}">
        <i class="fas fa-chart-line" style="margin-right: 10px;"></i> Laporan
    </a>

    <div style="flex-grow: 1;"></div>

    <div style="padding: 15px;">
        <a href="{{ url('/admin/logout') }}" style="display: flex; justify-content: center; align-items: center; padding: 10px; text-decoration: none; color: white; background-color: #dc3545; font-weight: bold; border-radius: 5px; font-size: 14px;">
            <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Keluar
        </a>
    </div>
</div>
