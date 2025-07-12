@extends('frontend.layouts.app')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <img src="{{ $pengumuman->gambar && file_exists(public_path('storage/' . $pengumuman->gambar))
                            ? asset('storage/' . $pengumuman->gambar)
                            : asset('themes/frontend/informasi/pengumuman/default.png') }}"
                            class="card-img-top w-100 h-50 d-inline-block object-fit-cover" alt="{{ $pengumuman->judul }}">
                        <h3 class="text-success fw-bold mt-4">
                            {{ $pengumuman->judul }}
                        </h3>
                        <small class="text-secondary me-2"><i class="bi bi-calendar-fill"></i>
                            {{ $pengumuman->created_at->format('d M Y') }}</small>
                        <span class="text-secondary me-2"><i class="bi bi-eye-fill"></i> {{ $pengumuman->lihat }} kali
                            dilihat</span>
                        <p class="mt-4">{{ $pengumuman->deskripsi }}</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h3 class="bg-success p-2 mb-3 text-white">5 Pengumuman Terbaru</h3>
                    @foreach ($list_pengumuman as $item)
                        <div class="d-flex mb-3 border-bottom pb-2">
                            <div class="flex-shrink-0 me-3" style="width: 100px; height: 70px; overflow: hidden;">
                                <img src="{{ $item->gambar && file_exists(public_path('storage/' . $item->gambar))
                                    ? asset('storage/' . $item->gambar)
                                    : asset('themes/frontend/informasi/pengumuman/default.png') }}"
                                    alt="{{ $item->judul }}"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                            </div>
                            <div class="flex-grow-1">
                                <a href="{{ url('informasi/pengumuman/' . $item->slug) }}"
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
