@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subjectmanage.css') }}">
@endsection

@section('content')
<div class="subject-content">

    <div class="d-flex justify-content-between mb-1">
        <div>
            <h2>Subject Management</h2>
            <p style="font-size: 18px; color:#555 !important;">
                Manage and organize subjects efficiently.
            </p>
        </div>
        <a href="{{ route('subject.index') }}"><button class="btn tex-dark"><i
                    class="fa-solid fa-right-from-bracket"></i> Back</button></a>
    </div>
    <!-- Handlers -->
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
    <div class="alert alert-success p-1 mb-3">
        <strong><i class="fa-solid fa-circle-check"></i> Success!</strong> {{ session('success') }}
    </div>
    @endif
    <button class="btn btn-sm btn-primary p-1 mb-3" style="font-size: 14px;" disabled>
        <i class="fa-solid fa-graduation-cap"></i> Students
    </button>
    <!-- Student Assignment Note -->
    <div class="note-div" id="studentNote">
        <div class="note-header">
            <h6>How to Assign Subjects to Students</h6>
            <i class="fa-solid fa-chevron-down toggle-icon" data-note-id="studentNote"></i>
        </div>
        <div class="note-details" id="studentNoteDetails">
            <ul>
                <li><strong>Step 1: Filter students by strand and grade level.</strong>
                    <ul>
                        <li>Click the "Strand" dropdown to select a specific strand (e.g., STEM, ABM).</li>
                        <li>Click the "Grade Level" dropdown to choose Grade 11 or 12.</li>
                        <li>Use "All Strands" or "All Levels" to view all students.</li>
                    </ul>
                </li>
                <li><strong>Step 2: Select students.</strong>
                    <ul>
                        <li>Check the boxes next to student names to select them.</li>
                        <li>Use the "Select All" checkbox to select all visible students.</li>
                        <li>Ensure you have at least one student selected.</li>
                    </ul>
                </li>
                <li><strong>Step 3: Select subjects.</strong>
                    <ul>
                        <li>Check the boxes next to subjects in the right panel.</li>
                        <li>Ensure subjects match the selected students' strand and grade level.</li>
                        <li>Use "Select All" to choose all visible subjects.</li>
                    </ul>
                </li>
                <li><strong>Step 4: Assign subjects.</strong>
                    <ul>
                        <li>Click "Assign Subjects" to open a confirmation popup.</li>
                        <li>Review the selected students and subjects in the popup.</li>
                        <li>Click "Assign" to confirm, or "Cancel" to revise your selections.</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- Student Assignment Section -->
    <form id="assignSubjectForm" action="{{ route('subject.assign') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Left Card: Students Selection -->
            <div class="col-6">
                <div class="card p-1">
                    <div class="card-header">
                        <h5>Assign Subjects to Students</h5>
                        <div class="d-flex gap-2">
                            <!-- Strand Filter -->
                            <div class="dropdown">
                                <a class="btn btn-outline-dark btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-filter"></i> <span
                                        class="filter-strand">{{ $strand ?? 'Strand' }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item {{ !$strand ? 'active' : '' }}" href="#"
                                            data-strand="">All Strands</a></li>
                                    @foreach ($strands as $id => $strandName)
                                    <li><a class="dropdown-item {{ $strand == strtolower($strandName) ? 'active' : '' }}"
                                            href="#" data-strand="{{ strtolower($strandName) }}">{{ $strandName }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- Grade Level Filter -->
                            <div class="dropdown">
                                <a class="btn btn-outline-dark btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-filter"></i> <span
                                        class="filter-grade-level">{{ $gradeLevel ?? 'Grade Level' }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item {{ !$gradeLevel ? 'active' : '' }}" href="#"
                                            data-strand="{{ $strand ?? '' }}" data-grade-level="">All Levels</a>
                                    </li>
                                    <li><a class="dropdown-item {{ $gradeLevel == '11' ? 'active' : '' }}" href="#"
                                            data-strand="{{ $strand ?? '' }}" data-grade-level="11">Grade 11</a>
                                    </li>
                                    <li><a class="dropdown-item {{ $gradeLevel == '12' ? 'active' : '' }}" href="#"
                                            data-strand="{{ $strand ?? '' }}" data-grade-level="12">Grade 12</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <label class="form-label">Select Students</label>
                            <div class="form-check p-1">
                                <input type="checkbox" id="select_all_students" class="form-check-input">
                                <label for="select_all_students" class="form-check-label">Select All</label>
                            </div>
                        </div>
                        @if ($students->isNotEmpty())
                        @foreach ($students as $student)
                        <div class="student-card" data-strand="{{ strtolower($student->strand->strand_name) }}"
                            data-grade-level="{{ $student->grade_level }}">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <input type="checkbox" id="student_{{ $student->id }}" name="student_ids[]"
                                        value="{{ $student->id }}" class="form-check-input student-checkbox"
                                        data-student-name="{{ $student->first_name }} {{ $student->last_name }}">
                                    <label for="student_{{ $student->id }}" class="form-check-label">
                                        {{ $student->id }} - {{ $student->first_name }} {{ $student->last_name }}
                                        ({{ $student->strand->strand_name }}, {{ $student->grade_level }})
                                    </label>
                                </div>
                                <div>
                                    <a href="{{ route('student.edit', ['id'=>$student->id,'formtype'=>'view']) }}"><i
                                            class="fa-solid fa-expand"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <p>No students available.</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Right Card: Subjects Selection -->
            <div class="col-6">
                <div class="card p-1">
                    <div class="card-header">
                        <h5><i class="fa-solid fa-book"></i> Select Subjects</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <label class="form-label">Select Subjects</label>
                            <div class="form-check p-1">
                                <input type="checkbox" id="select_all_subjects" class="form-check-input">
                                <label for="select_all_subjects" class="form-check-label">Select All</label>
                            </div>
                        </div>
                        @if ($subjects->isNotEmpty())
                        @php
                        $groupedSubjects = $subjects->groupBy(function($subject) {
                        return $subject->strand->strand_name;
                        });
                        @endphp
                        @foreach ($groupedSubjects as $strandName => $strandSubjects)
                        <div class="strand-group">
                            <h6 class="strand-header" style="margin: 10px 0 5px; color: #333; font-weight: bold;">
                                {{ $strandName }}
                            </h6>
                            @foreach ($strandSubjects as $subject)
                            <div class="subject-card" data-strand="{{ strtolower($subject->strand->strand_name) }}"
                                data-grade-level="{{ $subject->grade_level }}">
                                <input type="checkbox" id="subject_{{ $subject->id }}" name="subject_ids[]"
                                    value="{{ $subject->id }}" class="form-check-input subject-checkbox"
                                    data-subject-name="{{ $subject->subject_name }}"
                                    data-strand="{{ strtolower($subject->strand->strand_name) }}"
                                    data-grade-level="{{ $subject->grade_level }}">
                                <label for="subject_{{ $subject->id }}" class="form-check-label">
                                    {{ $subject->subject_name }} ( {{ $subject->grade_level }},
                                    {{ $subject->semester }} , {{ $subject->term }})
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                        @else
                        <p>No subjects available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary btn-sm" id="assignStudentButton"><i
                    class="fa-solid fa-upload"></i> Assign Subjects</button>
        </div>
    </form>
    <hr>
    <button class="btn btn-sm btn-primary p-1 mb-3" style="font-size: 14px;" disabled>
        <i class="fa-solid fa-chalkboard-user"></i> Teachers
    </button>
    <!-- Teacher Assignment Note -->
    <div class="note-div" id="teacherNote">
        <div class="note-header">
            <h6>How to Assign Subjects to Teachers</h6>
            <i class="fa-solid fa-chevron-down toggle-icon" data-note-id="teacherNote"></i>
        </div>
        <div class="note-details" id="teacherNoteDetails">
            <ul>
                <li><strong>Step 1: Filter teachers by specialization.</strong>
                    <ul>
                        <li>Click the "Specialization" dropdown to select a specific specialization (e.g., Math,
                            Science).</li>
                        <li>Use "All Specializations" to view all teachers.</li>
                    </ul>
                </li>
                <li><strong>Step 2: Select teachers.</strong>
                    <ul>
                        <li>Check the boxes next to teacher names to select them.</li>
                        <li>Use the "Select All" checkbox to select all visible teachers.</li>
                        <li>Ensure at least one teacher is selected.</li>
                    </ul>
                </li>
                <li><strong>Step 3: Select subjects.</strong>
                    <ul>
                        <li>Check the boxes next to subjects in the right panel.</li>
                        <li>Choose subjects that align with the teachers' specialization for best results.</li>
                        <li>Use "Select All" to choose all visible subjects.</li>
                    </ul>
                </li>
                <li><strong>Step 4: Assign subjects.</strong>
                    <ul>
                        <li>Click "Assign to Teachers" to open a confirmation popup.</li>
                        <li>Review the selected teachers and subjects in the popup.</li>
                        <li>Click "Assign" to confirm, or "Cancel" to revise your selections.</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- Teacher Assignment Section -->
    <form id="assignTeacherForm" action="{{ route('subject.assignTeacher') }}" method="POST" class="mt-4">
        @csrf
        <div class="row">
            <!-- Left Card: Teachers Selection -->
            <div class="col-6">
                <div class="card p-1">
                    <div class="card-header">
                        <h5>Assign Subjects to Teachers</h5>
                        <div class="d-flex gap-2">
                            <!-- Specialization Filter -->
                            <div class="dropdown">
                                <a class="btn btn-outline-dark btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-filter"></i> <span
                                        class="filter-specialization">{{ $specialization ?? 'Specialization' }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item {{ !$specialization ? 'active' : '' }}" href="#"
                                            data-specialization="">All Specializations</a></li>
                                    @foreach ($specializations as $spec)
                                    <li><a class="dropdown-item {{ $specialization == $spec ? 'active' : '' }}" href="#"
                                            data-specialization="{{ $spec }}">{{ $spec }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <label class="form-label">Select Teachers</label>
                            <div class="form-check p-1">
                                <input type="checkbox" id="select_all_teachers" class="form-check-input">
                                <label for="select_all_teachers" class="form-check-label">Select All</label>
                            </div>
                        </div>
                        @if ($teachers->isNotEmpty())
                        @foreach ($teachers as $teacher)
                        <div class="teacher-card"
                            data-specialization="{{ strtolower($teacher->specialization ?? '') }}">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <input type="checkbox" id="teacher_{{ $teacher->id }}" name="teacher_ids[]"
                                        value="{{ $teacher->id }}" class="form-check-input teacher-checkbox"
                                        data-teacher-name="{{ $teacher->first_name }} {{ $teacher->last_name }}">

                                    <label for="teacher_{{ $teacher->id }}" class="form-check-label">
                                        {{ $teacher->id }} - {{ $teacher->first_name }} {{ $teacher->last_name }}
                                        (Specialization: {{ $teacher->specialization ?? 'N/A' }})
                                    </label>
                                </div>
                                <div>
                                    <a href="{{ route('teachers.edit', ['id'=>$teacher->id,'formtype'=>'view']) }}"><i
                                            class="fa-solid fa-expand"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <p>No teachers available.</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Right Card: Subjects Selection -->
            <div class="col-6">
                <div class="card p-1">
                    <div class="card-header">
                        <h5><i class="fa-solid fa-book"></i> Select Subjects</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <label class="form-label">Select Subjects</label>
                            <div class="form-check p-1">
                                <input type="checkbox" id="select_all_teacher_subjects" class="form-check-input">
                                <label for="select_all_teacher_subjects" class="form-check-label">Select All</label>
                            </div>
                        </div>
                        @if ($subjects->isNotEmpty())
                        @php
                        $groupedSubjects = $subjects->groupBy(function($subject) {
                        return $subject->strand->strand_name;
                        });
                        @endphp
                        @foreach ($groupedSubjects as $strandName => $strandSubjects)
                        <div class="strand-group">
                            <h6 class="strand-header" style="margin: 10px 0 5px; color: #333; font-weight: bold;">
                                {{ $strandName }}
                            </h6>
                            @foreach ($strandSubjects as $subject)
                            <div class="subject-card">
                                <input type="checkbox" id="teacher_subject_{{ $subject->id }}" name="subject_ids[]"
                                    value="{{ $subject->id }}" class="form-check-input teacher-subject-checkbox"
                                    data-subject-name="{{ $subject->subject_name }}"
                                    data-strand="{{ strtolower($subject->strand->strand_name) }}"
                                    data-grade-level="{{ $subject->grade_level }}">
                                <label for="teacher_subject_{{ $subject->id }}" class="form-check-label">
                                    {{ $subject->subject_name }} ({{ $subject->strand->strand_name }},
                                    {{ $subject->grade_level }}, {{ $subject->semester }}, {{ $subject->term }})
                                </label>

                            </div>
                            @endforeach
                        </div>
                        @endforeach
                        @else
                        <p>No subjects available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary btn-sm" id="assignTeacherButton"><i
                    class="fa-solid fa-upload"></i> Assign to Teachers</button>
        </div>
    </form>

    <!-- Custom Error Modal -->
    <div class="custom-modal" id="customErrorModal">
        <div class="modal-content">
            <div class="modal-header error">
                <h5 style="margin: 0;"><i class="fa-solid fa-circle-exclamation"></i> Error</h5>
                <button type="button" class="modal-close" data-modal-id="customErrorModal"
                    aria-label="Close error modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <strong>Warning!</strong>
                <p id="errorMessage" style="color:#333 !important;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-close btn text-danger" data-modal-id="customErrorModal"
                    style="padding: 8px 16px; cursor: pointer;" aria-label="Close error modal">Close</button>
            </div>
        </div>
    </div>

    <!-- Custom Confirmation Modal for Students -->
    <div class="custom-modal" id="customAssignStudentModal">
        <div class="modal-content">
            <div class="modal-header confirm">
                <h5 style="margin: 0;">Confirm Student Assignment</h5>
                <button type="button" class="modal-close" data-modal-id="customAssignStudentModal"
                    aria-label="Close assign confirmation modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div style="text-align: center; font-size: 50px;">
                    <i class="fa-solid fa-circle-plus" style="color: #28a745;"></i>
                </div>
                <p>Are you sure you want to assign the following subjects to the selected students?</p>
                <h6>Selected Students:</h6>
                <ul id="selectedStudentsList"
                    style="list-style: none; padding: 0; max-height: 150px; overflow-y: auto;"></ul>
                <h6>Selected Subjects:</h6>
                <ul id="selectedSubjectsList"
                    style="list-style: none; padding: 0; max-height: 150px; overflow-y: auto;"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-close btn text-danger" data-modal-id="customAssignStudentModal"
                    style="padding: 8px 16px; cursor: pointer;" aria-label="Cancel assign subjects">Cancel</button>
                <button type="button" id="confirmAssignStudentButton"
                    style="padding: 8px 16px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer;"
                    aria-label="Confirm assign subjects">Assign</button>
            </div>
        </div>
    </div>

    <!-- Custom Confirmation Modal for Teachers -->
    <div class="custom-modal" id="customAssignTeacherModal">
        <div class="modal-content">
            <div class="modal-header confirm">
                <h5 style="margin: 0;">Confirm Teacher Assignment</h5>
                <button type="button" class="modal-close" data-modal-id="customAssignTeacherModal"
                    aria-label="Close assign confirmation modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div style="text-align: center; font-size: 50px;">
                    <i class="fa-solid fa-circle-plus" style="color: #28a745;"></i>
                </div>
                <p>Are you sure you want to assign the following subjects to the selected teachers?</p>
                <h6>Selected Teachers:</h6>
                <ul id="selectedTeachersList"
                    style="list-style: none; padding: 0; max-height: 150px; overflow-y: auto;"></ul>
                <h6>Selected Subjects:</h6>
                <ul id="selectedTeacherSubjectsList"
                    style="list-style: none; padding: 0; max-height: 150px; overflow-y: auto;"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-close btn text-danger" data-modal-id="customAssignTeacherModal"
                    style="padding: 8px 16px; cursor: pointer;" aria-label="Cancel assign subjects">Cancel</button>
                <button type="button" id="confirmAssignTeacherButton"
                    style="padding: 8px 16px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer;"
                    aria-label="Confirm assign subjects">Assign</button>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Student Assignment Elements
        const assignSubjectForm = document.getElementById('assignSubjectForm');
        const customAssignStudentModal = document.getElementById('customAssignStudentModal');
        const selectedStudentsList = document.getElementById('selectedStudentsList');
        const selectedSubjectsList = document.getElementById('selectedSubjectsList');
        const confirmAssignStudentButton = document.getElementById('confirmAssignStudentButton');
        const assignStudentButton = document.getElementById('assignStudentButton');
        const selectAllStudents = document.getElementById('select_all_students');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');
        const selectAllSubjects = document.getElementById('select_all_subjects');
        const subjectCheckboxes = document.querySelectorAll('.subject-checkbox');

        // Teacher Assignment Elements
        const assignTeacherForm = document.getElementById('assignTeacherForm');
        const customAssignTeacherModal = document.getElementById('customAssignTeacherModal');
        const selectedTeachersList = document.getElementById('selectedTeachersList');
        const selectedTeacherSubjectsList = document.getElementById('selectedTeacherSubjectsList');
        const confirmAssignTeacherButton = document.getElementById('confirmAssignTeacherButton');
        const assignTeacherButton = document.getElementById('assignTeacherButton');
        const selectAllTeachers = document.getElementById('select_all_teachers');
        const teacherCheckboxes = document.querySelectorAll('.teacher-checkbox');
        const selectAllTeacherSubjects = document.getElementById('select_all_teacher_subjects');
        const teacherSubjectCheckboxes = document.querySelectorAll('.teacher-subject-checkbox');

        // Error Modal Elements
        const customErrorModal = document.getElementById('customErrorModal');
        const errorMessage = document.getElementById('errorMessage');

        // Modal Close Buttons
        const closeButtons = document.querySelectorAll('.modal-close');

        // Note Toggle Icons
        const toggleIcons = document.querySelectorAll('.toggle-icon');

        // Load Note Expanded State from localStorage
        toggleIcons.forEach(icon => {
            const noteId = icon.getAttribute('data-note-id');
            const details = document.getElementById(`${noteId}Details`);
            const isExpanded = localStorage.getItem(`expanded_${noteId}`) === 'true';
            if (isExpanded) {
                details.classList.add('show');
                icon.classList.add('expanded');
                icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            }
        });

        // Handle Note Toggle
        toggleIcons.forEach(icon => {
            icon.parentElement.addEventListener('click', function() {
                const noteId = icon.getAttribute('data-note-id');
                const details = document.getElementById(`${noteId}Details`);
                const isExpanded = details.classList.contains('show');
                if (isExpanded) {
                    details.classList.remove('show');
                    icon.classList.remove('expanded');
                    icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                    localStorage.setItem(`expanded_${noteId}`, 'false');
                } else {
                    details.classList.add('show');
                    icon.classList.add('expanded');
                    icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                    localStorage.setItem(`expanded_${noteId}`, 'true');
                }
            });
        });

        // Dropdown Filters for Students
        const studentDropdownItems = document.querySelectorAll('#assignSubjectForm .dropdown-menu .dropdown-item');
        studentDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const strand = this.getAttribute('data-strand') || '';
                const gradeLevel = this.getAttribute('data-grade-level') || '';
                filterStudents(strand, gradeLevel);
                const button = this.closest('.dropdown').querySelector(
                    '[data-bs-toggle="dropdown"]');
                if (button.querySelector('.filter-strand')) {
                    button.querySelector('.filter-strand').textContent = strand || 'Strand';
                } else {
                    button.querySelector('.filter-grade-level').textContent = gradeLevel ?
                        `Grade ${gradeLevel}` : 'Grade Level';
                }
            });
        });

        // Dropdown Filters for Teachers
        const teacherDropdownItems = document.querySelectorAll('#assignTeacherForm .dropdown-menu .dropdown-item');
        teacherDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const specialization = this.getAttribute('data-specialization') || '';
                filterTeachers(specialization);
                const button = this.closest('.dropdown').querySelector(
                    '[data-bs-toggle="dropdown"]');
                button.querySelector('.filter-specialization').textContent = specialization ||
                    'Specialization';
            });
        });

        // Select All Students
        selectAllStudents.addEventListener('change', function() {
            studentCheckboxes.forEach(checkbox => {
                if (checkbox.closest('.student-card').style.display !== 'none') {
                    checkbox.checked = this.checked;
                }
            });
        });

        // Select All Subjects (Students)
        selectAllSubjects.addEventListener('change', function() {
            subjectCheckboxes.forEach(checkbox => {
                if (checkbox.closest('.subject-card').style.display !== 'none') {
                    checkbox.checked = this.checked;
                }
            });
        });

        // Select All Teachers
        selectAllTeachers.addEventListener('change', function() {
            teacherCheckboxes.forEach(checkbox => {
                if (checkbox.closest('.teacher-card').style.display !== 'none') {
                    checkbox.checked = this.checked;
                }
            });
        });

        // Select All Subjects (Teachers)
        selectAllTeacherSubjects.addEventListener('change', function() {
            teacherSubjectCheckboxes.forEach(checkbox => {
                if (checkbox.closest('.subject-card').style.display !== 'none') {
                    checkbox.checked = this.checked;
                }
            });
        });

        // Filter Students
        function filterStudents(strand, gradeLevel) {
            const students = document.querySelectorAll('.student-card');
            students.forEach(student => {
                const studentStrand = student.dataset.strand;
                const studentGradeLevel = student.dataset.gradeLevel;
                const strandMatch = !strand || studentStrand === strand;
                const gradeMatch = !gradeLevel || studentGradeLevel === gradeLevel;
                student.style.display = strandMatch && gradeMatch ? '' : 'none';
            });
            selectAllStudents.checked = false;
            studentCheckboxes.forEach(checkbox => {
                if (checkbox.closest('.student-card').style.display !== 'none') {
                    checkbox.checked = false;
                }
            });
            filterSubjects(strand, gradeLevel);
        }

        // Filter Subjects
        function filterSubjects(strand, gradeLevel) {
            const subjects = document.querySelectorAll('.subject-card');
            subjects.forEach(subject => {
                const subjectStrand = subject.dataset.strand;
                const subjectGradeLevel = subject.dataset.gradeLevel;
                const strandMatch = !strand || subjectStrand === strand;
                const gradeMatch = !gradeLevel || subjectGradeLevel === gradeLevel;
                subject.style.display = strandMatch && gradeMatch ? '' : 'none';
                const strandGroup = subject.closest('.strand-group');
                if (strandGroup) {
                    const visibleSubjects = strandGroup.querySelectorAll(
                        '.subject-card:not([style*="display: none"])');
                    strandGroup.style.display = visibleSubjects.length > 0 ? '' : 'none';
                }
            });
            selectAllSubjects.checked = false;
            subjectCheckboxes.forEach(checkbox => {
                if (checkbox.closest('.subject-card').style.display !== 'none') {
                    checkbox.checked = false;
                }
            });
        }

        // Filter Teachers
        function filterTeachers(specialization) {
            const teachers = document.querySelectorAll('.teacher-card');
            teachers.forEach(teacher => {
                const teacherSpecialization = teacher.dataset.specialization || '';
                const specializationMatch = !specialization || teacherSpecialization === specialization;
                teacher.style.display = specializationMatch ? '' : 'none';
            });
            selectAllTeachers.checked = false;
            teacherCheckboxes.forEach(checkbox => {
                if (checkbox.closest('.teacher-card').style.display !== 'none') {
                    checkbox.checked = false;
                }
            });
        }

        // Show Error Modal
        function showError(message) {
            errorMessage.textContent = message;
            customErrorModal.classList.add('show');
        }

        // Student Assignment Submission
        assignSubjectForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const selectedStudents = document.querySelectorAll('input[name="student_ids[]"]:checked');
            const selectedSubjects = document.querySelectorAll(
                '#assignSubjectForm input[name="subject_ids[]"]:checked');

            if (selectedStudents.length === 0 || selectedSubjects.length === 0) {
                showError('Please select at least one student and one subject.');
                return;
            }

            // Validate strand and grade level match
            let hasError = false;
            let errorMessage = '';
            selectedStudents.forEach(student => {
                const studentCard = student.closest('.student-card');
                const studentStrand = studentCard.dataset.strand;
                const studentGradeLevel = studentCard.dataset.gradeLevel;

                selectedSubjects.forEach(subject => {
                    const subjectStrand = subject.dataset.strand;
                    const subjectGradeLevel = subject.dataset.gradeLevel;

                    if (studentStrand !== subjectStrand || studentGradeLevel !==
                        subjectGradeLevel) {
                        hasError = true;
                        errorMessage =
                            `Mismatch: ${student.dataset.studentName} (Strand: ${studentStrand}, Grade: ${studentGradeLevel}) cannot be assigned to ${subject.dataset.subjectName} (Strand: ${subjectStrand}, Grade: ${subjectGradeLevel}).`;
                    }
                });
            });

            if (hasError) {
                showError(errorMessage);
                return;
            }

            // Populate Confirmation Modal
            selectedStudentsList.innerHTML = '';
            selectedStudents.forEach(student => {
                const li = document.createElement('li');
                li.textContent = student.dataset.studentName;
                li.style.padding = '5px 0';
                selectedStudentsList.appendChild(li);
            });

            selectedSubjectsList.innerHTML = '';
            selectedSubjects.forEach(subject => {
                const li = document.createElement('li');
                li.textContent = subject.dataset.subjectName;
                li.style.padding = '5px 0';
                selectedSubjectsList.appendChild(li);
            });

            customAssignStudentModal.classList.add('show');
        });

        // Confirm Student Assignment
        confirmAssignStudentButton.addEventListener('click', function() {
            assignStudentButton.disabled = true;
            assignStudentButton.classList.add('btn-loading');
            assignSubjectForm.submit();
        });

        // Teacher Assignment Submission
        assignTeacherForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const selectedTeachers = document.querySelectorAll('input[name="teacher_ids[]"]:checked');
            const selectedSubjects = document.querySelectorAll(
                '#assignTeacherForm input[name="subject_ids[]"]:checked');

            if (selectedTeachers.length === 0 || selectedSubjects.length === 0) {
                showError('Please select at least one teacher and one subject.');
                return;
            }

            // Populate Confirmation Modal
            selectedTeachersList.innerHTML = '';
            selectedTeachers.forEach(teacher => {
                const li = document.createElement('li');
                li.textContent = teacher.dataset.teacherName;
                li.style.padding = '5px 0';
                selectedTeachersList.appendChild(li);
            });

            selectedTeacherSubjectsList.innerHTML = '';
            selectedSubjects.forEach(subject => {
                const li = document.createElement('li');
                li.textContent = subject.dataset.subjectName;
                li.style.padding = '5px 0';
                selectedTeacherSubjectsList.appendChild(li);
            });

            customAssignTeacherModal.classList.add('show');
        });

        // Confirm Teacher Assignment
        confirmAssignTeacherButton.addEventListener('click', function() {
            assignTeacherButton.disabled = true;
            assignTeacherButton.classList.add('btn-loading');
            assignTeacherForm.submit();
        });

        // Close Modals
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-id');
                const modal = document.getElementById(modalId);
                if (modal) modal.classList.remove('show');
            });
        });

        // Close Modal on Outside Click
        document.querySelectorAll('.custom-modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.remove('show');
                }
            });
        });
    });
</script>
@endsection