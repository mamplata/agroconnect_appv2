<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
    <link rel="stylesheet" href="{{ asset('css/damages.css') }}">
    <title>AgroConnect Cabuyao</title>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    @include('header')
    <main class="container my-5">
        <h1 class="text-center">Damage Report Monitoring</h1>

        <!-- Grouped Bar Chart -->
        <div>
            <canvas id="groupedBarChart"></canvas>
        </div>

        <!-- Pie Chart -->
        <div>
            <canvas id="damagePieChart" style="width: 300px; height: 300px;"></canvas>
        </div>

    </main>

    <script>
        const groupedChartData = @json($groupedChartData);
        const pieChartData = @json($pieChartData);
    </script>
    <script src="{{ asset('js/damages.js') }}"></script>
    @include('footer')
</body>

</html>
