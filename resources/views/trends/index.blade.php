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
    <main>
        <div class="container my-5">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Image</th>
                            <th>Commodity</th>
                            <th>Variety</th>
                            <th>Latest Price (PHP)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr>
                            <td><img src="https://via.placeholder.com/50" alt="Commodity Image" class="img-fluid"></td>
                            <td>Tomato</td>
                            <td>Cherry</td>
                            <td>50.00 (up)</td>
                            <td>
                                <a href="/price" class="btn btn-primary btn-sm me-1">
                                    <i class="fas fa-tag"></i>
                                </a>
                                <a href="/stats" class="btn btn-success btn-sm me-1">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                <a href="/info" class="btn btn-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr>
                            <td><img src="https://via.placeholder.com/50" alt="Commodity Image" class="img-fluid"></td>
                            <td>Squash</td>
                            <td>Summer</td>
                            <td>30.00 (down)</td>
                            <td>
                                <a href="/price" class="btn btn-primary btn-sm me-1">
                                    <i class="fas fa-tag"></i>
                                </a>
                                <a href="/stats" class="btn btn-success btn-sm me-1">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                <a href="/info" class="btn btn-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr>
                            <td><img src="https://via.placeholder.com/50" alt="Commodity Image" class="img-fluid"></td>
                            <td>Banana</td>
                            <td>Cavendish</td>
                            <td>25.00 (no change)</td>
                            <td>
                                <a href="/price" class="btn btn-primary btn-sm me-1">
                                    <i class="fas fa-tag"></i>
                                </a>
                                <a href="/stats" class="btn btn-success btn-sm me-1">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                <a href="/info" class="btn btn-info btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    @include('footer')
</body>

</html>
