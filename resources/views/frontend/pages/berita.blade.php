@extends('frontend.layouts.app')
@section('content')
    <section class="container my-4">
        <div class="container">
            <div class="row">
                <div class="text-center mb-4">
                    <h3 class="text-success fw-bold">
                        Berita
                    </h3>
                    <p class="text-muted">
                        Informasi resmi seputar kegiatan pendidikan, agenda penting, dan pemberitahuan terkini yang
                        berlangsung di seluruh wilayah Kabupaten Teluk Bintuni.
                    </p>
                </div>
            </div>
            <div class="row gx-4">
                <section class="col-lg-12 mb-4">
                    <div class="row">
                        @foreach ($berita as $item)
                            <div class="col-lg-3 col-md-6 d-flex my-3">
                                <div class="card mb-3 h-100 w-100">
                                    <img src="{{ asset('storage/' . ($item->gambar ?? 'frontend/informasi.png')) }}"
                                        class="card-img-top" alt="{{ $item->judul }}">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-truncate"
                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $item->judul }}
                                        </h5>
                                        <p class="card-text mt-3">{{ $item->short_desc }}</p>
                                        <p class="card-text m-0">
                                            <small class="text-body-secondary">{{ $item->created_at }}</small>
                                        </p>
                                        <a href="{{ url('informasi/berita/' . $item->slug) }}" class="stretched-link"></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </section>
                <div class="mt-4">
                    {{ $berita->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>
@endsection
