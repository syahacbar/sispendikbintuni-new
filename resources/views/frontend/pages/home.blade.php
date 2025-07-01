@extends('frontend.layouts.app')
@section('content')
    <section class="hero w-100 container-fluid d-flex align-items-start justify-content-start text-start">
        <div class="container">
            <div class="hero-content" data-aos="fade-up">
                <p>Selamat datang di website</p>
                <h1>Sispendik<br />Kabupaten Teluk Bintuni</h1>
                <p>Sistem Informasi Pendidikan Kabupaten Teluk Bintuni.</p>
                <div class="hero-buttons">
                    <a href="about.html" class="btn-gelas"><i class="bi bi-buildings-fill"></i>
                        Tentang Sispendik Bintuni</a>
                    <a href="#" class="btn-gelas"><i class="bi bi-pencil"></i>
                        Pengaduan</a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 text-center mb-4 mb-lg-0 d-flex justify-content-center " data-aos="fade-right">
                    <img src="https://konten.usu.ac.id/storage/satker/0/icons/kakak-pendidikan.webp?w=360&amp;q=75"
                        alt="Wisudawati UTI" class="img-fluid quote-img" style="max-height: 450px; object-fit: cover;">
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="d-flex align-items-center mb-2">
                        <div class="display-6 text-success me-2">“</div>
                        <div class="badge bg-success d-flex align-items-center px-3 py-2">
                            <i class="fas fa-seedling me-2"></i> Pendidikan
                        </div>
                    </div>
                    <h5 class="fw-bold text-teal mb-4">
                        Pendidikan adalah salah satu kunci terpenting bagi bangsa dan
                        negara untuk bertahan dalam persaingan global dan merupakan bidang
                        kesejahteraan nasional yang paling strategis.
                    </h5>
                    <p class="text-dark">
                        Sumber daya manusia (SDM) yang cerdas dan berkarakter merupakan
                        prasyarat bagi pembangunan peradaban yang tinggi.
                        University Of Tech Innovation (UTI) berusaha memajukan SDM di
                        Indonesia melalui pendidikan berkualitas guna menyejahterakan
                        bangsa dan negara.
                        Tersedia berbagai program pendidikan vokasi, sarjana, profesi,
                        magister, spesialis, sub spesialis dan doktoral yang dapat Anda
                        pilih sesuai minat dan bakat
                        untuk mendukung karier dan keahlian profesional Anda pada masa
                        depan.
                    </p>
                    <div class="text-end display-6 text-success">”</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" data-aos="fade-right">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-bar-chart text-bg-success rounded p-1"></i>
                        <h5 class="mb-0 text-success fw-bold mx-2">Statistik Sekolah</h5>
                    </div>
                    <p class="text-dark">
                        Berikut adalah data jumlah sekolah berdasarkan jenjang pendidikan di Kabupaten Teluk Bintuni per 15
                        Desember 2024.
                    </p>
                </div>

                <div class="col-lg-8" data-aos="fade-left">
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="allSekolah-tab" data-bs-toggle="tab"
                                        data-bs-target="#allSekolah-tab-pane" type="button" role="tab"
                                        aria-controls="allSekolah-tab-pane" aria-selected="true">Semua</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="sekolahSwasta-tab" data-bs-toggle="tab"
                                        data-bs-target="#sekolahSwasta-tab-pane" type="button" role="tab"
                                        aria-controls="sekolahSwasta-tab-pane" aria-selected="false">Swasta</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="sekolahNegeri-tab" data-bs-toggle="tab"
                                        data-bs-target="#sekolahNegeri-tab-pane" type="button" role="tab"
                                        aria-controls="sekolahNegeri-tab-pane" aria-selected="false">Swasta</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="allSekolah-tab-pane" role="tabpanel"
                                    aria-labelledby="allSekolah-tab" tabindex="0">
                                    <div class="row text-center py-2 mb-3">
                                        <div class="col">
                                            <div class="text-muted small">PAUD</div>
                                            <div class="fw-bold text-success">113</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SD</div>
                                            <div class="fw-bold text-danger">138</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SMP</div>
                                            <div class="fw-bold text-primary">59</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SMA</div>
                                            <div class="fw-bold text-secondary">18</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SMK</div>
                                            <div class="fw-bold text-dark">24</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">PKBM</div>
                                            <div class="fw-bold text-info">21</div>
                                        </div>
                                    </div>
                                    <canvas id="semuaSekolahChart"></canvas>
                                </div>
                                <div class="tab-pane fade" id="sekolahSwasta-tab-pane" role="tabpanel"
                                    aria-labelledby="sekolahSwasta-tab" tabindex="0">
                                    <div class="row text-center py-2 mb-3">
                                        <div class="col">
                                            <div class="text-muted small">PAUD</div>
                                            <div class="fw-bold text-success">10</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SD</div>
                                            <div class="fw-bold text-danger">12</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SMP</div>
                                            <div class="fw-bold text-primary">10</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SMA</div>
                                            <div class="fw-bold text-secondary">18</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SMK</div>
                                            <div class="fw-bold text-dark">24</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">PKBM</div>
                                            <div class="fw-bold text-info">21</div>
                                        </div>
                                    </div>
                                    <canvas id="sekolahSwastaChart"></canvas>
                                </div>
                                <div class="tab-pane fade" id="sekolahNegeri-tab-pane" role="tabpanel"
                                    aria-labelledby="sekolahNegeri-tab" tabindex="0">
                                    <div class="row text-center py-2 mb-3">
                                        <div class="col">
                                            <div class="text-muted small">PAUD</div>
                                            <div class="fw-bold text-success">10</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SD</div>
                                            <div class="fw-bold text-danger">12</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SMP</div>
                                            <div class="fw-bold text-primary">10</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SMA</div>
                                            <div class="fw-bold text-secondary">18</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">SMK</div>
                                            <div class="fw-bold text-dark">24</div>
                                        </div>
                                        <div class="col">
                                            <div class="text-muted small">PKBM</div>
                                            <div class="fw-bold text-info">21</div>
                                        </div>
                                    </div>
                                    <canvas id="sekolahNegeriChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-right">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold text-muted">Peserta Didik <span
                                    class="float-end text-primary">71.077</span>
                            </h6>
                            <hr class="mt-1 mb-2">
                            <div class="d-flex justify-content-between">
                                <span>SKB</span>
                                <span>0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>PAUD</span>
                                <span>5.471</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>SD</span>
                                <span>36.404</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>SMP</span>
                                <span>13.814</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>SMA</span>
                                <span>5.328</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>SMK</span>
                                <span>5.601</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>PKBM</span>
                                <span>4.459</span>
                            </div>

                            <h6 class="text-muted mt-4">Guru <span class="float-end text-primary">3.605</span></h6>
                            <hr class="mt-1 mb-2">
                            <div class="d-flex justify-content-between">
                                <span>SKB</span>
                                <span>0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>PAUD</span>
                                <span>284</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>SD</span>
                                <span>1.774</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>SMP</span>
                                <span>788</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>SMA</span>
                                <span>323</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>SMK</span>
                                <span>406</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>PKBM</span>
                                <span>30</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Akreditasi Sekolah</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="chartAkreditasi"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Status PTK</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="chartStatusPTK"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Kondisi Sarpras</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="chartKondisiSarpras"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6>Kualifikasi Guru</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="chartKualifikasiGuru"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container my-5" data-aos="fade-up">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card text-bg-white">
                    <img src="{{ asset('frontend/dummy.png') }}" class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <span class="badge mb-2">
                            <p class="card-title text-white m-0"><i class="fas fa-newspaper"></i> Liputan
                                Utama</p>
                        </span>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset('frontend/dummy.png') }}" class="card-img-top" alt="Liputan 2" />
                    <div class="card-body">
                        <p class="card-text">Lorem ipsum dolor sit amet,
                            consectetur
                            adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                            dolore magn a aliqua. Ut enim ad minim veniam, quis
                            nostrud exercitation ullamco laboris nisi ut
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset('frontend/dummy.png') }}" class="card-img-top" alt="Liputan 2" />
                    <div class="card-body">
                        <p class="card-text">Lorem ipsum dolor sit amet,
                            consectetur
                            adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis
                            nostrud exercitation ullamco laboris nisi ut </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h5 class="text-success fw-bold">Bersama Menuju Masa Depan
                    Berkelanjutan</h5>
                <p class="text-muted">
                    Dengan inovasi dan kolaborasi, University Of Tech Innovation
                    berkontribusi dalam mendorong inovasi dan keberlanjutan demi
                    lingkungan yang lebih baik dan masa depan yang lebih cerah.
                </p>
            </div>

            <div class="marquee-wrapper">
                <div class="marquee-content">
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-12.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-13.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-14.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-15.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-16.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-17.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-12.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-13.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-14.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-15.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-16.jpg" alt>
                    </div>
                    <div class="icon-card"><img src="../sdgs.un.org/sites/default/files/goals/E_SDG_Icons-17.jpg" alt>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5" data-aos="fade-up">
        <div class="riset-card mb-4">
            <h6 class="mb-2">Riset Unggulan</h6>
            <p>Riset Unggulan University Of Tech Innovation adalah kontribusi kami
                dalam perkembangan ilmiah terkini.</p>
            <a href="#" class="text-white text-decoration-underline">Riset Lainnya
                →</a>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-3">
            <a>
                <div class="col">
                    <div class="artikel-card">
                        <img src="{{ asset('frontend/dummy.png') }}" alt="Artikel 1">
                        <div class="artikel-content">
                            <small class="badge badge-success">Artikel Penelitian</small>
                            <h6 class="fw-bold">Konstruksi Bangunan dengan Abu Vulkanik</h6>
                            <small>10 April 2025</small>
                        </div>
                    </div>
                </div>
            </a>
            <a>
                <div class="col">
                    <div class="artikel-card">
                        <img src="{{ asset('frontend/dummy.png') }}" alt="Artikel 2">
                        <div class="artikel-content">
                            <small class="badge badge-success">Artikel Penelitian</small>
                            <h6 class="fw-bold">Potensi Nangka sebagai Bahan Baku Ramah
                                Lingkungan</h6>
                            <small>10 April 2025</small>
                        </div>
                    </div>
                </div>
            </a>
            <a>
                <div class="col">
                    <div class="artikel-card">
                        <img src="{{ asset('frontend/dummy.png') }}" alt="Artikel 3">
                        <div class="artikel-content">
                            <small class="badge badge-success">Artikel Penelitian</small>
                            <h6 class="fw-bold">Mengoptimalkan Pembelajaran Bahasa di Kelas
                                Keperawatan</h6>
                            <small>09 April 2025</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>

    <section class="py-5 bg-light" data-aos="fade-up">
        <div class="container">
            <div class="row g-4">
                <!-- Kartu Program (ulang bagian ini untuk setiap program) -->
                <div class="col-md-4">
                    <div class="edu-card h-100 p-4 bg-white rounded-3 shadow-sm">
                        <h6><i class="fas fa-graduation-cap me-2"></i>Program Diploma</h6>
                        <p class="mb-0">Program Vokasi UTI menawarkan berbagai bidang
                            studi jenjang pendidikan diploma yang berfokus pada pengalaman
                            nyata dan keterampilan praktis yang dibutuhkan dalam dunia
                            kerja.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="edu-card h-100 p-4 bg-white rounded-3 shadow-sm">
                        <h6><i class="fas fa-university me-2 text-success"></i>Program
                            Sarjana</h6>
                        <p class="mb-0">Program Sarjana UTI memberikan pendidikan mendalam
                            pada bidang studi yang dipilih untuk mengembangkan pengetahuan,
                            keterampilan, dan pemikiran analitis untuk sukses di karier dan
                            kehidupan.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="edu-card h-100 p-4 bg-white rounded-3 shadow-sm">
                        <h6><i class="fas fa-user-md me-2 text-success"></i>Program
                            Profesi</h6>
                        <p class="mb-0">Program Profesi UTI menawarkan bidang studi
                            tertentu untuk melatih praktisi dengan pengetahuan mendalam dan
                            keterampilan profesional untuk menghasilkan lulusan
                            spesialis.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="edu-card h-100 p-4 bg-white rounded-3 shadow-sm">
                        <h6><i class="fas fa-lightbulb me-2 text-warning"></i>Program
                            Magister</h6>
                        <p class="mb-0">Program Magister UTI menawarkan bidang studi
                            dengan pendalaman pengetahuan dan penelitian untuk membekali
                            mahasiswa dengan keterampilan lanjutan dan inovasi.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="edu-card h-100 p-4 bg-white rounded-3 shadow-sm">
                        <h6><i class="fas fa-award me-2 text-warning"></i>Program
                            Doktoral</h6>
                        <p class="mb-0">Program Doktoral menawarkan bidang studi yang
                            membawa mahasiswa ke tingkat keahlian tertinggi untuk menjadi
                            pemimpin dalam penelitian ilmiah.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="edu-card h-100 p-4 bg-white rounded-3 shadow-sm">
                        <h6><i class="fas fa-stethoscope me-2 text-success"></i>Program
                            Spesialis</h6>
                        <p class="mb-0">Program Spesialis dan Sub Spesialis memberikan
                            pendidikan dan pelatihan klinis lanjutan untuk lulusan yang
                            terampil dalam diagnosis dan manajemen kesehatan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-5 text-white" style="background: linear-gradient(90deg, #087830, #28a745);">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 fw-bold">Pengumuman</h5>
                </div>
                <a href="#" class="text-white text-decoration-none fw-semibold">
                    Pengumuman Lainnya →
                </a>
            </div>

            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4" data-aos="fade-up">
                <!-- Item 1 -->
                <div class="col-lg-3 card-pengumuman">
                    <a href="#" class="text-white text-decoration-none">
                        <div>
                            <small class="d-block mb-1">Kamis, 13 Maret 2025</small>
                            <p class="mb-0 fw-bold">PENGUMUMAN Nomor :
                                5494/UN5.1.R1/TM.00/2025<br>TATACARA...</p>
                        </div>
                    </a>
                </div>

                <!-- Item 2 -->
                <div class="col-lg-3 card-pengumuman">
                    <a href="#" class="text-white text-decoration-none">
                        <div>
                            <small class="d-block mb-1">Sabtu, 12 Oktober 2024</small>
                            <p class="mb-0 fw-bold">Waspada Modus Penipuan</p>
                        </div>
                    </a>
                </div>

                <!-- Item 3 -->
                <div class="col-lg-3 card-pengumuman">
                    <a href="#" class="text-white text-decoration-none">
                        <div>
                            <small class="d-block mb-1">Rabu, 24 Juli 2024</small>
                            <p class="mb-0 fw-bold">TATACARA PENDAFTARAN ULANG MAHASISWA
                                BARU
                                YAN...</p>
                        </div>
                    </a>
                </div>

                <!-- Item 4 -->
                <div class="col-lg-3 card-pengumuman">
                    <a href="#" class="text-white text-decoration-none">
                        <div>
                            <small class="d-block mb-1">Jumat, 12 Juli 2024</small>
                            <p class="mb-0 fw-bold">Keputusan Rektor Tentang Keringanan Uang
                                Kuliah Tunggal</p>
                        </div>
                    </a>
                </div>

                <!-- Item 5 -->

            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <!-- Judul -->
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center mb-2">
                    <img src="../img.icons8.com/emoji/48/calendar-emoji.png" alt="icon" width="32"
                        class="me-2">
                    <h5 class="fw-bold mb-0 text-success">Agenda Kegiatan</h5>
                </div>
            </div>

            <div class="row">
                <!-- Agenda Kiri -->
                <div class="col-md-8" data-aos="fade-right">
                    <div class="bg-white p-4 rounded-4 shadow-sm">
                        <!-- Agenda Rutin -->
                        <h6 class="text-success fw-semibold mb-3">Agenda Rutin</h6>
                        <div class="d-flex justify-content-between align-items-center border rounded-3 p-3 mb-4">
                            <div class="d-flex align-items-start">
                                <div class="text-center me-3">
                                    <div class="fs-4 fw-bold text-success">21</div>
                                    <div class="text-uppercase text-muted small">Apr</div>
                                </div>
                                <div>
                                    <div class="fw-semibold">Perkuliahan dan Praktikum</div>
                                    <div class="text-muted small">
                                        <i class="fas fa-university fa-1x text-success me-2"></i>
                                        University Of Tech Innovation
                                    </div>
                                </div>
                            </div>
                            <div class="text-end small">
                                <div class="text-muted">Event</div>
                                <div class="fw-medium">21 April - 6 Juni</div>
                                <div class="text-muted">University Of Tech Innovation</div>
                            </div>
                        </div>

                        <!-- Agenda Mendatang -->
                        <h6 class="text-success fw-semibold mb-3">Agenda Mendatang</h6>
                        <div class="d-flex justify-content-between align-items-center border rounded-3 p-3">
                            <div class="d-flex align-items-start">
                                <div class="text-center me-3">
                                    <div class="fs-4 fw-bold text-success">10</div>
                                    <div class="text-uppercase text-muted small">Feb</div>
                                </div>
                                <div>
                                    <div class="fw-semibold">Pelaksanaan Kegiatan MBKM</div>
                                    <div class="text-muted small">
                                        <i class="fas fa-university fa-1x text-success me-2"></i>
                                        University Of Tech Innovation
                                    </div>
                                </div>
                            </div>
                            <div class="text-end small">
                                <div class="text-muted">Event</div>
                                <div class="fw-medium">10 Februari - 30 Mei</div>
                                <div class="text-muted">University Of Tech Innovation</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kalender Kanan -->
                <div class="col-md-4 mt-4 mt-md-0" data-aos="fade-left">
                    <div class="bg-white p-4 rounded-4 shadow-sm text-center">
                        <h6 class="text-success fw-bold">Mei 2025</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="text-muted small">
                                    <tr>
                                        <th>Sn</th>
                                        <th>Sl</th>
                                        <th>Rb</th>
                                        <th>Km</th>
                                        <th>Jn</th>
                                        <th>Sb</th>
                                        <th>Mn</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <tr>
                                        <td>28</td>
                                        <td>29</td>
                                        <td>30</td>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>6</td>
                                        <td>7</td>
                                        <td>8</td>
                                        <td>9</td>
                                        <td>10</td>
                                        <td>11</td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>13</td>
                                        <td>14</td>
                                        <td>15</td>
                                        <td>16</td>
                                        <td>17</td>
                                        <td>18</td>
                                    </tr>
                                    <tr>
                                        <td>19</td>
                                        <td>20</td>
                                        <td>21</td>
                                        <td>22</td>
                                        <td>23</td>
                                        <td>24</td>
                                        <td>25</td>
                                    </tr>
                                    <tr>
                                        <td>26</td>
                                        <td class="bg-success text-white fw-bold rounded">27</td>
                                        <td>28</td>
                                        <td>29</td>
                                        <td>30</td>
                                        <td>31</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>5</td>
                                        <td>6</td>
                                        <td>7</td>
                                        <td>8</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Akreditasi Sekolah (Bar)
        new Chart(document.getElementById('chartAkreditasi'), {
            type: 'bar',
            data: {
                labels: ['A', 'B', 'C', 'Belum Terakreditasi'],
                datasets: [{
                    label: 'Jumlah Sekolah',
                    data: [30, 45, 15, 10],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Status PTK (Bar)
        new Chart(document.getElementById('chartStatusPTK'), {
            type: 'bar',
            data: {
                labels: ['PNS', 'Honorer', 'GTY'],
                datasets: [{
                    label: 'Jumlah PTK',
                    data: [1200, 800, 500],
                    backgroundColor: ['#0093dd', '#17a2b8', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Kondisi Sarpras (Bar)
        new Chart(document.getElementById('chartKondisiSarpras'), {
            type: 'bar',
            data: {
                labels: ['Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat'],
                datasets: [{
                    label: 'Jumlah Sarpras',
                    data: [200, 100, 60, 20],
                    backgroundColor: ['#28a745', '#ffc107', '#fd7e14', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Kualifikasi Guru (Bar)
        new Chart(document.getElementById('chartKualifikasiGuru'), {
            type: 'bar',
            data: {
                labels: ['SMA', 'D3', 'S1', 'S2'],
                datasets: [{
                    label: 'Jumlah Guru',
                    data: [100, 200, 800, 100],
                    backgroundColor: ['#6c757d', '#17a2b8', '#0093dd', '#6610f2']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
