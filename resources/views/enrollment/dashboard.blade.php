@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="dashboard-content my-auto">
    <div class="container">
        <p>
            <span class="h5" style="color:#555 !important;">Welcome back,
                {{ ucfirst(auth()->user()->username) }}!</span><br>
            <span class="h2" style="color: var(--text-clr) !important;">Dashboard</span>
        </p>

        <hr>
        <div class="row mt-3 mb-2">
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-users stat-icon"></i>
                        <h3>{{ $totalStudents }}</h3>
                        <p>Total Students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-hourglass-half stat-icon"></i>
                        <h3>{{ $pendingStudents }}</h3>
                        <p>Pending Students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-user-check stat-icon"></i>
                        <h3>{{ $activeStudents }}</h3>
                        <p>Active Students</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="h6">Recent Students</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Grade Level</th>
                            <th scope="col">Strand</th>
                            <th scope="col">Status</th>
                            <th scope="col">Enrolled Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentStudents as $index => $student)
                        <tr>
                            <th class="text-primary"><a
                                    href="{{ route('student.edit',['id' => $student->id,'formtype'=>'view']) }}"><i
                                        class="fa-solid fa-angle-right"></i></a></th>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td>{{ $student->grade_level }}</td>
                            <td>{{ $student->strand->strand_name }}</td>
                            <td>{{ $student->status }}</td>
                            <td>{{ $student->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <!-- <div>
                        Showing {{ $recentStudents->firstItem() ?? 0 }} to {{ $recentStudents->lastItem() ?? 0 }} of {{ $recentStudents->total() }} entries
                    </div> -->
                    <div>
                        {{ $recentStudents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection