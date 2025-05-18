@extends('layouts.app')

@section('title', 'Reports')

@section('styles')
<style>
    .reports-container {
        padding: 20px;
    }
    .report-card {
        height: 100%;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .card-subtitle {
        color: #2c3e50 !important;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }
    .card-text {
        color: #666;
        margin-bottom: 1.5rem;
        min-height: 48px;
    }
    .btn-primary {
        padding: 8px 16px;
        font-size: 14px;
    }
    .btn-primary i {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="reports-container">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <h2>Reports</h2>
            <p style="font-size: 18px; color:#555 !important;">Generate enrollment and student reports for the SHS Student Enrollment System.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Select Report Type</h5>
            <hr>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card report-card">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-subtitle">Enrollment Report</h5>
                            <p class="card-text" style="color:#555 !important;">Summary of enrolled students by grade level, status, strand, and track.</p>
                            <div class="mt-auto">
                                <a href="{{ route('reports.generate', ['type' => 'enrollment']) }}" target="_blank"
                                    class="btn btn-primary">
                                    <i class="fa-solid fa-file-pdf"></i> Generate Enrollment Report
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card report-card">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-subtitle">Student Report</h5>
                            <p class="card-text"style="color:#555 !important;">Detailed records of all students including personal information and enrollment details.</p>
                            <div class="mt-auto">
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
</div>
@endsection