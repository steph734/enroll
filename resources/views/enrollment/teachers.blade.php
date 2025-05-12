@extends('layouts.app')

@section('title', 'Teachers')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/teachers.css') }}">
@endsection

@section('content')
<div class="teachers-content">
    <div class="container">
        <h2>List of Teachers</h2>
        <p style="font-size: 18px; color:#555 !important;">For 1st Semester, Class of 2024-2025</p>
        <div class="row mb-3">
            <div class="p-3 card card-header-teacher">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title"></div>
                        <form action="teachers" id="searchForm">
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
                            <button class="tab active" data-filter="all">All Teachers</button>
                            <button class="tab" data-filter="Academic">Academic Track</button>
                            <button class="tab" data-filter="TVL">TVL</button>
                            <button class="tab" data-filter="Sports">Sports</button>
                            <button class="tab" data-filter="Arts and Design">Arts and Design</button>
                        </div>

                        <div class="gap-2 dropdowns d-flex">
                            <select class="form-select" id="statusFilter" style="width: 150px;">
                                <option value="">Filter by Status</option>
                                <option value="Active">Active</option>
                                <option value="On Leave">On Leave</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Terminated">Terminated</option>
                            </select>
                            <select class="form-select" id="employmentStatusFilter" style="width: 150px;">
                                <option value="">Filter by Employment Status</option>
                                <option value="Full-time">Full-Time</option>
                                <option value="Part-time">Part-Time</option>
                                <option value="Contractual">Contractual</option>
                            </select>
                            <a href="#">
                                <button class="btn btn-outline-dark btn-sm p-1" id="clearFilters">
                                    <i class="fa-solid fa-eraser"></i> Clear Filters
                                </button>
                            </a>
                            <a href="{{ route('enrollment.show', 'teacher_form') }}">
                                <button class="p-1 btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i>
                                    Add Teacher</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session()->has('success'))
        <div class="alert alert-success p-5" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <div class="mb-3 row">
            <div class="p-3 card card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle">ID</th>
                                    <th scope="col" class="align-middle">Firstname</th>
                                    <th scope="col" class="align-middle">Lastname</th>
                                    <th scope="col" class="align-middle">Email</th>
                                    <th scope="col" class="align-middle">Age</th>
                                    <th scope="col" class="align-middle">Specialization</th>
                                    <th scope="col" class="align-middle">Employment Status</th>
                                    <th scope="col" class="align-middle">Status</th>
                                    <th scope="col" class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody id="teachersTable">
                                @forelse(\App\Models\Teacher::all() as $teacher)
                                <tr class="teacher-row" data-specialization="{{ $teacher->specialization }}"
                                    data-employment-status="{{ $teacher->employment_status }}"
                                    data-status="{{ $teacher->status }}">
                                    <td>{{ $teacher->id }}</td>
                                    <td>{{ $teacher->first_name }}</td>
                                    <td>{{ $teacher->last_name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->age }}</td>
                                    <td>{{ $teacher->specialization }}</td>
                                    <td>{{ $teacher->employment_status }}</td>
                                    <td>
                                        <select name="status" class="form-select form-select-sm status-select"
                                            data-teacher-id="{{ $teacher->id }}">
                                            <option value="Active"
                                                {{ $teacher->status === 'Active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="On Leave"
                                                {{ $teacher->status === 'On Leave' ? 'selected' : '' }}>
                                                On Leave</option>
                                            <option value="Inactive"
                                                {{ $teacher->status === 'Inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                            <option value="Terminated"
                                                {{ $teacher->status === 'Terminated' ? 'selected' : '' }}>
                                                Terminated</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="gap-2 d-flex justify-content-center">
                                            <a
                                                href="{{ route('teachers.edit', ['id' => $teacher->id, 'formtype' => 'view']) }}">
                                                <button class="btn" title="View">
                                                    <i class="fa-solid fa-eye" style="color:#305cde;"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No teachers found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const suggestionsDiv = document.getElementById('suggestions');
        const teacherRows = document.querySelectorAll('.teacher-row');
        const statusFilter = document.getElementById('statusFilter');
        const employmentStatusFilter = document.getElementById('employmentStatusFilter');
        const clearFiltersBtn = document.getElementById('clearFilters');
        const tabs = document.querySelectorAll('.tab');
        const statusSelects = document.querySelectorAll('.status-select');

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
            const selectedSpecialization = document.querySelector('.tab.active').getAttribute('data-filter');
            const selectedStatus = statusFilter.value;
            const selectedEmploymentStatus = employmentStatusFilter.value;

            teacherRows.forEach(row => {
                const firstName = row.cells[1].textContent.toLowerCase();
                const lastName = row.cells[2].textContent.toLowerCase();
                const email = row.cells[3].textContent.toLowerCase();
                const specialization = row.getAttribute('data-specialization');
                const status = row.getAttribute('data-status');
                const employmentStatus = row.getAttribute('data-employment-status');

                const matchesSearch = !searchTerm ||
                    firstName.includes(searchTerm) ||
                    lastName.includes(searchTerm) ||
                    email.includes(searchTerm);

                const matchesSpecialization = selectedSpecialization === 'all' ||
                    specialization === selectedSpecialization;

                const matchesStatus = !selectedStatus || status === selectedStatus;
                const matchesEmploymentStatus = !selectedEmploymentStatus || employmentStatus ===
                    selectedEmploymentStatus;

                row.style.display = matchesSearch && matchesSpecialization && matchesStatus &&
                    matchesEmploymentStatus ? '' : 'none';
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

            const matches = Array.from(teacherRows).filter(row => {
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

        // Update teacher status via AJAX with confirmation
        statusSelects.forEach(select => {
            let previousValue = select.value; // Store initial value

            select.addEventListener('change', function() {
                const teacherId = this.getAttribute('data-teacher-id');
                const newStatus = this.value;
                const row = this.closest('.teacher-row');
                const teacherName = `${row.cells[1].textContent} ${row.cells[2].textContent}`;

                // Show confirmation dialog
                if (confirm(
                        `Are you sure you want to change the status of ${teacherName} to "${newStatus}"?`
                    )) {
                    fetch('{{ route("teachers.updateStatus") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                teacher_id: teacherId,
                                status: newStatus
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update the row's data-status attribute and previous value
                                row.setAttribute('data-status', newStatus);
                                previousValue = newStatus;
                                applyFilters(); // Re-apply filters
                                alert('Status updated successfully!');
                            } else {
                                alert('Failed to update status: ' + (data.message ||
                                    'Unknown error'));
                                this.value = previousValue; // Revert to previous value
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while updating the status.');
                            this.value = previousValue; // Revert to previous value
                        });
                } else {
                    // Revert to previous value if canceled
                    this.value = previousValue;
                }
            });
        });

        // Event listeners for filters and search
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

        statusFilter.addEventListener('change', applyFilters);
        employmentStatusFilter.addEventListener('change', applyFilters);

        clearFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            statusFilter.value = '';
            employmentStatusFilter.value = '';
            tabs.forEach(t => t.classList.remove('active'));
            document.querySelector('.tab[data-filter="all"]').classList.add('active');
            suggestionsDiv.style.display = 'none';
            applyFilters();
        });
    });
</script>
@endsection