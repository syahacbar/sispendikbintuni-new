@extends('frontend.layouts.app')
@section('content')
    <section class="about-section">
        <div class="container">
            <div class="row my-3">
                <div id="calendar" class="my-4"></div>
            </div>
        </div>
    </section>

    <!-- Modal Detail Kegiatan -->
    <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="eventDetailModalLabel">Detail Kegiatan</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama:</strong> <span id="eventTitle"></span></p>
                    <p><strong>Deskripsi:</strong> <span id="eventDescription"></span></p>
                    <p><strong>Waktu:</strong> <span id="eventTime"></span></p>
                    <p><strong>Tanggal:</strong> <span id="eventDate"></span></p>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'spacelab',
            height: 600,
            events: {!! json_encode($events) !!},

            eventClick: function(info) {
                document.getElementById('eventTitle').textContent = info.event.title;
                document.getElementById('eventDescription').textContent = info.event.extendedProps
                    .description || '-';

                const startDate = new Date(info.event.start).toLocaleDateString('id-ID');
                const endDate = info.event.end ? new Date(info.event.end).toLocaleDateString(
                    'id-ID') : '';
                document.getElementById('eventDate').textContent = endDate ?
                    `${startDate} - ${endDate}` : startDate;

                document.getElementById('eventTime').textContent =
                    `${info.event.extendedProps.jam_mulai ?? '-'} - ${info.event.extendedProps.jam_akhir ?? '-'}`;

                var modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
                modal.show();
            }
        });

        calendar.render();
    });
</script>
