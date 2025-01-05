document.addEventListener("DOMContentLoaded", function () {
    // 5-Day Forecast Data
    const forecastContainer = document.getElementById("forecast");
    weatherData.DailyForecasts.forEach((forecastDay) => {
        const dayCard = document.createElement("div");
        const date = new Date(forecastDay.Date);
        const formattedDate = date.toLocaleDateString("en-US", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        });

        // Generate the icon URL
        const iconCode = forecastDay.Day.Icon;
        const iconUrl = `https://developer.accuweather.com/sites/default/files/${(
            "0" + iconCode
        ).slice(-2)}-s.png`;

        // Build the HTML content for the forecast card
        dayCard.innerHTML = `
                <div class="col">
                <div class="card forecast-card">
                    <div class="card-body">
                        <h5 class="card-title">${formattedDate}</h5>
                        <div class="metrics row d-flex align-items-center justify-content-around">
                            <div class="col icon-section d-flex flex-column align-items-center">
                                <img
                                    src="${iconUrl}"
                                    alt="${forecastDay.Day.IconPhrase}"
                                    class="weather-icon img-fluid"
                                    data-bs-toggle="tooltip"
                                    title="${forecastDay.Day.IconPhrase}">
                                <span class="text-center">${forecastDay.Day.IconPhrase}</span>
                            </div>
                            <div class="col metrics">
                                <div class="d-flex">
                                    <span
                                        data-bs-toggle="tooltip"
                                        title="Maximum Temperature">
                                        <i class="fas fa-temperature-high me-2 text-danger"></i>${forecastDay.Temperature.Maximum.Value}°C
                                    </span>
                                </div>
                                <div class="d-flex">
                                    <span
                                        data-bs-toggle="tooltip"
                                        title="Minimum Temperature">
                                        <i class="fas fa-temperature-low me-2 text-primary"></i>${forecastDay.Temperature.Minimum.Value}°C
                                    </span>
                                </div>
                                <div class="d-flex">
                                    <span
                                        data-bs-toggle="tooltip"
                                        title="Average Humidity">
                                        <i class="fas fa-tint me-2 text-info"></i>${forecastDay.Day.RelativeHumidity.Average} %
                                    </span>
                                </div>
                                <div class="d-flex">
                                    <span
                                        data-bs-toggle="tooltip"
                                        title="Rain Probability">
                                        <i class="fas fa-cloud-rain me-2 text-primary"></i>${forecastDay.Day.RainProbability} %
                                    </span>
                                </div>
                                <div class="d-flex">
                                    <span
                                        data-bs-toggle="tooltip"
                                        title="Wind Speed">
                                        <i class="fas fa-wind me-2 text-muted"></i>${forecastDay.Day.Wind.Speed.Value} km/h
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                `;
        forecastContainer.appendChild(dayCard);
    });

    const forecastData = weatherData.DailyForecasts;
    console.log(forecastData);
    const labels = weatherData.DailyForecasts.map((forecast) => {
        const date = new Date(forecast.Date);
        return date.toLocaleDateString("en-US", {
            weekday: "short",
            month: "short",
            day: "numeric",
        });
    });
    console.log(labels);
    const maxTemperatureData = forecastData.map(
        (day) => day.Temperature.Maximum.Value
    );
    const minTemperatureData = forecastData.map(
        (day) => day.Temperature.Minimum.Value
    );
    const humidityData = forecastData.map(
        (day) => day.Day.RelativeHumidity.Average
    );
    const rainProbabilityData = forecastData.map(
        (day) => day.Day.RainProbability
    );
    const windSpeedData = forecastData.map((day) => day.Day.Wind.Speed.Value);

    // Weather Forecast Chart
    const ctx = document.getElementById("forecastChart").getContext("2d");
    const forecastChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: labels, // Array of dates or corresponding x-axis labels
            datasets: [
                {
                    label: "Max Temperature (°C)",
                    data: maxTemperatureData,
                    borderColor: "#ff6f61",
                    fill: false,
                    tension: 0.1,
                },
                {
                    label: "Min Temperature (°C)",
                    data: minTemperatureData,
                    borderColor: "#61a0ff",
                    fill: false,
                    tension: 0.1,
                },
                {
                    label: "Average Humidity (%)",
                    data: humidityData,
                    borderColor: "#61ffab",
                    fill: false,
                    tension: 0.1,
                },
                {
                    label: "Rain Probability (%)",
                    data: rainProbabilityData,
                    borderColor: "#ffab61",
                    fill: false,
                    tension: 0.1,
                },
                {
                    label: "Wind Speed (km/h)",
                    data: windSpeedData,
                    borderColor: "#ab61ff",
                    fill: false,
                    tension: 0.1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "top",
                },
            },
        },
    });

    // Control logic
    const datasetControls = document.querySelectorAll("#datasetControls input");
    const selectAllBtn = document.getElementById("selectAll");
    const unselectAllBtn = document.getElementById("unselectAll");

    datasetControls.forEach((checkbox) => {
        checkbox.addEventListener("change", (e) => {
            const datasetIndex = parseInt(e.target.dataset.dataset, 10);
            forecastChart.data.datasets[datasetIndex].hidden =
                !e.target.checked;
            forecastChart.update();
        });
    });

    selectAllBtn.addEventListener("click", () => {
        datasetControls.forEach((checkbox, index) => {
            checkbox.checked = true;
            forecastChart.data.datasets[index].hidden = false;
        });
        forecastChart.update();
    });

    unselectAllBtn.addEventListener("click", () => {
        datasetControls.forEach((checkbox, index) => {
            checkbox.checked = false;
            forecastChart.data.datasets[index].hidden = true;
        });
        forecastChart.update();
    });
});
