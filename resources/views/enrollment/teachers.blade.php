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
                                <div id="suggestions"
                                    style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000;">
                                </div>
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
                                <option>Filter by</option>
                                <option value="grade">Grade</option>
                                <option value="age">Age</option>
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
                            <tr class="teacher-row" data-specialization="{{ $teacher->specialization }}">
                                <td>{{ $teacher->id }}</td>
                                <td>{{ $teacher->first_name }}</td>
                                <td>{{ $teacher->last_name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->age }}</td>
                                <td>{{ $teacher->specialization }}</td>
                                <td>{{ $teacher->employment_status }}</td>
                                <td>
                                    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" class="status-form" data-teacher-id="{{ $teacher->id }}">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="status-dropdown form-select">
                                            <option value="ongoing" {{ $teacher->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                            <option value="graduated" {{ $teacher->status == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                            <option value="dropped" {{ $teacher->status == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <button class="btn view-teacher" data-bs-toggle="modal" data-bs-target="#teacherViewModal" data-teacher-id="{{ $teacher->id }}" title="View">
                                        <i class="fa-solid fa-eye" style="color:#305cde; font-size: 18px;"></i>
                                    </button>
                                    <a href="{{ route('teachers.edit', $teacher->id) }}"
                                        style="color: #ffc107; text-decoration: none; margin-right: 20px;" title="Edit">
                                        <i class="fa-solid fa-pen-to-square" onmouseover="this.style.color='#e0a800'"
                                            onmouseout="this.style.color='#ffc107'"></i>
                                    </a>
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

<!-- Teacher Details Modal -->
<div class="modal fade" id="teacherViewModal" tabindex="-1" aria-labelledby="teacherViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="teacherViewModalLabel">Teacher Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Personal Information -->
                <h5 class="section-title">Personal Information</h5>
                <div class="form-section">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">ID</label>
                            <span id="modal-id" class="form-value"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <span id="modal-firstname" class="form-value"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <span id="modal-lastname" class="form-value"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Date of Birth</label>
                            <span id="modal-dob" class="form-value"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <span id="modal-gender" class="form-value"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Age</label>
                            <span id="modal-age" class="form-value"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Nationality</label>
                            <span id="modal-nationality" class="form-value"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Address</label>
                            <span id="modal-address" class="form-value"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact Number</label>
                            <span id="modal-contact" class="form-value"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Email Address</label>
                            <span id="modal-email" class="form-value"></span>
                        </div>
                    </div>
                </div>

                <!-- Academic Background -->
                <h5 class="section-title">Academic Background</h5>
                <div class="form-section">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Degree</label>
                            <span id="modal-degree" class="form-value"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Institution</label>
                            <span id="modal-institution" class="form-value"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Year Graduated</label>
                            <span id="modal-yeargraduated" class="form-value"></span>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <h5 class="section-title">Professional Information</h5>
                <div class="form-section">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Specialization</label>
                            <span id="modal-specialization" class="form-value"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Employment Status</label>
                            <span id="modal-employment" class="form-value"></span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <span id="modal-status" class="form-value"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="editTeacherLink" class="btn btn-primary">Edit Teacher</a>
            </div>
        </div>
    </div>
</div>
</div>

<style>
/* Modal Container */
.modal-content {
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    border: none;
    overflow: hidden;
}

/* Modal Header */
.modal-header {
    background: linear-gradient(135deg, #305cde 0%, #4a7bff 100%);
    color: white;
    padding: 20px;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    border-bottom: none;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.btn-close {
    filter: invert(1);
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

.btn-close:hover {
    opacity: 1;
}

/* Modal Body */
.modal-body {
    padding: 30px;
    background-color: #f8fafc;
}

.section-title {
    color: #305cde;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 8px;
}

.section-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 2px;
    background-color: #305cde;
}

.form-section {
    margin-bottom: 30px;
    padding: 15px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.form-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 6px;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-value {
    font-size: 1rem;
    color: #4a5568;
    display: block;
    padding: 8px 0;
    word-break: break-word;
}

.modal-body .row {
    margin-bottom: 15px;
}

.modal-body .col-md-4,
.modal-body .col-md-6 {
    padding: 0 15px;
}

/* Modal Footer */
.modal-footer {
    padding: 20px;
    border-top: none;
    background-color: #f8fafc;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-secondary {
    background-color: #6b7280;
    border-color: #6b7280;
    padding: 10px 20px;
    font-size: 0.9rem;
    font-weight: 500;
    border-radius: 6px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-secondary:hover {
    background-color: #4b5563;
    border-color: #4b5563;
    transform: translateY(-1px);
}

.btn-primary {
    background-color: #305cde;
    border-color: #305cde;
    padding: 10px 20px;
    font-size: 0.9rem;
    font-weight: 500;
    border-radius: 6px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-primary:hover {
    background-color: #2547b7;
    border-color: #2547b7;
    transform: translateY(-1px);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .modal-dialog {
        margin: 1rem;
    }

    .modal-body {
        padding: 20px;
    }

    .form-section {
        padding: 10px;
    }

    .modal-body .col-md-4,
    .modal-body .col-md-6 {
        margin-bottom: 15px;
    }

    .section-title {
        font-size: 1.1rem;
    }

    .form-label {
        font-size: 0.85rem;
    }

    .form-value {
        font-size: 0.95rem;
    }
}
</style>

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
    const sortSelect = document.querySelectorAll('.form-select')[1]; // Second select is for sorting
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

    // Status update functionality with validation
    const validStatuses = ['ongoing', 'graduated', 'dropped'];

    document.querySelectorAll('.status-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', function() {
            const form = this.closest('.status-form');
            const teacherId = form.getAttribute('data-teacher-id');
            const newStatus = this.value;
            const token = document.querySelector('input[name="_token"]').value;

            // Client-side validation
            if (!validStatuses.includes(newStatus)) {
                alert('Invalid status selected');
                this.value = this.dataset.previousValue || 'ongoing';
                return;
            }

            // Store current value as previous
            this.dataset.previousValue = newStatus;

            // Show loading state
            dropdown.disabled = true;

            fetch(`/teachers/${teacherId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                dropdown.disabled = false;
                if (data.success) {
                    alert('Status updated successfully!');
                } else {
                    alert('Error updating status: ' + (data.message || 'Unknown error'));
                    this.value = this.dataset.previousValue || 'ongoing';
                }
            })
            .catch(error => {
                dropdown.disabled = false;
                console.error('Error:', error);
                alert('Error updating status');
                this.value = this.dataset.previousValue || 'ongoing';
            });
        });
    });

    // View modal functionality
    document.querySelectorAll('.view-teacher').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const teacherId = this.getAttribute('data-teacher-id');

            // Extract data from the row and mock additional fields
            const teacherData = {
                id: row.cells[0].textContent,
                firstname: row.cells[1].textContent,
                lastname: row.cells[2].textContent,
                email: row.cells[3].textContent,
                age: row.cells[4].textContent,
                specialization: row.cells[5].textContent,
                employment: row.cells[6].textContent,
                status: row.cells[7].querySelector('select').value,
                // Mock data for additional fields (replace with actual data from backend)
                dob: '1975-03-15',
                gender: 'Not Specified',
                nationality: 'Not Specified',
                address: '123 Sample St, City',
                contact: '123-456-7890',
                degree: 'Bachelor of Education',
                institution: 'Sample University',
                yeargraduated: '1997'
            };

            // Populate modal fields
            document.getElementById('modal-id').textContent = teacherData.id;
            document.getElementById('modal-firstname').textContent = teacherData.firstname;
            document.getElementById('modal-lastname').textContent = teacherData.lastname;
            document.getElementById('modal-dob').textContent = teacherData.dob;
            document.getElementById('modal-gender').textContent = teacherData.gender;
            document.getElementById('modal-age').textContent = teacherData.age;
            document.getElementById('modal-nationality').textContent = teacherData.nationality;
            document.getElementById('modal-address').textContent = teacherData.address;
            document.getElementById('modal-contact').textContent = teacherData.contact;
            document.getElementById('modal-email').textContent = teacherData.email;
            document.getElementById('modal-degree').textContent = teacherData.degree;
            document.getElementById('modal-institution').textContent = teacherData.institution;
            document.getElementById('modal-yeargraduated').textContent = teacherData.yeargraduated;
            document.getElementById('modal-specialization').textContent = teacherData.specialization;
            document.getElementById('modal-employment').textContent = teacherData.employment;
            document.getElementById('modal-status').textContent = teacherData.status;

            // Set edit link
            document.getElementById('editTeacherLink').setAttribute('href', `/teachers/${teacherId}/edit`);
        });
    });
});
</script>
@endsection