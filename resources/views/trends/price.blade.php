<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <title>AgroConnect Cabuyao</title>
</head>

<body>
    @include('header')
    <main class="container my-5">
        <form method="GET" action="{{ route('trends.price', ['cropName' => $cropName, 'variety' => $variety]) }}"
            class="mb-3">
            <div class="input-group">
                <div class="row w-100">
                    <div class="col-md-3">
                        <select name="price" class="form-control">
                            <option value="" {{ request('price') == '' ? 'selected' : '' }}>None</option>
                            <option value="asc" {{ request('price') == 'asc' ? 'selected' : '' }}>Ascend</option>
                            <option value="desc" {{ request('price') == 'desc' ? 'selected' : '' }}>Descend</option>
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div class="col-md-3">
                        <input type="date" name="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-3 d-flex">
                        <button class="btn btn-dark me-2" type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('trends.price', ['cropName' => $cropName, 'variety' => $variety]) }}"
                            class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <h1 class="text-center mb-4">Price Monitoring</h1>
        <h3 class="text-center mb-4">
            Commodity: {{ ucfirst($cropName) }}
            @if ($variety && $variety !== 'N/A')
                - {{ ucfirst($variety) }}
            @endif
        </h3>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-success text-white">
                    <tr>
                        <th>Date</th>
                        <th>Price (PHP)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prices as $price)
                        <tr>
                            <td>{{ $price->date }}</td>
                            <td>{{ number_format($price->price, 2) }}</td>
                            <td>
                                <i class="{{ $price->statusIcon }}"></i> {{ $price->status }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links (Centered) -->
        <div class="d-flex justify-content-center mt-4">
            {{ $prices->links() }} <!-- Pagination links -->
        </div>

        <div class="text-center mt-4">
            <a href="/trends" class="btn btn-dark btn-lg">Back</a>
        </div>
    </main>

    @include('footer')
</body>

</html>
