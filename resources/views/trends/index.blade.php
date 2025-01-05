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

    <main>
        <div class="container my-5">
            <!-- Search Form -->
            <form method="GET" action="{{ route('trends.index') }}" class="mb-3">
                <div class="input-group">
                    <div class="row w-100">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="search"
                                placeholder="Search by Crop Name or Variety" value="{{ old('search', $search) }}">
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-control">
                                <option value="">Filter by Type</option>
                                <option value="Rice" {{ old('type', $type) == 'Rice' ? 'selected' : '' }}>Rice
                                </option>
                                <option value="Vegetables" {{ old('type', $type) == 'Vegetables' ? 'selected' : '' }}>
                                    Vegetables</option>
                                <option value="Fruits" {{ old('type', $type) == 'Fruits' ? 'selected' : '' }}>Fruits
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex">
                            <button class="btn btn-dark me-2" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <a href="{{ route('trends.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Table of Crops -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-success text-white"">
                        <tr>
                            <th>Image</th>
                            <th>Commodity</th>
                            <th>Variety</th>
                            <th>Latest Price (PHP)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($crops as $crop)
                            <tr class="text-center">
                                <td>
                                    <img src="{{ $crop->img ? $crop->img : 'https://via.placeholder.com/640x480.png/00cc99?text=No+Image+Available' }}"
                                        alt="{{ $crop->cropName }}" class="img-fluid"
                                        style="max-width: 150px; height: auto;">
                                </td>
                                <td>{{ $crop->cropName }}</td>
                                <td>{{ $crop->variety }}</td>
                                <td>
                                    @if ($crop->latest_price > $crop->previous_price)
                                        <span class="text-success">
                                            <i class="fas fa-arrow-up"></i> {{ number_format($crop->latest_price, 2) }}
                                        </span>
                                    @elseif($crop->latest_price < $crop->previous_price)
                                        <span class="text-danger">
                                            <i class="fas fa-arrow-down"></i>
                                            {{ number_format($crop->latest_price, 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-arrow-right"></i>
                                            {{ number_format($crop->latest_price, 2) }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('trends.price', ['cropName' => $crop->cropName, 'variety' => $crop->variety]) }}"
                                        class="btn btn-primary btn-sm mb-2 me-1 d-block w-100">
                                        <i class="fas fa-tag"></i> Price
                                    </a>
                                    <a href="/stats" class="btn btn-success btn-sm mb-2 me-1 d-block w-100">
                                        <i class="fas fa-chart-line"></i> Stats
                                    </a>
                                    <a href="/info" class="btn btn-info btn-sm d-block w-100">
                                        <i class="fas fa-info-circle"></i> Info
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $crops->links() }}
            </div>
        </div>
    </main>

    @include('footer')
</body>

</html>
