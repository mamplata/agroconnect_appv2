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
        <a href="{{ route('admin.add-user') }}" class="btn btn-dark mb-3">
            <i class="fas fa-user-plus"></i> Add User
        </a>

        <!-- User Table with Agricultural Theme - Make it scrollable on small screens -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-success text-white">
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
                        <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-light' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->status ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <button class="btn btn-sm {{ $user->status ? 'btn-success' : 'btn-danger' }}"
                                    data-id="{{ $user->id }}" data-status="{{ $user->status }}"
                                    onclick="toggleStatus(this)">
                                    <i class="fas fa-toggle-{{ $user->status ? 'on' : 'off' }}"></i>
                                    {{ $user->status ? 'Deactivate' : 'Activate' }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure that all buttons reflect the correct status and color on initial load
            const statusButtons = document.querySelectorAll('[data-status]');
            statusButtons.forEach(function(button) {
                const currentStatus = button.getAttribute('data-status') === '1' ? 1 :
                    0; // Active (1) or Inactive (0)

                // Set the button color based on the current status
                if (currentStatus === 1) {
                    button.classList.add('btn-danger');
                    button.classList.remove('btn-success');
                } else {
                    button.classList.add('btn-success');
                    button.classList.remove('btn-danger');
                }
            });
        });

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

                        // Clear the button content and add new icon and text based on new status
                        button.innerHTML = ''; // Reset the button content
                        const icon = document.createElement('i');
                        icon.classList.add('fas', 'fa-toggle-' + (newStatus ? 'on' : 'off'));
                        button.appendChild(icon);
                        button.appendChild(document.createTextNode(' ' + (newStatus ? 'Deactivate' : 'Activate')));

                        // Toggle button color based on the new status
                        if (newStatus) {
                            button.classList.add('btn-danger'); // Active - green
                            button.classList.remove('btn-success'); // Inactive - red
                        } else {
                            button.classList.add('btn-success'); // Inactive - red
                            button.classList.remove('btn-danger'); // Active - green
                        }

                        // Update the status value on the button
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

    <style>
        /* Ensure table borders are visible */
        .table-bordered {
            border: 2px solid #ddd;
            /* Light gray border */
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
            /* Light gray border for cells */
        }

        /* Optional: Add a shadow effect to table rows */
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Optional: Add padding for better spacing */
        .table th,
        .table td {
            padding: 10px;
        }
    </style>
</x-app-layout>
