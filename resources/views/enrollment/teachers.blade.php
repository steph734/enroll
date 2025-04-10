@extends('layouts.app')

@section('title', 'Teachers')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/teachers.css') }}">
@endsection

@section('content')
    <div class="teachers-content">
        <div class="mb-3 row">
            <div class="row">
                <div class="p-3 card card-header-teacher">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="card-title">
                                <h5>List of Teachers</h5>
                            </div>
                            <form action="teachers" id="searchForm">
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
                                <button class="tab active" data-filter="all">ALL Teachers</button>
                                <button class="tab" data-filter="Academic">Academic Track</button>
                                <button class="tab" data-filter="TVL">TVL</button>
                                <button class="tab" data-filter="Sports">Sports</button>
                                <button class="tab" data-filter="Arts and Design">Arts and Design</button>
                            </div>

                            <div class="gap-2 dropdowns d-flex">
                                <select class="form-select" style="width: 150px;">
                                    <option>Sort by</option>
                                    <option value="name-asc">Name (A-Z)</option>
                                    <option value="name-desc">Name (Z-A)</option>
                                    <option value="years-asc">Years (Low to High)</option>
                                    <option value="years-desc">Years (High to Low)</option>
                                </select>
                            </div>

                            <a href="{{ route('enrollment.show', 'teacher_form') }}">
                                <button class="p-1 btn btn-primary add-teacher rounded-5">Add Teacher</button>
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
                                    <th scope="col" class="align-middle">Firstname</th>
                                    <th scope="col" class="align-middle">Lastname</th>
                                    <th scope="col" class="align-middle">Email</th>
                                    <th scope="col" class="align-middle">Age</th>
                                    <th scope="col" class="align-middle">Specialization</th>
                                    <th scope="col" class="align-middle">Employment Status</th>
                                    <th scope="col" class="align-middle">Subjects</th>
                                    <th scope="col" class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody id="teachersTable">
                                @forelse(\App\Models\Teacher::all() as $teacher)
                                    <tr class="teacher-row" data-specialization="{{ $teacher->specialization }}">
                                        <td>{{ $teacher->id }}</td>
                                        <td>{{ $teacher->first_name }}</td>
                                        <td>{{ $teacher->last_name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->age }}</td>
                                        <td>{{ $teacher->specialization }}</td>
                                        <td>{{ $teacher->employment_status }}</td>
                                        <td>{{ $teacher->subjects }}</td>
                                        <td>
                                            <a href="{{ route('teachers.edit', $teacher->id) }}"
                                               style="color: #ffc107; text-decoration: none; margin-right: 20px;"
                                               title="Edit">
                                                <i class="fa-solid fa-pen-to-square"
                                                   onmouseover="this.style.color='#e0a800'" 
                                                   onmouseout="this.style.color='#ffc107'"></i>
                                            </a>
                                            <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        style="background: none; border: none; color: #dc3545; cursor: pointer;"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this teacher?')">
                                                    <i class="fa-solid fa-trash" 
                                                       onmouseover="this.style.color='#c82333'" 
                                                       onmouseout="this.style.color='#dc3545'"></i>
                                                </button>
                                            </form>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const teacherRows = document.querySelectorAll('.teacher-row');
        
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            teacherRows.forEach(row => {
                const firstName = row.cells[1].textContent.toLowerCase();
                const lastName = row.cells[2].textContent.toLowerCase();
                const email = row.cells[3].textContent.toLowerCase();
                const specialization = row.cells[5].textContent.toLowerCase();
                
                if (firstName.includes(searchTerm) || 
                    lastName.includes(searchTerm) || 
                    email.includes(searchTerm) || 
                    specialization.includes(searchTerm)) {
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
                
                teacherRows.forEach(row => {
                    const specialization = row.getAttribute('data-specialization');
                    if (filter === 'all' || specialization === filter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        // Sort functionality
        const sortSelect = document.querySelector('.form-select');
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const tbody = document.getElementById('teachersTable');
            const rows = Array.from(teacherRows);
            
            rows.sort((a, b) => {
                if (sortValue === 'name-asc') {
                    return a.cells[1].textContent.localeCompare(b.cells[1].textContent);
                } else if (sortValue === 'name-desc') {
                    return b.cells[1].textContent.localeCompare(a.cells[1].textContent);
                } else if (sortValue === 'years-asc') {
                    return parseInt(a.cells[4].textContent) - parseInt(b.cells[4].textContent);
                } else if (sortValue === 'years-desc') {
                    return parseInt(b.cells[4].textContent) - parseInt(a.cells[4].textContent);
                }
                return 0;
            });

            rows.forEach(row => tbody.appendChild(row));
        });
    });
    </script>
@endsection