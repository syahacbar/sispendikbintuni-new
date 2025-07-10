@extends('frontend.layouts.app')

@section('content')
    <section class="about-section">
        <div class="container">
            <div class="row my-3">
                <div class="card mt-3">
                    <div class="card-body">
                        @forelse($tentangData as $key => $value)
                            <h4 class="text-capitalize">{{ str_replace('_', ' ', $key) }}</h4>
                            <div>{!! $value !!}</div>
                        @empty
                            <p>Konten tentang belum tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
