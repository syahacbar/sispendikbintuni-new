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
        <div class="container my-0">
            <div class="row my-3">
                <div class="card">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a class="text-decoration-none"
                                        href="{{ url('/data-pendidikan') }}">Data Pendidikan</a> /</li>
                                <li class="breadcrumb-item"><a class="text-decoration-none"
                                        href="{{ url('/data-pendidikan') }}">{{ $namaKabupaten }}</a> /</li>
                                <li class="breadcrumb-item active" aria-current="page">Kec. {{ $namaKecamatan }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <table id="dataKecamatan" class="display responsive nowrap" style="width:100%">
                            <thead class="bg-success text-light mt-4">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelurahan</th>
                                    @foreach ($jenjangList as $jenjang)
                                        <th>{{ $jenjang }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelurahans as $i => $kel)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <a class="text-decoration-none"
                                                href="{{ url('/data-pendidikan/' . urlencode($kecamatan) . '/' . urlencode($kel['desa_kelurahan']) . '/sekolah') }}">
                                                {{ $kel['nama_kelurahan'] }}
                                            </a>
                                        </td>
                                        @foreach ($jenjangList as $jenjang)
                                            <td>{{ $kel['jumlah'][$jenjang] }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
