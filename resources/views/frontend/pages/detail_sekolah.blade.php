@extends('frontend.layouts.app')
@section('content')
    <section class="identity-section mb-4 mt-5">
        <div class="container">
            <div class="identity-content">
                <h1 class="text-white fw-bold" data-aos="fade-up">{{ $title }}</h1>
                <p class="text-warning mb-4" data-aos="fade-up">{{ $subtitle }}</p>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="row my-3">
                <div class="card">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a class="text-decoration-none"
                                        href="{{ url('/data-pendidikan') }}">Data Pendidikan</a> /</li>
                                <li class="breadcrumb-item"><a class="text-decoration-none"
                                        href="{{ url('/data-pendidikan') }}">{{ $namaKabupaten }}</a> /</li>
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/data-pendidikan/' . urlencode($kodeKecamatan) . '/kecamatan') }}"
                                        class="text-decoration-none">
                                        Kec. {{ $namaKecamatan }}
                                    </a> /
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/data-pendidikan/' . urlencode($kodeKecamatan) . '/' . urlencode($kodeKelurahan) . '/sekolah') }}"
                                        class="text-decoration-none">
                                        Kel. {{ $namaKelurahan }}
                                    </a> /
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $sekolah->nama }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <h3>{{ $sekolah->nama }}</h3>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Akreditasi</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->akreditasi }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kurikulum</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->kurikulum }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->status_sekolah }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenjang</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->jenjang }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>:</td>
                                            <td>{{ $sekolah->alamat_jalan }}, {{ $sekolah->desa_kelurahan }},
                                                {{ $sekolah->kecamatan }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-8">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-kondisiSekolah-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-kondisiSekolah" type="button" role="tab"
                                            aria-controls="nav-kondisiSekolah" aria-selected="true">Kondisi Sekolah</button>
                                        <button class="nav-link" id="nav-dataPTK-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-dataPTK" type="button" role="tab"
                                            aria-controls="nav-dataPTK" aria-selected="false">Data PTK</button>
                                        <button class="nav-link" id="nav-dataSiswa-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-dataSiswa" type="button" role="tab"
                                            aria-controls="nav-dataSiswa" aria-selected="false">Data Siswa</button>
                                        <button class="nav-link" id="nav-dataSarpras-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-dataSarpras" type="button" role="tab"
                                            aria-controls="nav-dataSarpras" aria-selected="false">Data Sarpras</button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-kondisiSekolah" role="tabpanel"
                                        aria-labelledby="nav-kondisiSekolah-tab" tabindex="0">
                                        <div class="row mt-3">


                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-dataPTK" role="tabpanel"
                                        aria-labelledby="nav-dataPTK-tab" tabindex="0">
                                        <div class="row">
                                            <ul>
                                                @foreach ($sekolah->ptks as $ptk)
                                                    <li>{{ $ptk->nama }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-dataSiswa" role="tabpanel"
                                        aria-labelledby="nav-dataSiswa-tab" tabindex="0">
                                        <div class="row">
                                            <ul>
                                                @foreach ($sekolah->pesertaDidiks as $siswa)
                                                    <li>{{ $siswa->nama }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-dataSarpras" role="tabpanel"
                                        aria-labelledby="nav-dataSarpras-tab" tabindex="0">
                                        <div class="row">
                                            <ul>
                                                @foreach ($sekolah->saranas as $sarana)
                                                    <li>{{ $sarana->nama_sarana }} - {{ $sarana->jumlah }}</li>
                                                @endforeach
                                            </ul>

                                            <ul>
                                                @foreach ($sekolah->prasaranas as $prasarana)
                                                    <li>{{ $prasarana->jenis }} - {{ $prasarana->kondisi }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
