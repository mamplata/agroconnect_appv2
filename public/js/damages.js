document.addEventListener("DOMContentLoaded", function () {
    // Grouped Bar Chart
    const groupedCtx = document
        .getElementById("groupedBarChart")
        .getContext("2d");
    new Chart(groupedCtx, {
        type: "bar",
        data: groupedChartData,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                tooltip: { mode: "index", intersect: false },
                legend: { position: "top" },
            },
            scales: {
                x: {
                    stacked: false, // Disable stacking for grouped bars
                    title: {
                        display: true,
                        text: "Month",
                    },
                },
                y: {
                    stacked: false, // Disable stacking for Y-axis
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Area (Ha)",
                    },
                },
            },
        },
    });

    // Pie Chart
    const pieCtx = document.getElementById("damagePieChart").getContext("2d");
    new Chart(pieCtx, {
        type: "pie",
        data: pieChartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: "bottom" },
                tooltip: {
                    callbacks: {
                        label: (tooltipItem) =>
                            `${tooltipItem.label}: ${tooltipItem.raw.toFixed(
                                2
                            )}%`,
                    },
                },
            },
        },
    });
});
