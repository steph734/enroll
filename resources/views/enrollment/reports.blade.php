@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container">
    <h2>Reports</h2>
    <p>Generate enrollment and student reports for the SHS Student Enrollment System.</p>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Select Report Type</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-subtitle mb-2 text-muted">Enrollment Report</h5>
                            <p class="card-text">Summary of enrolled students by grade level, status, strand, and track.
                            </p>
                            <a href="{{ route('reports.generate', ['type' => 'enrollment']) }}" target="_blank"
                                class="btn btn-primary">
                                <i class="fa-solid fa-file-pdf"></i> Generate Enrollment Report
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-subtitle mb-2 text-muted">Student Report</h5>
                            <p class="card-text">Detailed records of all students including personal information and
                                enrollment details.</p>
                            <a href="{{ route('reports.generate', ['type' => 'student']) }}" target="_blank"
                                class="btn btn-primary">
                                <i class="fa-solid fa-file-pdf"></i> Generate Student Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection