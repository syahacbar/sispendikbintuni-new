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