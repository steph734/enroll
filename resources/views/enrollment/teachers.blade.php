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
                        <div class="d-flex">
                            <div class="card-title d-flex align-items-center">
                                <h5>List of Teachers</h5>
                                <form action="teachers" id="searchForm" style="margin-left: 230px !important;">
                                    <div class="search-container-dash">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" placeholder="Search..." id="searchInput">
                                        <div id="suggestions" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000;">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Filters Section -->
                        <div class="mt-3 filters d-flex justify-content-between align-items-center">
                            <div class="gap-3 tabs d-flex">
                                <button class="tab active">ALL Teachers</button>
                                <button class="tab">STEM</button>
                                <button class="tab">ABM</button>
                                <button class="tab">HUMMMS</button>
                            </div>

                            <div class="gap-2 dropdowns d-flex">
                                <select class="form-select" style="width: 150px;">
                                    <option>Filter by</option>
                                    <option value="department">Strand</option>
                                    <option value="years">Years of Service</option>
                                    <option value="status">Status</option>
                                </select>
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
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle">ID</th>
                                    <th scope="col" class="align-middle">Firstname</th>
                                    <th scope="col" class="align-middle">Middlename</th>
                                    <th scope="col" class="align-middle">Lastname</th>
                                    <th scope="col" class="align-middle">Email</th>
                                    <th scope="col" class="align-middle">Age</th>
                                    <th scope="col" class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tbody>
                                    @forelse(\App\Models\Teacher::all() as $teacher)
                                        <tr>
                                            <td>{{ $teacher->id }}</td>
                                            <td>{{ $teacher->first_name }}</td>
                                            <td>{{ $teacher->middle_name }}</td>
                                            <td>{{ $teacher->last_name }}</td>
                                            <td>{{ $teacher->email }}</td>
                                            <td>{{ $teacher->age }}</td>
                                            <td>
                                                <div style="display: flex; gap: 4px;">
                                                    <a href="{{ route('teachers.edit', $teacher->id) }}" style="padding: 4px 8px; background-color: #ffc107; color: black; text-decoration: none; border-radius: 3px; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#e0a800'" onmouseout="this.style.backgroundColor='#ffc107'">Edit</a>
                                                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="padding: 4px 8px; background-color: #dc3545; color: white; border: none; border-radius: 3px; cursor: pointer; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#c82333'" onmouseout="this.style.backgroundColor='#dc3545'" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No teachers found.</td>
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
            const searchForm = document.getElementById('searchForm');

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value;
                
                const url = new URL(window.location);
                if (searchTerm) {
                    url.searchParams.set('search', searchTerm);
                } else {
                    url.searchParams.delete('search');
                }
                window.history.pushState({}, '', url);

                fetch(`/teachers?search=${searchTerm}`)
                    .then(response => response.json())
                    .then(data => {
                        // Handle suggestions if needed
                    })
                    .catch(error => console.error('Error:', error));
            });

            document.querySelectorAll('.tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    const strand = this.textContent === 'ALL Teachers' ? '' : this.textContent;
                    const url = new URL(window.location);
                    if (strand) {
                        url.searchParams.set('strand', strand);
                    } else {
                        url.searchParams.delete('strand');
                    }
                    window.location = url;
                });
            });
        });
    </script>
@endsection