<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Crop: ') . $crop->cropName }}
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

        <!-- Edit Crop Form -->
        <form method="POST" action="{{ route('crops.update', $crop) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Crop Name -->
            <div class="mb-3">
                <label for="cropName" class="form-label">Crop Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-seedling"></i></span>
                    <input type="text" class="form-control @error('cropName') is-invalid @enderror" id="cropName"
                        name="cropName" value="{{ old('cropName', $crop->cropName) }}" required>
                </div>
                @error('cropName')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Type -->
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-leaf"></i></span>
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type"
                        required>
                        <option value="" disabled>Select Type</option>
                        <option value="Rice" {{ old('type', $crop->type) == 'Rice' ? 'selected' : '' }}>Rice</option>
                        <option value="Vegetables" {{ old('type', $crop->type) == 'Vegetables' ? 'selected' : '' }}>
                            Vegetables</option>
                        <option value="Fruits" {{ old('type', $crop->type) == 'Fruits' ? 'selected' : '' }}>Fruits
                        </option>
                    </select>
                </div>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                    rows="3">{{ old('description', $crop->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Planting Period -->
            <div class="mb-3">
                <label for="planting_period" class="form-label">Planting Period</label>
                <input type="text" class="form-control @error('planting_period') is-invalid @enderror"
                    id="planting_period" name="planting_period"
                    value="{{ old('planting_period', $crop->planting_period) }}">
                @error('planting_period')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Growth Duration -->
            <div class="mb-3">
                <label for="growth_duration" class="form-label">Growth Duration (in days)</label>
                <input type="number" class="form-control @error('growth_duration') is-invalid @enderror"
                    id="growth_duration" name="growth_duration"
                    value="{{ old('growth_duration', $crop->growth_duration) }}">
                @error('growth_duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image Upload (optional for editing) -->
            <div class="mb-3">
                <label for="img" class="form-label">Crop Image (Optional)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                    <input type="file" class="form-control @error('img') is-invalid @enderror" id="img"
                        name="img">
                </div>
                @if ($crop->img)
                    <div class="mt-2">
                        <p>Current Image:</p>
                        <img src="{{ asset('storage/' . $crop->img) }}" alt="Crop Image" class="img-thumbnail"
                            width="150">
                    </div>
                @endif
                @error('img')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save"></i> Update Crop
                </button>
                <a href="{{ route('crops.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Crop Management
                </a>
            </div>
        </form>

    </div>

</x-app-layout>
