@extends('layouts.app')
@section('title', 'Students')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/students.css') }}">
<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        overflow: auto;
        backdrop-filter: blur(3px);
    }
    .modal-content {
        background-color: #ffffff;
        margin: 5% auto;
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 700px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        position: relative;
        animation: slideIn 0.3s ease-out;
    }
    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .close {
        color: #666;
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.2s;
    }
    .close:hover,
    .close:focus {
        color: #000;
    }
    .modal-content h2 {
        color: #1a3c87;
        font-size: 24px;
        margin: 0 0 20px;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 10px;
    }
    .modal-content .student-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    .modal-content .info-item {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 6px;
        transition: transform 0.2s;
    }
    .modal-content .info-item:hover {
        transform: translateY(-2px);
    }
    .modal-content .info-item strong {
        color: #333;
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .modal-content .info-item span {
        color: #555;
        font-size: 16px;
    }
    .modal-footer {
        text-align: right;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
    }
    .modal-footer .btn-close {
        background-color: #dc3545;
        color: white;
        padding: 8px 20px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .modal-footer .btn-close:hover {
        background-color: #c82333;
    }
    @media (max-width: 600px) {
        .modal-content .student-info {
            grid-template-columns: 1fr;
        }
        .modal-content {
            margin: 10% auto;
            padding: 20px;
        }
    }
</style>
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
                                    <td>{{ $student->trackname }}</td>
                                    <td>{{ $student->grade_level }}</td>
                                    <td>
                                        <form action="{{ route('student.update', $student->id) }}" method="POST" class="status-form" data-student-id="{{ $student->id }}">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="status-dropdown">
                                                <option value="ongoing" {{ $student->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                                <option value="graduated" {{ $student->status == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                                <option value="dropped" {{ $student->status == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <button class="btn view-btn" data-student-id="{{ $student->studentid }}"
                                            data-first-name="{{ $student->first_name }}"
                                            data-last-name="{{ $student->last_name }}"
                                            data-email="{{ $student->email }}"
                                            data-age="{{ $student->age }}"
                                            data-strand="{{ $student->strand }}"
                                            data-track="{{ $student->trackname }}"
                                            data-grade-level="{{ $student->grade_level }}"
                                            data-status="{{ $student->status }}"
                                            title="View">
                                            <i class="fa-solid fa-eye" style="color:#305cde; font-size: 18px;"></i>
                                        </button>
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

<!-- Modal -->
<div id="studentModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <h2>Student Details</h2>
        <p><strong>ID:</strong> <span id="modal-student-id"></span></p>
        <p><strong>First Name:</strong> <span id="modal-first-name"></span></p>
        <p><strong>Last Name:</strong> <span id="modal-last-name"></span></p>
        <p><strong>Email:</strong> <span id="modal-email"></span></p>
        <p><strong>Age:</strong> <span id="modal-age"></span></p>
        <p><strong>Strand:</strong> <span id="modal-strand"></span></p>
        <p><strong>Track:</strong> <span id="modal-track"></span></p>
        <p><strong>Grade Level:</strong> <span id="modal-grade-level"></span></p>
        <p><strong>Status:</strong> <span id="modal-status"></span></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    const modal = document.getElementById('studentModal');
    const closeBtn = document.querySelector('.close');
    const viewButtons = document.querySelectorAll('.view-btn');

    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Populate modal with student data
            document.getElementById('modal-student-id').textContent = this.dataset.studentId;
            document.getElementById('modal-first-name').textContent = this.dataset.firstName;
            document.getElementById('modal-last-name').textContent = this.dataset.lastName;
            document.getElementById('modal-email').textContent = this.dataset.email;
            document.getElementById('modal-age').textContent = this.dataset.age;
            document.getElementById('modal-strand').textContent = this.dataset.strand;
            document.getElementById('modal-track').textContent = this.dataset.track;
            document.getElementById('modal-grade-level').textContent = this.dataset.gradeLevel;
            document.getElementById('modal-status').textContent = this.dataset.status;

            // Show modal
            modal.style.display = 'block';
        });
    });

    // Close modal
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

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
                const strand = row.cells[5].textContent;
                if (filter === 'all' || strand === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Sort functionality
    const sortSelect = document.querySelectorAll('.form-select')[1];
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

    // Status update functionality with validation
    const validStatuses = ['ongoing', 'graduated', 'dropped'];

    document.querySelectorAll('.status-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', function() {
            const form = this.closest('.status-form');
            const studentId = form.getAttribute('data-student-id');
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

            fetch(`/students/${studentId}`, {
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
});
</script>
@endsection