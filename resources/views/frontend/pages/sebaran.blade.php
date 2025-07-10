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
@endsection
