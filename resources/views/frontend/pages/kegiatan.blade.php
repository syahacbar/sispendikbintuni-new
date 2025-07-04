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
            <div class="row">
                <div class="text-center mb-4">
                    <h3 class="text-success fw-bold">
                        Kegiatan
                    </h3>
                    <p class="text-muted">
                        Informasi resmi seputar kegiatan pendidikan, agenda penting, dan pemberitahuan terkini yang
                        berlangsung di seluruh wilayah Kabupaten Teluk Bintuni.
                    </p>
                </div>
            </div>
            <div class="row gx-4">
                <div class="row">
                    @foreach ($kegiatan as $item)
                        <div class="col-lg-6 mb-4">
                            <div id="activity-list">
                                <article class="card-research mt-4" data-aos="fade-up">
                                    <div class="card-img-wrapper">
                                        <img src="{{ asset('storage/' . ($item->gambar ?? 'frontend/informasi.png')) }}"
                                            alt="{{ $item->judul }}">
                                    </div>
                                    <div class="card-content">
                                        <h5 class="card-title text-truncate"
                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $item->judul }}
                                        </h5>
                                        <p class="card-desc">{{ $item->short_desc }}</p>
                                        <time class="card-date">{{ $item->created_at }}</time>
                                        <a href="{{ url('informasi/' . $item->slug) }}" class="stretched-link"></a>
                                    </div>
                                </article>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-4">
                    {{ $kegiatan->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>
@endsection
