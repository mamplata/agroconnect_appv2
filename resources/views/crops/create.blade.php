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

    <div class="container">
        <h1>Upload File</h1>
        <form action="{{ route('crops.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Select File:</label>
                <input type="file" class="form-control" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Upload</button>
        </form>
    </div>
</x-app-layout>
