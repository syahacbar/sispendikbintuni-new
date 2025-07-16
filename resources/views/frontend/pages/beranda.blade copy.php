@extends('frontend.layouts.app')
@section('content')
    {{-- @php
        use App\Helpers\PengaturanHelper;

        $deskripsi = PengaturanHelper::get('deskripsi', 'Sistem Informasi Pendidikan');
        $slogan = PengaturanHelper::get('slogan', 'Membangun Pendidikan Cerdas, Terhubung, dan Transparan');
        $teks_selamat_datang = PengaturanHelper::get('teks_selamat_datang', 'Selamat Datang di');
        $nama_instansi = PengaturanHelper::get('nama_instansi', 'Kabupaten Teluk Bintuni');
        $alamat_lengkap = PengaturanHelper::get(
            'alamat_lengkap',
            'Jalan Trikora Wesiri, Kec. Bintuni, Kabupaten Teluk Bintuni, Provinsi Papua Barat',
        );
        $email = PengaturanHelper::get('email', 'info@sispendikbintuni.go.id');
        $no_hp = PengaturanHelper::get('no_hp', '+6281255554444');
        $telepon = PengaturanHelper::get('telepon', '98312-5587');
        $instagram = PengaturanHelper::get('instagram', 'Kabupaten Teluk Bintuni');
        $facebook = PengaturanHelper::get('facebook', 'Kabupaten Teluk Bintuni');
        $youtube = PengaturanHelper::get('youtube', 'Kabupaten Teluk Bintuni');
        $twitter = PengaturanHelper::get('twitter', 'Kabupaten Teluk Bintuni');

    @endphp --}}

    <section class="hero w-100 container-fluid d-flex align-items-start justify-content-start text-start">
        <div class="container">
            <div class="hero-content" data-aos="fade-up">
                <p>{{ $pengaturan['welcome_text'] ?? '' }}</p>
                <h1>{{ $pengaturan['site_description'] ?? '' }}<br />{{ $pengaturan['site_name'] ?? '' }}</h1>
                <p>{{ $pengaturan['site_tagline'] ?? '' }}</p>
            </div>
        </div>
    </section>


    <section class="bg-white">
        <div class="container pb-3">
            <div class="row align-items-center">
                <div class="col-lg-5 text-center mb-4 mb-lg-0 d-flex justify-content-center " data-aos="fade-right">
                    <img src="{{ asset('storage/' . ($pengaturan['sambutan_foto'] ?? 'assets/default.png')) }}"
                        alt="Kepala Dinas Kabupaten Teluk Bintuni" class="img-fluid quote-img"
                        style="max-height: 450px; object-fit: cover;">
                </div>
                <div class="col-lg-7 mt-4" data-aos="fade-left">
                    <h5 class="fw-bold text-teal mb-4">
                        {{ $pengaturan['judul_sambutan'] ?? 'Judul sambutan belum tersedia.' }}
                    </h5>
                    @php
                        $fullContent = $pengaturan['isi_sambutan'] ?? 'Isi sambutan belum tersedia.';
                        $shortContent = Str::limit(strip_tags($fullContent), 1000);
                    @endphp

                    <div class="text-dark">
                        <div id="sambutan-content" class="mb-3">
                            {!! $shortContent !!}
                        </div>
                        <button id="toggle-sambutan" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</button>
                    </div>

                    <div id="sambutan-full" class="d-none">
                        {!! $fullContent !!}
                    </div>
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
                                <span class="float-end text-primary">{{ number_format($total_guru) }}</span>
                            </h6>
                            <hr class="mt-1 mb-2">
                            @foreach ($jenjangList as $jenjang)
                                <div class="d-flex justify-content-between">
                                    <span>{{ $jenjang }}</span>
                                    <span>{{ number_format($jumlah_guru[$jenjang] ?? 0) }}</span>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-4 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Akreditasi Sekolah</h6>
                        </div>
                        <div class="card-body">
                            <canvas style="height: 300px" id="chartAkreditasi"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Kondisi Sarpras</h6>
                        </div>
                        <div class="card-body">
                            <canvas style="height: 300px" id="chartKondisiSarpras"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Kualifikasi Guru</h6>
                        </div>
                        <div class="card-body">
                            <canvas style="height: 300px" id="chartKualifikasiGuru"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Status PTK</h6>
                        </div>
                        <div class="card-body">
                            <canvas style="height: 300px" id="chartStatusPTK"></canvas>
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






    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        // new Chart(document.getElementById('chartAkreditasi'), {
        //     type: 'bar',
        //     data: {
        //         labels: @json($jenjangList),
        //         datasets: @json($akreditasiDatasets)
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 position: 'bottom'
        //             },
        //             title: {
        //                 display: true,
        //                 text: 'Akreditasi Sekolah per Jenjang'
        //             },
        //             tooltip: {
        //                 mode: 'nearest', // HANYA tampilkan tooltip untuk dataset yang sedang di-hover
        //                 intersect: true,
        //                 callbacks: {
        //                     label: function(context) {
        //                         return `${context.dataset.label} di ${context.label}: ${context.parsed.y}`;
        //                     }
        //                 }
        //             },
        //             // datalabels: {
        //             //     color: '#000',
        //             //     anchor: 'center',
        //             //     align: 'center',
        //             //     font: {
        //             //         weight: 'bold',
        //             //         size: 10
        //             //     },
        //             //     formatter: (value) => value
        //             // }
        //         },
        //         interaction: {
        //             mode: 'nearest', // ini penting
        //             intersect: true // ini juga penting
        //         },
        //         scales: {
        //             x: {
        //                 stacked: true
        //             },
        //             y: {
        //                 stacked: true,
        //                 beginAtZero: true
        //             }
        //         }
        //     },
        //     // plugins: [ChartDataLabels]

        // });

        // new Chart(document.getElementById('chartStatusPTK'), {
        //     type: 'bar',
        //     data: {
        //         labels: @json($jenjangList),
        //         datasets: @json($statusPTKDatasets)
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 position: 'bottom'
        //             },
        //             tooltip: {
        //                 mode: 'nearest', // tampilkan hanya 1 dataset per hover
        //                 intersect: true, // aktif hanya saat benar-benar di atas bar
        //                 callbacks: {
        //                     label: function(context) {
        //                         return `${context.dataset.label} di ${context.label}: ${context.parsed.y}`;
        //                     }
        //                 }
        //             },
        //             // datalabels: {
        //             //     color: '#000',
        //             //     anchor: 'center',
        //             //     align: 'center',
        //             //     font: {
        //             //         weight: 'bold',
        //             //         size: 10
        //             //     },
        //             //     formatter: (value) => value
        //             // }
        //         },
        //         interaction: {
        //             mode: 'nearest', // ini wajib untuk hover per warna
        //             intersect: true
        //         },
        //         scales: {
        //             x: {
        //                 stacked: true
        //             },
        //             y: {
        //                 stacked: true,
        //                 beginAtZero: true
        //             }
        //         }
        //     },
        //     // plugins: [ChartDataLabels]
        // });

        // new Chart(document.getElementById('chartKondisiSarpras'), {
        //     type: 'bar',
        //     data: {
        //         labels: @json($jenjangList),
        //         datasets: @json($datasets)
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         interaction: {
        //             mode: 'nearest',
        //             intersect: true
        //         },
        //         plugins: {
        //             legend: {
        //                 position: 'bottom'
        //             },
        //             title: {
        //                 display: true,
        //                 text: 'Kondisi Sarpras per Jenjang'
        //             },
        //             tooltip: {
        //                 mode: 'nearest',
        //                 intersect: true,
        //                 callbacks: {
        //                     label: function(context) {
        //                         const jenjang = context.label;
        //                         const kondisi = context.dataset.label;
        //                         const jumlah = context.parsed.y;
        //                         return `${kondisi} di ${jenjang}: ${jumlah}`;
        //                     }
        //                 }
        //             },
        //             // datalabels: {
        //             //     color: '#000',
        //             //     anchor: 'center',
        //             //     align: 'center',
        //             //     font: {
        //             //         weight: 'bold',
        //             //         size: 10
        //             //     },
        //             //     formatter: (value) => value
        //             // }
        //         },
        //         scales: {
        //             x: {
        //                 stacked: true,
        //                 ticks: {
        //                     maxRotation: 0,
        //                     minRotation: 0
        //                 }
        //             },
        //             y: {
        //                 stacked: true,
        //                 beginAtZero: true
        //             }
        //         }
        //     },
        //     // plugins: [ChartDataLabels]
        // });

        // // Kualifikasi Guru
        // new Chart(document.getElementById('chartKualifikasiGuru'), {
        //     type: 'bar',
        //     data: {
        //         labels: @json($jenjangList),
        //         datasets: @json($kualifikasiDatasets)
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 position: 'bottom'
        //             },
        //             title: {
        //                 display: true,
        //                 text: 'Kualifikasi Guru per Jenjang'
        //             },
        //             tooltip: {
        //                 mode: 'nearest',
        //                 intersect: true,
        //                 callbacks: {
        //                     label: function(context) {
        //                         return `${context.dataset.label} di ${context.label}: ${context.parsed.y}`;
        //                     }
        //                 }
        //             },
        //             // datalabels: {
        //             //     color: '#000',
        //             //     anchor: 'center',
        //             //     align: 'center',
        //             //     font: {
        //             //         weight: 'bold',
        //             //         size: 10
        //             //     },
        //             //     formatter: (value) => value
        //             // }
        //         },
        //         interaction: {
        //             mode: 'nearest',
        //             intersect: true
        //         },
        //         scales: {
        //             x: {
        //                 stacked: true
        //             },
        //             y: {
        //                 stacked: true,
        //                 beginAtZero: true
        //             }
        //         }
        //     },
        //     // plugins: [ChartDataLabels]
        // });


        // const ctx = document.getElementById('chartSebaranKecamatan').getContext('2d');
        // const chart = new Chart(ctx, {
        //     type: 'line',
        //     data: {
        //         labels: @json($kecamatanLabels),
        //         datasets: [{
        //             label: 'Jumlah Sekolah',
        //             data: @json($jumlahSekolahData),
        //             borderColor: '#28a745',
        //             backgroundColor: 'rgba(40, 167, 69, 0.1)',
        //             pointBackgroundColor: '#28a745',
        //             fill: true,
        //             tension: 0.4
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 display: true
        //             },
        //             datalabels: {
        //                 align: 'top',
        //                 anchor: 'end',
        //                 font: {
        //                     weight: 'bold'
        //                 },
        //                 formatter: (value) => value
        //             }
        //         },
        //         scales: {
        //             y: {
        //                 beginAtZero: true,
        //                 title: {
        //                     display: true,
        //                     text: 'Jumlah Sekolah'
        //                 }
        //             },
        //             x: {
        //                 title: {
        //                     display: true,
        //                     text: 'Kecamatan'
        //                 }
        //             }
        //         }
        //     },
        //     plugins: [ChartDataLabels] // <- aktifkan plugin
        // });
    </script>



    <script>
        const chartSemuaData = @json(array_values($statistik['semua']));
        const chartSwastaData = @json(array_values($statistik['Swasta']));
        const chartNegeriData = @json(array_values($statistik['Negeri']));

        const labelsJenjang = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'];

        // Semua Sekolah
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

        // Sekolah Swasta
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

        // Sekolah Negeri
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
            const contentDiv = document.getElementById('sambutan-content');
            const fullContent = document.getElementById('sambutan-full').innerHTML;
            const shortContent = `{!! addslashes($shortContent) !!}`; // escape quote

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
    </script>
@endsection
