<nav id="mainNavbar" class="navbar navbar-expand-md main-navbar">
    <div class="container">
        <a class="w-15 navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img class="w-25 mr-3" src="{{ asset('themes/frontend/logo.png') }}" alt="Logo Kab Bintuni">
            <h5 class="d-md-none mb-0 fw-bold text-success mx-2">Sispendik Bintuni</h5>
        </a>
        <div class="w-85 collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto flex-md-row">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('sekolah*') ? 'active' : '' }}" href="/sekolah">Sekolah</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('sebaran*') ? 'active' : '' }}" href="/sebaran">Sebaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('ptk*') ? 'active' : '' }}" href="/ptk">PTK</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('siswa*') ? 'active' : '' }}" href="/siswa">Siswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('kalender*') ? 'active' : '' }}" href="/kalender">Kalender</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('informasi*') ? 'active' : '' }}" href="/informasi">Informasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('pengaduan*') ? 'active' : '' }}" href="/pengaduan">Pengaduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary btn-sm btnLogin {{ Request::is('login*') ? 'active' : '' }}"
                        href="/paneladmin/login">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
