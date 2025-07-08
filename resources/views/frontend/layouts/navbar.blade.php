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
                    <a class="nav-link {{ Request::is('tentang*') ? 'active' : '' }}" href="/tentang">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('data-pendidikan*') ? 'active' : '' }}"
                        href="/data-pendidikan">Data
                        Pendidikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('sebaran*') ? 'active' : '' }}" href="/sebaran">Sebaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('kalender*') ? 'active' : '' }}" href="/kalender">Kalender</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('informasi*') ? 'active' : '' }}" href="#"
                        id="navbarDropdownInformasi" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Informasi
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownInformasi">
                        <li><a class="dropdown-item {{ Request::is('informasi/berita') ? 'active' : '' }}"
                                href="/informasi/berita">Berita</a></li>
                        <li><a class="dropdown-item {{ Request::is('informasi/pengumuman') ? 'active' : '' }}"
                                href="/informasi/pengumuman">Pengumuman</a></li>
                        <li><a class="dropdown-item {{ Request::is('informasi/kegiatan') ? 'active' : '' }}"
                                href="/informasi/kegiatan">Kegiatan</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('pengaduan*') ? 'active' : '' }}" href="#"
                        id="navbarDropdownPengaduan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pengaduan
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownPengaduan">
                        <li><a class="dropdown-item {{ Request::is('pengaduan/buat-pengaduan') ? 'active' : '' }}"
                                href="/pengaduan/buat-pengaduan">Buat Pengaduan</a></li>
                        <li><a class="dropdown-item {{ Request::is('pengaduan/lacak-pengaduan') ? 'active' : '' }}"
                                href="/pengaduan/lacak-pengaduan">Lacak Pengaduan</a></li>
                    </ul>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary btn-sm btnLogin {{ Request::is('login*') ? 'active' : '' }}"
                            href="/paneladmin/login">Login</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
