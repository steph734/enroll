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
        <div class="row mb-2">
            <div class="col-md-4">
                <div class="card card-first">
                    <div class="card-body text-center">
                        <h5>HUMMS</h5>
                        <canvas id="hummsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-first">
                    <div class="card-body text-center">
                        <h5>STEM</h5>
                        <canvas id="stemChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-abm">
                    <div class="card-body text-center">
                        <h5>ABM</h5>
                        <canvas id="abmChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="h5">Recent Students</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Grade Level</th>
                            <th scope="col">Strand</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentStudents as $index => $student)
                        <tr>
                            <th><i class="fa-solid fa-angle-right"></i></th>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td>{{ $student->grade_level }}</td>
                            <td>{{ $student->strand->strand_name }}</td>
                            <td>{{ $student->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pass chart data from PHP to JavaScript safely
    const chartData = {
        {
            json_encode($chartData)
        }
    };

    // Pie Chart for HUMMS
    const hummsChart = new Chart(document.getElementById('hummsChart'), {
        type: 'pie',
        data: {
            labels: ['HUMMS', 'Others'],
            datasets: [{
                data: [
                    chartData.humms.strand || 0,
                    chartData.humms.others || 0
                ],
                backgroundColor: ['#5e63ff', '#d3d3d3']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Pie Chart for STEM
    const stemChart = new Chart(document.getElementById('stemChart'), {
        type: 'pie',
        data: {
            labels: ['STEM', 'Others'],
            datasets: [{
                data: [
                    chartData.stem.strand || 0,
                    chartData.stem.others || 0
                ],
                backgroundColor: ['#305cde', '#d3d3d3']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Pie Chart for ABM
    const abmChart = new Chart(document.getElementById('abmChart'), {
        type: 'pie',
        data: {
            labels: ['ABM', 'Others'],
            datasets: [{
                data: [
                    chartData.abm.strand || 0,
                    chartData.abm.others || 0
                ],
                backgroundColor: ['#5e63ff', '#d3d3d3']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection