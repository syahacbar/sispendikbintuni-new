@extends('frontend.layouts.app')

@section('content')
    <section class="about-section">
        <div class="container">
            <div class="row my-3">
                <div class="col-lg-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    {!! $pengaturan['tentang_web'] ?? '' !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
