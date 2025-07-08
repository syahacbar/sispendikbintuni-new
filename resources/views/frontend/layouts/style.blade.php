<link rel="stylesheet" href="{{ asset('themes/frontend/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('themes/frontend/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('themes/frontend/css/aos.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />

<style>
    .w-5 {
        width: 5%
    }

    .w-15 {
        width: 15%
    }

    .w-85 {
        width: 85%
    }

    .btnLogin {
        color: #856404;
        background-color: #cee22a;
        border-color: #0093dd;
    }

    .btnLogin:hover {
        color: #856404 !important;
        background-color: #cee22a !important;
        border-color: #0093dd !important;
    }

    #map {
        height: 600px;
        width: 100%;
    }

    .fc .fc-col-header-cell-cushion {
        display: inline-block;
        padding: 2px 4px;
        text-decoration: none;
    }

    fc-daygrid-day-top a {
        text-decoration: none !important;
    }

    /* Ganti ikon panah default dengan ikon plus */
    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
        content: '\002B';
    }

    td.dtr-control.sorting_1 {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    table#dataSekolah *,
    table.dataTable>tbody>tr.child ul.dtr-details * {
        font-size: 1rem;
    }

    table.dataTable tbody th,
    table.dataTable tbody td {
        padding: 4px 8px;
    }

    div#dataSekolah_length,
    div#dataSekolah_filter,
    div#dataKecamatan_length,
    div#dataKecamatan_filter {
        margin-bottom: 1rem;
    }

    footer li a:hover {
        color: #0394dd !important;
    }

    footer img {
        width: 70px;
        height: auto;
    }

    @media (max-width: 576px) {
        .col-lg-7.mt-4.mt-md-0 .col-lg-4 {
            width: 33.33%;
        }
    }
</style>
