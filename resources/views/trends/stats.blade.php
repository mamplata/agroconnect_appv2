<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
    <title>AgroConnect Cabuyao</title>
</head>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById("priceChart").getContext("2d");
        const priceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                    'Dec'
                ],
                datasets: [{
                        label: 'Price',
                        data: [25, 30, 27, 32, 29, 28, 31, 33, 35, 36, 34, 32],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false,
                        hidden: false,
                    },
                    {
                        label: 'Production Volume',
                        data: [200, 210, 220, 250, 230, 240, 250, 270, 280, 290, 300, 310],
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 2,
                        fill: false,
                        hidden: false,
                    },
                    {
                        label: 'Area Planted',
                        data: [50, 55, 60, 65, 62, 61, 64, 68, 70, 72, 75, 78],
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2,
                        fill: false,
                        hidden: false,
                    },
                    {
                        label: 'Price Income',
                        data: [5000, 6300, 5940, 7040, 6670, 6720, 7750, 8900, 9100, 9720, 9500,
                            8640
                        ],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: false,
                        hidden: false,
                    },
                    {
                        label: 'Yield',
                        data: [10, 12, 11, 15, 14, 13, 16, 17, 18, 19, 18, 16],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: false,
                        hidden: false,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        onClick: (e, legendItem, legend) => {
                            const index = legendItem.datasetIndex;
                            const chart = legend.chart;
                            const meta = chart.getDatasetMeta(index);
                            meta.hidden = !meta.hidden;
                            chart.update();
                        }
                    }
                }
            }
        });

        // Select or unselect chart data
        document.getElementById("selectAll").addEventListener("click", function() {
            priceChart.data.datasets.forEach(function(dataset) {
                dataset.hidden = false;
            });
            priceChart.update();
        });

        document.getElementById("unselectAll").addEventListener("click", function() {
            priceChart.data.datasets.forEach(function(dataset) {
                dataset.hidden = true;
            });
            priceChart.update();
        });

        document.querySelectorAll(".checkbox-option").forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                const datasetIndex = checkbox.getAttribute("data-index");
                priceChart.data.datasets[datasetIndex].hidden = !checkbox.checked;
                priceChart.update();
            });
        });
    });
</script>

<body>
    @include('header')
    <main class="container my-5">
        <h2 class="text-center mb-4">Price Monitoring - Squash</h2>

        <div class="mb-3">
            <h4>Monitor:</h4>
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input checkbox-option" data-index="0" checked>
                <label class="form-check-label">Price</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input checkbox-option" data-index="1" checked>
                <label class="form-check-label">Production Volume</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input checkbox-option" data-index="2" checked>
                <label class="form-check-label">Area Planted</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input checkbox-option" data-index="3" checked>
                <label class="form-check-label">Price Income</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input checkbox-option" data-index="4" checked>
                <label class="form-check-label">Yield</label>
            </div>
        </div>

        <div class="mb-3">
            <button id="selectAll" class="btn btn-primary">Select All</button>
            <button id="unselectAll" class="btn btn-secondary">Unselect All</button>
        </div>

        <div class="mb-4">
            <canvas id="priceChart"></canvas>
        </div>

        <div class="text-center">
            <a href="/trends" class="btn btn-primary">Back</a>
        </div>
    </main>
    @include('footer')
</body>

</html>
