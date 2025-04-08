<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
  <title>AgroConnect Cabuyao</title>
  <link rel="stylesheet" href="{{ asset('css/weather_forecasts.css') }}">
  <!-- Ensure you have Bootstrap linked for grid classes to work -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  @include('header')

  <main class="main-content mx-0 w-100">
    <div class="container my-5">
      <div style="background-color: #f1f1f1" class="card w-100 shadow-sm">
        <div class="bg-header">
          <h1 class="forecast-title text-center">14-Day Forecast for Cabuyao, Laguna, Philippines</h1>
        </div>
        <div class="container-fluid p-5">
          <div class="content">
            <h3 class="text-center mb-4">
              <i class="fas fa-cloud"></i>
              Weather forecast powered by Open-Meteo
            </h3>
            <!-- Separate containers for today's forecast and remaining days -->
            <div class="forecast-container">
              <!-- Today's forecast: Full width -->
              <div id="todayForecast" class="row mb-4"></div>
              <!-- Remaining forecasts: Displayed in grid format -->
              <div id="otherForecasts" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    // The weatherData variable now holds Open-Meteo's JSON response.
    const weatherData = @json($weatherData);
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const todayContainer = document.getElementById("todayForecast");
      const otherForecastsContainer = document.getElementById("otherForecasts");

      // Open-Meteo structures data in the "daily" object.
      const dates = weatherData.daily.time;
      const maxTemps = weatherData.daily.temperature_2m_max;
      const minTemps = weatherData.daily.temperature_2m_min;
      const precipitations = weatherData.daily.precipitation_sum;

      // If there is at least one forecast item, use the first as "today"
      if (dates.length > 0) {
        const todayDate = new Date(dates[0]);
        const formattedToday = todayDate.toLocaleDateString("en-US", {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric"
        });
        const todayCard = document.createElement("div");
        todayCard.classList.add("col-12");
        todayCard.innerHTML = `
          <div class="card forecast-card">
            <div class="card-body">
              <h5 class="card-title">${formattedToday} - Today</h5>
              <div class="metrics row d-flex align-items-center justify-content-around">
                <div class="col">
                  <div class="d-flex">
                    <span title="Maximum Temperature">
                      <i class="fas fa-temperature-high me-2 text-danger"></i>Maximum Temperature: ${maxTemps[0]}°C
                    </span>
                  </div>
                  <div class="d-flex">
                    <span title="Minimum Temperature">
                      <i class="fas fa-temperature-low me-2 text-primary"></i>Minimum Temperature:${minTemps[0]}°C
                    </span>
                  </div>
                  <div class="d-flex">
                    <span title="Precipitation">
                      <i class="fas fa-cloud-rain me-2 text-primary"></i>Precipitation: ${precipitations[0]} mm
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        `;
        todayContainer.appendChild(todayCard);
      }

      // Loop for the remaining forecast days (from index 1 onward)
      for (let i = 1; i < dates.length; i++) {
        const date = new Date(dates[i]);
        const formattedDate = date.toLocaleDateString("en-US", {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric"
        });

        const dayCard = document.createElement("div");
        // Each card will follow the grid structure.
        dayCard.classList.add("col");
        dayCard.innerHTML = `
          <div class="card forecast-card">
            <div class="card-body">
              <h5 class="card-title">${formattedDate}</h5>
              <div class="metrics row d-flex align-items-center justify-content-around">
                <div class="col">
                  <div class="d-flex">
                    <span title="Maximum Temperature">
                      <i class="fas fa-temperature-high me-2 text-danger"></i>Maximum Temperature: ${maxTemps[i]}°C
                    </span>
                  </div>
                  <div class="d-flex">
                    <span title="Minimum Temperature">
                      <i class="fas fa-temperature-low me-2 text-primary"></i>Minimum Temperature: ${minTemps[i]}°C
                    </span>
                  </div>
                  <div class="d-flex">
                    <span title="Precipitation">
                      <i class="fas fa-cloud-rain me-2 text-primary"></i>Precipitation:${precipitations[i]} mm
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        `;
        otherForecastsContainer.appendChild(dayCard);
      }
    });
  </script>

  @include('footer')
  
  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
