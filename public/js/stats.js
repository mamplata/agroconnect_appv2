document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("multiAxisChart").getContext("2d");
    const multiAxisChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: chartData.labels,
            datasets: chartData.datasets,
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allows the chart to grow dynamically
            scales: {
                x: {
                    ticks: {
                        autoSkip: true, // Skips labels if there isn't enough space
                        maxRotation: 45, // Limits label rotation to 45 degrees
                        minRotation: 0, // Avoids unnecessary rotation
                    },
                },
                y: {
                    beginAtZero: true,
                },
                y1: {
                    beginAtZero: true,
                    position: "right",
                },
                y2: {
                    beginAtZero: true,
                    position: "right",
                },
            },
            plugins: {
                legend: {
                    position: "top",
                },
                tooltip: {
                    mode: "index",
                    intersect: false,
                },
            },
            layout: {
                padding: {
                    bottom: 20, // Prevent labels from cutting off on small screens
                },
            },
        },
    });

    // Functionality for Select All and Unselect All
    const datasetControls = document.getElementById("datasetControls");
    const selectAllButton = document.getElementById("selectAll");
    const unselectAllButton = document.getElementById("unselectAll");

    // Add event listeners to checkboxes
    datasetControls.addEventListener("change", function (event) {
        if (event.target.tagName === "INPUT") {
            const datasetIndex = event.target.dataset.dataset;
            multiAxisChart.data.datasets[datasetIndex].hidden =
                !event.target.checked;
            multiAxisChart.update();
        }
    });

    // Select All button functionality
    selectAllButton.addEventListener("click", function () {
        const checkboxes = datasetControls.querySelectorAll(
            "input[type='checkbox']"
        );
        checkboxes.forEach((checkbox) => {
            checkbox.checked = true;
            const datasetIndex = checkbox.dataset.dataset;
            multiAxisChart.data.datasets[datasetIndex].hidden = false;
        });
        multiAxisChart.update();
    });

    // Unselect All button functionality
    unselectAllButton.addEventListener("click", function () {
        const checkboxes = datasetControls.querySelectorAll(
            "input[type='checkbox']"
        );
        checkboxes.forEach((checkbox) => {
            checkbox.checked = false;
            const datasetIndex = checkbox.dataset.dataset;
            multiAxisChart.data.datasets[datasetIndex].hidden = true;
        });
        multiAxisChart.update();
    });
});
