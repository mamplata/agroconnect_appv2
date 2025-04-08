<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            @if (session('status'))
                <div class="alert {{ session('status_type') == 'success' ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show mb-4"
                    role="alert">
                    <strong>{{ session('status') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <!-- Welcome Card -->
                <div class="col-md-12 d-flex justify-content-center align-items-center">
                    <div class="card mb-4 shadow-lg border-0 rounded-lg w-100">
                        <div class="card-header bg-primary text-white rounded-top">
                            <h5 class="font-semibold text-lg text-center">Welcome, {{ Auth::user()->name }}!</h5>
                        </div>
                        <div class="card-body">
                            <p>You are logged in as an Agriculturist/Encoder.</p>
                            <p>
                                This system allows users to encode and manage data, ensuring the public site provides
                                accurate and reliable information. Every user can contribute, modify, and access data
                                while ensuring transparency and accountability for any changes.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Weather Forecast Section Removed -->
            </div>
            <h3 class="font-semibold text-lg mb-4 text-center">Key Features</h3>

            <div class="row g-4">
                <div class="col-md-4 d-flex">
                    <div class="card border-0 shadow w-100 d-flex flex-column" style="background-color: white;">
                        <div class="card-body text-center flex-grow-1">
                            <h5 class="card-title fw-bold">🌱 Crops</h5>
                            <p class="card-text">
                                Access and manage data about crop information, ensuring detailed and
                                up-to-date records.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex">
                    <div class="card border-0 shadow w-100 d-flex flex-column">
                        <div class="card-body text-center flex-grow-1">
                            <h5 class="card-title fw-bold">📊 Crop Reports</h5>
                            <p class="card-text">
                                Manage reports such as productivity, prices, and other key insights to monitor trends.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex">
                    <div class="card border-0 shadow w-100 d-flex flex-column">
                        <div class="card-body text-center flex-grow-1">
                            <h5 class="card-title fw-bold">🌪️ Damage Reports</h5>
                            <p class="card-text">
                                Record and review damage reports due to pests, diseases, or natural
                                disasters like typhoons.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="/manage-crop" class="btn btn-dark btn-lg px-5 py-3">
                    Get Started <i class="bi bi-arrow-right-circle ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
