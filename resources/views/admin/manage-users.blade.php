<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
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

        <!-- Link to Open Add User Page -->
        <a href="{{ route('admin.add-user') }}" class="btn btn-primary mb-3">Add User</a>

        <!-- User Table -->
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <button class="btn btn-sm {{ $user->status ? 'btn-danger' : 'btn-success' }}"
                                data-id="{{ $user->id }}" data-status="{{ $user->status }}"
                                onclick="toggleStatus(this)">
                                {{ $user->status ? 'Deactivate' : 'Activate' }}
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function toggleStatus(button) {
            const userId = button.getAttribute('data-id');
            const currentStatus = button.getAttribute('data-status') === '1' ? 1 :
            0; // Current status: 1 = Active, 0 = Inactive

            fetch(`/admin/toggle-status/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Determine new status
                        const newStatus = currentStatus === 1 ? 0 : 1; // Toggle the status

                        // Update the button text and color based on new status
                        button.textContent = newStatus ? 'Deactivate' : 'Activate';
                        button.classList.toggle('btn-danger', newStatus); // If Active, btn-danger (for Deactivate)
                        button.classList.toggle('btn-success', !newStatus); // If Inactive, btn-success (for Activate)
                        button.setAttribute('data-status', newStatus); // Update the status value

                        // Update the status column in the table immediately
                        const statusCell = button.closest('tr').querySelector('td:nth-child(4)');
                        statusCell.textContent = newStatus ? 'Active' : 'Inactive';
                    } else {
                        alert('Error toggling status');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

</x-app-layout>
