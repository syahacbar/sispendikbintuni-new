    {{-- @php
        use App\Helpers\PengaturanHelper;

        $deskripsi = PengaturanHelper::get('deskripsi', 'Sistem Informasi Pendidikan');
        $hak_cipta = PengaturanHelper::get('hak_cipta', 'Sistem Informasi Pendidikan');
        $nama_instansi = PengaturanHelper::get('nama_instansi', 'Kabupaten Teluk Bintuni');
        $alamat_lengkap = PengaturanHelper::get(
            'alamat_lengkap',
            'Jalan Trikora Wesiri, Kec. Bintuni, Kabupaten Teluk Bintuni, Provinsi Papua Barat',
        );
        $kode_pos = PengaturanHelper::get('kode_pos', 'info@sispendikbintuni.go.id');
        $email = PengaturanHelper::get('email', 'info@sispendikbintuni.go.id');
        $no_hp = PengaturanHelper::get('no_hp', '+6281255554444');
        $telepon = PengaturanHelper::get('telepon', '98312-5587');
        $instagram = PengaturanHelper::get('instagram', 'Kabupaten Teluk Bintuni');
        $facebook = PengaturanHelper::get('facebook', 'Kabupaten Teluk Bintuni');
        $youtube = PengaturanHelper::get('youtube', 'Kabupaten Teluk Bintuni');
        $twitter = PengaturanHelper::get('twitter', 'Kabupaten Teluk Bintuni');

    @endphp --}}

    <footer class="bg-dark text-white pt-5 pb-3 mb-4">
        <div class="container">
            <div class="row align-items-start mb-4">
                <div class="col-sm-5">
                    <div class="mb-3 d-flex gap-2 justify-content-start align-items-center">
                        <img class="mr-3" src="{{ asset('themes/frontend/logo.png') }}" alt="Logo Kab Bintuni">
                        {{-- <strong class="text-success fw-bold">{{ $deskripsi }}</strong> --}}
                    </div>
                    {{-- <p class="small mb-1">
                        {{ $alamat_lengkap }}, {{ $kode_pos }} <br />
                        Telepon: {{ $telepon }} <br />
                        Email: <a href="mailto:{{ $email }}" class="text-white text-decoration-none">
                            <i class="fas fa-envelope me-1"></i>
                            {{ $email }} </a>
                    </p> --}}

                    {{-- <div class="d-flex mt-3">
                        <a href="{{ $youtube }}" class="text-white me-3"><i class="bi bi-youtube fs-5"></i></a>
                        <a href="{{ $twitter }}" class="text-white me-3"><i class="bi bi-twitter fs-5"></i></a>
                        <a href="{{ $facebook }}" class="text-white me-3"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="{{ $instagram }}" class="text-white me-3"><i class="bi bi-instagram fs-5"></i></a>
                    </div> --}}
                </div>

                <div class="col-lg-7 mt-4 mt-md-0">
                    <div class="row mt-4">
                        <div class="col-lg-4">
                            <h6 class="text-success fw-bold">NAVIGASI</h6>
                            <ul class="list-unstyled small">
                                <li class="mb-2"><a href="/data-pendidikan"
                                        class="text-white text-decoration-none">Data
                                        Pendidikan</a>
                                </li>
                                <li class="mb-2"><a href="/peta-sebaran" class="text-white text-decoration-none">Peta
                                        Sebaran</a></li>
                                <li class="mb-2"><a href="/informasi/pengumuman"
                                        class="text-white text-decoration-none">Pengumuman</a></li>
                                <li class="mb-2"><a href="/informasi/berita"
                                        class="text-white text-decoration-none">Berita</a></li>
                                <li class="mb-2"><a href="/kalender-pendidikan"
                                        class="text-white text-decoration-none">Kalender Pendidikan</a></li>
                                <li class="mb-2"><a href="/form-pengaduan"
                                        class="text-white text-decoration-none">Form
                                        Pengaduan</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-4 mt-md-0">
                            <h6 class="text-success fw-bold">PEMDA</h6>
                            <ul class="list-unstyled small">
                                <li class="mb-2"><a href="https://papuabaratprov.go.id/"
                                        class="text-white text-decoration-none">Pemprov Papua Barat</a></li>
                                <li class="mb-2"><a href="https://telukbintuni.go.id/"
                                        class="text-white text-decoration-none">Kab. Teluk Bintuni</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-4 mt-md-0">
                            <h6 class="text-success fw-bold">KEMENDIKDASMEN</h6>
                            <ul class="list-unstyled small">
                                <li class="mb-2"><a href="https://pdm.dikdasmen.go.id/"
                                        class="text-white text-decoration-none">Dirjen PAUD & Dikdasmen
                                    </a></li>
                                <li class="mb-2"><a href="https://vokasi.kemendikdasmen.go.id/"
                                        class="text-white text-decoration-none">Dirjen Pendidikan Vokasi, Khusus, &
                                        Layanan
                                        Khusus
                                    </a></li>
                                <li class="mb-2"><a href="https://gtk.dikdasmen.go.id/"
                                        class="text-white text-decoration-none">Dirjen Guru, Tendik,
                                        & Pendidikan Guru</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center border-top border-secondary pt-3 mt-3 mb-4">
                {{-- <div class="small"> {{ $hak_cipta }} </div> --}}
                <i class="fas fa-university fa-2x text-success me-2"></i>
            </div>
        </div>
    </footer>
