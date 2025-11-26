@extends('layouts.app')

@section('title', 'Data SKM | Disdik Kab.Banjar')

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

/* ================= LEFT PANEL (CONTENT) ================= */
.dashboard-left {
    flex: 2.1; 
    padding: 40px 50px;
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
}

.data-table-row {
    display: flex;
    padding: 10px 10px;
    border-bottom: 1px solid #f0f0f0;
    color: #444;
    font-size: .85rem;
    transition: background 0.2s;
    align-items: center;
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
.col-usia { flex: 0.8; min-width: 50px;}
.col-jk { flex: 1.5; min-width: 100px; }
.col-pendidikan { flex: 2; min-width: 150px; }
.col-pekerjaan { flex: 2; min-width: 150px; }
.col-layanan { flex: 3; min-width: 200px; }

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
    overflow-y: auto;
    padding-right: 6px;
    margin-top: 0;
}

/* === BUTTON ACTION (3D PUSH BUTTONS) === */
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

/* Simpan/Pertanyaan Button (Blue/Teal) */
.btn-simpan { 
    background: linear-gradient(135deg, #30E3BC 0%, #1bcfa5 100%);
    color: #fff; 
    box-shadow: 0 4px 0 #16a080, 0 5px 10px rgba(48, 227, 188, 0.3);
}
.btn-simpan:hover { transform: translateY(-2px); box-shadow: 0 6px 0 #16a080, 0 8px 15px rgba(48, 227, 188, 0.4); }
.btn-simpan:active { top: 4px; box-shadow: 0 0 0 #16a080, 0 2px 5px rgba(48, 227, 188, 0.3); }

/* Disabled State */
.disabled {
    background: #ccc !important;
    box-shadow: none !important;
    color: #666 !important;
    transform: none !important;
    top: 0 !important;
}

/* ================= RIGHT PANEL (IMAGE) ================= */
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
    padding: 80px 40px 40px; 
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
    font-size: 2.2rem;
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
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .dashboard-right h1 { font-size: 1.8rem; margin-top: 10px; }
    
    .dashboard-left { order: 2; padding: 30px 20px; }
    .title-card { font-size: 1.8rem; }
    .container-dashboard { margin-top: 10px; }
    .logo-header { top: 10px; right: 10px; }
    .logo-header img { height: 40px; }
    
    .data-table-header { font-size: 0.8rem; }
    .data-table-row { font-size: 0.75rem; }
}

/* === MOBILE STACKED CARD VIEW (DI BAWAH 600PX) === */
@media (max-width: 600px) {
    .data-table-header { display: none; }

    .data-table-row {
        flex-direction: column;
        align-items: flex-start;
        padding: 15px;
        border: 1px solid #e0e6ed;
        border-radius: 12px;
        margin-bottom: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        background: #fff;
    }
    
    .data-table-row span {
        width: 100%;
        text-align: left !important;
        white-space: normal; 
        padding: 5px 0;
        border-bottom: 1px dotted #eee;
    }
    
    /* Labels */
    .data-table-row span:before {
        content: attr(data-label) ": ";
        font-weight: 700;
        color: #003366;
        min-width: 110px;
        display: inline-block;
    }
    .data-table-row span:last-child { border-bottom: none; }
    
    /* Checkbox Styling Mobile */
    .checkbox-col {
        order: -1; 
        padding-bottom: 10px !important;
        border-bottom: 2px solid #f0f0f0 !important;
        margin-bottom: 5px;
    }
    .checkbox-col input { margin-right: 10px; width: 20px; height: 20px; }
    .checkbox-col:before {
        content: 'Pilih Data';
        color: #30E3BC;
        font-weight: 700;
        font-size: 1rem;
    }

    .dashboard-right h1 { font-size: 1.5rem; }
    .title-card { font-size: 1.5rem; }
    
    .action-buttons { flex-direction: column; gap: 10px; padding: 15px; }
    .btn-action { width: 80%; }
}
</style>


<div class="logo-header">
    <img src="{{ asset('images/LOGO_KEMENTRIAN.png') }}" alt="Logo Kementrian">
    <img src="{{ asset('images/LOGO_PEMKAB_BANJAR.png') }}" alt="Logo Kab. Banjar">
</div>

{{-- === PANGGIL SIDEBAR DARI COMPONENT === --}}
@include('components._sidebar')

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

    // CHECKBOX LOGIC
    const checkboxes = document.querySelectorAll('.row-check');
    const btnEdit = document.getElementById('btnEdit');
    const btnDelete = document.getElementById('btnDelete');
    const deleteForm = document.getElementById('deleteForm');

    // Mencegah multiple check (Single Selection Logic)
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
            // Restore shadows
            btnEdit.style.boxShadow = "";
            btnDelete.style.boxShadow = "";

            btnEdit.classList.remove("disabled");
            btnDelete.classList.remove("disabled");

            btnEdit.href = "{{ url('/admin/skm') }}/" + id + "/edit";
            deleteForm.action = "{{ url('/admin/skm') }}/" + id;

        } else {
            btnEdit.style.pointerEvents = "none";
            btnDelete.style.pointerEvents = "none";
            btnEdit.style.opacity = "0.5";
            btnDelete.style.opacity = "0.5";
            // Remove shadows for flat look
            btnEdit.style.boxShadow = "none";
            btnDelete.style.boxShadow = "none";

            btnEdit.classList.add("disabled");
            btnDelete.classList.add("disabled");
        }
    }
    
    updateButtonState();
});
</script>

@endsection