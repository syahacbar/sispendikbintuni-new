<link href="{{ asset('themes/frontend/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('themes/frontend/css/styles.css') }}" />
<link rel="stylesheet" href="{{ asset('themes/frontend/css/aos.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<link href="https://cdn.datatables.net/columncontrol/1.0.6/css/columnControl.dataTables.min.css" rel="stylesheet">

<!-- DataTables core CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Add-ons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<!-- Marker Cluster CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

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

    #calendar {
        background-color: #1e293b;
        color: #f8fafc;
        padding: 1rem;
        border-radius: 0.5rem;
    }

    .fc {
        background-color: #1e293b;
        color: #f8fafc;
    }

    .fc .fc-toolbar-title {
        color: #f1f5f9;
    }

    .fc .fc-button {
        background-color: #334155;
        border-color: #334155;
        color: #f8fafc;
    }

    .fc .fc-button:hover {
        background-color: #475569;
    }

    .fc .fc-daygrid-day-number {
        color: #cbd5e1;
    }

    .fc .fc-day-today {
        background-color: #0f172a !important;
    }

    h5.fw-bold.text-teal.mb-4 {
        color: #da251c !important;
    }

    /* Ganti ikon panah default dengan ikon plus */
    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
        content: '\002B';
        /* background-color: #0394dd;
        color: #fff;
        border-radius: 50%;
        width: 1.5em;
        height: 1.5em;
        line-height: 1.5em;
        display: flex;
        align-items: center;
        justify-content: center; */
    }

    td.dtr-control.sorting_1 {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr.parent>th.dtr-control:before {
        content: '\2212';
        background-color: #dc3545;
    } */

    table#dataSekolah *,
    table.dataTable>tbody>tr.child ul.dtr-details * {
        font-size: 1rem;
    }

    table.dataTable tbody th,
    table.dataTable tbody td {
        padding: 4px 8px;
    }
</style>
