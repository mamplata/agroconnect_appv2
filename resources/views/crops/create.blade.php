<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Crop') }}
        </h2>
    </x-slot>

    <!-- Show success or error messages -->
    @if (session('status'))
        <div class="card mb-4">
            <div class="card-body text-white {{ session('status_type') == 'success' ? 'bg-success' : 'bg-danger' }}">
                <p class="mb-0">{{ session('status') }}</p>
            </div>
        </div>
    @endif

    <div class="container d-flex justify-content-center align-items-center mt-5">
        <div class="card">
            <!-- Card for Validation Error -->
            <div class="card mb-4" id="validationErrorCard" style="display: none;">
                <div class="card-body text-white bg-danger">
                    <p id="errorMessage" class="mb-0">The file is invalid. Please fix the issue and try again.</p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card-body">
                <form action="{{ route('crops.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="form-group">
                        <label for="file"><i class="fas fa-upload"></i> Select File:</label>
                        <input type="file" class="form-control" name="file" id="file" required>
                        <small id="fileHelp" class="form-text text-muted">
                            Max file size: 10MB. Allowed file types: jpg, jpeg, png, pdf, docx, txt.
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 w-100">
                        <i class="fas fa-cloud-upload-alt"></i> Upload
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            const fileInput = document.getElementById('file');
            const file = fileInput.files[0];
            const maxSize = 10 * 1024 * 1024; // 10MB in bytes
            const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'
            ];
            const fileType = file ? file.type : '';

            // Reset error message
            document.getElementById('errorMessage').textContent =
                'The file is invalid. Please fix the issue and try again.';
            document.getElementById('validationErrorCard').style.display = 'none'; // Hide the card initially

            // Check file size
            if (file && file.size > maxSize) {
                event.preventDefault();
                document.getElementById('errorMessage').textContent =
                    'The file size exceeds the 10MB limit. Please select a smaller file.';
                document.getElementById('validationErrorCard').style.display = 'block'; // Show the card
                return;
            }

            // Check file type
            if (file && !allowedTypes.includes(fileType)) {
                event.preventDefault();
                document.getElementById('errorMessage').textContent =
                    'Invalid file type. Allowed types are jpg, jpeg, png, pdf, docx, and txt.';
                document.getElementById('validationErrorCard').style.display = 'block'; // Show the card
                return;
            }
        });
    </script>
</x-app-layout>
