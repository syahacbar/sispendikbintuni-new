<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sispendik Kabupaten Bintuni</title>
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


    @include('frontend.layouts.mobilefooter')
    @include('frontend.layouts.script')
    @livewireScripts

</body>

</html>
