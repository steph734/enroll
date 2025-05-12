@extends('layouts.app')

@section('content')
<div class="schedule-content">
    <!-- Header Section with Search -->
    <div class="mb-3 row">
        <div class="row">
            <div class="p-3 card card-header-payment">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="card-title d-flex align-items-center">
                            <div class="container">
                                <h2>Class Schedule</h2>
                                <p>First Semester Academic Year of 2024 - 2025</p>
                            </div>
                            <form action="{{ route('schedules.index') }}" id="searchForm" style="margin-left: 230px !important;">
                                <div class="search-container-dash">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" placeholder="Search..." id="searchInput" name="search" value="{{ request('search') }}">
                                    <!-- Suggestions dropdown -->
                                    <div id="suggestions"
                                        style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000;">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Filters Section -->
                    <div class="mt-3 filters d-flex justify-content-between align-items-center">
                        <!-- Tabs for filtering by strand -->
                        <div class="gap-3 tabs d-flex">
                            <button class="tab {{ request('strand', 'ALL') === 'ALL' ? 'active' : '' }}">ALL Schedule</button>
                            <button class="tab {{ request('strand') === 'STEM' ? 'active' : '' }}">STEM</button>
                            <button class="tab {{ request('strand') === 'ABM' ? 'active' : '' }}">ABM</button>
                            <button class="tab {{ request('strand') === 'HUMMS' ? 'active' : '' }}">HUMMS</button>
                        </div>

                        <!-- Dropdowns for Filter by and Sort by -->
                        <div class="gap-2 dropdowns d-flex">
                            <select class="form-select" style="width: 150px;" name="filter">
                                <option value="">Filter by</option>
                                <option value="grade" {{ request('filter') === 'grade' ? 'selected' : '' }}>Grade & Section</option>
                                <option value="status" {{ request('filter') === 'status' ? 'selected' : '' }}>Status</option>
                                <option value="payment-date" {{ request('filter') === 'payment-date' ? 'selected' : '' }}>Payment Date</option>
                            </select>
                            <select class="form-select" style="width: 150px;" name="sort">
                                <option value="">Sort by</option>
                                <option value="name-asc" {{ request('sort') === 'name-asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                <option value="name-desc" {{ request('sort') === 'name-desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                <option value="amount-due-asc" {{ request('sort') === 'amount-due-asc' ? 'selected' : '' }}>Amount Due (Low to High)</option>
                                <option value="amount-due-desc" {{ request('sort') === 'amount-due-desc' ? 'selected' : '' }}>Amount Due (High to Low)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Table -->
    <div class="mb-3 row">
        <div class="p-3 card card-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle">Subject</th>
                                <th scope="col" class="align-middle">Section</th>
                                <th scope="col" class="align-middle">Grade Level</th>
                                <th scope="col" class="align-middle">Day</th>
                                <th scope="col" class="align-middle">Semester</th>
                                <th scope="col" class="align-middle">Time</th>
                                <th scope="col" class="align-middle">Room</th>
                                <th scope="col" class="align-middle">Strand</th>
                                <th scope="col" class="align-middle">Status</th>
                                <th scope="col" class="align-middle">Teachername</th>
                                <th scope="col" class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse(\App\Models\Schedule::with('teacher')->get() as $schedule)
                                <tr>
                                    <td>{{ $schedule->subject }}</td>
                                    <td>{{ $schedule->section }}</td>
                                    <td>{{ $schedule->grade_level }}</td>
                                    <td>{{ $schedule->day }}</td>
                                    <td>{{ $schedule->semester }}</td>
                                    <td>{{ $schedule->time }}</td>
                                    <td>{{ $schedule->room }}</td>
                                    <td>{{ $schedule->strand }}</td>
                                    <td>{{ $schedule->status }}</td>
                                   <td>{{ $schedule->teacher ? $schedule->teacher->name : 'No Teacher Assigned' }}</td>
                                    <td>
                                        <a href="{{ route('schedules.edit', $schedule->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">No schedules found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Interactive Features -->
@section('scripts')
<script>
    // Handle tab clicks for strand filtering
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const strand = this.textContent.trim() === 'ALL Schedule' ? 'ALL' : this.textContent.trim();
            const url = new URL(window.location);
            url.searchParams.set('strand', strand);
            url.searchParams.delete('page'); // Reset pagination
            window.location = url;
        });
    });

    // Handle dropdown changes for filter/sort
    document.querySelectorAll('.form-select').forEach(select => {
        select.addEventListener('change', function () {
            const url = new URL(window.location);
            if (this.name === 'filter') {
                url.searchParams.set('filter', this.value);
            } else if (this.name === 'sort') {
                url.searchParams.set('sort', this.value);
            }
            url.searchParams.delete('page'); // Reset pagination
            window.location = url;
        });
    });

    // Handle search suggestions
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value;
        const suggestionsDiv = document.getElementById('suggestions');

        if (query.length < 2) {
            suggestionsDiv.style.display = 'none';
            return;
        }

        fetch(`/schedules/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                suggestionsDiv.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        const div = document.createElement('div');
                        div.textContent = item.subject || item.teachername || item.section || item.room;
                        div.style.padding = '8px';
                        div.style.cursor = 'pointer';
                        div.addEventListener('click', () => {
                            document.getElementById('searchInput').value = div.textContent;
                            suggestionsDiv.style.display = 'none';
                            const url = new URL(window.location);
                            url.searchParams.set('search', div.textContent);
                            url.searchParams.delete('page'); // Reset pagination
                            window.location = url;
                        });
                        suggestionsDiv.appendChild(div);
                    });
                    suggestionsDiv.style.display = 'block';
                } else {
                    suggestionsDiv.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching suggestions:', error);
            });
    });
</script>
@endsection
@endsection