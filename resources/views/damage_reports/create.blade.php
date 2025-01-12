<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Damages Report') }}
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

        <!-- Add Damages Report Form -->
        <form method="POST" action="{{ route('damage_reports.store') }}">
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
                        name="variety" value="{{ old('variety') }}" required>
                </div>
                @error('variety')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Type -->
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                    <option value="">Select Type</option>
                    <option value="Vegetables" {{ old('type') == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
                    <option value="Fruits" {{ old('type') == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                    <option value="Rice" {{ old('type') == 'Rice' ? 'selected' : '' }}>Rice</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Type of Damage -->
            <div class="mb-3">
                <label for="damageType" class="form-label">Type of Damage</label>
                <select class="form-select @error('damage_type') is-invalid @enderror" id="damageType"
                    name="damage_type" required>
                    <option value="" disabled selected>Select Damage Type</option>
                    <option value="Natural Disaster" {{ old('damage_type') == 'Natural Disaster' ? 'selected' : '' }}>
                        Natural Disaster</option>
                    <option value="Pest" {{ old('damage_type') == 'Pest' ? 'selected' : '' }}>Pest</option>
                    <option value="Disease" {{ old('damage_type') == 'Disease' ? 'selected' : '' }}>Disease</option>
                </select>
                @error('damage_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Natural Disaster Type -->
            <div class="mb-3" id="naturalDisasterTypeContainer" style="display: none;">
                <label for="naturalDisasterType" class="form-label">Natural Disaster Type</label>
                <select class="form-select @error('natural_disaster_type') is-invalid @enderror"
                    id="naturalDisasterType" name="natural_disaster_type">
                    <option value="" disabled selected>Select a natural disaster</option>
                    <option value="Flood" {{ old('natural_disaster_type') == 'Flood' ? 'selected' : '' }}>Flood
                    </option>
                    <option value="Typhoon" {{ old('natural_disaster_type') == 'Typhoon' ? 'selected' : '' }}>Typhoon
                    </option>
                    <option value="Drought" {{ old('natural_disaster_type') == 'Drought' ? 'selected' : '' }}>Drought
                    </option>
                    <option value="Earthquake" {{ old('natural_disaster_type') == 'Earthquake' ? 'selected' : '' }}>
                        Earthquake</option>
                    <option value="Volcanic Eruption"
                        {{ old('natural_disaster_type') == 'Volcanic Eruption' ? 'selected' : '' }}>
                        Volcanic Eruption</option>
                    <option value="Landslide" {{ old('natural_disaster_type') == 'Landslide' ? 'selected' : '' }}>
                        Landslide</option>
                    <option value="Other" {{ old('natural_disaster_type') == 'Other' ? 'selected' : '' }}>Other
                    </option>
                </select>
                @error('natural_disaster_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Damage Name -->
            <div class="mb-3">
                <label for="damageName" class="form-label">Damage Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-bug"></i></span>
                    <input type="text" class="form-control @error('damage_name') is-invalid @enderror"
                        id="damageName" name="damage_name" value="{{ old('damage_name') }}">
                </div>
                <small class="form-text text-muted">This can be the typhoon name, pest, or disease
                    name/observation.</small>
                @error('damage_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Area Planted -->
            <div class="mb-3">
                <label for="areaPlanted" class="form-label">Area Planted (ha)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-arrows-alt-h"></i></span>
                    <input type="number" step="0.01"
                        class="form-control @error('area_planted') is-invalid @enderror" id="areaPlanted"
                        name="area_planted" value="{{ old('area_planted') }}" required>
                </div>
                @error('area_planted')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Area Affected -->
            <div class="mb-3">
                <label for="areaAffected" class="form-label">Area Affected (ha)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="number" step="0.01"
                        class="form-control @error('area_affected') is-invalid @enderror" id="areaAffected"
                        name="area_affected" value="{{ old('area_affected') }}" required>
                </div>
                @error('area_affected')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Month Observed -->
            <div class="mb-3">
                <label for="monthObserved" class="form-label">Month Observed</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    <input type="month" class="form-control @error('monthObserved') is-invalid @enderror"
                        id="monthObserved" name="monthObserved" value="{{ old('monthObserved') }}" required>
                </div>
                @error('monthObserved')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save"></i> Save Report
                </button>
                <a href="{{ route('damage_reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Reports
                </a>
            </div>
        </form>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const damageType = document.getElementById('damageType');
            const naturalDisasterTypeContainer = document.getElementById('naturalDisasterTypeContainer');

            // Show or hide the natural disaster type field based on the selected damage type
            damageType.addEventListener('change', function() {
                if (this.value === 'Natural Disaster') {
                    naturalDisasterTypeContainer.style.display = 'block';
                } else {
                    naturalDisasterTypeContainer.style.display = 'none';
                }
            });

            // Trigger change event on page load to handle old value
            damageType.dispatchEvent(new Event('change'));
        });
    </script>
</x-app-layout>
