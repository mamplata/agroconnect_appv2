<!-- Footer -->
<footer class="footer text-white">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center py-1">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <span class="me-3">&copy; AgroConnect Cabuyao (<span id="dateTimeData"></span>)</span>
        </div>
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-end">
            <p class="mb-0 me-4">
                <i class="fas fa-map-marker-alt" data-toggle="tooltip" data-placement="top"
                    title="Address: 3rd Floor Cabuyao Retail Plaza, Brgy. Dos, Cabuyao, Philippines, 4025"></i>
            </p>
            <p class="mb-0 me-4">
                <a href="mailto:agricabuyao@gmail.com" class="text-white">
                    <i class="fas fa-envelope" data-toggle="tooltip" data-placement="top"
                        title="Email: agricabuyao@gmail.com"></i>
                </a>
            </p>
            <p class="mb-0 me-4">
                <i class="fas fa-phone-alt" data-toggle="tooltip" data-placement="top" title="Phone: (049) 5037796"></i>
            </p>
            <p class="mb-0 me-4">
                <a href="https://www.facebook.com/cabuyaoagricultureoffice" target="_blank" class="text-white">
                    <i class="fab fa-facebook" data-toggle="tooltip" data-placement="top"
                        title="Facebook Page: Cabuyao Agriculture Office"></i>
                </a>
            </p>
            <p class="mb-0">
                <a href="#" class="text-white">Privacy Policy</a> |
                <a href="#" class="text-white">Terms of Service</a>
            </p>
        </div>
    </div>
</footer>
<script>
    // Format the current date and time dynamically
    const currentDateTime = new Date().toLocaleString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });
    document.getElementById("dateTimeData").textContent = currentDateTime;
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
