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
                    @foreach ($users as $index => $user)
                        <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-light' : '' }}">
                            <td>{{ $users->firstItem() + $index }}</td> <!-- Adjust numbering for pagination -->
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

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusButtons = document.querySelectorAll('[data-status]');
            statusButtons.forEach(function(button) {
                const currentStatus = button.getAttribute('data-status') === '1' ? 1 : 0;
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
            const currentStatus = button.getAttribute('data-status') === '1' ? 1 : 0;

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
                        const newStatus = currentStatus === 1 ? 0 : 1;
                        button.innerHTML = '';
                        const icon = document.createElement('i');
                        icon.classList.add('fas', 'fa-toggle-' + (newStatus ? 'on' : 'off'));
                        button.appendChild(icon);
                        button.appendChild(document.createTextNode(' ' + (newStatus ? 'Deactivate' : 'Activate')));

                        if (newStatus) {
                            button.classList.add('btn-danger');
                            button.classList.remove('btn-success');
                        } else {
                            button.classList.add('btn-success');
                            button.classList.remove('btn-danger');
                        }

                        button.setAttribute('data-status', newStatus);

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
        .table-bordered {
            border: 2px solid #ddd;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table th,
        .table td {
            padding: 10px;
        }
    </style>
</x-app-layout>
