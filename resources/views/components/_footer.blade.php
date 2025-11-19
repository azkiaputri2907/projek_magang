<style>
    body {
        padding-bottom: 90px; /* Biar konten nggak ketutup footer */
    }

    .footer {
        position: fixed;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 95%;
        max-width: 770px;
        background-color: #CFDDF7;
        padding: 12px 10px;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        box-shadow: 0 -4px 10px rgba(0,0,0,0.1);
    }

    .footer-content {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap; /* biar turun kalo sempit */
        gap: 10px;       /* jarak antar item */
        font-size: 10px;
    }

    .footer-item {
        display: flex;
        align-items: center;
    }

    .footer-item img {
        width: 20px;
        height: 20px;
        margin-right: 5px;
    }
</style>
<div class="footer">
    <div class="footer-content">
        
        <span class="footer-item">
            <img src="{{ asset('images/icons8-youtube-50.png') }}" alt="YouTube">
            <strong>@DisdikKabBanjar</strong>
        </span>

        <span class="footer-item">
            <img src="{{ asset('images/icons8-website-50.png') }}" alt="Website">
            <strong>disdik.banjarkab.go.id</strong>
        </span>

        <span class="footer-item">
            <img src="{{ asset('images/icons8-instagram-50.png') }}" alt="Instagram">
            <strong>@disdik_kab.banjar</strong>
        </span>

    </div>
</div>
