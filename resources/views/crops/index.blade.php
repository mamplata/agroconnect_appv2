<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Crop') }}
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
        <h1>Uploaded Files</h1>
        <a href="{{ route('crops.create') }}" class="btn btn-primary">Upload New File</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>File Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($crops as $crop)
                    @php
                        $fileData = json_decode($crop->fileHolder, true);
                    @endphp
                    <tr>
                        <td>{{ $crop->id }}</td>
                        <td>{{ $fileData['originalName'] ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $fileData['path']) }}" target="_blank"
                                class="btn btn-success">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>
