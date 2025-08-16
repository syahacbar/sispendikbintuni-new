@extends('frontend.layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<style>
    @media (min-width: 991px) {
        .berandaInformasi .d-flex.align-items-start {
            display: block !important;
        }

        .berandaInformasi img {
            width: 100% !important;
            height: 150px;
            object-fit: cover;
        }
    }

    .swiper {
        width: 100%;
        height: auto;
    }

    .sliderSection {
        padding: 3.5rem 0 0 0 !important;
    }

    .sectionSambutan {
        padding-top: .5rem;
    }

    span.swiper-pagination-bullet {
        width: 15px;
        border-radius: 5px;
    }

    span.swiper-pagination-bullet.swiper-pagination-bullet-active {
        width: 30px;
        border-radius: 5px;
    }
</style>
@section('content')
    <section class="w-100 container-fluid d-flex align-items-start justify-content-start text-start sliderSection">
        <div class="swiper">
            <div class="swiper-wrapper">
                @forelse($banners as $banner)
                    <div class="swiper-slide">
                        <img class="w-100" src="{{ asset('storage/' . $banner->nama) }}"
                            alt="{{ $banner->deskripsi ?? $banner->nama }}">
                    </div>
                @empty
                    <div class="swiper-slide">
                        <img class="w-100" src="{{ asset('themes/frontend/slider/sliderserasi3.png') }}"
                            alt="Default Banner">
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <section class="bg-white sectionSambutan">
        <div class="container pb-3">
            <div class="row align-items-start mt-4">
                <div class="col-lg-3 text-center mb-lg-0 d-flex align-items-start justify-content-center"
                    data-aos="fade-right">
                    @php
                        $sambutanFoto = $pengaturan['sambutan_foto'] ?? null;
                        $imagePath =
                            $sambutanFoto && file_exists(public_path('storage/' . $sambutanFoto))
                                ? asset('storage/' . $sambutanFoto)
                                : asset('themes/frontend/sambutan/kadisdikbudporabintuni2.png');
                    @endphp

                    <img src="{{ asset('themes/frontend/sambutan/kadisdikbudporabintuni2.png') }}"
                        alt="Kepala Dinas Kabupaten Teluk Bintuni" class="img-fluid quote-img"
                        style="max-height: 450px; object-fit: cover;">

                </div>
                <div class="col-lg-9" data-aos="fade-left">
                    <h5 class="fw-bold text-teal mb-4">
                        {{ $pengaturan['judul_sambutan'] ?? 'Selamat Datang di Website Tata Kelola Pendidikan Dengan Sistem Perencanaan Terintegrasi (SERASI) Kabupaten Teluk Bintuni' }}
                    </h5>
                    @php
                        $fullContent = $pengaturan['isi_sambutan'] ?? '';
                        $shortContent = Str::limit($fullContent, 900);
                        $isExpandable = !empty($fullContent) && strlen(strip_tags($fullContent)) > 1000;
                    @endphp

                    <div class="text-dark">
                        <div id="sambutan-content" class="mb-3">
                            {!! $isExpandable ? $shortContent : $fullContent !!}
                        </div>

                        @if ($isExpandable)
                            <button id="toggle-sambutan" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</button>
                        @endif
                    </div>

                    @if ($isExpandable)
                        <div id="sambutan-full" class="d-none">
                            {!! $fullContent !!}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <section class="pt-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" data-aos="fade-right">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-bar-chart text-bg-success rounded p-1"></i>
                        <h5 class="mb-0 text-success fw-bold mx-2">Kondisi Pendidikan</h5>
                    </div>
                    <p class="text-dark">
                        Berikut adalah data jumlah sekolah berdasarkan jenjang pendidikan di Kabupaten Teluk Bintuni per 15
                        Desember 2024.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header">
                            <h6>Jumlah Sekolah</h6>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="allSekolah-tab" data-bs-toggle="tab"
                                        data-bs-target="#allSekolah-tab-pane" type="button" role="tab"
                                        aria-controls="allSekolah-tab-pane" aria-selected="true">Semua</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="sekolahSwasta-tab" data-bs-toggle="tab"
                                        data-bs-target="#sekolahSwasta-tab-pane" type="button" role="tab"
                                        aria-controls="sekolahSwasta-tab-pane" aria-selected="false">Swasta</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="sekolahNegeri-tab" data-bs-toggle="tab"
                                        data-bs-target="#sekolahNegeri-tab-pane" type="button" role="tab"
                                        aria-controls="sekolahNegeri-tab-pane" aria-selected="false">Negeri</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="allSekolah-tab-pane" role="tabpanel"
                                    aria-labelledby="allSekolah-tab" tabindex="0">
                                    <div class="row text-center py-2 mb-3">
                                        @foreach ($statistik['semua'] as $jenjang => $jumlah)
                                            <div class="col">
                                                <div class="text-muted small">{{ $jenjang }}</div>
                                                <div class="fw-bold text-success">{{ $jumlah }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <canvas id="semuaSekolahChart"></canvas>
                                </div>
                                <div class="tab-pane fade" id="sekolahSwasta-tab-pane" role="tabpanel"
                                    aria-labelledby="sekolahSwasta-tab" tabindex="0">
                                    <div class="row text-center py-2 mb-3">
                                        @foreach ($statistik['Swasta'] as $jenjang => $jumlah)
                                            <div class="col">
                                                <div class="text-muted small">{{ $jenjang }}</div>
                                                <div class="fw-bold text-success">{{ $jumlah }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <canvas id="sekolahSwastaChart"></canvas>
                                </div>
                                <div class="tab-pane fade" id="sekolahNegeri-tab-pane" role="tabpanel"
                                    aria-labelledby="sekolahNegeri-tab" tabindex="0">
                                    <div class="row text-center py-2 mb-3">
                                        @foreach ($statistik['Negeri'] as $jenjang => $jumlah)
                                            <div class="col">
                                                <div class="text-muted small">{{ $jenjang }}</div>
                                                <div class="fw-bold text-success">{{ $jumlah }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <canvas id="sekolahNegeriChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Total PD & PTK</h6>
                        </div>
                        <div class="card-body">
                            <h6 class="fw-bold text-muted">
                                Peserta Didik
                                <span class="float-end text-primary">{{ number_format($total_peserta_didik) }}</span>
                            </h6>
                            <hr class="mt-1 mb-2">
                            @foreach ($jenjangList as $jenjang)
                                <div class="d-flex justify-content-between">
                                    <span>{{ $jenjang }}</span>
                                    <span>{{ number_format($jumlah_peserta_didik[$jenjang] ?? 0) }}</span>
                                </div>
                            @endforeach

                            <h6 class="text-muted mt-4">
                                PTK
                                <span class="float-end text-primary">{{ number_format($total_ptk) }}</span>
                            </h6>
                            <hr class="mt-1 mb-2">
                            @foreach ($jenjangList as $jenjang)
                                <div class="d-flex justify-content-between">
                                    <span>{{ $jenjang }}</span>
                                    <span>{{ number_format($jumlah_ptk[$jenjang] ?? 0) }}</span>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-6 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Akreditasi Sekolah</h6>
                        </div>
                        <div class="card-body">
                            <canvas style="height: 300px" id="chartAkreditasi"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Kondisi Sarpras</h6>
                        </div>
                        <div class="card-body">
                            @if (!$hasKondisiSarprasData)
                                <div class="text-center text-muted py-5">
                                    <em>Belum ada data kondisi sarpras untuk ditampilkan</em>
                                </div>
                            @else
                                <canvas style="height: 300px" id="kondisiSarprasChart"></canvas>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Kualifikasi Pendidikan Guru</h6>
                        </div>
                        <div class="card-body">
                            <canvas style="height: 300px" id="chartGtkKualifikasi"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container my-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6>Sebaran Sekolah per Kecamatan</h6>
                </div>
                <div class="card-body">
                    <canvas style="height: 300px" id="chartSebaranKecamatan"></canvas>
                </div>
            </div>
        </div>
    </section>


    <section class="pt-5 bg-light berandaInformasi">
        <div class="container mb-4">
            <div class="row">
                <div class="col-lg-12" data-aos="fade-right">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-megaphone text-bg-success rounded p-1"></i>
                        <h5 class="mb-0 text-success fw-bold mx-2">Informasi Pendidikan</h5>
                    </div>
                    <p class="text-dark">
                        Berikut adalah informasi terbaru seputar dunia pendidikan.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mt-3" data-aos="fade-left">
                    <h6 class="text-success fw-semibold mb-3">Berita Terbaru</h6>
                    @foreach ($berita as $item)
                        <div class="d-flex justify-content-between align-items-center border rounded-3 p-2 mb-4">
                            <div class="d-flex align-items-start">
                                <img src="{{ $item->gambar && file_exists(public_path('storage/' . $item->gambar))
                                    ? asset('storage/' . $item->gambar)
                                    : asset('themes/frontend/informasi/kegiatan/default.png') }}"
                                    class="card-img-top w-25" alt="{{ $item->judul }}">
                                <div class="px-2">
                                    <div class="fw-semibold">{{ $item->judul }}</div>
                                    <div class="text-muted small mb-2">
                                        {{ $item->short_desc }}
                                    </div>
                                    <small class="text-body-secondary me-3"><i class="bi bi-calendar-fill"></i>
                                        {{ $item->created_at->format('d M Y') }}</small>
                                </div>
                                <a href="{{ url('informasi/berita/' . $item->slug) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    @endforeach
                    <a class="btn btn-success" href="">Berita Lainnya</a>
                </div>
                <div class="col-lg-4 mt-3" data-aos="fade-right">
                    <h6 class="text-success fw-semibold mb-3">Pengumuman Terbaru</h6>
                    @foreach ($pengumuman as $item)
                        <div class="d-flex justify-content-between align-items-center border rounded-3 p-2 mb-4">
                            <div class="d-flex align-items-start">
                                <img src="{{ $item->gambar && file_exists(public_path('storage/' . $item->gambar))
                                    ? asset('storage/' . $item->gambar)
                                    : asset('themes/frontend/informasi/kegiatan/default.png') }}"
                                    class="card-img-top w-25" alt="{{ $item->judul }}">
                                <div class="px-2">
                                    <div class="fw-semibold">{{ $item->judul }}</div>
                                    <div class="text-muted small mb-2">
                                        {{ $item->short_desc }}
                                    </div>
                                    <small class="text-body-secondary me-3"><i class="bi bi-calendar-fill"></i>
                                        {{ $item->created_at->format('d M Y') }}</small>
                                </div>
                                <a href="{{ url('informasi/pengumuman/' . $item->slug) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    @endforeach
                    <a class="btn btn-success" href="">Pengumuman Lainnya</a>
                </div>
                <div class="col-lg-4 mt-3" data-aos="fade-right">
                    <h6 class="text-success fw-semibold mb-3">Kegiatan Terbaru</h6>
                    @foreach ($kegiatan as $item)
                        <div class="d-flex justify-content-between align-items-center border rounded-3 p-2 mb-4">
                            <div class="d-flex align-items-start">
                                <img src="{{ $item->gambar && file_exists(public_path('storage/' . $item->gambar))
                                    ? asset('storage/' . $item->gambar)
                                    : asset('themes/frontend/informasi/kegiatan/default.png') }}"
                                    class="card-img-top w-25" alt="{{ $item->judul }}">
                                <div class="px-2">
                                    <div class="fw-semibold">{{ $item->judul }}</div>
                                    <div class="text-muted small mb-2">
                                        {{ $item->short_desc }}
                                    </div>
                                    <small class="text-body-secondary me-3"><i class="bi bi-calendar-fill"></i>
                                        {{ $item->created_at->format('d M Y') }}</small>
                                </div>
                                <a href="{{ url('informasi/kegiatan/' . $item->slug) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    @endforeach
                    <a class="btn btn-success" href="">Kegiatan Lainnya</a>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    @if ($hasKondisiSarprasData)
        <script>
            new Chart(document.getElementById('kondisiSarprasChart'), {
                type: 'bar',
                data: {
                    labels: @json($kondisiJenjangLabels),
                    datasets: @json($kondisiSarprasDatasets)
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Kondisi Sarpras per Jenjang'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label} di ${context.label}: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endif

    <script>
        new Chart(document.getElementById('chartAkreditasi'), {
            type: 'bar',
            data: {
                labels: @json($akreditasiJenjangLabels),
                datasets: @json($akreditasiDatasets)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Akreditasi Sekolah per Jenjang'
                    },
                    tooltip: {
                        mode: 'nearest',
                        intersect: true,
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label} di ${context.label}: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('chartGtkKualifikasi'), {
            type: 'bar',
            data: {
                labels: @json($kualifikasiJenjangLabels),
                datasets: @json($gtkKualifikasiDatasets)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Kualifikasi Pendidikan Guru per Jenjang'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label} di ${context.label}: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const ctx = document.getElementById('chartSebaranKecamatan').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($kecamatanLabels),
                datasets: [{
                    label: 'Jumlah Sekolah',
                    data: @json($jumlahSekolahData),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    pointBackgroundColor: '#28a745',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    datalabels: {
                        align: 'top',
                        anchor: 'end',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value) => value
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Sekolah'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Kecamatan'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>

    <script>
        const chartSemuaData = @json(array_values($statistik['semua']));
        const chartSwastaData = @json(array_values($statistik['Swasta']));
        const chartNegeriData = @json(array_values($statistik['Negeri']));

        const labelsJenjang = ['TK', 'KB', 'TPA', 'SPS', 'PKBM', 'SKB', 'SD', 'SMP', 'SMA', 'SMK', 'SLB'];

        new Chart(document.getElementById('semuaSekolahChart'), {
            type: 'bar',
            data: {
                labels: labelsJenjang,
                datasets: [{
                    label: 'Jumlah Sekolah',
                    data: chartSemuaData,
                    backgroundColor: ['#28a745', '#dc3545', '#007bff', '#6c757d', '#343a40', '#17a2b8']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        new Chart(document.getElementById('sekolahSwastaChart'), {
            type: 'bar',
            data: {
                labels: labelsJenjang,
                datasets: [{
                    label: 'Jumlah Sekolah Swasta',
                    data: chartSwastaData,
                    backgroundColor: ['#28a745', '#dc3545', '#007bff', '#6c757d', '#343a40', '#17a2b8']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        new Chart(document.getElementById('sekolahNegeriChart'), {
            type: 'bar',
            data: {
                labels: labelsJenjang,
                datasets: [{
                    label: 'Jumlah Sekolah Negeri',
                    data: chartNegeriData,
                    backgroundColor: ['#28a745', '#dc3545', '#007bff', '#6c757d', '#343a40', '#17a2b8']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-sambutan');
            if (!toggleBtn) return;

            const contentDiv = document.getElementById('sambutan-content');
            const fullContent = document.getElementById('sambutan-full').innerHTML;
            const shortContent = `{!! addslashes($shortContent) !!}`;

            let expanded = false;

            toggleBtn.addEventListener('click', function() {
                if (expanded) {
                    contentDiv.innerHTML = shortContent;
                    toggleBtn.innerText = 'Baca Selengkapnya';
                } else {
                    contentDiv.innerHTML = fullContent;
                    toggleBtn.innerText = 'Tampilkan Lebih Sedikit';
                }
                expanded = !expanded;
            });
        });

        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: true,

            pagination: {
                el: '.swiper-pagination',
            },

            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            autoplay: {
                delay: 5000,
            },

            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: false,
            },

        });
    </script>
@endsection
