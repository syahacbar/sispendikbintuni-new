@if ($kegiatan->isEmpty())
    <p>Tidak ada kegiatan pada tanggal ini.</p>
@else
    @foreach ($kegiatan as $item)
        <article class="card-research mt-4" data-aos="fade-up">
            <div class="card-img-wrapper">
                <img src="{{ asset('storage/' . ($item->gambar ?? 'frontend/informasi.png')) }}"
                    alt="{{ $item->judul }}">
            </div>
            <div class="card-content">
                <h5 class="card-title">{{ $item->judul }}</h5>
                <p class="card-desc">{{ $item->short_desc }}</p>
                <time class="card-date">{{ $item->created_at }}</time>
                <a href="{{ url('informasi/' . $item->slug) }}" class="stretched-link"></a>
            </div>
        </article>
    @endforeach
@endif
