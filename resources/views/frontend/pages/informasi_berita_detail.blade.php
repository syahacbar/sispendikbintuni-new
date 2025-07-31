@extends('frontend.layouts.app')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none" href="{{ url('/informasi/berita') }}">
                                            List Berita
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $berita->judul }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <img src="{{ $berita->gambar && file_exists(public_path('storage/' . $berita->gambar))
                            ? asset('storage/' . $berita->gambar)
                            : asset('themes/frontend/informasi/berita/default.png') }}"
                            class="card-img-top w-100 h-50 d-inline-block object-fit-cover" alt="{{ $berita->judul }}">
                        <h3 class="text-success fw-bold mt-4">
                            {{ $berita->judul }}
                        </h3>
                        <small class="text-secondary me-2"><i class="bi bi-calendar-fill"></i>
                            {{ $berita->created_at->format('d M Y') }}</small>
                        <span class="text-secondary me-2"><i class="bi bi-eye-fill"></i> {{ $berita->lihat }} kali
                            dilihat</span>
                        <p class="mt-4">{{ $berita->deskripsi }}</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h3 class="bg-success p-2 mb-3 text-white">5 Berita Terbaru</h3>
                    @foreach ($list_berita as $item)
                        <div class="d-flex mb-3 border-bottom pb-2">
                            <div class="flex-shrink-0 me-3" style="width: 100px; height: 70px; overflow: hidden;">
                                <img src="{{ $item->gambar && file_exists(public_path('storage/' . $item->gambar))
                                    ? asset('storage/' . $item->gambar)
                                    : asset('themes/frontend/informasi/berita/default.png') }}"
                                    alt="{{ $item->judul }}"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                            </div>
                            <div class="flex-grow-1">
                                <a href="{{ url('informasi/berita/' . $item->slug) }}"
                                    class="text-decoration-none text-dark">
                                    <h6 class="mb-1">{{ $item->judul }}</h6>
                                </a>
                                <p class="mb-1 small text-muted">{{ Str::limit($item->short_desc, 60) }}
                                </p>
                                <small class="text-secondary">{{ $item->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
