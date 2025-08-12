@extends('frontend.layouts.app')
<style>
    table#dataSekolah tfoot * {
        font-weight: bold;
        font-size: 14px !important;
    }

    table#dataSekolah tbody td,
    table#dataSekolah thead th,
    table#dataSekolah tfoot th {
        font-weight: normal !important;
        font-size: 14px;
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
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none" href="{{ url('/data-pendidikan') }}">Data
                                            Pendidikan</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none"
                                            href="{{ url('/data-pendidikan') }}">{{ $namaKabupaten }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Kec. {{ $namaKecamatan }}</li>
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
                                        @foreach ($sekolahs as $index => $sekolah)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <a class="text-decoration-none"
                                                        href="{{ url('/data-pendidikan/sekolah/' . $sekolah->npsn) }}">
                                                        {{ $sekolah->nama }}
                                                    </a>
                                                </td>
                                                <td class="text-center">{{ $sekolah->npsn }}</td>
                                                <td class="text-center">
                                                    {{ $sekolah->jenjang->kode }}</td>
                                                <td class="text-center">{{ $sekolah->status }}</td>
                                                <td class="text-center">{{ $sekolah->peserta_count }}</td>
                                                <td class="text-center">{{ $sekolah->rombongan_belajars_count }}</td>
                                                <td class="text-center">{{ $sekolah->guru_count }}</td>
                                                <td class="text-center">{{ $sekolah->pegawai_count }}</td>
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
