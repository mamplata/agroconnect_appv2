<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
    <title>AgroConnect Cabuyao</title>
</head>

<body>
    @include('header')
    <main class="container my-5">
        <h1 class="text-center mb-4">Price Monitoring</h1>
        <h3 class="text-center mb-4">Commodity: Squash</h3>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Price (PHP)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dummy Data -->
                    <tr>
                        <td>2024-12-01</td>
                        <td>25.00</td>
                        <td class="text-success">Up</td>
                    </tr>
                    <tr>
                        <td>2024-12-02</td>
                        <td>23.50</td>
                        <td class="text-danger">Down</td>
                    </tr>
                    <tr>
                        <td>2024-12-03</td>
                        <td>23.50</td>
                        <td class="text-secondary">No Change</td>
                    </tr>
                    <tr>
                        <td>2024-12-04</td>
                        <td>24.00</td>
                        <td class="text-success">Up</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="/trends" class="btn btn-primary">Back</a>
        </div>
    </main>

    @include('footer')
</body>

</html>
