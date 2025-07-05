@extends('frontend.layouts.app')
@section('content')
    <section class="identity-section mb-4 mt-5">
        <div class="container">
            <div class=" identity-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">
                                <i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">
                                <i class="fas fa-info-circle"></i> ></a></li>
                        <li class="breadcrumb-item text-white">
                            Lacak Pengaduan
                        </li>
                    </ol>
                </nav>
                <h1 class="text-white fw-bold" data-aos="fade-up">Lacak Pengaduan</h1>
                <p class="text-warning mb-4" data-aos="fade-up">Lacak Pengaduan yang sudah dikirim</p>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="text-center mb-4">
                    <h3 class="text-success fw-bold">Form Lacak Pengaduan</h3>
                    <p class="text-muted">
                        Lacak Pengaduan Layanan Sistem Informasi Pendidikan Kabupaten Teluk Bintuni
                    </p>
                </div>
            </div>
            <form action="{{ route('pengaduan.lacak') }}" method="POST">
                @csrf
                <div class="row justify-content-center my-3">
                    <div class="col-lg-6">
                        <div class="d-flex flex-column flex-md-row align-items-end gap-2">
                            <div class="flex-grow-1">
                                <label for="cek_laporan" class="form-label">Nomor Laporan</label>
                                <input type="text" class="form-control" id="cek_laporan" name="cek_laporan" required>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Cek Data</button>
                                <button type="reset" class="btn btn-secondary d-none" id="reset-btn">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row row justify-content-center my-4">
                <div class="row justify-content-center my-4">
                    @if ($errors->has('cek_laporan'))
                        <div class="alert alert-danger text-center">{{ $errors->first('cek_laporan') }}</div>
                    @elseif (isset($data))
                        <div class="col-md-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white fw-bold">
                                    Detail Laporan Anda
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped table-bordered m-0">
                                        <tbody>
                                            <tr>
                                                <th class="w-25">Nomor Laporan</th>
                                                <td>{{ $data->nomor_laporan }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama</th>
                                                <td>{{ $data->nama }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $data->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Telepon</th>
                                                <td>{{ $data->telepon }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kategori</th>
                                                <td>{{ $data->kategori }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @if ($data->status == 'selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @elseif ($data->status == 'diproses')
                                                        <span class="badge bg-warning text-dark">Sedang Diproses</span>
                                                    @else
                                                        <span class="badge bg-secondary">Terkirim</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Isi Laporan</th>
                                                <td>{!! nl2br(e($data->isi)) !!}</td>
                                            </tr>
                                            @if ($data->dok_lampiran)
                                                <tr>
                                                    <th>Lampiran</th>
                                                    <td>
                                                        <a href="{{ asset('storage/' . $data->dok_lampiran) }}"
                                                            target="_blank">Lihat Lampiran</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('cek_laporan');
            const submitBtn = document.getElementById('submit-btn');
            const resetBtn = document.getElementById('reset-btn');

            function toggleButtons() {
                const hasValue = input.value.trim().length > 0;
                submitBtn.disabled = !hasValue;
                resetBtn.classList.toggle('d-none', !hasValue);
            }

            input.addEventListener('input', toggleButtons);
            toggleButtons(); // initial state
        });
    </script>

@endsection
