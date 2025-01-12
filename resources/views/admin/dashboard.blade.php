<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- Header Section -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <!-- Main Content Section -->
    <div class="container mt-4">
        @if (session('status'))
            <div class="alert {{ session('status_type') == 'success' ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show mb-4"
                role="alert">
                <strong>{{ session('status') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row d-flex">
            <!-- Two Column Layout for Welcome & Month/Year Display -->
            <div class="col-md-6 d-flex">
                <div class="card mb-4 shadow-lg border-0 rounded-lg w-100">
                    <div class="card-header bg-primary text-white rounded-top">
                        <h5>Welcome, {{ Auth::user()->name }}!</h5>
                    </div>
                    <div class="card-body">
                        <p>You are logged in as an Administrator.</p>
                        <p>
                            This is the administrator side of the system where you can monitor all data entries, manage
                            users, and oversee system operations.
                            Use the tools below to get detailed insights into system updates.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Current Month & Year Display -->
            <div class="col-md-6 d-flex">
                <div class="card mb-4 shadow-lg border-0 rounded-lg w-100">
                    <div class="card-header bg-primary text-white rounded-top">
                        <h5 class="mb-0 text-center">Date (Y/M)</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="fs-5 font-weight-bolder text-dark" id="currentYear"
                            style="font-size: 2.5rem; font-weight: 900;">
                        </div>
                        <div class="font-weight-bold text-primary" style="font-size: 4.5rem; line-height: 1.2;"
                            id="currentMonth"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full-Width Chart Selection Section -->
        <div class="col-12">
            <div class="card mb-4 shadow-lg border-0 rounded-lg w-100">
                <div class="card-header bg-dark text-white rounded-top">
                    <h5>Chart Controls</h5>
                </div>
                <div class="card-body text-center">
                    <button id="selectAll" class="btn btn-primary mx-2">Select All</button>
                    <button id="unselectAll" class="btn btn-secondary mx-2">Unselect All</button>

                    <div id="datasetControls" class="mt-3">
                        <label><input type="checkbox" data-dataset="0" checked> User</label>
                        <label><input type="checkbox" data-dataset="1" checked> Crop</label>
                        <label><input type="checkbox" data-dataset="2" checked> CropReport</label>
                        <label><input type="checkbox" data-dataset="3" checked> AdditionalInformation</label>
                        <label><input type="checkbox" data-dataset="4" checked> DamageReport</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full-Width Chart Display Section -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow-lg border-0 rounded-lg w-100">
                    <div class="card-header bg-success text-white rounded-top">
                        <h5>Model Update Trends</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-wrapper">
                            <canvas id="updateChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data from backend (dynamically generated)
        const datasets = @json($datasets); // The dataset should come from the backend.

        // Chart.js data
        const labels = @json($labels); // Dates (if applicable)

        const updateChart = new Chart(document.getElementById('updateChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Update Count'
                        },
                        beginAtZero: true
                    }
                },
                elements: {
                    point: {
                        radius: 6 // Adjust this value to make the circles bigger or smaller
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'nearest', // Ensures tooltip shows for the closest point
                        intersect: false, // Allows the tooltip to display for points near the cursor
                        callbacks: {
                            label: function(context) {
                                const datasetLabel = context.dataset.label || 'Dataset';
                                const value = context.raw;
                                return `${datasetLabel}: ${value}`;
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'index', // Tooltip will display all datasets for a single X-axis value
                    axis: 'x', // Tooltips will respond horizontally
                    intersect: false // Tooltip activates even if the cursor is between points
                }
            }
        });


        // Toggle visibility of datasets
        const checkboxes = document.querySelectorAll('#datasetControls input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', (event) => {
                const datasetIndex = event.target.dataset.dataset;
                updateChart.data.datasets[datasetIndex].hidden = !event.target.checked;
                updateChart.update();
            });
        });

        // Select all datasets
        document.getElementById('selectAll').addEventListener('click', () => {
            checkboxes.forEach(checkbox => checkbox.checked = true);
            datasets.forEach((dataset, index) => updateChart.data.datasets[index].hidden = false);
            updateChart.update();
        });

        // Unselect all datasets
        document.getElementById('unselectAll').addEventListener('click', () => {
            checkboxes.forEach(checkbox => checkbox.checked = false);
            datasets.forEach((dataset, index) => updateChart.data.datasets[index].hidden = true);
            updateChart.update();
        });

        // Display Current Month and Year
        const currentDate = new Date();
        const month = currentDate.toLocaleString('default', {
            month: 'short'
        }); // Short month name (e.g., "Jan")
        const year = currentDate.getFullYear();

        document.getElementById('currentYear').textContent = year; // Display year above month
        document.getElementById('currentMonth').textContent = month; // Display month in larger font
    </script>
</x-app-layout>
