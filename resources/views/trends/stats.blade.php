<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
    <link rel="stylesheet" href="{{ asset('css/stats.css') }}">
    <title>AgroConnect Cabuyao</title>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<script>
    const chartData = @json($chartData);
</script>
<script src="{{ asset('js/stats.js') }}"></script>

<body>
    @include('header')
    <main class="container my-5">
        <div class="chart-container">
            <h2 class="text-center mb-4">Crop Monitoring: {{ $cropName }} ({{ $variety }})</h2>
            <!-- Chart Selection Section (Placed Above the Chart) -->
            <div class="chart-controls mt-3 text-center">
                <div>
                    <button id="selectAll" class="btn btn-primary mx-2">Select All</button>
                    <button id="unselectAll" class="btn btn-secondary mx-2">Unselect All</button>
                </div>
                <div id="datasetControls" class="mt-2">
                    <label><input type="checkbox" data-dataset="0" checked> Area Planted (ha)</label>
                    <label><input type="checkbox" data-dataset="1" checked> Production Volume (MT)</label>
                    <label><input type="checkbox" data-dataset="2" checked> Yield (MT/ha)</label>
                    <label><input type="checkbox" data-dataset="3" checked> Price (₱)</label>
                    <label><input type="checkbox" data-dataset="4" checked> Price Income (₱)</label>
                </div>

            </div>
            <div class="chart-wrapper">
                <canvas id="multiAxisChart"></canvas>
            </div>
        </div>

        <!-- Description Section -->
        <section class="description-section mt-5">
            <h3 class="text-center">About the Chart</h3>
            <p class="mt-3 text-justify">
                This chart provides a comprehensive analysis of crop performance for
                <strong>{{ $cropName }}</strong>,
                specifically the <strong>{{ $variety }}</strong> variety. The metrics displayed help stakeholders
                and
                agriculturists monitor crop trends over time. Each metric is defined below:
            </p>
            <ul class="mt-3 text-justify">
                <li><strong>Area Planted (ha):</strong> The total area (in hectares) allocated for planting this crop.
                </li>
                <li><strong>Production Volume (MT):</strong> The total production volume measured in metric tons (MT).
                </li>
                <li><strong>Yield (MT/ha):</strong> The yield calculated as the production volume per hectare, providing
                    insights into crop efficiency.</li>
                <li><strong>Price (₱):</strong> The market price per metric ton of the crop, reflecting economic trends
                    and profitability.</li>
                <li><strong>Price Income (₱):</strong> The total income calculated as the product of production volume
                    and price, providing a measure of overall economic output.</li>
            </ul>
            <p class="mt-3 text-justify">
                Use the "Select All" and "Unselect All" buttons to customize the metrics displayed on the chart.
                You can also toggle individual metrics using the checkboxes above.
            </p>
        </section>


        <div class="text-center mt-4">
            <a href="/trends" class="btn btn-primary btn-lg">Back</a>
        </div>
    </main>
    @include('footer')
</body>

</html>
