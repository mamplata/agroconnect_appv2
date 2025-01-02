<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
    <title>AgroConnect Cabuyao</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Add Chart.js -->
    <style>
        /* Background for the page with a natural, earthy texture */
        .bg-header {
            background-color: #6c8e57;
            /* Olive green */
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
            border-radius: 10px 10px 0 0;
            background-image: url('https://www.transparenttextures.com/patterns/wood-pattern.png');
            background-size: cover;
        }

        .forecast-container {
            margin-top: 2rem;
        }

        .card-title {
            font-size: 1.25rem;
            color: #2f4f4f;
            font-weight: bold;
        }

        .icon-section img {
            width: 150px;
            height: 90px;
            transition: transform 0.3s ease;
        }

        .icon-section img:hover {
            transform: scale(1.1);
            /* Slight zoom effect on hover */
        }

        .forecast-card .card-body {
            padding: 1.5rem;
            text-align: center;
            color: #333;
            font-weight: 700;
        }

        .forecast-card {
            border-radius: 20px;
            background-color: #f8f8f8 !important;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease !important;
        }

        .forecast-card:hover {
            transform: translateY(-12px) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2) !important;
        }

        .forecast-title {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .metrics span {
            font-size: 1.1rem;
        }

        /* Chart container */
        .chart-container {
            margin-top: 2rem;
            text-align: center;
        }

        .chart-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    @include('header')

    <main class="main-content mx-0 w-100">
        <div class="container my-5">
            <div style="background-color: #f1f1f1" class="card w-100 shadow-sm">
                <div class="bg-header">
                    <h1 class="forecast-title">5-Day Forecast for Cabuyao, Laguna, Philippines</h1>
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

                        <!-- Weather Forecast Chart Section -->
                        <div class="chart-container">
                            <h3 class="chart-title">Weather Forecast Chart (Temperature)</h3>
                            <canvas id="forecastChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const weatherData = @json($weatherData);
            console.log(weatherData);

            // 5-Day Forecast Data
            const forecastContainer = document.getElementById('forecast');
            weatherData.DailyForecasts.forEach((forecastDay) => {
                const dayCard = document.createElement('div');
                const date = new Date(forecastDay.Date);
                const formattedDate = date.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                });

                // Generate the icon URL
                const iconCode = forecastDay.Day.Icon;
                const iconUrl =
                    `https://developer.accuweather.com/sites/default/files/${("0" + iconCode).slice(-2)}-s.png`;

                // Build the HTML content for the forecast card
                dayCard.innerHTML = `
                    <div class="col">
                        <div class="card forecast-card">
                            <div class="card-body">
                                <h5 class="card-title">${formattedDate}</h5>
                                <div class="row d-flex align-items-center justify-content-around">
                                    <div class="col icon-section d-flex flex-column align-items-center">
                                        <img src="${iconUrl}" alt="${forecastDay.Day.IconPhrase}" class="weather-icon img-fluid">
                                        <span class="text-center">${forecastDay.Day.IconPhrase}</span>
                                    </div>
                                    <div class="col metrics">
                                        <div class="d-flex">
                                            <span><i class="fas fa-temperature-high me-2 text-danger"></i>${forecastDay.Temperature.Maximum.Value}°C</span>
                                        </div>
                                        <div class="d-flex">
                                            <span><i class="fas fa-temperature-low me-2 text-primary"></i>${forecastDay.Temperature.Minimum.Value}°C</span>
                                        </div>
                                        <div class="d-flex">
                                            <span><i class="fas fa-tint me-2 text-info"></i>${forecastDay.Day.RelativeHumidity.Average} %</span>
                                        </div>
                                        <div class="d-flex">
                                            <span><i class="fas fa-cloud-rain me-2 text-primary"></i>${forecastDay.Day.RainProbability} %</span>
                                        </div>
                                        <div class="d-flex">
                                            <span><i class="fas fa-wind me-2 text-muted"></i>${forecastDay.Day.Wind.Speed.Value} km/h</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                forecastContainer.appendChild(dayCard);
            });

            // Dummy Weather Data for Chart.js (Replace this with dynamic data later)
            const temperatureData = weatherData.DailyForecasts.map((forecast) => forecast.Temperature.Maximum
                .Value);
            const labels = weatherData.DailyForecasts.map((forecast) => {
                const date = new Date(forecast.Date);
                return date.toLocaleDateString('en-US', {
                    weekday: 'short',
                    month: 'short',
                    day: 'numeric',
                });
            });

            // Weather Forecast Chart
            const ctx = document.getElementById('forecastChart').getContext('2d');
            const forecastChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Max Temperature (°C)',
                        data: temperatureData,
                        borderColor: '#ff6f61',
                        fill: false,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItem) {
                                    return tooltipItem[0].label;
                                },
                                label: function(tooltipItem) {
                                    return `Temperature: ${tooltipItem.raw}°C`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Temperature (°C)'
                            }
                        }
                    }
                }
            });
        });
    </script>

    @include('footer')
</body>

</html>
