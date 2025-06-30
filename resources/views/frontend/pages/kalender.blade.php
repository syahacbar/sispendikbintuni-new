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
                        Kalender Pendidikan
                    </li>
                </ol>
            </nav>
            <h1 class="text-white fw-bold" data-aos="fade-up">Kalender Pendidikan</h1>
            <p class="text-warning mb-4" data-aos="fade-up">Kalender Pendidikan Kabupaten Teluk Bintuni</p>
        </div>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="text-center mb-4">
                <h3 class="text-success fw-bold">
                    Kalender Pendidikan
                </h3>
                <p class="text-muted">
                    Kalender Pendidikan Se-Kabupaten Teluk Bintuni
                </p>
            </div>
        </div>
        <div class="row my-3">
            <div id="calendar" class="my-4"></div>
        </div>
    </div>
</section>

@endsection