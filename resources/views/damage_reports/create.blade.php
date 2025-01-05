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

            <!-- Type of Damage -->
            <div class="mb-3">
                <label for="damageType" class="form-label">Type of Damage</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                    <input type="text" class="form-control @error('damageType') is-invalid @enderror" id="damageType"
                        name="damageType" value="{{ old('damageType') }}" required>
                </div>
                @error('damageType')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Area Affected (hectares) -->
            <div class="mb-3">
                <label for="areaAffected" class="form-label">Area Affected (hectares)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-arrows-alt-h"></i></span>
                    <input type="number" step="0.01"
                        class="form-control @error('areaAffected') is-invalid @enderror" id="areaAffected"
                        name="areaAffected" value="{{ old('areaAffected') }}" required>
                </div>
                @error('areaAffected')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Estimated Loss -->
            <div class="mb-3">
                <label for="estimatedLoss" class="form-label">Estimated Loss (PHP)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                    <input type="number" step="0.01"
                        class="form-control @error('estimatedLoss') is-invalid @enderror" id="estimatedLoss"
                        name="estimatedLoss" value="{{ old('estimatedLoss') }}" required>
                </div>
                @error('estimatedLoss')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Date of Occurrence -->
            <div class="mb-3">
                <label for="dateOccurred" class="form-label">Date of Occurrence</label>
                <input type="date" class="form-control @error('dateOccurred') is-invalid @enderror" id="dateOccurred"
                    name="dateOccurred" value="{{ old('dateOccurred') }}" required>
                @error('dateOccurred')
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
                <a href="{{ route('damage_reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Reports
                </a>
            </div>
        </form>

    </div>

</x-app-layout>
