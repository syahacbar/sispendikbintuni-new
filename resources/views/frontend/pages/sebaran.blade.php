@extends('frontend.layouts.app')
@section('content')
    <section class="about-section">
        <div class="container">
            <div class="text-center mb-4">
                <h3 class="text-success fw-bold">{{ $title }}</h3>
                <p class="text-muted">{{ $subtitle }}</p>
            </div>
            <div id="map" style="height: 600px;"></div>
        </div>
    </section>


    <script>
        var map = L.map('map').setView([-2.2, 133.55], 9);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const icons = {
            SD: new L.Icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41]
            }),
            SMP: new L.Icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41]
            }),
            SMA: new L.Icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41]
            }),
            DEFAULT: new L.Icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41]
            }),
        };

        const schools = @json($sekolah);
        const markers = L.markerClusterGroup();

        schools.forEach(school => {
            const lat = parseFloat(school.lintang);
            const lng = parseFloat(school.bujur);

            if (!isNaN(lat) && !isNaN(lng)) {
                const icon = icons[school.jenjang] || icons.DEFAULT;

                const popupContent = `
                <strong>${school.nama}</strong><br>
                <b>NPSN:</b> ${school.npsn}<br>
                <b>Bentuk Pendidikan:</b> ${school.jenjang}<br>
                <b>Status:</b> ${school.status_sekolah}<br>
                <b>Alamat:</b> ${school.alamat_jalan ?? '-'}<br>
                <b>Kecamatan:</b> ${school.kecamatan ?? '-'}<br>
                <b>Kabupaten:</b> ${school.kabupaten ?? '-'}<br>
                <b>Provinsi:</b> ${school.provinsi ?? '-'}<br>
                <b>Lintang:</b> ${school.lintang}<br>
                <b>Bujur:</b> ${school.bujur}
            `;

                var marker = L.marker([lat, lng], {
                    icon: icon
                }).bindPopup(popupContent);
                markers.addLayer(marker);
            }
        });

        map.addLayer(markers);
    </script>
@endsection
