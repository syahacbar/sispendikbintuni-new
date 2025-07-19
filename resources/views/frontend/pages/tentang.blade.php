@extends('frontend.layouts.app')

@section('content')
    <section class="about-section">
        <div class="container">
            <div class="row my-3">
                <div class="col-lg-12">
                    <div class="card mt-3">
                        {{-- <div class="card-body">
                            @forelse($tentang as $key => $value)
                                <h4 class="text-capitalize mt-4">{{ str_replace('_', ' ', $key) }}</h4>
                                <div>{!! $value !!}</div>
                            @empty
                                <p>Konten tentang belum tersedia.</p>
                            @endforelse
                        </div> --}}

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
                            {{-- @php
                                $kontenList = ['deskripsi_web', 'visi', 'misi', 'tujuan']; // Key yang mau kamu tampilkan
                            @endphp --}}

                            @foreach ($kontenList as $key)
                                @php
                                    $item = $tentang->firstWhere('key', $key);
                                    $judul = $judulMapping[$key] ?? ucwords(str_replace('_', ' ', $key));
                                @endphp

                                @if ($item)
                                    <h4 class="mt-4">{{ $judul }}</h4>
                                    <div>{!! $item->value !!}</div>
                                @endif
                            @endforeach

                            @if ($tentang->isEmpty())
                                <p>Konten tentang belum tersedia.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
