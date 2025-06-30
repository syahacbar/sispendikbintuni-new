@extends('frontend.layouts.app')

@section('content')
<section class="identity-section mb-4 mt-5">
    <div class="container">
        <div class="identity-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white text-decoration-none">
                            <i class="fas fa-home"></i> Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-white">
                        <i class="fas fa-info-circle"></i> Informasi PTK
                    </li>
                </ol>
            </nav>
            <h1 class="text-white fw-bold" data-aos="fade-up">Informasi PTK</h1>
            <p class="text-warning mb-4" data-aos="fade-up">Data PTK Kabupaten Teluk Bintuni</p>
        </div>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="text-center mb-4">
                <h3 class="text-success fw-bold">
                    Pendidik dan Tenaga Kependidikan
                </h3>
                <p class="text-muted">
                    Tabel Informasi Pendidik dan Tenaga Kependidikan Se-Kabupaten Teluk Bintuni
                </p>
            </div>
        </div>
        <div class="row my-3">
            <table id="dataPTK" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>NUPTK</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Status Kepegawaian</th>
                        <th>Jabatan</th>
                        <th>NPWP</th>
                        <th>Nama Sekolah</th>
                        <th>Distrik</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ptk as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->nik ?? '-' }}</td>
                        <td>{{ $item->nuptk ?? '-' }}</td>
                        <td>{{ $item->tempat_lahir ?? '-' }}</td>
                        <td>{{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') : '-'
                            }}</td>
                        <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $item->agama ?? '-' }}</td>
                        <td>{{ $item->status_kepegawaian ?? '-' }}</td>
                        <td>{{ $item->jabatan ?? '-' }}</td>
                        <td>{{ $item->npwp ?? '-' }}</td>
                        <td>{{ $item->sekolah->nama_sekolah ?? '-' }}</td>
                        <td>{{ $item->sekolah->distrik ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection