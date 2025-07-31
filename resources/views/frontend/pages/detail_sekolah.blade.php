@extends('frontend.layouts.app')
<style>
    table tfoot * {
        font-weight: bold;
        font-size: 14px !important;
    }

    table tbody td,
    table thead th,
    table tfoot th {
        font-weight: normal !important;
        font-size: 14px;
    }

    table#dataKecamatan thead th,
    table#dataKecamatan tfoot th {
        font-weight: normal !important;
    }

    div#dataKondisiGuru_filter,
    .dataTables_filter,
    .dataTables_length,
    div#dataKondisiGuru_length {
        margin-bottom: 15px;
    }

    .bg-success {
        background-color: #0093dd !important;
    }

    div#nav-tab button {
        color: #0093dd !important;
    }

    div#nav-tab button.active {
        color: #000 !important;
    }
</style>

@section('content')
    <section class="about-section">
        <div class="container">
            <div class="row my-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item">
                                                <a class="text-decoration-none" href="{{ url('/data-pendidikan') }}">
                                                    Data Pendidikan
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a class="text-decoration-none" href="{{ url('/data-pendidikan') }}">
                                                    {{ $namaKabupaten }}
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a class="text-decoration-none"
                                                    href="{{ url('/data-pendidikan/kecamatan/' . urlencode($kodeKecamatan) . '/sekolah') }}">
                                                    Kec. {{ $namaKecamatan }}
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                {{ $sekolah->nama }}
                                            </li>
                                        </ol>
                                    </nav>

                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header text-center">
                            <h3>{{ $sekolah->nama }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>NPSN</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->npsn }}</td>
                                        </tr>
                                        <tr>
                                            <td>Bentuk Pendidikan</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->kode_jenjang }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->status }}</td>
                                        </tr>
                                        <tr>
                                            <td>Akreditasi</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->akreditasi }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Telepon</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->telepon }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kepala Sekolah</td>
                                            <td>:</td>
                                            <td>{{ optional($sekolah->kepalaSekolahDetail)->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status Kepemilikan</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->kepemilikan }}</td>
                                        </tr>
                                        <tr>
                                            <td>SK Pendirian</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->sk_pendirian }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal SK Pendirian</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->tanggal_sk_pendirian }}</td>
                                        </tr>
                                        <tr>
                                            <td>SK Izin Operasional</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->sk_izin_operasional }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal SK Operasional</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->tanggal_sk_izin_operasional }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kurikulum</td>
                                            <td>:</td>
                                            <td>{{ $kurikulum?->kode ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Koordinat</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->latitude }}, {{ $sekolah->longitude }}</td>
                                        </tr>

                                        <tr>
                                            <td>Alamat</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->alamat }}, Kel. {{ $namaKelurahan }}, Kec.
                                                {{ $namaKecamatan }}, {{ $namaKabupaten }}, {{ $sekolah->kode_pos }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-kondisiSekolah-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-kondisiSekolah" type="button" role="tab"
                                        aria-controls="nav-kondisiSekolah" aria-selected="true">Kondisi Sekolah</button>
                                    <button class="nav-link" id="nav-direktoriPTK-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-direktoriPTK" type="button" role="tab"
                                        aria-controls="nav-direktoriPTK" aria-selected="false">Direktori
                                        PTK</button>
                                    <button class="nav-link" id="nav-direktoriPesertaDidik-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-direktoriPesertaDidik" type="button" role="tab"
                                        aria-controls="nav-direktoriPesertaDidik" aria-selected="false">Direktori Pesrta
                                        Didik</button>

                                </div>
                            </nav>
                            <div class="tab-content navigasiKondisiSekolah" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-kondisiSekolah" role="tabpanel"
                                    aria-labelledby="nav-kondisiSekolah-tab" tabindex="0">
                                    <div class="row mt-3">
                                        <div>
                                            <h4 class="bg-success p-2 mb-3 text-light">Data Guru</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="dataKondisiGuru" class="display responsive nowrap"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th class="text-center">Jumlah Rombel</th>
                                                        <th class="text-center">Jumlah Ideal</th>
                                                        <th class="text-center">Jumlah Sekarang</th>
                                                        <th class="text-center">Kurang/Lebih</th>
                                                        <th class="text-center">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sekolah->ptks as $index => $ptk)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $ptk->mata_pelajaran ?? '-' }}</td>
                                                            <td class="text-center">{{ $ptk->jumlah_rombel ?? '-' }}</td>
                                                            <td class="text-center">{{ $ptk->jumlah_ideal ?? '-' }}</td>
                                                            <td class="text-center">{{ $ptk->jumlah_sekarang ?? '-' }}</td>
                                                            <td class="text-center">{{ $ptk->selisih ?? '-' }}</td>
                                                            <td class="text-center">{{ $ptk->keterangan ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-3">
                                        <div>
                                            <h4 class="bg-success p-2 mb-3 text-light">Kualifikasi
                                                Pendidikan dan Status Guru</h4>
                                        </div>
                                        <div class="col-lg-6">
                                            <canvas id="chartKualifikasiGuru"></canvas>
                                        </div>
                                        <div class="col-lg-6">
                                            <canvas id="chartStatusGuru"></canvas>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row mt-4 mb4">
                                        <div>
                                            <h4 class="bg-success p-2 mb-3 text-light">Data Tenaga Pendidik</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="dataKondisiTendik" class="display responsive nowrap"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th class="text-center">Jumlah Rombel</th>
                                                        <th class="text-center">Jumlah Ideal</th>
                                                        <th class="text-center">Jumlah Sekarang</th>
                                                        <th class="text-center">Kurang/Lebih</th>
                                                        <th class="text-center">Uraian Item</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sekolah->ptks as $index => $ptk)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $ptk->mata_pelajaran ?? '-' }}</td>
                                                            <td class="text-center">{{ $ptk->jumlah_rombel ?? '-' }}</td>
                                                            <td class="text-center">{{ $ptk->jumlah_ideal ?? '-' }}</td>
                                                            <td class="text-center">{{ $ptk->jumlah_sekarang ?? '-' }}
                                                            </td>
                                                            <td class="text-center">{{ $ptk->selisih ?? '-' }}</td>
                                                            <td class="text-center">{{ $ptk->uraian_item ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-4 mb4">
                                        <div>
                                            <h4 class="bg-success p-2 mb-3 text-light">Data Rombel</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="dataRombel" class="display responsive nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Rombel</th>
                                                        <th class="text-center">Kelas</th>
                                                        <th class="text-center">Jumlah Siswa</th>
                                                        <th class="text-center">Wali Kelas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sekolah->rombonganBelajars ?? [] as $index => $rombel)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $rombel->nama }}</td>
                                                            <td class="text-center">{{ $rombel->tingkat }}</td>
                                                            <td class="text-center">
                                                                {{ $rombel->peserta_didiks_count ?? 0 }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $rombel->waliKelas->nama ?? '-' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-3">
                                        <div>
                                            <h4 class="bg-success p-2 mb-3 text-light">Data Sarana & Prasarana</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="dataSarpras" class="display responsive nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">No</th>
                                                        <th rowspan="2">Nama Prasarana</th>
                                                        <th rowspan="2" class="text-center">Jumlah Ideal</th>
                                                        <th rowspan="2" class="text-center">Jumlah Saat Ini</th>
                                                        <th rowspan="2" class="text-center">Selisih</th>
                                                        <th class="text-center" colspan="4">Kondisi</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">Baik</th>
                                                        <th class="text-center">RR</th>
                                                        <th class="text-center">RS</th>
                                                        <th class="text-center">RB</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $no = 1; @endphp
                                                    @foreach ($sekolah->mstSarprasSekolah as $sarpras)
                                                        @php
                                                            $selisih =
                                                                $sarpras->jumlah_saat_ini - $sarpras->jumlah_ideal;
                                                            $baik = $sarpras->kondisiSarpras
                                                                ->where('kondisi', 'Baik')
                                                                ->sum('jumlah');
                                                            $rr = $sarpras->kondisiSarpras
                                                                ->where('kondisi', 'Rusak Ringan')
                                                                ->sum('jumlah');
                                                            $rs = $sarpras->kondisiSarpras
                                                                ->where('kondisi', 'Rusak Sedang')
                                                                ->sum('jumlah');
                                                            $rb = $sarpras->kondisiSarpras
                                                                ->where('kondisi', 'Rusak Berat')
                                                                ->sum('jumlah');
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $sarpras->nama ?? '-' }}</td>
                                                            <td class="text-center">{{ $sarpras->jumlah_ideal }}</td>
                                                            <td class="text-center">{{ $sarpras->jumlah_saat_ini }}</td>
                                                            <td class="text-center">
                                                                @if ($selisih > 0)
                                                                    <span class="text-success">+{{ $selisih }}</span>
                                                                @elseif ($selisih < 0)
                                                                    <span class="text-danger">{{ $selisih }}</span>
                                                                @else
                                                                    <span class="text-muted">0</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">{{ $baik }}</td>
                                                            <td class="text-center">{{ $rr }}</td>
                                                            <td class="text-center">{{ $rs }}</td>
                                                            <td class="text-center">{{ $rb }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="nav-direktoriPTK" role="tabpanel"
                                    aria-labelledby="nav-direktoriPTK-tab" tabindex="0">
                                    <div class="row mt-3">
                                        <div>
                                            <h4 class="bg-success p-2 mb-3 text-light">Direktori PTK</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="DirektoriPTK" class="display responsive nowrap"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>NIK</th>
                                                        <th>Status</th>
                                                        <th>Jabatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sekolah->ptks as $index => $ptk)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $ptk->nama }}</td>
                                                            <td>{{ $ptk->nik }}</td>
                                                            <td>{{ $ptk->status_kepegawaian }}</td>
                                                            <td>{{ $ptk->jenisGtk->nama }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-direktoriPesertaDidik" role="tabpanel"
                                    aria-labelledby="nav-direktoriPesertaDidik-tab" tabindex="0">
                                    <div class="row mt-3">
                                        <div>
                                            <h4 class="bg-success p-2 mb-3 text-light">Direktori Peserta Didik</h4>
                                        </div>
                                        <table id="DirektoriPesertaDidik" class="display responsive nowrap"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="w-5">No</th>
                                                    <th class="w-75">Nama</th>
                                                    <th class="text-center w-25">NISN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pesertaDidiks as $index => $pd)
                                                    <tr>
                                                        <td class="w-5">{{ $index + 1 }}</td>
                                                        <td class="w-75">{{ $pd->nama }}</td>
                                                        <td class="text-center w-25">{{ $pd->nisn }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('chartKualifikasiGuru'), {
            type: 'bar',
            data: {
                labels: @json($kualifikasiLabels),
                datasets: [{
                    label: 'Jumlah Guru',
                    data: @json($kualifikasiData),
                    backgroundColor: [
                        '#007bff', '#28a745', '#ffc107', '#17a2b8', '#dc3545', '#6f42c1'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });


        new Chart(document.getElementById('chartStatusGuru'), {
            type: 'bar',
            data: {
                labels: @json($statusLabels),
                datasets: [{
                    label: 'Jumlah Guru',
                    data: @json($statusData),
                    backgroundColor: [
                        '#fd7e14', '#20c997', '#6c757d', '#6610f2', '#e83e8c'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
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
@endsection
