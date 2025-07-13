@extends('frontend.layouts.app')
<style>
    table#dataSekolah tfoot * {
        font-weight: bold;
        font-size: 14px !important;
    }

    table#dataSekolah thead th,
    table#dataSekolah tfoot th {
        font-weight: normal !important;
    }

    .text-center {
        text-align: center;
    }

    table.dataTable.nowrap th,
    table.dataTable.nowrap td {
        white-space: nowrap;
        font-size: 12px;
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
                                    <li class="breadcrumb-item"><a class="text-decoration-none"
                                            href="{{ url('/data-pendidikan') }}">Data Pendidikan</a></li>
                                    <li class="breadcrumb-item"><a class="text-decoration-none"
                                            href="{{ url('/data-pendidikan') }}">{{ $namaKabupaten }}</a></li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/data-pendidikan/' . urlencode($kecamatan) . '/kelurahan') }}"
                                            class="text-decoration-none">
                                            Kec. {{ $namaKecamatan }}
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Kel. {{ $namaKelurahan }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataSekolah" class="display responsive nowrap" style="width:100%">
                                    <thead class="bg-success text-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Sekolah</th>
                                            <th class="text-center">NPSN</th>
                                            <th class="text-center">Jenjang</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Peserta Didik</th>
                                            <th class="text-center">Rombel</th>
                                            <th class="text-center">Guru</th>
                                            <th class="text-center">Pegawai</th>
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
                                                <td class="text-center">{{ $s->npsn }}</td>
                                                <td class="text-center">{{ $s->jenjang }}</td>
                                                <td class="text-center">{{ $s->status_sekolah }}</td>
                                                <td class="text-center">{{ $s->peserta_didiks_count }}</td>
                                                <td class="text-center">{{ $s->rombongan_belajars_count }}</td>
                                                <td class="text-center">{{ $s->ptks_count }}</td>
                                                <td class="text-center">{{ $s->ptks_count }}</td>
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
    </section>
@endsection
