<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Additional Information') }}
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
            @if ($errors->any())
                <div class="card mb-4">
                    <div class="card-body text-white bg-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="card-body">
                <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="form-group">
                        <label for="file"><i class="fas fa-upload"></i> Select File:</label>
                        <input type="file" class="form-control" name="file" id="file" required>
                        <small id="fileHelp" class="form-text text-muted">
                            Max file size: 10MB. Allowed file types: jpg, jpeg, png, pdf, docx, txt.
                        </small>
                    </div>

                    <!-- Hidden field to store crop ID -->
                    <input type="hidden" name="crop_id" value="{{ $crop_id }}">

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
            document.getElementById('validationErrorCard').style.display = 'none'; // Hide the card initially

            // Check file size
            if (file && file.size > maxSize) {
                event.preventDefault();
                alert('The file size exceeds the 10MB limit. Please select a smaller file.');
                return;
            }

            // Check file type
            if (file && !allowedTypes.includes(fileType)) {
                event.preventDefault();
                alert('Invalid file type. Allowed types are jpg, jpeg, png, pdf, docx, and txt.');
                return;
            }
        });
    </script>
</x-app-layout>
