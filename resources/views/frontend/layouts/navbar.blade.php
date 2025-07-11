<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top" aria-label="Sispendik Navbar">
    <div class="container d-flex justify-content-between">
        <a class="w-15 navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img class="w-25 mr-3" src="{{ asset('themes/frontend/logo.png') }}" alt="Logo Kab Bintuni">
            <h5 class="mb-0 text-white fw-bold mx-2">Sispendik Bintuni</h5>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSispendikBintuni"
            aria-controls="navbarSispendikBintuni" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-2"></i>
        </button>

        <div class="w-85 collapse navbar-collapse" id="navbarSispendikBintuni">
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
                    <a class="nav-link {{ Request::is('peta-sebaran*') ? 'active' : '' }}"
                        href="/peta-sebaran">Sebaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('kalender-pendidikan*') ? 'active' : '' }}"
                        href="/kalender-pendidikan">Kalender</a>
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
