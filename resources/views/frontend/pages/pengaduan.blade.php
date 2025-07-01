@extends('frontend.layouts.app')
@section('content')
<section class="identity-section mb-4 mt-5">
    <div class="container">
        <div class=" identity-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-home"></i>
                            Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-home"></i>
                            ></a></li>
                    <li class="breadcrumb-item" class="text-white">
                        <i class="fas fa-info-circle"></i>
                        Pengaduan
                    </li>
                </ol>
            </nav>
            <h1 class="text-white fw-bold" data-aos="fade-up">Pengaduan</h1>
            <p class="text-warning mb-4" data-aos="fade-up">Form Pengaduan Kabupaten Teluk Bintuni</p>
        </div>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="text-center mb-4">
                <h3 class="text-success fw-bold">
                    Form Pengaduan
                </h3>
                <p class="text-muted">
                    Form Pengaduan Layanan Sistem Informasi Pendidikan Kabupaten Teluk Bintuni
                </p>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-8">
                <form onsubmit="handlePengaduan(event)">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Aktif</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor HP / WA</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Pengaduan</label>
                        <select class="form-control" id="kategori" name="kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Fasilitas Sekolah">Fasilitas Sekolah</option>
                            <option value="Kurikulum & Pembelajaran">Kurikulum & Pembelajaran</option>
                            <option value="Guru & Tenaga Kependidikan">Guru & Tenaga Kependidikan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi Pengaduan</label>
                        <textarea class="form-control" id="isi" name="isi" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
                </form>
            </div>
        </div>

        <script>
            function handlePengaduan(event) {
                        event.preventDefault();
                        const nama = document.getElementById('nama').value;
                        const kategori = document.getElementById('kategori').value;
                
                        alert(`Terima kasih, ${nama}.\nPengaduan Anda di kategori "${kategori}" telah diterima.`);
                        
                        event.target.reset();
                    }
        </script>
    </div>
</section>

@endsection