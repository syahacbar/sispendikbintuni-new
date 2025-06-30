@extends('frontend.layouts.app')
@section('content')
<section class="identity-section mb-4 mt-5">
    <div class="container">
        <div class=" identity-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-home"></i>
                            Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-home"></i>
                            ></a></li>
                    <li class="breadcrumb-item" class="text-white">
                        <i class="fas fa-info-circle"></i>
                        Informasi Sekolah
                    </li>
                </ol>
            </nav>
            <h1 class="text-white fw-bold" data-aos="fade-up">Informasi Sekolah</h1>
            <p class="text-warning mb-4" data-aos="fade-up">Data Sekolah Kabupaten Teluk Bintuni</p>
        </div>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="row my-3">
            <section class="container my-4">
                <div class="row">
                    <div class="text-center mb-4">
                        <h3 class="text-success fw-bold">
                            Informasi
                        </h3>
                        <p class="text-muted">
                            Info Aktual untuk Warga Sekolah dan Masyarakat
                        </p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card text-bg-white">
                            <img src="{{ ('frontend/informasi.png') }}" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <span class="badge mb-2">
                                    <p class="card-title text-white m-0"><i class="fas fa-newspaper"></i>Berita</p>
                                </span>
                                <p class="card-text">Lorem ipsum dolor sit amet,
                                    consectetur
                                    adipiscing elit. Sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card text-bg-white">
                            <img src="{{ ('frontend/informasi.png') }}" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <span class="badge mb-2">
                                    <p class="card-title text-white m-0"><i class="fas fa-newspaper"></i>Berita</p>
                                </span>
                                <p class="card-text">Lorem ipsum dolor sit amet,
                                    consectetur
                                    adipiscing elit. Sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card text-bg-white">
                            <img src="{{ ('frontend/informasi.png') }}" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <span class="badge mb-2">
                                    <p class="card-title text-white m-0"><i class="fas fa-newspaper"></i>Kegiatan</p>
                                </span>
                                <p class="card-text">Lorem ipsum dolor sit amet,
                                    consectetur
                                    adipiscing elit. Sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card text-bg-white">
                            <img src="{{ ('frontend/informasi.png') }}" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <span class="badge mb-2">
                                    <p class="card-title text-white m-0"><i class="fas fa-newspaper"></i>Kegiatan</p>
                                </span>
                                <p class="card-text">Lorem ipsum dolor sit amet,
                                    consectetur
                                    adipiscing elit. Sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

@endsection