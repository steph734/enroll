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
</style>

@endsection
@section('content')
<div class="container">
    <h2>Accounts</h2>
    <p>Manage admin accounts for the SHS Student Enrollment System.</p>

    <!-- Success/Error Messages Placeholder -->
    <div class="alert alert-success" style="display: none;">
        This is a success message placeholder.
    </div>
    <div class="alert alert-danger" style="display: none;">
        This is an error message placeholder.
    </div>

    <!-- Create Admin Account Form -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Create Admin Account</h5>
            <hr>
            <form action="#" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
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
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>admin1</td>
                        <td>admin</td>
                        <td>active</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to deactivate this account?')">Deactivate</button>
                        </td>
                    </tr>
                    <tr>
                        <td>admin2</td>
                        <td>admin</td>
                        <td>deactivated</td>
                        <td>
                            <span class="text-muted">Deactivated</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection