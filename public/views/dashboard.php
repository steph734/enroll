<!-- ../views/dashboard.php -->
<?php
?>
<link rel="stylesheet" href="../css/dashboard.css">

<div class="dashboard-content my-auto">

    <p class="h4" style="color: var(--text-clr) !important;">
        Dashboard</p>
    <hr>
    <div class="row mb-2 justify-content-center">
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


    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card card-students">
                <div class="card-body">
                    <h5>Students</h5>
                    <canvas id="studentsChart" height="50"></canvas>
                    <div class="chart-legend">
                        <span><i class="fas fa-circle" style="color: #305cde;"></i> STEM</span>
                        <span><i class="fas fa-circle" style="color: #5e63ff;"></i> ABM</span>
                        <span><i class="fas fa-circle" style="color: #d3d3d3;"></i> HUMMS</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-bar">
                <div class="card-body">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <i class="fas fa-users stat-icon"></i>
                    <h3>1,432</h3>
                    <p>Total Students</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <i class="fas fa-file-alt stat-icon"></i>
                    <h3>2,000</h3>
                    <p>Total Applications</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle stat-icon"></i>
                    <h3>1,821</h3>
                    <p>Submitted Applications</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js for charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pie Chart for HUMMS
    const hummsChart = new Chart(document.getElementById('hummsChart'), {
        type: 'pie',
        data: {
            labels: ['HUMMS', 'Others'],
            datasets: [{
                data: [40, 60], // Example data
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

    // Pie Chart for ABM
    const abmChart = new Chart(document.getElementById('abmChart'), {
        type: 'pie',
        data: {
            labels: ['ABM', 'Others'],
            datasets: [{
                data: [30, 70], // Example data
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
                data: [50, 50], // Example data
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

    // Larger Pie Chart for Students
    const studentsChart = new Chart(document.getElementById('studentsChart'), {
        type: 'pie',
        data: {
            labels: ['STEM', 'ABM', 'HUMMS'],
            datasets: [{
                data: [40, 30, 30], // Example data
                backgroundColor: ['#305cde', '#5e63ff', '#d3d3d3']
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

    // Bar Chart
    const barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['STEM', 'ABM', 'HUMMS'],
            datasets: [{
                label: 'STEM',
                data: [80, 0, 0],
                backgroundColor: '#305cde'
            }, {
                label: 'ABM',
                data: [0, 60, 0],
                backgroundColor: '#5e63ff'
            }, {
                label: 'HUMMS',
                data: [0, 0, 40],
                backgroundColor: '#d3d3d3'
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script>