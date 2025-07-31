<script data-navigate-once src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script data-navigate-once src="{{ asset('themes/frontend/js/aos.js') }}"></script>
<script data-navigate-once src="{{ asset('themes/frontend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script data-navigate-once src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
{{-- <script data-navigate-once  src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script> --}}
{{-- <script data-navigate-once  src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script> --}}
{{-- <script data-navigate-once  src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script> --}}
<script data-navigate-once src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script data-navigate-once src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script data-navigate-once src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

<script data-navigate-once src="https://unpkg.com/osmtogeojson@3.0.0/osmtogeojson.js"></script>

<script>
    AOS.init({
        once: true,
        duration: 1000
    });
</script>

<!-- untuk peta sebaran -->
<script>
    var map = L.map('map').setView([-2.2, 133.55], 9);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const icons = {
        TK: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        KB: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        TPA: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-grey.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        SPS: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),

        PKBM: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        SKB: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        SD: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        SMP: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        SMA: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        SMK: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        SLB: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),

        DEFAULT: new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
    };

    const schools =
        @if (isset($sekolah) && !empty($sekolah))
            @json($sekolah)
        @else
            null
        @endif ;

    const markers = L.markerClusterGroup();

    schools.forEach(school => {
        const lat = parseFloat(school.latitude);
        const lng = parseFloat(school.longitude);

        // Ambil kurikulum pertama, jika ada
        const firstKurikulum = school.rombongan_belajars?.[0]?.kurikulum?.kode || '-';

        if (!isNaN(lat) && !isNaN(lng)) {
            const icon = icons[school.kode_jenjang] || icons.DEFAULT;

            const popupContent = `
            <strong>${school.nama}</strong><br>
            <b>NPSN:</b> ${school.npsn}<br>
            <b>Bentuk Pendidikan:</b> ${school.kode_jenjang}<br>
            <b>Status:</b> ${school.status}<br>
            <b>Kurikulum:</b> ${firstKurikulum} <br>
            <b>Koordinat:</b> ${school.latitude}, ${school.longitude}
        `;

            const marker = L.marker([lat, lng], {
                icon: icon
            }).bindPopup(popupContent);
            markers.addLayer(marker);
        }
    });


    map.addLayer(markers);

    //Batas administratif Kab. Teluk Bintuni dari Overpass API
    fetch('/assets/geo/92.06_Teluk_Bintuni.geojson')
        .then(res => res.json())
        .then(geojson => {
            L.geoJSON(geojson, {
                style: {
                    color: '#0093dd',
                    weight: 2,
                    fillColor: '#0093dd',
                    fillOpacity: 0.2
                }
            }).addTo(map);
        })
        .catch(error => {
            console.error('Gagal memuat GeoJSON Bintuni:', error);
        });
</script>

<script>
    $(document).ready(function() {
        $('#DirektoriPTK').DataTable({
            responsive: true
        });
        $('#DirektoriPesertaDidik').DataTable({
            responsive: true
        });

        $('#dataSekolahByKecamatan').DataTable({
            responsive: true,
            scrollX: true
        });
        $('#dataSekolah').DataTable({
            responsive: true,
            scrollX: true
        });
        $('#dataKondisiGuru').DataTable({
            responsive: true,
            scrollX: true
        });

        $('#dataKondisiTendik').DataTable({
            responsive: true,
            scrollX: true
        });

        $('#dataRombel').DataTable({
            responsive: true,
            scrollX: true
        });

        $('#dataSarpras').DataTable({
            responsive: true,
            scrollX: true
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust()
                .responsive.recalc();
        });
    });
</script>

{{-- <script>
    $(document).ready(function() {
        const tableIds = [
            // '#dataSekolah',
            '#dataSekolahByKecamatan',
            '#dataSiswa',
        ];

        tableIds.forEach(function(id) {
            if ($(id).length && $(id + ' thead th').length === $(id + ' tbody tr:first td').length) {
                $(id).DataTable({
                    responsive: true,
                    dom: 'Blfrtip',
                    ordering: false
                });
            }
        });
    });
</script> --}}


<script>
    const toggleBtn = document.getElementById('toggleMenuBtn');
    const mainNavbar = document.getElementById('mainNavbar');

    toggleBtn.addEventListener('click', () => {
        mainNavbar.classList.toggle('show-navbar');

        if (mainNavbar.classList.contains('show-navbar')) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    });
</script>
