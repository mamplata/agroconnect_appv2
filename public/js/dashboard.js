const updateChart = new Chart(document.getElementById("updateChart"), {
    type: "line",
    data: {
        labels: labels,
        datasets: datasets,
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                title: {
                    display: true,
                    text: "Date",
                },
            },
            y: {
                title: {
                    display: true,
                    text: "Update Count",
                },
                beginAtZero: true,
            },
        },
        elements: {
            point: {
                radius: 6, // Adjust this value to make the circles bigger or smaller
            },
        },
        plugins: {
            tooltip: {
                mode: "nearest", // Ensures tooltip shows for the closest point
                intersect: false, // Allows the tooltip to display for points near the cursor
                callbacks: {
                    label: function (context) {
                        const datasetLabel = context.dataset.label || "Dataset";
                        const value = context.raw;
                        return `${datasetLabel}: ${value}`;
                    },
                },
            },
        },
        interaction: {
            mode: "index", // Tooltip will display all datasets for a single X-axis value
            axis: "x", // Tooltips will respond horizontally
            intersect: false, // Tooltip activates even if the cursor is between points
        },
    },
});

// Toggle visibility of datasets
const checkboxes = document.querySelectorAll(
    '#datasetControls input[type="checkbox"]'
);
checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", (event) => {
        const datasetIndex = event.target.dataset.dataset;
        updateChart.data.datasets[datasetIndex].hidden = !event.target.checked;
        updateChart.update();
    });
});

// Select all datasets
document.getElementById("selectAll").addEventListener("click", () => {
    checkboxes.forEach((checkbox) => (checkbox.checked = true));
    datasets.forEach(
        (dataset, index) => (updateChart.data.datasets[index].hidden = false)
    );
    updateChart.update();
});

// Unselect all datasets
document.getElementById("unselectAll").addEventListener("click", () => {
    checkboxes.forEach((checkbox) => (checkbox.checked = false));
    datasets.forEach(
        (dataset, index) => (updateChart.data.datasets[index].hidden = true)
    );
    updateChart.update();
});

// Display Current Month and Year
const currentDate = new Date();
const month = currentDate.toLocaleString("default", {
    month: "short",
}); // Short month name (e.g., "Jan")
const year = currentDate.getFullYear();

document.getElementById("currentYear").textContent = year; // Display year above month
document.getElementById("currentMonth").textContent = month; // Display month in larger font

// Button event listeners
document.getElementById("downloadChart").addEventListener("click", function () {
    downloadChartImage(updateChart);
});

document.getElementById("downloadData").addEventListener("click", () => {
    const labels = updateChart.data.labels;
    const datasets = updateChart.data.datasets;
    downloadChartData(labels, datasets);
});
