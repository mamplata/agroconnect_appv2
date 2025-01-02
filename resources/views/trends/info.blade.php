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
        <h2 class="text-center mb-5">Squash Information</h2>

        <!-- Squash Information Card -->
        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title">Squash Overview</h4>
            </div>
            <div class="card-body">
                <h5>Description</h5>
                <p>
                    Squash (Cucurbita spp.) is a member of the gourd family and is widely cultivated for its edible
                    fruits, which come in various shapes and sizes. It is commonly used in culinary dishes, especially
                    in
                    soups and stews. Squash thrives in warm climates and requires full sunlight for optimal growth.
                </p>

                <h5>Planting Period</h5>
                <p>
                    The ideal planting period for squash is during the wet season, typically from June to August. It is
                    best
                    to plant squash when the risk of frost is minimal, and the soil temperature is between 21°C and
                    30°C.
                </p>

                <h5>Growth Duration</h5>
                <p>
                    Squash typically takes 60 to 100 days to mature, depending on the variety. It starts with the
                    germination
                    phase, followed by the vegetative growth phase, flowering, and finally fruiting. The growth period
                    can vary
                    based on environmental conditions such as temperature and water availability.
                </p>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h4 class="card-title">Additional Information</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-link">Squash Planting Guide (PDF)</a>
                        <span class="badge bg-info text-white">Download</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-link">Squash Pest and Disease Management (PDF)</a>
                        <span class="badge bg-info text-white">Download</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-link">Squash Market Trends (External Link)</a>
                        <span class="badge bg-info text-white">Link</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="/trends" class="btn btn-primary btn-lg">Back </a>
        </div>
    </main>

    @include('footer')
</body>

</html>
