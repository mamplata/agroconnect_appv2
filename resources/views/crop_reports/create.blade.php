<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Crop Report') }}
        </h2>
    </x-slot>

    <div class="container mt-5">

        <!-- Show success or error messages -->
        @if (session('status'))
            <div class="card mb-4">
                <div class="card-body text-white {{ session('status_type') == 'success' ? 'bg-success' : 'bg-danger' }}">
                    <p class="mb-0">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add Crop Report Form -->
        <form method="POST" action="{{ route('crop_reports.store') }}">
            @csrf

            <!-- Crop Name -->
            <div class="mb-3">
                <label for="cropName" class="form-label">Crop Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-seedling"></i></span>
                    <input type="text" class="form-control @error('cropName') is-invalid @enderror" id="cropName"
                        name="cropName" value="{{ old('cropName') }}" required>
                </div>
                @error('cropName')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Variety -->
            <div class="mb-3">
                <label for="variety" class="form-label">Variety</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-leaf"></i></span>
                    <input type="text" class="form-control @error('variety') is-invalid @enderror" id="variety"
                        name="variety" value="{{ old('variety') }}">
                </div>
                @error('variety')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Type -->
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                    <option value="" disabled selected>Select Type</option>
                    <option value="Rice" {{ old('type') == 'Rice' ? 'selected' : '' }}>Rice</option>
                    <option value="Vegetables" {{ old('type') == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
                    <option value="Fruits" {{ old('type') == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Area Planted -->
            <div class="mb-3">
                <label for="areaPlanted" class="form-label">Area Planted (hectares)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-arrows-alt-h"></i></span>
                    <input type="number" step="0.01" class="form-control @error('areaPlanted') is-invalid @enderror"
                        id="areaPlanted" name="areaPlanted" value="{{ old('areaPlanted') }}" required>
                </div>
                @error('areaPlanted')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Production Volume -->
            <div class="mb-3">
                <label for="productionVolume" class="form-label">Production Volume (kg)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-weight-hanging"></i></span>
                    <input type="number" step="0.01"
                        class="form-control @error('productionVolume') is-invalid @enderror" id="productionVolume"
                        name="productionVolume" value="{{ old('productionVolume') }}" required>
                </div>
                @error('productionVolume')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Yield -->
            <div class="mb-3">
                <label for="yield" class="form-label">Yield (kg/hectare)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-cogs"></i></span>
                    <input type="number" step="0.01" class="form-control @error('yield') is-invalid @enderror"
                        id="yield" name="yield" value="{{ old('yield') }}" required>
                </div>
                @error('yield')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">Price (per kg)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                        id="price" name="price" value="{{ old('price') }}" required>
                </div>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Month Observed -->
            <div class="mb-3">
                <label for="monthObserved" class="form-label">Month Observed</label>
                <input type="month" class="form-control @error('monthObserved') is-invalid @enderror"
                    id="monthObserved" name="monthObserved" value="{{ old('monthObserved') }}" required>
                @error('monthObserved')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save"></i> Save Report
                </button>
                <a href="{{ route('crop_reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Crop Reports
                </a>
            </div>
        </form>

    </div>

</x-app-layout>
