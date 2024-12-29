<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Crop Reports') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('admin.crop_reports.index') }}" class="mb-3">
            <div class="input-group">
                <div class="row w-100">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="search"
                            placeholder="Search by Crop Name or Variety" value="{{ old('search', $search) }}">
                    </div>
                    <div class="col-md-2">
                        <select name="type" class="form-control">
                            <option value="">Filter by Type</option>
                            <option value="Rice" {{ old('type', $type) == 'Rice' ? 'selected' : '' }}>Rice</option>
                            <option value="Vegetables" {{ old('type', $type) == 'Vegetables' ? 'selected' : '' }}>
                                Vegetables</option>
                            <option value="Fruits" {{ old('type', $type) == 'Fruits' ? 'selected' : '' }}>Fruits
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="sortBy" class="form-control">
                            <option value="created_at" {{ old('sortBy', $sortBy) == 'created_at' ? 'selected' : '' }}>
                                Sort by Date</option>
                            <option value="areaPlanted" {{ old('sortBy', $sortBy) == 'areaPlanted' ? 'selected' : '' }}>
                                Sort by Area Planted</option>
                            <option value="productionVolume"
                                {{ old('sortBy', $sortBy) == 'productionVolume' ? 'selected' : '' }}>Sort by Production
                                Volume</option>
                            <option value="yield" {{ old('sortBy', $sortBy) == 'yield' ? 'selected' : '' }}>Sort by
                                Yield</option>
                            <option value="price" {{ old('sortBy', $sortBy) == 'price' ? 'selected' : '' }}>Sort by
                                Price</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="sortOrder" class="form-control">
                            <option value="asc" {{ old('sortOrder', $sortOrder) == 'asc' ? 'selected' : '' }}>
                                Ascending</option>
                            <option value="desc" {{ old('sortOrder', $sortOrder) == 'desc' ? 'selected' : '' }}>
                                Descending</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex">
                        <button class="btn btn-dark me-2" type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('admin.crop_reports.index') }}" class="btn btn-secondary">
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

        <!-- Crop Report Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-success text-white">
                    <tr>
                        <th>#</th>
                        <th>Crop Name</th>
                        <th>Variety</th>
                        <th>Type</th>
                        <th>Area Planted</th>
                        <th>Production Volume</th>
                        <th>Yield</th>
                        <th>Price</th>
                        <th>Month Observed</th>
                        <th>Author</th>
                        <th>Modified By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cropReports as $index => $cropReport)
                        <tr>
                            <td>{{ $cropReports->firstItem() + $index }}</td>
                            <td>{{ $cropReport->cropName }}</td>
                            <td>{{ $cropReport->variety }}</td>
                            <td>{{ $cropReport->type }}</td>
                            <td>{{ $cropReport->areaPlanted }}</td>
                            <td>{{ $cropReport->productionVolume }}</td>
                            <td>{{ $cropReport->yield }}</td>
                            <td>{{ $cropReport->price }}</td>
                            <td>{{ $cropReport->monthObserved }}</td>
                            <td>{{ $cropReport->author->name ?? 'Unknown' }}</td>
                            <td>{{ $cropReport->modifier->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $cropReports->links() }}
        </div>
    </div>
</x-app-layout>
