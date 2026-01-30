@extends('frontend.layouts.app')

@section('content')
    <!-- Build Assets for Tailwind -->
    @vite(['resources/css/tailwind.css'])

    <section class="container my-5">
        <h1 class="text-center mb-5">Comparison: Bootstrap vs Tailwind</h1>

        <div class="row">
            <!-- Bootstrap Example (Standard) -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="m-0">Bootstrap Card</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            This is a standard Bootstrap card. It uses classes like <code>card</code>,
                            <code>bg-primary</code>, and <code>text-white</code>.
                        </p>
                        <button class="btn btn-primary">Bootstrap Button</button>
                    </div>
                </div>
            </div>

            <!-- Tailwind Example (New) -->
            <div class="col-md-6">
                <!-- Using tw- prefix to avoid conflicts -->
                <div
                    class="tw-bg-white tw-rounded-lg tw-shadow-md tw-h-full tw-overflow-hidden tw-border tw-border-gray-200">
                    <div class="tw-bg-blue-600 tw-p-4 tw-text-white">
                        <h5 class="tw-m-0 tw-text-lg tw-font-bold">Tailwind Card</h5>
                    </div>
                    <div class="tw-p-4">
                        <p class="tw-mb-4 tw-text-gray-700">
                            This is a Tailwind card. It uses utility classes like <code>tw-rounded-lg</code>,
                            <code>tw-shadow-md</code>, and custom colors.
                        </p>
                        <button
                            class="tw-bg-blue-600 hover:tw-bg-blue-700 tw-text-white tw-font-bold tw-py-2 tw-px-4 tw-rounded tw-transition tw-duration-300">
                            Tailwind Button
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div
                    class="tw-p-6 tw-bg-gradient-to-r tw-from-cyan-500 tw-to-blue-500 tw-rounded-xl tw-text-white tw-shadow-xl">
                    <h2 class="tw-text-2xl tw-font-bold tw-mb-2">This is a Tailwind Gradient Banner</h2>
                    <p>
                        Created using <code>tw-bg-gradient-to-r tw-from-cyan-500 tw-to-blue-500</code>.
                        It sits inside a Bootstrap Grid Column (<code>col-12</code>), showing they can work together!
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection