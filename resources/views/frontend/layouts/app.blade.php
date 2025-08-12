<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? '' }} | SERASI - Sistem Perencanaan Terintegrasi</title>
    <meta name="description"
        content="{{ $pengaturan['site_description'] ?? 'Tata Kelola Pendidikan Dengan Sistem Perencanaan Terintegrasi (SERASI) Kabupaten Teluk Bintuni' }}">
    <meta name="author" content="{{ $pengaturan['author'] ?? 'Admin' }}">
    <meta name="keywords" content="{{ $pengaturan['keywords'] ?? 'sekolah, pendidikan, bintuni' }}">
    <link rel="icon" sizes="16x16"
        href="{{ asset($pengaturan['favicon_16'] ?? 'themes/frontend/logoserasi.png') }}">
    <link rel="icon" sizes="32x32"
        href="{{ asset($pengaturan['favicon_32'] ?? 'themes/frontend/logoserasi.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset($pengaturan['favicon_apple'] ?? 'themes/frontend/logoserasi.png') }}">
    <link rel="icon" sizes="192x192"
        href="{{ asset($pengaturan['favicon_android_192'] ?? 'themes/frontend/logoserasi.png') }}">
    <link rel="icon" sizes="512x512"
        href="{{ asset($pengaturan['favicon_android_512'] ?? 'themes/frontend/logoserasi.png') }}">

    @include('frontend.layouts.style')
    @livewireStyles
</head>

<body class="bg-light">

    @if (!Request::is('/'))
        <section class="identity-section mb-4 mt-5">
            <div class="container">
                <div class="identity-content">
                    <h1 class="text-white fw-bold" data-aos="fade-up">{{ $title ?? '' }}</h1>
                    <p class="text-white mb-4" data-aos="fade-up">{{ $subtitle ?? '' }}</p>
                </div>
            </div>
        </section>
    @endif

    <!-- Main Navbar untuk desktop -->
    @include('frontend.layouts.navbar')

    {{-- body here --}}
    @yield('content')

    {{-- Footer --}}
    @include('frontend.layouts.footer')


    @include('frontend.layouts.script')
    @livewireScripts

</body>

</html>
