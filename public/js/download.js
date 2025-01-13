// Generalized function to download the chart as an image
function downloadChartImage(chart, width = 1080, height = 720) {
    const offscreenCanvas = document.createElement("canvas");
    offscreenCanvas.width = width;
    offscreenCanvas.height = height;
    const offscreenCtx = offscreenCanvas.getContext("2d");

    // Temporarily resize the chart to the offscreen dimensions
    chart.resize(width, height);
    chart.update();

    // Draw the chart onto the offscreen canvas
    offscreenCtx.drawImage(chart.canvas, 0, 0, width, height);

    // Create a unique filename based on the current timestamp
    const timestamp = new Date().toISOString().replace(/[^a-zA-Z0-9]/g, "_");
    const filename = `chart_${timestamp}.png`;

    // Convert the offscreen canvas to a Base64 image and download it
    const url = offscreenCanvas.toDataURL("image/png");
    const a = document.createElement("a");
    a.href = url;
    a.download = filename;
    a.click();

    // Restore the chart to its original size
    chart.resize(); // Resets to default responsive size
}

// Generalized function to download chart data as CSV with quoted values
function downloadChartData(labels, datasets) {
    // Function to escape and quote each label or value
    function escapeAndQuote(value) {
        // Convert the value to a string to avoid errors with non-string values
        const strValue = String(value);
        return `"${strValue.replace(/"/g, '""')}"`; // Escape double quotes inside the string and wrap it in quotes
    }

    // Encrypt and quote the labels using Base64 encoding and wrap them in quotes
    const encryptedLabels = labels.map(escapeAndQuote);

    const csvContent =
        "data:text/csv;charset=utf-8," +
        "Label," +
        encryptedLabels.join(",") +
        "\n" + // Add header (X-axis labels)
        datasets
            .map(
                (dataset) =>
                    `${escapeAndQuote(dataset.label)},${dataset.data
                        .map(escapeAndQuote)
                        .join(",")}`
            )
            .join("\n"); // Add data rows with encrypted and quoted labels

    // Create a download link
    const link = document.createElement("a");
    // Create a unique filename based on the current timestamp
    const timestamp = new Date().toISOString().replace(/[^a-zA-Z0-9]/g, "_");
    const filename = `chart-data_${timestamp}.csv`;

    link.download = filename; // Name of the downloaded file
    link.href = encodeURI(csvContent); // Encode the CSV content into a URI
    link.click();
}
