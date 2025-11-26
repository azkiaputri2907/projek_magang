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
        background-color: #DFEDFE;
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
        cursor: pointer; /* biar keliatan bisa diklik */
    }

    .footer-item img {
        width: 20px;
        height: 20px;
        margin-right: 5px;
    }
</style>

<div class="footer">
    <div class="footer-content">
        
        <span class="footer-item" data-link="https://www.youtube.com/c/DisdikKabBanjar" data-name="YouTube">
            <img src="{{ asset('images/icons8-youtube-50.png') }}" alt="YouTube">
            <strong>@DisdikKabBanjar</strong>
        </span>

        <span class="footer-item" data-link="https://disdik.banjarkab.go.id" data-name="Website">
            <img src="{{ asset('images/icons8-website-50.png') }}" alt="Website">
            <strong>disdik.banjarkab.go.id</strong>
        </span>

        <span class="footer-item" data-link="https://instagram.com/disdik_kab.banjar" data-name="Instagram">
            <img src="{{ asset('images/icons8-instagram-50.png') }}" alt="Instagram">
            <strong>@disdik_kab.banjar</strong>
        </span>

    </div>
</div>

<script>
    document.querySelectorAll('.footer-item').forEach(item => {
        item.addEventListener('click', () => {
            const name = item.getAttribute('data-name');
            const link = item.getAttribute('data-link');
            const confirmOpen = confirm(`Ingin membuka ${name} Disdik Kab Banjar?`);
            if(confirmOpen) {
                window.open(link, '_blank');
            }
        });
    });
</script>
