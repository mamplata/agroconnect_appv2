<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Damage Reports') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('damage_reports.index') }}" class="mb-3">
            <div class="input-group">
                <div class="row w-100">
                    <div class="col-md-2 col-sm-6">
                        <input type="text" class="form-control" name="search"
                            placeholder="Search by Crop Name or Variety" value="{{ old('search', $search) }}">
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <select name="type" class="form-control">
                            <option value="">Filter by Type</option>
                            <option value="Rice" {{ old('type', $type) == 'Rice' ? 'selected' : '' }}>Rice</option>
                            <option value="Vegetables" {{ old('type', $type) == 'Vegetables' ? 'selected' : '' }}>
                                Vegetables</option>
                            <option value="Fruits" {{ old('type', $type) == 'Fruits' ? 'selected' : '' }}>Fruits
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <select name="damageType" class="form-control">
                            <option value="">Filter by Damage Type</option>
                            <option value="Natural Disaster"
                                {{ old('damageType', $damageType) == 'Natural Disaster' ? 'selected' : '' }}>Natural
                                Disaster</option>
                            <option value="Pest" {{ old('damageType', $damageType) == 'Pest' ? 'selected' : '' }}>Pest
                            </option>
                            <option value="Disease" {{ old('damageType', $damageType) == 'Disease' ? 'selected' : '' }}>
                                Disease</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <select name="sortBy" class="form-control">
                            <option value="monthObserved"
                                {{ old('sortBy', $sortBy) == 'monthObserved' ? 'selected' : '' }}>Sort by Month Observed
                            </option>
                            <option value="area_planted"
                                {{ old('sortBy', $sortBy) == 'area_planted' ? 'selected' : '' }}>Sort by Area Planted
                            </option>
                            <option value="area_affected"
                                {{ old('sortBy', $sortBy) == 'area_affected' ? 'selected' : '' }}>Sort by Area Affected
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <select name="sortOrder" class="form-control">
                            <option value="asc" {{ old('sortOrder', $sortOrder) == 'asc' ? 'selected' : '' }}>
                                Ascending</option>
                            <option value="desc" {{ old('sortOrder', $sortOrder) == 'desc' ? 'selected' : '' }}>
                                Descending</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex justify-content-md-end justify-content-sm-start">
                        <button class="btn btn-dark me-2" type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('damage_reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
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

        <!-- Link to Add Damage Report Page -->
        <a href="{{ route('damage_reports.create') }}" class="btn btn-dark mb-3">
            <i class="fas fa-plus"></i> Add Damage Report
        </a>

        <!-- Damage Report Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-success text-white">
                    <tr>
                        <th>#</th>
                        <th>Crop Name</th>
                        <th>Variety</th>
                        <th>Type</th>
                        <th>Damage Type</th>
                        <th>Natural Disaster Type</th>
                        <th>Damage Name</th>
                        <th>Area Planted (ha)</th>
                        <th>Area Affected (ha)</th>
                        <th>Month Observed</th>
                        <th>Author</th>
                        <th>Modified By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($damageReports as $index => $damageReport)
                        <tr>
                            <td>{{ $damageReports->firstItem() + $index }}</td>
                            <td>{{ $damageReport->cropName }}</td>
                            <td>{{ $damageReport->variety }}</td>
                            <td>{{ $damageReport->type }}</td>
                            <td>{{ $damageReport->damage_type }}</td>
                            <td>{{ $damageReport->natural_disaster_type ?? 'N/A' }}</td>
                            <td>{{ $damageReport->damage_name ?? 'N/A' }}</td>
                            <td>{{ $damageReport->area_planted }}</td>
                            <td>{{ $damageReport->area_affected }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $damageReport->monthObserved)->format('F Y') }}
                            </td>
                            <td>{{ $damageReport->author->name ?? 'Unknown' }}</td>
                            <td>{{ $damageReport->modifier->name ?? 'N/A' }}</td>
                            <td>
                                <div class="input-group">
                                    <div class="w-100 mb-2">
                                        <a href="{{ route('damage_reports.edit', $damageReport) }}"
                                            class="btn btn-sm btn-primary w-100">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                    <div class="w-100">
                                        <form method="POST"
                                            action="{{ route('damage_reports.destroy', $damageReport) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100"
                                                onclick="return confirm('Are you sure you want to delete this damage report?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $damageReports->links() }}
        </div>
    </div>
</x-app-layout>
