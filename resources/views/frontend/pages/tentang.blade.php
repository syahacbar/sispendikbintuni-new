@extends('frontend.layouts.app')

@section('content')
    <section class="about-section">
        <div class="container">
            <div class="row my-3">
                <div class="col-lg-12">
                    <div class="card mt-3">
                        @php
                            $judulMapping = [
                                'deskripsi_web' => 'Deskripsi Website',
                                'visi' => 'Visi Kami',
                                'misi' => 'Misi Utama',
                                'tujuan' => 'Tujuan Sistem',
                                'sejarah' => 'Sejarah Pengembangan',
                            ];
                            $kontenList = array_keys($judulMapping);
                        @endphp

                        <div class="card-body">
                            {{-- @foreach ($kontenList as $key)
                                @php
                                    $item = $tentang->firstWhere('key', $key);
                                    $judul = $judulMapping[$key] ?? ucwords(str_replace('_', ' ', $key));
                                @endphp

                                @if ($item) --}}
                            {{-- <h4 class="mt-4">{{ $judul }}</h4> --}}
                            <div class="row">
                                <div class="col-12">
                                    <p>
                                        <strong>Tata Kelola Pendidikan dengan Sistem Perencanaan Terintegrasi</strong>
                                        adalah aplikasi yang dikembangkan oleh
                                        <em>Dinas Pendidikan, Kebudayaan, Pemuda dan Olahraga Kabupaten Teluk Bintuni</em>
                                        sebagai upaya strategis dalam menciptakan
                                        sistem pendidikan yang <strong>transparan</strong>, <strong>akuntabel</strong>, dan
                                        <strong>berbasis data</strong>.
                                    </p>

                                    <p>
                                        Platform ini dirancang untuk mendukung seluruh tahapan pengelolaan program
                                        pendidikan — mulai dari <strong>perencanaan</strong>,
                                        <strong>penganggaran</strong>, <strong>pelaksanaan</strong>, hingga
                                        <strong>evaluasi</strong> — agar berjalan lebih efektif dan efisien.
                                        Sistem ini juga memungkinkan kolaborasi antar pemangku kepentingan dalam mewujudkan
                                        pendidikan yang merata dan berkeadilan.
                                    </p>

                                    <h4 class="mt-4">Tujuan Utama Aplikasi:</h4>
                                    <ul class="list-group list-group-flush mb-4">
                                        <li class="list-group-item">
                                            <strong>Transparansi dan Akuntabilitas:</strong> Menyediakan informasi terbuka
                                            dan dapat dipertanggungjawabkan.
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Perencanaan Berbasis Data:</strong> Mengintegrasikan data dari satuan
                                            pendidikan untuk mendukung kebijakan yang tepat sasaran.
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Efisiensi Proses:</strong> Mempermudah alur kerja mulai dari perencanaan
                                            hingga pelaporan kegiatan.
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Kolaborasi Lintas Sektor:</strong> Mendorong keterlibatan sekolah,
                                            tenaga pendidik, pengelola data, dan masyarakat.
                                        </li>
                                    </ul>

                                    <p>
                                        Aplikasi ini tersedia dalam versi <strong>website</strong> dan
                                        <strong>mobile</strong>, sehingga dapat diakses kapan saja dan di mana saja.
                                        Kami berharap platform ini dapat menjadi pondasi penting dalam membangun generasi
                                        Teluk Bintuni yang cerdas, berkarakter, dan berdaya saing.
                                    </p>
                                </div>
                            </div>
                            {{-- @endif
                            @endforeach

                            @if ($tentang->isEmpty())
                                <p>Konten tentang belum tersedia.</p>
                            @endif --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
