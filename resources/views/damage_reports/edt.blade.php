<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Damage Report: ') . $damagesReport->cropName }}
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

        <!-- Edit Damage Report Form -->
        <form method="POST" action="{{ route('damage_reports.update', $damagesReport) }}">
            @csrf
            @method('PUT')

            <!-- Crop Name -->
            <div class="mb-3">
                <label for="cropName" class="form-label">Crop Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-seedling"></i></span>
                    <input type="text" class="form-control @error('cropName') is-invalid @enderror" id="cropName"
                        name="cropName" value="{{ old('cropName', $damagesReport->cropName) }}" required>
                </div>
                @error('cropName')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Damage Type -->
            <div class="mb-3">
                <label for="damageType" class="form-label">Damage Type</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-skull-crossbones"></i></span>
                    <select class="form-select @error('damageType') is-invalid @enderror" id="damageType"
                        name="damageType" required>
                        <option value="" disabled>Select Damage Type</option>
                        <option value="Pest"
                            {{ old('damageType', $damagesReport->damageType) == 'Pest' ? 'selected' : '' }}>Pest
                        </option>
                        <option value="Disease"
                            {{ old('damageType', $damagesReport->damageType) == 'Disease' ? 'selected' : '' }}>Disease
                        </option>
                        <option value="Weather"
                            {{ old('damageType', $damagesReport->damageType) == 'Weather' ? 'selected' : '' }}>Weather
                        </option>
                    </select>
                </div>
                @error('damageType')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Damage Area -->
            <div class="mb-3">
                <label for="damageArea" class="form-label">Area Damaged (ha)</label>
                <input type="number" class="form-control @error('damageArea') is-invalid @enderror" id="damageArea"
                    name="damageArea" value="{{ old('damageArea', $damagesReport->damageArea) }}" required>
                @error('damageArea')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Estimated Loss -->
            <div class="mb-3">
                <label for="estimatedLoss" class="form-label">Estimated Loss (kg)</label>
                <input type="number" class="form-control @error('estimatedLoss') is-invalid @enderror"
                    id="estimatedLoss" name="estimatedLoss"
                    value="{{ old('estimatedLoss', $damagesReport->estimatedLoss) }}" required>
                @error('estimatedLoss')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Loss Cause -->
            <div class="mb-3">
                <label for="lossCause" class="form-label">Cause of Loss</label>
                <textarea class="form-control @error('lossCause') is-invalid @enderror" id="lossCause" name="lossCause" required>{{ old('lossCause', $damagesReport->lossCause) }}</textarea>
                @error('lossCause')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Month Observed -->
            <div class="mb-3">
                <label for="monthObserved" class="form-label">Month Observed</label>
                <input type="month" class="form-control @error('monthObserved') is-invalid @enderror"
                    id="monthObserved" name="monthObserved"
                    value="{{ old('monthObserved', $damagesReport->monthObserved) }}" required>
                @error('monthObserved')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save"></i> Update Damage Report
                </button>
                <a href="{{ route('damage_reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Damage Reports
                </a>
            </div>
        </form>

    </div>

</x-app-layout>
