@extends('frontend.layouts.app')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="text-center mb-4">
                    <h3 class="text-success fw-bold">
                        {{ $sekolah->nama }}
                    </h3>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-img d-flex flex-wrap justify-content-center gap-3">
                        <img src="" alt="{{ $sekolah->nama }}">
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-profilSekolah-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profilSekolah" type="button" role="tab"
                                aria-controls="nav-profilSekolah" aria-selected="true">Profil</button>
                            <button class="nav-link" id="nav-saprasSekolah-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-saprasSekolah" type="button" role="tab"
                                aria-controls="nav-saprasSekolah" aria-selected="false">
                                Sarpras</button>
                            <button class="nav-link" id="nav-dataPTK-tab" data-bs-toggle="tab" data-bs-target="#nav-dataPTK"
                                type="button" role="tab" aria-controls="nav-dataPTK" aria-selected="false">PTK</button>
                            <button class="nav-link" id="nav-dataRombel-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-dataRombel" type="button" role="tab"
                                aria-controls="nav-dataRombel" aria-selected="false">Rombel</button>
                            <button class="nav-link" id="nav-dataSanitasi-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-dataSanitasi" type="button" role="tab"
                                aria-controls="nav-dataSanitasi" aria-selected="false">Sanitasi</button>

                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-profilSekolah" role="tabpanel"
                            aria-labelledby="nav-profilSekolah-tab" tabindex="0">
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Nama Sekolah</th>
                                                <td>{{ $sekolah->nama }}</td>
                                            </tr>
                                            <tr>
                                                <th>NPSN</th>
                                                <td>{{ $sekolah->npsn }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status Sekolah</th>
                                                <td>{{ $sekolah->status_sekolah == 1 ? 'Negeri' : 'Swasta' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>
                                                    {{ $sekolah->alamat_jalan }}
                                                    {{ $sekolah->desa_kelurahan ? ', ' . $sekolah->desa_kelurahan : '' }}
                                                    {{ $sekolah->kode_pos ? ' (' . $sekolah->kode_pos . ')' : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Kecamatan</th>
                                                <td>{{ $sekolah->kecamatan }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kabupaten</th>
                                                <td>{{ $sekolah->kabupaten }}</td>
                                            </tr>
                                            <tr>
                                                <th>Provinsi</th>
                                                <td>{{ $sekolah->provinsi }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $sekolah->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Telepon</th>
                                                <td>{{ $sekolah->telepon }}</td>
                                            </tr>
                                            <tr>
                                                <th>SK Pendirian</th>
                                                <td>{{ $sekolah->sk_pendirian }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal SK Pendirian</th>
                                                <td>{{ $sekolah->tanggal_sk_pendirian
                                                    ? \Carbon\Carbon::parse($sekolah->tanggal_sk_pendirian)->format('d-m-Y')
                                                    : '-' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-saprasSekolah" role="tabpanel"
                            aria-labelledby="nav-saprasSekolah-tab" tabindex="0">
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <h5 class="mb-3 fw-bold">Data Sarana dan Prasarana</h5>
                                    <table class="table table-striped table-bordered">
                                        <thead class="table-success text-center">
                                            <tr>
                                                <th style="width: 50px;">No</th>
                                                <th>Jenis Sarana/Prasarana</th>
                                                <th>Semester Genap 2023/2024</th>
                                                <th>Semester Ganjil 2024/2025</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sarpras = [
                                                    ['Ruang Kelas', 26, 26],
                                                    ['Ruang Perpustakaan', 2, 2],
                                                    ['Ruang Laboratorium', 6, 6],
                                                    ['Ruang Praktik', 0, 0],
                                                    ['Ruang Pimpinan', 1, 1],
                                                    ['Ruang Guru', 2, 2],
                                                    ['Ruang Ibadah', 1, 1],
                                                    ['Ruang UKS', 1, 1],
                                                    ['Ruang Toilet', 2, 2],
                                                    ['Ruang Gudang', 1, 1],
                                                    ['Ruang Sirkulasi', 0, 0],
                                                    ['Tempat Bermain / Olahraga', 0, 0],
                                                    ['Ruang Tata Usaha', 5, 5],
                                                    ['Ruang Konseling', 2, 2],
                                                    ['Ruang OSIS', 0, 0],
                                                    ['Bangunan Pendukung', 7, 7],
                                                ];

                                                $totalGenap = array_sum(array_column($sarpras, 1));
                                                $totalGanjil = array_sum(array_column($sarpras, 2));
                                            @endphp

                                            @foreach ($sarpras as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item[0] }}</td>
                                                    <td class="text-center">{{ $item[1] }}</td>
                                                    <td class="text-center">{{ $item[2] }}</td>
                                                </tr>
                                            @endforeach
                                            <tr class="table-secondary fw-bold">
                                                <td colspan="2" class="text-center">Total</td>
                                                <td class="text-center">{{ $totalGenap }}</td>
                                                <td class="text-center">{{ $totalGanjil }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-dataPTK" role="tabpanel" aria-labelledby="nav-dataPTK-tab"
                            tabindex="0">
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <h5 class="fw-bold mb-3">Rekapitulasi Data PTK dan PD</h5>
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-success text-center">
                                            <tr>
                                                <th rowspan="2" class="align-middle">Uraian</th>
                                                <th colspan="3">PTK</th>
                                                <th rowspan="2" class="align-middle">PD</th>
                                            </tr>
                                            <tr>
                                                <th>Guru</th>
                                                <th>Tendik</th>
                                                <th>Total PTK</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <td class="text-start">Laki-laki</td>
                                                <td>8</td>
                                                <td>4</td>
                                                <td>12</td>
                                                <td>142</td>
                                            </tr>
                                            <tr>
                                                <td class="text-start">Perempuan</td>
                                                <td>42</td>
                                                <td>3</td>
                                                <td>45</td>
                                                <td>419</td>
                                            </tr>
                                            <tr class="table-secondary fw-bold">
                                                <td class="text-center">Total</td>
                                                <td>50</td>
                                                <td>7</td>
                                                <td>57</td>
                                                <td>561</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="mt-3">
                                        <p class="mb-1"><strong>Keterangan:</strong></p>
                                        <ul class="mb-0">
                                            <li>Data rekap per tanggal <strong>27 Juni 2025</strong></li>
                                            <li>Penghitungan PTK adalah yang sudah mendapat penugasan, berstatus aktif, dan
                                                terdaftar di sekolah induk.
                                            </li>
                                            <li><strong>PTK</strong> = Guru + Tendik</li>
                                            <li><strong>PD</strong> = Peserta Didik</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-dataRombel" role="tabpanel"
                            aria-labelledby="nav-dataRombel-tab" tabindex="0">
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <h5 class="fw-bold mb-3">Rekapitulasi Rombel</h5>
                                    <div class="mt-3">
                                        {{ $sekolah->nama }} memiliki jumlah rombel sebanyak 50, dengan uraian sebagai
                                        berikut:
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-dataSanitasi" role="tabpanel"
                            aria-labelledby="nav-dataSanitasi-tab" tabindex="0">
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <h5 class="fw-bold mb-3">Data Sanitasi Sekolah</h5>
                                    <table class="table table-striped table-bordered">
                                        <thead class="table-success text-center">
                                            <tr>
                                                <th style="width: 50px;">No</th>
                                                <th>Nama Variabel</th>
                                                <th>Uraian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sanitasi = [
                                                    'Sumber air',
                                                    'Sumber air minum',
                                                    'Kecukupan air bersih',
                                                    'Sekolah menyediakan jamban yang dilengkapi dengan fasilitas pendukung untuk
                                        digunakan oleh siswa
                                        berkebutuhan khusus',
                                                    'Tipe Jamban',
                                                    'Jumlah hari dalam seminggu siswa mengikuti kegiatan cuci tangan berkelompok',
                                                    'Jumlah tempat cuci tangan',
                                                    'Jumlah tempat cuci tangan rusak',
                                                    'Apakah sabun dan air mengalir pada tempat cuci tangan',
                                                    'Sekolah memiliki saluran pembuangan air limbah dari jamban',
                                                    'Sekolah pernah menguras tangki septik dalam 3 hingga 5 tahun terakhir dengan
                                        truk/motor sedot tinja',
                                                ];
                                            @endphp

                                            @foreach ($sanitasi as $i => $item)
                                                <tr>
                                                    <td class="text-center">{{ $i + 1 }}</td>
                                                    <td>{{ $item }}</td>
                                                    <td class="text-center">-</td>
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

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
