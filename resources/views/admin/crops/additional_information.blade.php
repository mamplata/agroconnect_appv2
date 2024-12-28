<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Additional Information View') }}
        </h2>
    </x-slot>

    <!-- Show success or error messages -->
    @if (session('status'))
        <div class="alert alert-{{ session('status_type') == 'success' ? 'success' : 'danger' }} alert-dismissible fade show mb-4"
            role="alert">
            <strong>{{ session('status_type') == 'success' ? 'Success!' : 'Error!' }}</strong> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container py-4">
        <h1 class="mb-4">Uploaded Files: <span class="text-primary font-bold">{{ $crop->cropName }}</span></h1>
        <!-- Display the crop name -->

        <div class="mb-3">
            <!-- Back Button -->
            <a href="{{ route('admin.crops.index', $crop) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Information ID</th>
                        <th>File Name</th>
                        <th>Author</th>
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
                            <td>{{ $info->id }}</td>
                            <td>{{ $fileData['originalName'] ?? 'N/A' }}</td>
                            <td>{{ $info->author->name ?? 'N/A' }}</td> <!-- Display the author's name -->
                            <td>
                                <!-- View Button -->
                                <a href="{{ asset('storage/' . $fileData['path']) }}" target="_blank"
                                    class="btn btn-success btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
