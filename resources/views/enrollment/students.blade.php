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
                                <div id="suggestions"
                                    style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000;">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Filters Section -->
                    <div class="mt-3 filters d-flex justify-content-between align-items-center">
                        <div class="gap-3 tabs d-flex">
                            <button class="tab active" data-filter="all">All Students</button>
                            <button class="tab" data-filter="Academic">Academic</button>
                            <button class="tab" data-filter="Non-Academic">Non-Academic</button>
                        </div>

                        <!-- Filter Form (Date and Status) -->
                        <form method="GET" action="{{ route('students.index') }}" class="gap-2 d-flex align-items-center">
                            <div class="col-md-3">
                                <label for="date" class="form-label">Filter by Date:</label>
                                <input type="date" name="date" value="{{ request('date', $todayDate) }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Filter by Status:</label>
                                <select name="status" class="form-select">
                                    <option value="">Select Status</option>
                                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="graduated" {{ request('status') == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                    <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                </select>
                            </div>
                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>

                        <!-- Existing Dropdowns for Grade and Sorting -->
                        <div class="gap-2 dropdowns d-flex">
                            <select class="form-select" style="width: 150px;" onchange="this.form.submit()" name="grade" form="filterForm">
                                <option>Filter by</option>
                                <option value="grade" {{ request('grade') == 'grade' ? 'selected' : '' }}>Grade</option>
                                <option value="age" {{ request('age') == 'age' ? 'selected' : '' }}>Age</option>
                            </select>
                            <select class="form-select" style="width: 150px;" onchange="this.form.submit()" name="sort" form="filterForm">
                                <option>Sort by</option>
                                <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                <option value="grade-asc" {{ request('sort') == 'grade-asc' ? 'selected' : '' }}>Grade (Low to High)</option>
                                <option value="grade-desc" {{ request('sort') == 'grade-desc' ? 'selected' : '' }}>Grade (High to Low)</option>
                            </select>
                        </div>

                        <a href="{{ route('enrollment.show', 'enrollment_form') }}">
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
                    <table class="table table-hover table-striped table-bordered" style="cursor: pointer;">
                        <thead>
                            <tr>
                                <th scope="col" class="p-1 text-center align-middle">ID</th>
                                <th scope="col" class="p-1 text-center align-middle">First Name</th>
                                <th scope="col" class="p-1 text-center align-middle">Last Name</th>
                                <th scope="col" class="p-1 text-center align-middle">Email</th>
                                <th scope="col" class="p-1 text-center align-middle">Age</th>
                                <th scope="col" class="p-1 text-center align-middle">Track</th>
                                <th scope="col" class="p-1 text-center align-middle">Strand</th>
                                <th scope="col" class="p-1 text-center align-middle">Grade Level</th>
                                <th scope="col" class="p-1 text-center align-middle">Status</th>
                                <th scope="col" class="p-1 text-center align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTable">
                            @forelse($students as $student)
                            <tr class="student-row" data-grade-level="{{ $student->grade_level }}">
                                <td class="p-1">{{ $student->studentid }}</td>
                                <td class="p-1">{{ $student->first_name }}</td>
                                <td class="p-1">{{ $student->last_name }}</td>
                                <td class="p-1">{{ $student->email }}</td>
                                <td class="p-1">{{ $student->age }}</td>
                                <td class="p-1">{{ $student->track->track_name }}</td>
                                <td class="p-1">{{ $student->strand->strand_name }}</td>
                                <td class="p-1">{{ $student->grade_level }}</td>
                                <td class="p-1">
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
                                <td class="p-3">
                                    <div class="gap-2 d-flex justify-content-center">
                                        <button class="btn" title="View">
                                            <i class="fa-solid fa-eye" style="color:#305cde;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="p-3 text-center">No students found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center">
                        {{ $students->links() }}
                    </div>
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
                const gradeLevel = row.cells[7].textContent.toLowerCase();

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
                    const strand = row.cells[6].textContent; // Strand column (index 6)
                    if (filter === 'all' || strand === filter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endsection