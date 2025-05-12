@extends('layouts.app')

@section('styles')
<style>
    .card {
        position: sticky !important;
        top: 0 !important;
        border-radius: 1em !important;
        min-height: 100vh !important;
    }

    .dropdown-item i {
        margin-right: 8px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .modal-content {
        border-radius: 1em;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
    }

    .section {
        background-color: #f8f9fa;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .card-modal {
        background-color: #f8f9fa;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    /* Ensure modal body scrolls smoothly */
    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }
</style>
@endsection

@section('content')
<div class="subject-content">
    <div class="card p-3">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h2>Manage Students' Section</h2>
                <p style="font-size:14px; color:#555 !important;">
                    View and manage students assigned to {{ $section->section_name }}.
                    Add or remove students who belong to the {{ $section->strand->strand_name }} strand.
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('section.index') }}" class="p-1" style="text-decoration:none;"><i
                        class="fa-solid fa-right-from-bracket"></i> <span class="text-muted">Sections</span></a>
            </div>
        </div>
        <hr>

        @if ($errors->any())
        <div class="alert alert-danger p-1 mb-3">
            <i class="fa-solid fa-circle-exclamation"></i>
            <strong>Whoops!</strong> There were some problems with your input.
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success p-1 mb-3"><strong><i class="fa-solid fa-circle-check"></i> Success!</strong>
            {{ session('success') }}
        </div>
        @endif

        <!-- Section -->
        <div class="section">
            <!-- Section Details -->
            <div class="row">
                <div class="col-md-6">
                    <h5>Section Details</h5>
                    <p style="font-size: 14px !important; color: #555 !important;"><strong>Name:</strong>
                        {{ $section->section_name }}
                    </p>
                    <p style="font-size: 14px !important; color: #555 !important;"><strong>Strand:</strong>
                        {{ $section->strand->strand_name }}
                    </p>
                    <p style="font-size: 14px !important; color: #555 !important;"><strong>Track:</strong>
                        {{ $section->track->track_name }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p style="font-size: 14px !important; color: #555 !important;"><strong>Grade Level:</strong>
                        {{ $section->GradeLevel }}
                    </p>
                    <p style="font-size: 14px !important; color: #555 !important;"><strong>School Year:</strong>
                        {{ $section->school_year ?? 'N/A' }}
                    </p>
                    <p style="font-size: 14px !important; color: #555 !important;"><strong>Capacity:</strong>
                        {{ $section->sectionLines->count() }} / {{ $section->capacity }}
                    </p>
                    <p style="font-size: 14px !important; color: #555 !important;"><strong>Adviser:</strong>
                        {{ $section->adviser ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
        <!-- Add Student Button -->
        <div class="mb-3">
            @if ($availableStudents->isEmpty())
            <p class="text-warning">No available students to add for this strand.</p>
            @else
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="fa-solid fa-plus"></i> Add Student
            </button>
            @endif
        </div>

        <!-- Students Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Strand</th>
                        <th>Track</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($section->sectionLines as $sectionLine)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sectionLine->student->first_name }} {{ $sectionLine->student->last_name }}</td>
                        <td>{{ $sectionLine->strand->strand_name }}</td>
                        <td>{{ $sectionLine->track->track_name }}</td>
                        <td>
                            <form action="{{ route('sectionline.destroy', $sectionLine->id) }}" method="POST"
                                onsubmit="return confirmDeletion(event, '{{ $sectionLine->student->first_name }} {{ $sectionLine->student->last_name }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No students assigned to this section.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add Students to {{ $section->section_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sectionline.store', $section->id) }}" method="POST" id="addStudentForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <label class="form-label">Select Students</label>
                            <div class="form-check p-1">
                                <input type="checkbox" id="select_all" class="form-check-input">
                                <label for="select_all" class="form-check-label">Select All</label>
                            </div>
                        </div>
                        @foreach ($availableStudents as $student)
                        <div class="card-modal mb-2 p-2">
                            <input type="checkbox" id="student_{{ $student->id }}" name="student_ids[]"
                                value="{{ $student->id }}" class="form-check-input student-checkbox">
                            <label for="student_{{ $student->id }}" class="form-check-label">
                                {{ $student->first_name }} {{ $student->last_name }}
                                ({{ $student->strand->strand_name }})
                            </label>
                        </div>
                        @endforeach
                        @error('student_ids')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error('student_ids.*')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Add
                        Students</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Select All checkbox
        const selectAllCheckbox = document.getElementById('select_all');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');
        const addStudentForm = document.getElementById('addStudentForm');

        selectAllCheckbox.addEventListener('change', function() {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Sync Select All with individual checkbox changes
        studentCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    const allChecked = Array.from(studentCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });

        // Confirmation prompt for adding students
        addStudentForm.addEventListener('submit', function(e) {
            const selectedCount = document.querySelectorAll('input[name="student_ids[]"]:checked').length;
            if (selectedCount > 0) {
                const message = selectedCount === 1 ?
                    `Are you sure you want to add ${selectedCount} student to the section?` :
                    `Are you sure you want to add ${selectedCount} students to the section?`;
                if (!confirm(message)) {
                    e.preventDefault();
                }
            }
        });

        // Enhanced deletion confirmation
        window.confirmDeletion = function(event, studentName) {
            event.preventDefault();
            const confirmed = confirm(`Are you sure you want to remove ${studentName} from the section?`);
            if (confirmed) {
                event.target.closest('form').submit();
            }
        };

        // Reset checkboxes when modal is closed
        const addStudentModal = document.getElementById('addStudentModal');
        addStudentModal.addEventListener('hidden.bs.modal', function() {
            selectAllCheckbox.checked = false;
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
                checkbox.classList.remove('is-invalid');
            });
            // Remove error messages
            const errorDivs = document.querySelectorAll('.text-danger');
            errorDivs.forEach(div => div.remove());
        });
    });
</script>
@endsection