<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AgroConnect Cabuyao</title>
</head>

<body>
    @include('header')
    <main>
        <!-- Hero Section -->
        <div class="hero">
            <div class="container">
                <h1>Welcome to AgroConnect Cabuyao</h1>
                <p>Empowering farmers and agriculturists with insights for better crop selection and planning.</p>
                <a href="#features" class="btn btn-success btn-lg mt-3">Learn More</a>
            </div>
        </div>

        <!-- Features Section -->
        <section id="features" class="features">
            <div class="container text-center">
                <h2 class="mb-4">Features</h2>
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="icon mb-3">📊</div>
                        <h5>Crop Performance Monitoring</h5>
                        <p>Track productivity, prices, and trends to make informed decisions.</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="icon mb-3">📈</div>
                        <h5>Data Updates</h5>
                        <p>Stay updated with the latest information about crops and farming techniques.</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="icon mb-3">🌱</div>
                        <h5>Smart Planning</h5>
                        <p>Utilize trends and analytics to optimize crop selection and yields.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="py-5 bg-light">
            <div class="container text-center">
                <h3 class="mb-3">Start Your Journey with AgroConnect Cabuyao Today</h3>
                <p class="mb-4">Join a growing community of farmers and agriculturists transforming agriculture in
                    Cabuyao.</p>
                <a href="/trends" class="btn btn-success btn-lg">Get Started</a>
            </div>
        </section>
    </main>
    @include('footer')
</body>

</html>
