
    <script src="{{ asset('themes/frontend/js/aos.js') }}"></script>
    <script src="{{ asset('themes/frontend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('themes/frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.datatables.net/columncontrol/1.0.6/js/dataTables.columnControl.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataSekolah').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                target: 0,
                buttons: [
                    {
                        extend: 'colvis',
                        text: '☰ Column Control',
                        collectionLayout: 'fixed two-column',
                        columns: ':gt(0)'
                    }
                ]
            });
            $('#dataPTK').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                target: 0,
                buttons: [
                    {
                        extend: 'colvis',
                        text: '☰ Column Control',
                        collectionLayout: 'fixed two-column',
                        columns: ':gt(0)'
                    }
                ]
            });
            $('#dataSiswa').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                target: 0,
                buttons: [
                    {
                        extend: 'colvis',
                        text: '☰ Column Control',
                        collectionLayout: 'fixed two-column',
                        columns: ':gt(0)'
                    }
                ]
            });
        });
    </script>

    <script>
        var map = L.map('map').setView([-2.2, 133.55], 9);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const icons = {
            SD: new L.Icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
            }),
            SMP: new L.Icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
            }),
            SMA: new L.Icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
            })
        };

        var schools = Array.from({ length: 100 }, (_, i) => {
            const jenjangList = ['SD', 'SMP', 'SMA'];
            const distrikList = ['Babo', 'Manimeri', 'Merdey', 'Moskona', 'Wamesa', 'Tembuni', 'Kuri', 'Aranday'];
            const jenjang = jenjangList[i % 3];
            const distrik = distrikList[i % distrikList.length];

            return {
                nama: `${jenjang} Negeri ${i + 1}`,
                alamat: `Jl. Pendidikan No.${i + 1}, Distrik ${distrik}`,
                jenjang: jenjang,
                lat: -2.0 + Math.random() * -1, 
                lng: 133.3 + Math.random() * 0.6
            };
        });

        var markers = L.markerClusterGroup();
        schools.forEach(school => {
            var marker = L.marker([school.lat, school.lng], {
                icon: icons[school.jenjang] || icons.SD
            }).bindPopup(`<b>${school.nama}</b><br>${school.alamat}<br><i>Jenjang: ${school.jenjang}</i>`);

            markers.addLayer(marker);
        });

        map.addLayer(markers);
    </script>

    <script>
        AOS.init({
            once: true, 
            duration: 1000 
        });
    </script>


    <script>
    const toggleBtn = document.getElementById('toggleMenuBtn');
    const mainNavbar = document.getElementById('mainNavbar');

    toggleBtn.addEventListener('click', () => {
      mainNavbar.classList.toggle('show-navbar');

      if (mainNavbar.classList.contains('show-navbar')) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 600,
            events: [
                {
                    title: 'Test Dummy',
                    start: '2025-06-26',
                    color: '#28a745'
                },
                {
                    title: 'Hari Pertama Masuk Sekolah',
                    start: '2025-06-26',
                    color: '#28a745'
                },
                {
                    title: 'Sepak Bola Online',
                    start: '2025-06-29',
                    color: '#28a745'
                },
                {
                    title: 'Hari Pertama Masuk Sekolah',
                    start: '2025-07-15',
                    color: '#28a745'
                },
                {
                    title: 'Ujian Semester Ganjil',
                    start: '2025-12-02',
                    end: '2025-12-06',
                    color: '#ffc107'
                },
                {
                    title: 'Libur Semester',
                    start: '2025-12-20',
                    end: '2026-01-04',
                    color: '#dc3545'
                }
            ]
        });

        calendar.render();
    });
    </script>
    <script>
        const ctxSemua = document.getElementById('semuaSekolahChart').getContext('2d');
        const semuaSekolahChart = new Chart(ctxSemua, {
            type: 'bar',
            data: {
                labels: ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'],
                datasets: [{
                    label: 'Jumlah Sekolah',
                    data: [113, 138, 59, 18, 24, 21],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(0, 123, 255, 0.8)',
                        'rgba(108, 117, 125, 0.8)',
                        'rgba(33, 37, 41, 0.8)',
                        'rgba(23, 162, 184, 0.8)'
                    ],
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} Sekolah`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 20 }
                    }
                }
            }
        });

        let negeriChartRendered = false;
        let swastaChartRendered = false;

        document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function (event) {
                const target = event.target.getAttribute('data-bs-target');

                if (target === '#nav-sekolahNegeri' && !negeriChartRendered) {
                    const ctxNegeri = document.getElementById('sekolahNegeriChart').getContext('2d');
                    new Chart(ctxNegeri, {
                        type: 'bar',
                        data: {
                            labels: ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'],
                            datasets: [{
                                label: 'Jumlah Sekolah',
                                data: [10, 12, 10, 18, 24, 21],
                                backgroundColor: [
                                    'rgba(40, 167, 69, 0.8)',
                                    'rgba(220, 53, 69, 0.8)',
                                    'rgba(0, 123, 255, 0.8)',
                                    'rgba(108, 117, 125, 0.8)',
                                    'rgba(33, 37, 41, 0.8)',
                                    'rgba(23, 162, 184, 0.8)'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: true },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => ` ${ctx.parsed} Sekolah`
                                    }
                                }
                            }
                        }
                    });
                    negeriChartRendered = true;
                }

                if (target === '#nav-sekolahSwasta' && !swastaChartRendered) {
                    const ctxSwasta = document.getElementById('sekolahSwastaChart').getContext('2d');
                    new Chart(ctxSwasta, {
                        type: 'bar',
                        data: {
                            labels: ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'],
                            datasets: [{
                                label: 'Jumlah Sekolah',
                                data: [5, 7, 3, 5, 6, 4],
                                backgroundColor: 'rgba(0, 123, 255, 0.8)',
                                borderColor: 'rgba(0, 123, 255, 1)',
                                fill: false,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: true }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                    swastaChartRendered = true;
                }
            });
        });
    </script>