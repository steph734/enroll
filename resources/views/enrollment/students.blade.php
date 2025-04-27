@extends('layouts.app')
@section('title', 'Students')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/students.css') }}">
@endsection
@section('content')

<div class="students-content">
    <div class="mb-3 row">
        <div class="row row-header-student">
            <div class="p-3 card card-header-student sticky-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            <h5>List of Students</h5>
                        </div>
                        <form action="" id="searchForm">
                            <div class="search-container-dash">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" placeholder="Search..." id="searchInput" class="form-control">
                                <div id="suggestions" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000;"></div>
                            </div>
                        </form>
                    </div>

                    <!-- Filters Section -->
                    <div class="mt-3 filters d-flex justify-content-between align-items-center">
                        <div class="gap-3 tabs d-flex">
                            <button class="tab active" data-filter="all">ALL Students</button>
                            <button class="tab" data-filter="STEM">STEM</button>
                            <button class="tab" data-filter="ABM">ABM</button>
                            <button class="tab" data-filter="HUMSS">HUMSS</button>
                        </div>

                        <div class="gap-2 dropdowns d-flex">
                            <select class="form-select" style="width: 150px;">
                                <option>Filter by</option>
                                <option value="grade">Grade</option>
                                <option value="age">Age</option>
                            </select>
                            <select class="form-select" style="width: 150px;">
                                <option>Sort by</option>
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                                <option value="grade-asc">Grade (Low to High)</option>
                                <option value="grade-desc">Grade (High to Low)</option>
                            </select>
                        </div>

                        <a href="{{ route('student.create') }}">
                            <button class="btn btn-primary add-student">Add Student</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="p-3 card card-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" style="cursor: pointer;">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle">ID</th>
                                <th scope="col" class="align-middle">First Name</th>
                                <th scope="col" class="align-middle">Last Name</th>
                                <th scope="col" class="align-middle">Email</th>
                                <th scope="col" class="align-middle">Age</th>
                                <th scope="col" class="align-middle">Strand</th>
                                <th scope="col" class="align-middle">Track</th>
                                <th scope="col" class="align-middle">Grade Level</th>
                                <th scope="col" class="align-middle">Status</th>
                                <th scope="col" class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTable">
                            @forelse(\App\Models\Student::all() as $student)
                                <tr class="student-row" data-grade-level="{{ $student->grade_level }}">
                                    <td>{{ $student->studentid }}</td>
                                    <td>{{ $student->first_name }}</td>
                                    <td>{{ $student->last_name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->age }}</td>
                                    <td>{{ $student->strand }}</td>
                                    <td>{{ $student->track }}</td>
                                    <td>{{ $student->grade_level }}</td>
                                    <td>
                                        <form action="{{ route('student.update', $student->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="status-dropdown" onchange="this.form.submit()">
                                                <option value="ongoing" {{ $student->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                                <option value="graduated" {{ $student->status == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                                <option value="dropped" {{ $student->status == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="" class="btn" title="View">
                                            <i class="fa-solid fa-eye" style="color:#305cde; font-size: 18px;"></i>
                                        </a>
                                        <a href="{{ route('student.edit', $student->id) }}"
                                            style="color: #ffc107; text-decoration: none; margin-right: 20px;"
                                            title="Edit">
                                             <i class="fa-solid fa-pen-to-square"
                                                onmouseover="this.style.color='#e0a800'" 
                                                onmouseout="this.style.color='#ffc107'"></i>
                                         </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No students found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const studentRows = document.querySelectorAll('.student-row');
    
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        
        studentRows.forEach(row => {
            const firstName = row.cells[1].textContent.toLowerCase();
            const lastName = row.cells[2].textContent.toLowerCase();
            const email = row.cells[3].textContent.toLowerCase();
            const gradeLevel = row.cells[7].textContent.toLowerCase(); // Updated to correct column
            
            if (firstName.includes(searchTerm) || 
                lastName.includes(searchTerm) || 
                email.includes(searchTerm) || 
                gradeLevel.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Tab filtering
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            studentRows.forEach(row => {
                const strand = row.cells[5].textContent; // Strand column
                if (filter === 'all' || strand === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Sort functionality
    const sortSelect = document.querySelectorAll('.form-select')[1]; // Second select is for sorting
    sortSelect.addEventListener('change', function() {
        const sortValue = this.value;
        const tbody = document.getElementById('studentsTable');
        const rows = Array.from(studentRows);
        
        rows.sort((a, b) => {
            if (sortValue === 'name-asc') {
                return a.cells[1].textContent.localeCompare(b.cells[1].textContent);
            } else if (sortValue === 'name-desc') {
                return b.cells[1].textContent.localeCompare(a.cells[1].textContent);
            } else if (sortValue === 'grade-asc') {
                return a.cells[7].textContent.localeCompare(b.cells[7].textContent);
            } else if (sortValue === 'grade-desc') {
                return b.cells[7].textContent.localeCompare(a.cells[7].textContent);
            }
            return 0;
        });

        rows.forEach(row => tbody.appendChild(row));
    });
});
</script>
@endsection