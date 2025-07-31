@extends('frontend.layouts.app')
@section('content')
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
                                        <img src="{{ $item->gambar && file_exists(public_path('storage/' . $item->gambar))
                                            ? asset('storage/' . $item->gambar)
                                            : asset('themes/frontend/informasi/kegiatan/default.png') }}"
                                            class="card-img-top" alt="{{ $item->judul }}">
                                    </div>

                                    <div class="card-content">
                                        <h5 class="card-title">
                                            {{ $item->judul }}
                                        </h5>
                                        <p class="card-desc">{{ $item->short_desc }}</p>
                                        <p class="card-text m-0">
                                            <small class="text-body-secondary me-3"><i class="bi bi-calendar-fill"></i>
                                                {{ $item->created_at->format('d M Y') }}</small>
                                            <span class="text-body-secondary"><i class="bi bi-eye-fill"></i>
                                                {{ $item->lihat }}
                                                kali</span>
                                        </p>
                                        <a href="{{ url('informasi/kegiatan/' . $item->slug) }}" class="stretched-link"></a>
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
