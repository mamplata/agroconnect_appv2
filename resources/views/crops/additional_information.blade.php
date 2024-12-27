<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Additional Information View') }}
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
        <h1>Uploaded Files for Crop: {{ $crop->name }}</h1> <!-- Display the crop name -->

        <!-- Back Button -->
        <a href="{{ route('upload.index', $crop) }}" class="btn btn-secondary mb-3">Back</a>
        <!-- Pass crop_id -->

        <a href="{{ route('upload.create', $crop) }}" class="btn btn-primary mb-3">Upload New File</a>
        <!-- Pass crop_id -->

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Information ID</th>
                    <th>File Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($additionalInformation as $info)
                    @php
                        $fileData = json_decode($info->fileHolder, true);
                    @endphp
                    <tr>
                        <!-- Display ID in 'information->id' format -->
                        <td>{{ $info->id }}</td> <!-- Correct the syntax for displaying ID -->
                        <td>{{ $fileData['originalName'] ?? 'N/A' }}</td>
                        <td>
                            <!-- View Button -->
                            <a href="{{ asset('storage/' . $fileData['path']) }}" target="_blank"
                                class="btn btn-success">View</a>

                            <form
                                action="{{ route('upload.destroy', ['crop_id' => $crop->id, 'additionalInformation' => $info->id]) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this file?')">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>
