@extends('frontend.layouts.app')
@section('content')
<section class="identity-section mb-4 mt-5">
    <div class="container">
        <div class="identity-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="breadcrumb-item text-white">
                        <i class="fas fa-info-circle"></i> Informasi Siswa
                    </li>
                </ol>
            </nav>
            <h1 class="text-white fw-bold" data-aos="fade-up">Informasi Siswa</h1>
            <p class="text-warning mb-4" data-aos="fade-up">Data Siswa Kabupaten Teluk Bintuni</p>
        </div>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="text-center mb-4">
                <h3 class="text-success fw-bold">
                    Data Siswa
                </h3>
                <p class="text-muted">
                    Tabel Informasi Siswa Se-Kabupaten Teluk Bintuni
                </p>
            </div>
        </div>
        <div class="row my-3">
            <table id="dataSiswa" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>NISN</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Jenjang</th>
                        <th>Nama Sekolah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>******{{ substr($item->nisn, -4) }}</td>
                        <td>
                            {{ $item->tempat_lahir ?? '-' }},
                            {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') : '-'
                            }}
                        </td>
                        <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $item->agama ?? '-' }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->status_siswa }}</td>
                        <td>{{ $item->sekolah->jenjang ?? '-' }}</td>
                        <td>{{ $item->sekolah->nama ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection