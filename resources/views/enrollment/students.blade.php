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

                        <div class="gap-2 dropdowns d-flex">
                            <select class="form-select filter-select" id="gradeLevelFilter" style="width: 150px;">
                                <option value="">All Grade Levels</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </select>
                            <select class="form-select filter-select" id="statusFilter" style="width: 150px;">
                                <option value="">All Statuses</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="graduated">Graduated</option>
                                <option value="dropped">Dropped</option>
                            </select>
                            <select class="form-select filter-select" id="strandFilter" style="width: 150px;">
                                <option value="">All Strands</option>
                                @foreach(\App\Models\Strands::all() as $strand)
                                <option value="{{ $strand->strand_name }}">{{ $strand->strand_name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-dark btn-sm p-1" id="clearFilters"><i
                                    class="fa-solid fa-eraser"></i> Clear
                                Filters</button>
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
                    <table class="table table-hover table-striped" style="cursor: pointer;">
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
                            @forelse(\App\Models\Student::all() as $student)
                            <tr class="student-row" data-track="{{ $student->track->track_name }}"
                                data-grade-level="{{ $student->grade_level }}" data-status="{{ $student->status }}"
                                data-strand="{{ $student->strand->strand_name }}">
                                <td class="text-center">{{ $student->studentid }}</td>
                                <td class="text-center">{{ $student->first_name }}</td>
                                <td class="text-center">{{ $student->last_name }}</td>
                                <td class="text-center">{{ $student->email }}</td>
                                <td class="text-center">{{ $student->age }}</td>
                                <td class="text-center">{{ $student->track->track_name }}</td>
                                <td class="text-center">{{ $student->strand->strand_name }}</td>
                                <td class="text-center">{{ $student->grade_level }}</td>
                                <td class="text-center">
                                    <form action="{{ route('student.update', $student->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="status-dropdown" onchange="this.form.submit()">
                                            <option value="ongoing"
                                                {{ $student->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                            <option value="graduated"
                                                {{ $student->status == 'graduated' ? 'selected' : '' }}>Graduated
                                            </option>
                                            <option value="dropped"
                                                {{ $student->status == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="gap-2 d-flex justify-content-center">
                                        <a
                                            href="{{ route('student.edit', ['id' => $student->id, 'formtype' => 'view']) }}">
                                            <button class="btn" title="View">
                                                <i class="fa-solid fa-eye" style="color:#305cde;"></i>
                                            </button>
                                        </a>
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
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const suggestionsDiv = document.getElementById('suggestions');
        const studentRows = document.querySelectorAll('.student-row');
        const gradeLevelFilter = document.getElementById('gradeLevelFilter');
        const statusFilter = document.getElementById('statusFilter');
        const strandFilter = document.getElementById('strandFilter');
        const clearFiltersBtn = document.getElementById('clearFilters');
        const tabs = document.querySelectorAll('.tab');

        // Debounce function for search
        const debounce = (func, wait) => {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        };

        // Apply all filters
        const applyFilters = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedTrack = document.querySelector('.tab.active').getAttribute('data-filter');
            const selectedGradeLevel = gradeLevelFilter.value;
            const selectedStatus = statusFilter.value;
            const selectedStrand = strandFilter.value;

            studentRows.forEach(row => {
                const firstName = row.cells[1].textContent.toLowerCase();
                const lastName = row.cells[2].textContent.toLowerCase();
                const email = row.cells[3].textContent.toLowerCase();
                const track = row.getAttribute('data-track');
                const gradeLevel = row.getAttribute('data-grade-level');
                const status = row.getAttribute('data-status');
                const strand = row.getAttribute('data-strand');

                const matchesSearch = !searchTerm ||
                    firstName.includes(searchTerm) ||
                    lastName.includes(searchTerm) ||
                    email.includes(searchTerm);

                const matchesTrack = selectedTrack === 'all' ||
                    (selectedTrack === 'Academic' && track === 'Academic') ||
                    (selectedTrack === 'Non-Academic' && track !== 'Academic');

                const matchesGradeLevel = !selectedGradeLevel || gradeLevel === selectedGradeLevel;
                const matchesStatus = !selectedStatus || status === selectedStatus;
                const matchesStrand = !selectedStrand || strand === selectedStrand;

                row.style.display = matchesSearch && matchesTrack && matchesGradeLevel &&
                    matchesStatus && matchesStrand ? '' : 'none';
            });
        };

        // Search suggestions
        const updateSuggestions = debounce(() => {
            const searchTerm = searchInput.value.toLowerCase();
            suggestionsDiv.innerHTML = '';
            if (searchTerm.length < 2) {
                suggestionsDiv.style.display = 'none';
                return;
            }

            const matches = Array.from(studentRows).filter(row => {
                const firstName = row.cells[1].textContent.toLowerCase();
                const lastName = row.cells[2].textContent.toLowerCase();
                return firstName.includes(searchTerm) || lastName.includes(searchTerm);
            });

            if (matches.length) {
                matches.slice(0, 5).forEach(row => {
                    const suggestion = document.createElement('div');
                    suggestion.classList.add('p-2');
                    suggestion.textContent =
                        `${row.cells[1].textContent} ${row.cells[2].textContent}`;
                    suggestion.addEventListener('click', () => {
                        searchInput.value = suggestion.textContent;
                        suggestionsDiv.style.display = 'none';
                        applyFilters();
                    });
                    suggestionsDiv.appendChild(suggestion);
                });
                suggestionsDiv.style.display = 'block';
            } else {
                suggestionsDiv.style.display = 'none';
            }
        }, 300);

        // Event listeners
        searchInput.addEventListener('input', () => {
            updateSuggestions();
            applyFilters();
        });

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                applyFilters();
            });
        });

        gradeLevelFilter.addEventListener('change', applyFilters);
        statusFilter.addEventListener('change', applyFilters);
        strandFilter.addEventListener('change', applyFilters);

        clearFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            gradeLevelFilter.value = '';
            statusFilter.value = '';
            strandFilter.value = '';
            tabs.forEach(t => t.classList.remove('active'));
            document.querySelector('.tab[data-filter="all"]').classList.add('active');
            suggestionsDiv.style.display = 'none';
            applyFilters();
        });
    });
</script>
@endsection