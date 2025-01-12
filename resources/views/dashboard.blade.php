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
                <div class="col-md-6 d-flex">
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

                <div class="col-md-6 mb-4">
                    <div id="forecast">
                        @php
                            $forecastDay = $weatherData['DailyForecasts'][0];
                            $date = \Carbon\Carbon::parse($forecastDay['Date']);
                            $formattedDate = $date->format('l, F j, Y');
                            $iconCode = str_pad($forecastDay['Day']['Icon'], 2, '0', STR_PAD_LEFT);
                            $iconUrl = "https://developer.accuweather.com/sites/default/files/{$iconCode}-s.png";
                        @endphp

                        <div class="card shadow border-0">
                            <div class="card-header bg-primary text-white text-center rounded-top">
                                <h3 class="font-semibold text-lg text-center">🌦️ <strong>Today's Weather</strong> 🌦️
                                </h3>
                            </div>
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <h5 class="mb-2 text-center"><strong>{{ $formattedDate }}</strong></h5>
                                    <div class="col icon-section d-flex flex-column align-items-center">
                                        <img width="150px" src="{{ $iconUrl }}"
                                            alt="{{ $forecastDay['Day']['IconPhrase'] }}"
                                            class="weather-icon img-fluid cursor-pointer" style="cursor: pointer;"
                                            data-bs-toggle="tooltip" title="{{ $forecastDay['Day']['IconPhrase'] }}">
                                        <span
                                            class="text-center"><strong>{{ $forecastDay['Day']['IconPhrase'] }}</strong></span>
                                    </div>
                                    <div class="col-md-8">
                                        <ul class="list-group list-group-flush">
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong><span><i class="fas fa-temperature-high text-danger me-2"></i>
                                                        Max Temperature</span></strong>
                                                <strong><span
                                                        class="badge bg-danger rounded-pill">{{ $forecastDay['Temperature']['Maximum']['Value'] }}°C</span></strong>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong><span><i class="fas fa-temperature-low text-primary me-2"></i>
                                                        Min Temperature</span></strong>
                                                <strong><span
                                                        class="badge bg-primary rounded-pill">{{ $forecastDay['Temperature']['Minimum']['Value'] }}°C</span></strong>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong><span><i class="fas fa-tint text-info me-2"></i> Average
                                                        Humidity</span></strong>
                                                <strong><span
                                                        class="badge bg-info rounded-pill">{{ $forecastDay['Day']['RelativeHumidity']['Average'] }}%</span></strong>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong><span><i class="fas fa-cloud-rain text-primary me-2"></i> Rain
                                                        Probability</span></strong>
                                                <strong><span
                                                        class="badge bg-primary rounded-pill">{{ $forecastDay['Day']['RainProbability'] }}%</span></strong>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong><span><i class="fas fa-wind text-muted me-2"></i> Wind
                                                        Speed</span></strong>
                                                <strong><span
                                                        class="badge bg-secondary rounded-pill">{{ $forecastDay['Day']['Wind']['Speed']['Value'] }}
                                                        km/h</span></strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
