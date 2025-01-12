<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
    <title>Agroconnect Cabuyao</title>
    <link rel="stylesheet" href="{{ asset('css/damages.css') }}">
</head>

<body>
    @include('header')

    <div class="container
        mt-5">
        <h1 class="text-center mb-4">Damage Reports</h1>
        <ul class="nav nav-pills justify-content-center mb-4" id="damageTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->is('damages/pests') ? 'active' : '' }}"
                    href="{{ route('damages.pests') }}" role="tab">
                    <i class="fas fa-bug me-2"></i> Pests
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->is('damages/diseases') ? 'active' : '' }}"
                    href="{{ route('damages.diseases') }}" role="tab">
                    <i class="fas fa-virus me-2"></i> Diseases
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->is('damages/natural-disaster') ? 'active' : '' }}"
                    href="{{ route('damages.disasters') }}" role="tab">
                    <i class="fas fa-cloud-showers-heavy me-2"></i> Natural Disasters
                </a>
            </li>
        </ul>

        <div class="row">
            <div class="chart-container">
                <div class="chart-wrapper">
                    <!-- Full-width bar chart for pest damage statistics -->
                    <div class="col-lg-12 mb-4">
                        <h2 class="text-center">Diseases Damage Statistics</h2>
                        <canvas id="diseasesChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-wrapper">
                    <!-- Smaller pie chart for diseases type by area affected -->
                    <div class="col-lg-5 col-md-6 col-sm-12 mb-4">
                        <h2 class="text-center">Diseases Type By Area Affected</h2>
                        <canvas id="diseasesPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap and Chart.js for responsive design and chart rendering -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const groupedChartData = @json($groupedChartData);
        const pieChartData = @json($pieChartData);

        const ctx = document.getElementById('diseasesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: groupedChartData.labels,
                datasets: groupedChartData.datasets
            },
            options: {
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const label = tooltipItem.dataset.label || '';
                                const areaAffected = tooltipItem.raw;
                                const datasetIndex = tooltipItem.datasetIndex;
                                const areaPlanted = groupedChartData.datasets[datasetIndex].areaPlantedData[
                                    tooltipItem.dataIndex];
                                return `${label}: ${areaAffected} affected, ${areaPlanted} planted`;
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false, // Maintain a fixed aspect ratio
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                    },
                },
            },
        });

        // Pie chart for damage_name summary
        const pieCtx = document.getElementById('diseasesPieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieChartData.labels,
                datasets: [{
                    data: pieChartData.data,
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6', '#FFD700'],
                    borderColor: ['#FFF', '#FFF', '#FFF', '#FFF', '#FFF'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            },
        });
    </script>

    @include('footer')

</body>

</html>
