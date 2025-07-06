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
                                    <a href="{{ url('/data-pendidikan/' . urlencode($kecamatan) . '/kelurahan') }}"
                                        class="text-decoration-none">
                                        Kec. {{ $namaKecamatan }}
                                    </a> /
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Kel. {{ $namaKelurahan }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <table id="dataKecamatan" class="display responsive nowrap" style="width:100%">
                            <table id="dataSekolah" class="display responsive nowrap" style="width:100%">
                                <thead class="bg-success text-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sekolah</th>
                                        <th>NPSN</th>
                                        <th>Jenjang</th>
                                        <th>Status</th>
                                        <th>Peserta Didik</th>
                                        <th>Rombel</th>
                                        <th>PTK</th>
                                        <th>Sarana</th>
                                        <th>Prasarana</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sekolahs as $i => $s)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                <a class="text-decoration-none"
                                                    href="{{ url('/data-pendidikan/sekolah/' . $s->slug) }}">
                                                    {{ $s->nama }}
                                                </a>
                                            </td>
                                            <td>{{ $s->npsn }}</td>
                                            <td>{{ $s->jenjang }}</td>
                                            <td>{{ $s->status_sekolah }}</td>
                                            <td>{{ $s->peserta_didiks_count }}</td>
                                            <td>{{ $s->rombongan_belajars_count }}</td>
                                            <td>{{ $s->ptks_count }}</td>
                                            <td>{{ $s->saranas_count }}</td>
                                            <td>{{ $s->prasaranas_count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
