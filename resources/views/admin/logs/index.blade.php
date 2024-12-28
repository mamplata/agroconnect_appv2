<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Logs') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.logs.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search"
                    placeholder="Search by Action, Model, Changes or User" value="{{ old('search', $search) }}">
                <button class="btn btn-dark" type="submit">
                    <i class="fas fa-search"></i> Search
                </button>
                <button type="button" class="btn btn-secondary" onclick="resetSearch()">
                    <i class="fas fa-redo"></i> Reset
                </button>
            </div>
        </form>

        <!-- Display Success or Error Messages -->
        @if (session('status'))
            <div class="alert {{ session('status_type') == 'success' ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show"
                role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Log Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-success text-white">
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Model</th>
                        <th>Changes</th>
                        <th>User</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $index => $log)
                        <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-light' : '' }}">
                            <td>{{ $logs->firstItem() + $index }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->model }}</td>
                            <td>{{ Str::limit(is_array($log->changes) ? json_encode($log->changes) : $log->changes, 50) }}
                            </td>
                            <td>{{ $log->user ? $log->user->name : 'N/A' }}</td>
                            <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $logs->links() }}
        </div>
    </div>

    <script>
        function resetSearch() {
            const url = "{{ route('admin.logs.index') }}";
            window.location.href = url;
        }
    </script>
</x-app-layout>
