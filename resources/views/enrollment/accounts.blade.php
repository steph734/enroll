@extends('layouts.app')

@section('title', 'Accounts')

@section('styles')
<style>
    .card {
        border-left: 4px solid #007bff;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .nav-tabs .nav-link {
        color: #007bff;
    }

    .tab-content {
        padding: 20px;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 5px 5px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2>Accounts Management</h2>
    <p>Manage admin accounts, profile, and view audit logs for the SHS Student Enrollment System.</p>

    @if ($errors->any())
    <div class="alert alert-danger p-1 mb-3">
        <i class="fa-solid fa-circle-exclamation"></i>
        <strong>Whoops!</strong> There were some problems with your input.
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success p-1 mb-3">
        <strong><i class="fa-solid fa-circle-check"></i> Success!</strong> {{ session('success') }}
    </div>
    @endif

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" id="accounts-tab" data-bs-toggle="tab" href="#accounts">Accounts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="audit-logs-tab" data-bs-toggle="tab" href="#audit-logs">Audit Logs</a>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content">
        <!-- Accounts Tab -->
        <div class="tab-pane fade show active" id="accounts">
            <!-- Create Admin Account Form -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Create Admin Account</h5>
                    <hr>
                    <form action="{{ route('accounts.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary btn-sm">Create Account</button>
                    </form>
                </div>
            </div>

            <!-- Accounts List -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Admin Accounts</h5>
                    <hr>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\User::orderBy('created_at', 'desc')->get() as $user)
                            <tr class="account-row" data-status="{{ $user->status }}">
                                <td>{{ $user->username }}</td>
                                <td>
                                    <select name="status" class="form-select form-select-sm status-select"
                                        data-user-id="{{ $user->id }}" data-original-status="{{ $user->status }}">
                                        <option value="Active" {{ $user->status === 'Active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="Deactivated"
                                            {{ $user->status === 'Deactivated' ? 'selected' : '' }}>
                                            Deactivated
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center">No accounts found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Profile Tab -->
        <div class="tab-pane fade" id="profile">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User Profile</h5>
                    <hr>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="profile-username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="profile-username" name="username"
                                    value="{{ auth()->user()->username }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="new-password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new-password" name="password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary btn-sm">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Audit Logs Tab -->
        <div class="tab-pane fade" id="audit-logs">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Audit Logs</h5>
                    <hr>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>User</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\AuditLog::orderBy('created_at', 'desc')->take(50)->get() as $log)
                            <tr>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->user->username ?? 'System' }}</td>
                                <td>{{ now()->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No audit logs found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fade out alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 1s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 1000);
            }, 3000);
        });

        // Handle status select change
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const userId = this.dataset.userId;
                const newStatus = this.value;
                const originalStatus = this.dataset.originalStatus;

                fetch(`/accounts/${userId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Status updated successfully.');
                            this.dataset.originalStatus = newStatus;
                            document.querySelector(
                                `.account-row[data-status][data-status="${originalStatus}"]`
                            ).dataset.status = newStatus;
                        } else {
                            alert('Failed to update status: ' + data.message);
                            this.value = originalStatus; // Revert on failure
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating status.');
                        this.value = originalStatus; // Revert on error
                    });
            });
        });
    });
</script>
@endsection