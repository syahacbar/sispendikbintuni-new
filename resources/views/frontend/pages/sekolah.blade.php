@extends('frontend.layouts.app')

@section('content')
    <section class="identity-section mb-4 mt-5">
        <div class="container">
            <div class="identity-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">
                                <i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">
                                <i class="fas fa-home"></i>
                                ></a>
                        </li>
                        <li class="breadcrumb-item text-white"><i class="fas fa-info-circle"></i> Informasi Sekolah</li>
                    </ol>
                </nav>
                <h1 class="text-white fw-bold" data-aos="fade-up">Informasi Sekolah</h1>
                <p class="text-warning mb-4" data-aos="fade-up">Data Sekolah Kabupaten Teluk Bintuni</p>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="text-center mb-4">
                    <h3 class="text-success fw-bold">
                        Data Sekolah
                    </h3>
                    <p class="text-muted">
                        Tabel Informasi Sekolah Se-Kabupaten Teluk Bintuni
                    </p>
                </div>
            </div>
            <div class="row my-3">
                <table id="dataSekolah" class="display responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Sekolah</th>
                            <th>NPSN</th>
                            <th>Status</th>
                            <th>Jenjang</th>
                            <th>Alamat</th>
                            <th>Kecamatan</th>
                            <th>Kabupaten</th>
                            <th>Provinsi</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>SK Pendirian</th>
                            <th>Tanggal SK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sekolah as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>
                            <a class="text-decoration-none"
                                href="{{ route('frontend.sekolah.show', ['slug' => $item->slug]) }}">
                                {{ $item->nama }} </a>
                        </td> --}}
                                <td>{{ $item->npsn }}</td>
                                <td>{{ $item->status_sekolah == 1 ? 'Negeri' : 'Swasta' }}</td>
                                <td>{{ $item->jenjang }}</td>
                                <td>
                                    {{ $item->alamat_jalan }}
                                    {{ $item->desa_kelurahan ? ', ' . $item->desa_kelurahan : '' }}
                                    {{ $item->kode_pos ? ' (' . $item->kode_pos . ')' : '' }}
                                </td>
                                <td>{{ $item->kecamatan }}</td>
                                <td>{{ $item->kabupaten }}</td>
                                <td>{{ $item->provinsi }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->sk_pendirian }}</td>
                                <td>{{ $item->tanggal_sk_pendirian ? \Carbon\Carbon::parse($item->tanggal_sk_pendirian)->format('d-m-Y') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
