<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
    <title>AgroConnect Cabuyao</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Add Chart.js -->
    <link rel="stylesheet" href="{{ asset('css/weather_forecasts.css') }}">
</head>

<body>
    @include('header')

    <main class="main-content mx-0 w-100">
        <div class="container my-5">
            <div style="background-color: #f1f1f1" class="card w-100 shadow-sm">
                <div class="bg-header">
                    <h1 class="forecast-title text-center">5-Day Forecast for Cabuyao, Laguna, Philippines</h1>
                </div>
                <div class="container-fluid p-5">
                    <div class="content">
                        <h3 class="text-center mb-4">
                            <i class="fas fa-cloud"></i> <!-- Icon -->
                            Headline: {{ $weatherData['Headline']['Text'] ?? 'N/A' }}
                        </h3>

                        <!-- 5-Day Forecast -->
                        <div class="forecast-container">
                            <div id="forecast"
                                class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 d-flex justify-content-center align-items-center">
                                <!-- Dynamically inserted forecast cards will appear here -->
                            </div>
                        </div>
                        <div class="chart-container mt-5">
                            <!-- Chart Selection Section (Placed Above the Chart) -->
                            <div class="chart-controls mt-3 text-center">
                                <h3 class="chart-title">Weather Forecast Chart (Temperature)</h3>
                                <div>
                                    <button id="selectAll" class="btn btn-primary mx-2">Select All</button>
                                    <button id="unselectAll" class="btn btn-secondary mx-2">Unselect All</button>
                                </div>
                                <div id="datasetControls" class="mt-2">
                                    <label><input type="checkbox" data-dataset="0" checked> Max Temperature</label>
                                    <label><input type="checkbox" data-dataset="1" checked> Min Temperature</label>
                                    <label><input type="checkbox" data-dataset="2" checked> Humidity</label>
                                    <label><input type="checkbox" data-dataset="3" checked> Rain Probability</label>
                                    <label><input type="checkbox" data-dataset="4" checked> Wind Speed</label>
                                </div>
                            </div>

                            <!-- Chart Display Section -->
                            <div class="chart-wrapper mt-5">
                                <canvas id="forecastChart"></canvas>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </main>
    <script>
        const weatherData = @json($weatherData);
    </script>
    <script src="{{ asset('js/weather_forecasts.js') }}"></script>
    @include('footer')
</body>

</html>
