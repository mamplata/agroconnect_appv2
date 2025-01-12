<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
    <title>AgroConnect Cabuyao</title>
</head>

<body class="bg-light">

    @include('header')

    <main class="container my-5">
        <h2 class="text-center mb-4">{{ $crop->cropName }} - {{ $crop->variety ?? '' }}</h2>

        <!-- Squash Information Card -->
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0">{{ $crop->cropName }} - {{ $crop->variety ?? '' }} Overview</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title">Description</h5>
                <p class="card-text">{{ $crop->description ?? 'No description available.' }}</p>

                <h5 class="card-title mt-3">Planting Period</h5>
                <p class="card-text">{{ $crop->planting_period ?? 'No planting period available.' }}</p>

                <h5 class="card-title mt-3">Growth Duration</h5>
                <p class="card-text">{{ $crop->growth_duration ?? 'No growth duration available.' }}</p>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="card shadow-lg">
            <div class="card-header bg-secondary text-white">
                <h4 class="card-title mb-0">Additional Information</h4>
            </div>
            <div class="card-body">
                @if ($additionalInformation->isEmpty())
                    <p class="text-center text-muted">No additional information available.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($additionalInformation as $info)
                            @php
                                $fileData = json_decode($info->fileHolder, true);
                            @endphp
                            <li class="list-group-item p-0 mb-3">
                                <!-- Card for each file -->
                                <div class="card shadow-sm border-light rounded">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div class="d-flex flex-column">
                                            <a href="{{ asset('storage/' . $fileData['path']) }}"
                                                class="text-decoration-none h5 mb-2" target="_blank">
                                                {{ $fileData['originalName'] ?? 'File' }}
                                            </a>
                                        </div>
                                        <a href="{{ asset('storage/' . $fileData['path']) }}"
                                            class="btn btn-dark text-white rounded-pill px-4 py-2" target="_blank">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $additionalInformation->links() }}
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-5">
            <a href="/trends" class="btn btn-dark btn-lg">Back</a>
        </div>
    </main>

    @include('footer')

</body>

</html>
