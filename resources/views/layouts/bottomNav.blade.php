<!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="/dashboard" class= "item {{ Request()->is('dashboard') ? 'active' : '' }}">
            <div class="col">
                <<ion-icon name="home-outline"></ion-icon>
                <strong>home</strong>
            </div>
        </a>
        <a href="/Izin" class="item {{ Request()->is('izin') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="calendar-outline" role="img" class="md hydrated"
                    aria-label="calendar outline"></ion-icon>
                <strong>Izin/Cuti</strong>
            </div>
        </a>
        <a href="/dinas" class="item {{ Request()->is('dinas') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="document-text-outline" role="img" class="md hydrated"
                    aria-label="document text outline"></ion-icon>
                <strong>Dinas Luar</strong>
            </div>
        </a>
    </div>

    <!-- App Bottom Menu -->
<div class="appBottomMenu">
    <a href="/dashboard" class="item {{ Request()->is('dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="/izin" class="item {{ Request()->is('izin') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline"></ion-icon>
            <strong>Izin/Cuti</strong>
        </div>
    </a>
    <a href="/dinas" class="item {{ Request()->is('dinas') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline"></ion-icon>
            <strong>Dinas Luar</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->

<style>
    .appBottomMenu {
        display: flex;
        justify-content: space-around;
        background: #fff;
        border-top: 1px solid #ddd;
        padding: 8px 0;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;
    }

    .appBottomMenu .item {
        text-align: center;
        color: #777;
        text-decoration: none;
        flex: 1;
        transition: all 0.3s;
    }

    .appBottomMenu .item ion-icon {
        font-size: 22px;
        display: block;
        margin-bottom: 4px;
    }

    .appBottomMenu .item strong {
        font-size: 12px;
    }

    /* Style item active */
    .appBottomMenu .item.active {
        color: #007bff; /* warna teks & icon */
        font-weight: bold;
    }

    .appBottomMenu .item.active ion-icon {
        color: #007bff;
        transform: scale(1.2);
    }
</style>
    <!-- * App Bottom Menu -->