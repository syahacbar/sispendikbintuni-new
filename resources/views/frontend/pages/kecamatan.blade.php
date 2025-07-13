    @extends('frontend.layouts.app')
    <style>
        table#dataSekolahByKecamatan tfoot * {
            font-weight: bold;
            font-size: 14px !important;
        }

        table#dataSekolahByKecamatan tbody td,
        table#dataSekolahByKecamatan thead th,
        table#dataSekolahByKecamatan tfoot th {
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

        div#dataSekolahByKecamatan_filter,
        div#dataSekolahByKecamatan_length {
            margin-bottom: 15px;
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
                                        <li class="breadcrumb-item active" aria-current="page">{{ $namaKabupaten }}</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataSekolahByKecamatan" class="responsive nowrap" style="width:100%">
                                        <thead class="bg-success text-white text-normal">
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">Kecamatan</th>
                                                @foreach ($jenjangList as $jenjang)
                                                    <th colspan="3" class="text-center">{{ $jenjang }}</th>
                                                @endforeach
                                                <th colspan="3" class="text-center">Total</th>
                                            </tr>
                                            <tr>
                                                @foreach ($jenjangList as $jenjang)
                                                    <th class="text-center">N</th>
                                                    <th class="text-center">S</th>
                                                    <th class="text-light text-center">Jml</th>
                                                @endforeach
                                                <th class="text-center fw-bold">N</th>
                                                <th class="text-center fw-bold">S</th>
                                                <th class="text-light text-center fw-bold">Jml</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kecamatans as $i => $kec)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>
                                                        <a class="text-decoration-none"
                                                            href="{{ url('/data-pendidikan/kecamatan/' . urlencode($kec['kecamatan']) . '/sekolah') }}">
                                                            {{ $kec['nama_kecamatan'] }}
                                                        </a>
                                                    </td>
                                                    @foreach ($jenjangList as $jenjang)
                                                        <td class="text-dark text-center">
                                                            {{ $kec['jumlah'][$jenjang]['negeri'] ?? 0 }}</td>
                                                        <td class="text-dark text-center">
                                                            {{ $kec['jumlah'][$jenjang]['swasta'] ?? 0 }}</td>
                                                        <td class="bg-d5d5d5 text-dark text-center">
                                                            {{ $kec['jumlah'][$jenjang]['total'] ?? 0 }}</td>
                                                    @endforeach
                                                    <td class="text-dark text-center">
                                                        <strong>{{ $kec['total_all']['negeri'] }}</strong>
                                                    </td>
                                                    <td class="text-dark text-center">
                                                        <strong>{{ $kec['total_all']['swasta'] }}</strong>
                                                    </td>
                                                    <td class="bg-ecf0f6 text-dark text-center">
                                                        <strong>{{ $kec['total_all']['total'] }}</strong>
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
                                                        $totalCols[$jenjang] = [
                                                            'total' => 0,
                                                            'negeri' => 0,
                                                            'swasta' => 0,
                                                        ];
                                                    }
                                                    $totalFinal = ['total' => 0, 'negeri' => 0, 'swasta' => 0];

                                                    foreach ($kecamatans as $kec) {
                                                        foreach ($jenjangList as $jenjang) {
                                                            $totalCols[$jenjang]['total'] +=
                                                                $kec['jumlah'][$jenjang]['total'] ?? 0;
                                                            $totalCols[$jenjang]['negeri'] +=
                                                                $kec['jumlah'][$jenjang]['negeri'] ?? 0;
                                                            $totalCols[$jenjang]['swasta'] +=
                                                                $kec['jumlah'][$jenjang]['swasta'] ?? 0;
                                                        }

                                                        $totalFinal['negeri'] += $kec['total_all']['negeri'];
                                                        $totalFinal['swasta'] += $kec['total_all']['swasta'];
                                                        $totalFinal['total'] += $kec['total_all']['total'];
                                                    }
                                                @endphp

                                                @foreach ($jenjangList as $jenjang)
                                                    <td>{{ $totalCols[$jenjang]['total'] }}</td>
                                                    <td>{{ $totalCols[$jenjang]['negeri'] }}</td>
                                                    <td>{{ $totalCols[$jenjang]['swasta'] }}</td>
                                                @endforeach
                                                <td>{{ $totalFinal['negeri'] }}</td>
                                                <td>{{ $totalFinal['swasta'] }}</td>
                                                <td>{{ $totalFinal['total'] }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
