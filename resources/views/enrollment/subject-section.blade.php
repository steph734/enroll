@extends('layouts.app')

@section('title', 'Subject and Section Assignment')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subject_section.css') }}">
@endsection

@section('content')
<div class="assignment-content">
    <p class="h4 mb-4" style="color: var(--text-clr) !important;">Subject and Section Management</p>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item m-1">
            <a class="nav-link active p-1" href="#assign" data-bs-toggle="tab">Assign</a>
        </li>
        <li class="nav-item m-1">
            <a class="nav-link p-1" href="#section" data-bs-toggle="tab">Section</a>
        </li>
        <li class="nav-item m-1">
            <a class="nav-link p-1" href="#subject" data-bs-toggle="tab">Subject</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Assign Tab -->
        <div class="tab-pane fade show active" id="assign">
            <div class="card mb-4 p-3">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('assign.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-3 p-1 profile d-flex justify-content-center">
                                <i class="fa-solid fa-image" style="font-size: 100px; color:gray;"></i>
                            </div>
                            <div class="col-md-9 p-1 d-flex">
                                <div class="col-md-4 p-1">
                                    <label class="form-label mb-1">Teacher</label>
                                    <select class="form-select" name="teacher" id="teacherSelect">
                                        <option value="">Select a teacher</option>
                                        @forelse(\App\Models\Teacher::all() as $teacher)
                                            <option value="{{ $teacher->id }}"
                                                    data-employment-status="{{ $teacher->employment_status }}"
                                                    data-email="{{ $teacher->email }}">
                                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                                            </option>
                                        @empty
                                            <option value="">No teachers available</option>
                                        @endforelse
                                    </select>
                                    @error('teacher')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 p-1">
                                    <label class="form-label mb-1">Employment</label>
                                    <input type="text" class="form-control" id="employmentStatus" readonly>
                                </div>
                                <div class="col-md-4 p-1">
                                    <label class="form-label mb-1">Email</label>
                                    <input type="email" class="form-control" id="email" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="assignmentFields">
                            <div class="row mb-3 mt-1 d-flex justify-content-center assignment-field-set">
                                <div class="col-md-4 p-1">
                                    <label class="form-label mb-1">Section</label>
                                    <select class="form-select" name="assignments[0][section]">
                                        <option value="">Select a section</option>
                                        @forelse(\App\Models\Section::whereNotNull('sectioname')->whereNotNull('code')->get() as $section)
                                            <option value="{{ $section->id }}">
                                                {{ $section->sectioname }} - {{ $section->code }}
                                            </option>
                                        @empty
                                            <option value="">No sections available</option>
                                        @endforelse
                                    </select>
                                    @error('assignments.0.section')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 p-1">
                                    <label class="form-label mb-1">Subject</label>
                                    <select class="form-select" name="assignments[0][subject]">
                                        <option value="">Select a subject</option>
                                        @forelse(\App\Models\Subject::all() as $subject)
                                            <option value="{{ $subject->id }}">
                                                {{ $subject->subjectname }}
                                            </option>
                                        @empty
                                            <option value="">No subjects available</option>
                                        @endforelse
                                    </select>
                                    @error('assignments.0.subject')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 p-1">
                                    <label class="form-label mb-1">Time</label>
                                    <select class="form-select" name="assignments[0][time]">
                                        <option value="">Select a time</option>
                                        @forelse(\App\Models\Subject::whereNotNull('start_time')->whereNotNull('end_time')->get() as $subject)
                                            <option value="{{ $subject->id }}"
                                                    data-start-time="{{ $subject->start_time }}"
                                                    data-end-time="{{ $subject->end_time }}">
                                                {{ \Carbon\Carbon::parse($subject->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($subject->end_time)->format('h:i A') }}
                                            </option>
                                        @empty
                                            <option value="">No times available</option>
                                        @endforelse
                                    </select>
                                    @error('assignments.0.time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center mt-2 mb-3">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-outline-primary w-100" id="addFieldsBtn">+</button>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center gap-1">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">Assign</button>
                            </div>
                            <div class="col-md-3">
                                <button type="reset" class="btn btn-outline-secondary w-100">Clear</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card p-3">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="search-container">
                            <input type="text" id="assignmentSearch" class="p-1 form-control w-100"
                                   placeholder="Search here...">
                        </div>
                        <div class="filter-container">
                            <select class="form-select" style="width: 150px;">
                                <option>Filter by</option>
                                <option value="teacher">Teacher</option>
                                <option value="subject">Subject</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>Teacher</th>
                                    <th>Subject Name</th>
                                    <th>Section</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="assignmentTable">
                                @forelse(\App\Models\Assign::all() as $assignment)
                                    <tr class="assignment-row">
                                        <td>{{ $assignment->teachername }}</td>
                                        <td>{{ $assignment->subject }}</td>
                                        <td>{{ $assignment->section }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($assignment->start_time)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($assignment->end_time)->format('h:i A') }}
                                        </td>
                                        <td>
                                            <span class="p-1 badge {{ $assignment->status == 'ongoing' ? 'bg-blue' : ($assignment->status == 'completed' ? 'bg-green' : 'bg-red') }}">
                                                {{ ucfirst($assignment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('assign.destroy', $assignment->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger remove-btn">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No assign available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Tab -->
        <div class="tab-pane fade" id="section">
            <div class="card p-3">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="search-container">
                            <input type="text" id="sectionSearch" class="p-1 form-control w-100"
                                   placeholder="Search...">
                        </div>
                        <div class="filter-container">
                            <select class="form-select" style="width: 150px;">
                                <option>Filter by</option>
                                <option value="strand">Strand</option>
                                <option value="grade_level">Grade Level</option>
                            </select>
                        </div>
                    </div>
                    <table class="table table-hover table-striped" style="cursor: pointer;">
                        <thead>
                            <tr>
                                <th>Section Name</th>
                                <th>Gradelevel</th>
                                <th>Code</th>
                                <th>Slots</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="sectionTable">
                            @forelse (\App\Models\Section::all() as $section)
                                <tr class="section-row">
                                    <td>{{ $section->sectioname }}</td>
                                    <td>{{ $section->gradelevel }}</td>
                                    <td>{{ $section->code }}</td>
                                    <td style="{{ $section->current_slots == 30 ? 'color: green;' : ($section->current_slots == 0 ? 'color: red;' : '') }}">
                                        {{ $section->current_slots }}/{{ $section->max_slots }}
                                    </td>
                                    <td class="text">
                                        <button class="btn" title="View">
                                            <i class="fa-solid fa-eye" style="color:#305cde; font-size: 18px;"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No sections available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Subject Tab -->
        <div class="tab-pane fade" id="subject">
            <div class="card p-3">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="search-container">
                            <input type="text" id="subjectSearch" class="p-1 form-control w-100"
                                   placeholder="Search...">
                        </div>
                        <div class="filter-container">
                            <select class="form-select" style="width: 150px;">
                                <option>Filter by</option>
                                <option value="strand">Strand</option>
                                <option value="grade_level">Grade Level</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>Subject Name</th>
                                    <th>Description</th>
                                    <th>Grade Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="subjectTable">
                                @forelse(\App\Models\Subject::all() as $subject)
                                    <tr class="subject-row">
                                        <td>{{ $subject->subjectname }}</td>
                                        <td>{{ $subject->description }}</td>
                                        <td>{{ $subject->gradelevel }}</td>
                                        <td>
                                            <button class="btn" title="View">
                                                <i class="fa-solid fa-eye" style="color:#305cde; font-size: 18px;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No subjects available</td>
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

<script>
document.querySelector('#teacherSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    document.querySelector('#employmentStatus').value = selectedOption.getAttribute('data-employment-status') || '';
    document.querySelector('#email').value = selectedOption.getAttribute('data-email') || '';
});

// Function to add new assignment fields
document.getElementById('addFieldsBtn').addEventListener('click', function() {
    const container = document.getElementById('assignmentFields');
    const fieldSets = container.querySelectorAll('.assignment-field-set');
    const index = fieldSets.length;

    const newFieldSet = document.createElement('div');
    newFieldSet.className = 'row mb-3 mt-1 d-flex justify-content-center assignment-field-set';
    newFieldSet.innerHTML = `
        <div class="col-md-4 p-1">
            <label class="form-label mb-1">Section</label>
            <select class="form-select" name="assignments[${index}][section]">
                <option value="">Select a section</option>
                @forelse(\App\Models\Section::whereNotNull('sectioname')->whereNotNull('code')->get() as $section)
                    <option value="{{ $section->id }}">
                        {{ $section->sectioname }} - {{ $section->code }}
                    </option>
                @empty
                    <option value="">No sections available</option>
                @endforelse
            </select>
        </div>
        <div class="col-md-4 p-1">
            <label class="form-label mb-1">Subject</label>
            <select class="form-select" name="assignments[${index}][subject]">
                <option value="">Select a subject</option>
                @forelse(\App\Models\Subject::all() as $subject)
                    <option value="{{ $subject->id }}">
                        {{ $subject->subjectname }}
                    </option>
                @empty
                    <option value="">No subjects available</option>
                @endforelse
            </select>
        </div>
        <div class="col-md-4 p-1">
            <label class="form-label mb-1">Time</label>
            <select class="form-select" name="assignments[${index}][time]">
                <option value="">Select a time</option>
                @forelse(\App\Models\Subject::whereNotNull('start_time')->whereNotNull('end_time')->get() as $subject)
                    <option value="{{ $subject->id }}"
                            data-start-time="{{ $subject->start_time }}"
                            data-end-time="{{ $subject->end_time }}">
                        {{ \Carbon\Carbon::parse($subject->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($subject->end_time)->format('h:i A') }}
                    </option>
                @empty
                    <option value="">No times available</option>
                @endforelse
            </select>
        </div>
        <div class="col-md-1 p-1">
            <button type="button" class="btn btn-danger btn-sm remove-field-set w-100 mt-4">Remove</button>
        </div>
    `;

    container.appendChild(newFieldSet);

    // Add event listener for the remove button
    newFieldSet.querySelector('.remove-field-set').addEventListener('click', function() {
        newFieldSet.remove();
    });
});

// Update the reset button to clear dynamically added fields
document.querySelector('button[type="reset"]').addEventListener('click', function() {
    document.querySelector('#employmentStatus').value = '';
    document.querySelector('#email').value = '';
    document.querySelector('#teacherSelect').value = '';
    const container = document.getElementById('assignmentFields');
    const fieldSets = container.querySelectorAll('.assignment-field-set');
    for (let i = 1; i < fieldSets.length; i++) {
        fieldSets[i].remove();
    }
});

const assignmentSearch = document.getElementById('assignmentSearch');
const assignmentRows = document.querySelectorAll('.assignment-row');

assignmentSearch.addEventListener('input', () => {
    const searchTerm = assignmentSearch.value.toLowerCase();
    assignmentRows.forEach(row => {
        const teacher = row.cells[0].textContent.toLowerCase();
        const subject = row.cells[1].textContent.toLowerCase();
        const section = row.cells[2].textContent.toLowerCase();
        if (teacher.includes(searchTerm) || subject.includes(searchTerm) || section.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

const sectionSearch = document.getElementById('sectionSearch');
const sectionRows = document.querySelectorAll('.section-row');

sectionSearch.addEventListener('input', () => {
    const searchTerm = sectionSearch.value.toLowerCase();
    sectionRows.forEach(row => {
        const sectionName = row.cells[0].textContent.toLowerCase();
        const code = row.cells[1].textContent.toLowerCase();
        if (sectionName.includes(searchTerm) || code.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

const subjectSearch = document.getElementById('subjectSearch');
const subjectRows = document.querySelectorAll('.subject-row');

subjectSearch.addEventListener('input', () => {
    const searchTerm = subjectSearch.value.toLowerCase();
    subjectRows.forEach(row => {
        const subjectName = row.cells[0].textContent.toLowerCase();
        const description = row.cells[1].textContent.toLowerCase();
        const gradeLevel = row.cells[2].textContent.toLowerCase();
        if (subjectName.includes(searchTerm) || description.includes(searchTerm) || gradeLevel.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endsection