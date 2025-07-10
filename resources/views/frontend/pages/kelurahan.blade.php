@extends('frontend.layouts.app')
<style>
    table#dataKecamatan tfoot * {
        font-weight: bold;
        font-size: 14px !important;
    }

    table#dataKecamatan tbody td,
    table#dataKecamatan thead th,
    table#dataKecamatan tfoot th {
        font-weight: normal !important;
        font-size: 14px;
    }

    .bg-d5d5d5.text-dark {
        background-color: #d5d5d5 !important;
    }

    .bg-ecf0f6.text-dark {
        background-color: #ecf0f6 !important;
    }

    .bg-e9e9e9.text-dark {
        background-color: #e9e9e9 !important;
    }

    .bg-c2c2c2.text-dark {
        background-color: #c2c2c2 !important;
    }

    .text-center {
        text-align: center !important;
    }
</style>
@section('content')
    <section class="about-section">
        <div class="container my-0">
            <div class="row my-3">
                <div class="card">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a class="text-decoration-none"
                                        href="{{ url('/data-pendidikan') }}">Data Pendidikan</a></li>
                                <li class="breadcrumb-item"><a class="text-decoration-none"
                                        href="{{ url('/data-pendidikan') }}">{{ $namaKabupaten }}</a></li>
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
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Nama Kelurahan</th>
                                    @foreach ($jenjangList as $jenjang)
                                        <th colspan="3" class="text-center">{{ $jenjang }}</th>
                                    @endforeach
                                    <th colspan="3" class="text-center">Total</th>
                                </tr>
                                <tr>
                                    @foreach ($jenjangList as $jenjang)
                                        <th class="text-center text-light">N</th>
                                        <th class="text-center text-light">S</th>
                                        <th class="text-center text-light">Jml</th>
                                    @endforeach
                                    <th class="text-center text-light">N</th>
                                    <th class="text-center text-light">S</th>
                                    <th class="text-center text-light">Jml</th>
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
                                            <td class="text-center text-dark">
                                                {{ $kel['jumlah'][$jenjang]['negeri'] ?? 0 }}
                                            </td>
                                            <td class="text-center text-dark">
                                                {{ $kel['jumlah'][$jenjang]['swasta'] ?? 0 }}
                                            </td>
                                            <td class="bg-d5d5d5 text-center text-dark">
                                                {{ $kel['jumlah'][$jenjang]['total'] ?? 0 }}
                                            </td>
                                        @endforeach
                                        <td class="text-center text-dark">
                                            <strong>{{ $kel['total_all']['negeri'] }}</strong>
                                        </td>
                                        <td class="text-center text-dark">
                                            <strong>{{ $kel['total_all']['swasta'] }}</strong>
                                        </td>
                                        <td class="bg-d5d5d5 text-center text-dark">
                                            <strong>{{ $kel['total_all']['total'] }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot class="bg-light fw-bold">
                                <tr>
                                    <td colspan="2">Total</td>
                                    @php
                                        $totalCols = [];
                                        foreach ($jenjangList as $jenjang) {
                                            $totalCols[$jenjang] = ['total' => 0, 'negeri' => 0, 'swasta' => 0];
                                        }
                                        $totalFinal = ['total' => 0, 'negeri' => 0, 'swasta' => 0];

                                        foreach ($kelurahans as $kel) {
                                            foreach ($jenjangList as $jenjang) {
                                                $totalCols[$jenjang]['negeri'] +=
                                                    $kel['jumlah'][$jenjang]['negeri'] ?? 0;
                                                $totalCols[$jenjang]['swasta'] +=
                                                    $kel['jumlah'][$jenjang]['swasta'] ?? 0;
                                                $totalCols[$jenjang]['total'] += $kel['jumlah'][$jenjang]['total'] ?? 0;
                                            }

                                            $totalFinal['negeri'] += $kel['total_all']['negeri'];
                                            $totalFinal['swasta'] += $kel['total_all']['swasta'];
                                            $totalFinal['total'] += $kel['total_all']['total'];
                                        }
                                    @endphp

                                    @foreach ($jenjangList as $jenjang)
                                        <td class="bg-e9e9e9 text-dark">{{ $totalCols[$jenjang]['negeri'] }}</td>
                                        <td class="bg-ecf0f6 text-dark">{{ $totalCols[$jenjang]['swasta'] }}</td>
                                        <td class="bg-d5d5d5 text-dark">{{ $totalCols[$jenjang]['total'] }}</td>
                                    @endforeach
                                    <td class="bg-e9e9e9 text-dark">{{ $totalFinal['negeri'] }}</td>
                                    <td class="bg-ecf0f6 text-dark">{{ $totalFinal['swasta'] }}</td>
                                    <td class="bg-d5d5d5 text-dark">{{ $totalFinal['total'] }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
