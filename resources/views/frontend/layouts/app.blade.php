<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sispendik Kabupaten Bintuni</title>
    <!-- Favicon 16x16 (Browser) -->
<link rel="icon" sizes="16x16" href="{{ asset('favicon-16x16.ico') }}">

<!-- Favicon 32x32 (Browser) -->
<link rel="icon" sizes="32x32" href="{{ asset('favicon-32x32.ico') }}">

<!-- Favicon untuk Apple (iOS) -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

<!-- Favicon untuk Android -->
<link rel="icon" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
<link rel="icon" sizes="512x512" href="{{ asset('android-chrome-512x512.png') }}">

    @include('frontend.layouts.style')
    @livewireStyles
</head>

<body class="bg-light">

    @if (!Request::is('/'))
        <section class="identity-section mb-4 mt-5">
            <div class="container">
                <div class="identity-content">
                    <h1 class="text-white fw-bold" data-aos="fade-up">{{ $title ?? '' }}</h1>
                    <p class="text-warning mb-4" data-aos="fade-up">{{ $subtitle ?? '' }}</p>
                </div>
            </div>
        </section>
    @endif

    <!-- Main Navbar untuk desktop -->
    @include('frontend.layouts.navbar')
    @include('frontend.layouts.mobilelogo')

    {{-- body here --}}
    @yield('content')

    {{-- Footer --}}
    @include('frontend.layouts.footer')


    @include('frontend.layouts.mobilemenu')
    @include('frontend.layouts.script')
    @livewireScripts

</body>

</html>
