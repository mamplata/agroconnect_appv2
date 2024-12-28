<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Crops') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('admin.crops.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" placeholder="Search by Crop Name or Variety"
                        value="{{ old('search', $search) }}">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-control">
                        <option value="">Filter by Type</option>
                        <option value="Rice" {{ old('type', $type) == 'Rice' ? 'selected' : '' }}>Rice</option>
                        <option value="Vegetables" {{ old('type', $type) == 'Vegetables' ? 'selected' : '' }}>Vegetables
                        </option>
                        <option value="Fruits" {{ old('type', $type) == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-dark" type="submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <a href="{{ route('admin.crops.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <!-- Show success or error messages -->
        @if (session('status'))
            <div class="alert {{ session('status_type') == 'success' ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show"
                role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Crop Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-success text-white">
                    <tr>
                        <th>#</th>
                        <th>Crop Name</th>
                        <th>Variety</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Planting Period</th>
                        <th>Growth Duration</th>
                        <th>Author</th>
                        <th>Modified By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($crops as $index => $crop)
                        <tr>
                            <td>{{ $crops->firstItem() + $index }}</td>
                            <td>{{ $crop->cropName }}</td>
                            <td>{{ $crop->variety }}</td>
                            <td>{{ $crop->type }}</td>
                            <td>{{ $crop->description }}</td>
                            <td>{{ $crop->planting_period }}</td>
                            <td>{{ $crop->growth_duration }}</td>
                            <td>{{ $crop->author->name ?? 'Unknown' }}</td>
                            <td>{{ $crop->modifier->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.upload.index', $crop) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-upload"></i> View Uploads
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $crops->links() }}
        </div>
    </div>
</x-app-layout>
