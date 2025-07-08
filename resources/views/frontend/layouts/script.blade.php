<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('themes/frontend/js/aos.js') }}"></script>
<script src="{{ asset('themes/frontend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

<script>
    AOS.init({
        once: true,
        duration: 1000
    });
</script>

<script>
    $(document).ready(function() {
        $('#dataSekolahByKecamatan').DataTable({
            responsive: true,
            dom: 'Blfrtip',
            ordering: false
        });

        $('#dataKecamatan').DataTable({
            responsive: true,
            dom: 'Blfrtip',
            ordering: false
        });

        $('#dataSarpras').DataTable({
            responsive: true,
            dom: 'Blfrtip',
            ordering: false
        });
    });
</script>

<script>
    $(document).ready(function() {
        const tableIds = [
            '#dataSekolah',
            '#dataSekolahByKecamatan',
            '#dataSiswa',
            '#dataKondisiGuru',
            '#dataKondisiTendik',
            '#dataRombel',
            '#DirektoriPTK',
            '#DirektoriPesertaDidik'
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
</script>


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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'spacelab',
            height: 600,
            events: [{
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
