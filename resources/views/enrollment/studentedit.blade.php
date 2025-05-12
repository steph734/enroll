@extends('layouts.app')

@section('title', 'Student Details')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .student-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding: 0.5rem;
        background: #f3f4f6;
        border-radius: 0.25rem;
    }

    .student-tab {
        padding: 0.5rem 1rem;
        background: #e5e7eb;
        color: #374151;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 500;
        transition: background 0.3s;
    }

    .student-tab.active {
        background: #fff;
        color: #1f2937;
        border-bottom: 2px solid #2563eb;
    }

    .student-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 0 15px 15px 15px;
        padding: 1rem;
        max-width: auto;
        margin: 0 auto;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 500;
        color: #4b5563;
        margin: 1rem 0 0.5rem;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 0.25rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.75rem;
        font-size: 0.875rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-item strong {
        color: #374151;
        font-weight: 500;
        margin-bottom: 0.125rem;
    }

    .info-item span {
        color: #6b7280;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.75rem;
        font-size: 0.875rem;
    }

    .form-item {
        display: flex;
        flex-direction: column;
    }

    .form-item label {
        color: #374151;
        font-weight: 500;
        margin-bottom: 0.125rem;
    }

    .form-item input,
    .form-item select,
    .form-item textarea {
        font-size: 0.875rem;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        width: 100%;
    }

    .form-item textarea {
        resize: vertical;
        min-height: 60px;
    }

    .form-item .text-danger {
        font-size: 0.75rem;
        color: #dc3545;
    }

    .profile-pic {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile-pic img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-pic i {
        font-size: 2rem;
        color: #9ca3af;
    }

    .alert {
        padding: 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    .nav-links {
        display: flex;
        gap: 1rem;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .nav-links a {
        color: #6b7280;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .nav-links a:hover {
        color: #2563eb;
    }

    .subjects-table {
        margin-top: 1rem;
        font-size: 0.875rem;
    }

    .subjects-table .table {
        border: 1px solid #e5e7eb;
        border-radius: 0.25rem;
    }

    .subjects-table th {
        background: #f9fafb;
        color: #374151;
        font-weight: 500;
        padding: 0.5rem;
    }

    .subjects-table td {
        padding: 0.5rem;
        color: #6b7280;
    }

    .tr-head {
        background-color: #e7f3fe;
        border-left: 4px solid #007bff;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    .action-link {
        color: #2563eb;
    }

    .action-link:hover {
        color: #1e40af;
    }

    .btn-submit {
        background: #2563eb;
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        border: none;
    }

    .btn-submit:hover {
        background: #1e40af;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="student-card">
    @if($formtype === 'studentedit')
    <h2>Edit Student</h2>
    @else
    <h2>Student Details</h2>
    @endif
    <div class="nav-links">
        <a href="{{ route('enrollment.show', 'students') }}"><i class="fa-solid fa-house"></i> Home</a>
        @if($formtype === 'view')
        <a href="{{ route('student.edit', ['id' => $student->id, 'formtype' => 'studentedit']) }}"><i
                class="fa-solid fa-pen-to-square"></i> Edit</a>
        @else
        <a href="{{ route('student.edit', ['id' => $student->id, 'formtype' => 'view']) }}"><i
                class="fa-solid fa-arrow-left"></i> Return</a>
        @endif
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
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
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i>
        <strong>Success!</strong> {{ session('success') }}
    </div>
    @endif

    <div class="student-tabs">
        <div class="student-tab active" data-tab="personal">Personal Info</div>
        <div class="student-tab" data-tab="parent">Parent/Guardian Info</div>
        <div class="student-tab" data-tab="academic">Academic Background</div>
        <div class="student-tab" data-tab="program">Program Enrollment</div>
        <div class="student-tab" data-tab="additional">Additional Info</div>
        <div class="student-tab" data-tab="payment">Payment Info</div>
        <div class="student-tab" data-tab="status">Student Status</div>
    </div>

    <!-- Personal Information Tab -->
    <div class="tab-content active" id="personal">
        @if($formtype === 'studentedit')
        <h3 class="section-title">Personal Information</h3>
        <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-item">
                    <div class="profile-pic">
                        @if($student->profile_picture)
                        <img src="{{ Storage::url($student->profile_picture) }}" alt="Profile Picture">
                        @else
                        <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <input type="file" name="profile_picture" class="form-control mt-2">
                </div>
                <div class="form-item">
                    <label>First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}" required>
                    @error('first_name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $student->middle_name) }}">
                </div>
                <div class="form-item">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}" required>
                    @error('last_name')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}"
                        required>
                    @error('date_of_birth')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>
                            Female</option>
                        <option value="Other" {{ old('gender', $student->gender) === 'Other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    @error('gender')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Age</label>
                    <input type="number" name="age" value="{{ old('age', $student->age) }}" required>
                    @error('age')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Nationality</label>
                    <input type="text" name="nationality" value="{{ old('nationality', $student->nationality) }}"
                        required>
                    @error('nationality')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Home Address</label>
                    <input type="text" name="home_address" value="{{ old('home_address', $student->home_address) }}"
                        required>
                    @error('home_address')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Zip Code</label>
                    <input type="text" name="zip_code" value="{{ old('zip_code', $student->zip_code) }}" required>
                    @error('zip_code')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number"
                        value="{{ old('contact_number', $student->contact_number) }}" required>
                    @error('contact_number')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Secondary Contact</label>
                    <input type="text" name="secondary_contact"
                        value="{{ old('secondary_contact', $student->secondary_contact) }}">
                </div>
                <div class="form-item">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $student->email) }}" required>
                    @error('email')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
            @else
            <h3 class="section-title">Personal Information</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="profile-pic">
                        @if($student->profile_picture)
                        <img src="{{ Storage::url($student->profile_picture) }}" alt="Profile Picture">
                        @else
                        <i class="fas fa-user"></i>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <strong>First Name</strong>
                    <span>{{ $student->first_name }}</span>
                </div>
                <div class="info-item">
                    <strong>Middle Name</strong>
                    <span>{{ $student->middle_name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <strong>Last Name</strong>
                    <span>{{ $student->last_name }}</span>
                </div>
                <div class="info-item">
                    <strong>Date of Birth</strong>
                    <span>{{ $student->date_of_birth }}</span>
                </div>
                <div class="info-item">
                    <strong>Gender</strong>
                    <span>{{ $student->gender }}</span>
                </div>
                <div class="info-item">
                    <strong>Age</strong>
                    <span>{{ $student->age }}</span>
                </div>
                <div class="info-item">
                    <strong>Nationality</strong>
                    <span>{{ $student->nationality }}</span>
                </div>
                <div class="info-item">
                    <strong>Home Address</strong>
                    <span>{{ $student->home_address }}</span>
                </div>
                <div class="info-item">
                    <strong>Zip Code</strong>
                    <span>{{ $student->zip_code }}</span>
                </div>
                <div class="info-item">
                    <strong>Contact Number</strong>
                    <span>{{ $student->contact_number }}</span>
                </div>
                <div class="info-item">
                    <strong>Secondary Contact</strong>
                    <span>{{ $student->secondary_contact ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <strong>Email Address</strong>
                    <span>{{ $student->email }}</span>
                </div>
            </div>
            @endif
    </div>

    <!-- Parent/Guardian Information Tab -->
    <div class="tab-content" id="parent">
        @if($formtype === 'studentedit')
        <h3 class="section-title">Parent/Guardian Information</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>First Name</label>
                <input type="text" name="guardian_first_name"
                    value="{{ old('guardian_first_name', $student->guardian_first_name) }}" required>
                @error('guardian_first_name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Middle Name</label>
                <input type="text" name="guardian_middle_name"
                    value="{{ old('guardian_middle_name', $student->guardian_middle_name) }}">
            </div>
            <div class="form-item">
                <label>Last Name</label>
                <input type="text" name="guardian_last_name"
                    value="{{ old('guardian_last_name', $student->guardian_last_name) }}" required>
                @error('guardian_last_name')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Relationship</label>
                <select name="relationship" required>
                    <option value="Mother"
                        {{ old('relationship', $student->relationship) === 'Mother' ? 'selected' : '' }}>Mother</option>
                    <option value="Father"
                        {{ old('relationship', $student->relationship) === 'Father' ? 'selected' : '' }}>Father</option>
                    <option value="Guardian"
                        {{ old('relationship', $student->relationship) === 'Guardian' ? 'selected' : '' }}>Guardian
                    </option>
                    <option value="Other"
                        {{ old('relationship', $student->relationship) === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('relationship')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Contact Number</label>
                <input type="text" name="guardian_contact"
                    value="{{ old('guardian_contact', $student->guardian_contact) }}" required>
                @error('guardian_contact')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Email Address</label>
                <input type="email" name="guardian_email" value="{{ old('guardian_email', $student->guardian_email) }}">
                @error('guardian_email')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Parent/Guardian Information</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>First Name</strong>
                <span>{{ $student->guardian_first_name }}</span>
            </div>
            <div class="info-item">
                <strong>Middle Name</strong>
                <span>{{ $student->guardian_middle_name ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <strong>Last Name</strong>
                <span>{{ $student->guardian_last_name }}</span>
            </div>
            <div class="info-item">
                <strong>Relationship</strong>
                <span>{{ $student->relationship }}</span>
            </div>
            <div class="info-item">
                <strong>Contact Number</strong>
                <span>{{ $student->guardian_contact }}</span>
            </div>
            <div class="info-item">
                <strong>Email Address</strong>
                <span>{{ $student->guardian_email ?? 'N/A' }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Academic Background Tab -->
    <div class="tab-content" id="academic">
        @if($formtype === 'studentedit')
        <h3 class="section-title">Academic Background</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>Previous School</label>
                <input type="text" name="previous_school"
                    value="{{ old('previous_school', $student->previous_school) }}" required>
                @error('previous_school')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Grade Completed</label>
                <select name="grade_completed" required>
                    @foreach(['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8',
                    'Grade 9', 'Grade 10'] as $grade)
                    <option value="{{ $grade }}"
                        {{ old('grade_completed', $student->grade_completed) === $grade ? 'selected' : '' }}>
                        {{ $grade }}
                    </option>
                    @endforeach
                </select>
                @error('grade_completed')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>School Year</label>
                <input type="text" name="school_year_completed"
                    value="{{ old('school_year_completed', $student->school_year_completed) }}" required>
                @error('school_year_completed')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>GPA</label>
                <input type="text" name="gpa" value="{{ old('gpa', $student->gpa) }}">
                @error('gpa')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Academic Background</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Previous School</strong>
                <span>{{ $student->previous_school }}</span>
            </div>
            <div class="info-item">
                <strong>Grade Completed</strong>
                <span>{{ $student->grade_completed }}</span>
            </div>
            <div class="info-item">
                <strong>School Year</strong>
                <span>{{ $student->school_year_completed }}</span>
            </div>
            <div class="info-item">
                <strong>GPA</strong>
                <span>{{ $student->gpa ?? 'N/A' }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Program Enrollment Tab -->
    <div class="tab-content" id="program">
        @if($formtype === 'studentedit')
        <h3 class="section-title">Program Enrollment</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>Track</label>
                <select name="track_id" required>
                    @foreach($tracks as $track)
                    <option value="{{ $track->id }}"
                        {{ old('track_id', $student->track_id) == $track->id ? 'selected' : '' }}>
                        {{ $track->track_name }}
                    </option>
                    @endforeach
                </select>
                @error('track_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Strand</label>
                <select name="strand_id" required>
                    @foreach($student->track->strands as $strand)
                    <option value="{{ $strand->id }}"
                        {{ old('strand_id', $student->strand_id) == $strand->id ? 'selected' : '' }}>
                        {{ $strand->strand_name }}
                    </option>
                    @endforeach
                </select>
                @error('strand_id')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Grade Level</label>
                <select name="grade_level" required>
                    <option value="Grade 11"
                        {{ old('grade_level', $student->grade_level) === 'Grade 11' ? 'selected' : '' }}>Grade 11
                    </option>
                    <option value="Grade 12"
                        {{ old('grade_level', $student->grade_level) === 'Grade 12' ? 'selected' : '' }}>Grade 12
                    </option>
                </select>
                @error('grade_level')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Class Schedule</label>
                <select name="class_schedule" required>
                    <option value="Morning"
                        {{ old('class_schedule', $student->class_schedule) === 'Morning' ? 'selected' : '' }}>Morning
                    </option>
                    <option value="Afternoon"
                        {{ old('class_schedule', $student->class_schedule) === 'Afternoon' ? 'selected' : '' }}>
                        Afternoon</option>
                    <option value="Evening"
                        {{ old('class_schedule', $student->class_schedule) === 'Evening' ? 'selected' : '' }}>Evening
                    </option>
                </select>
                @error('class_schedule')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Notes</label>
                <textarea name="additional_notes">{{ old('additional_notes', $student->additional_notes) }}</textarea>
                @error('additional_notes')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Program Enrollment</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Track</strong>
                <span>{{ $student->track->track_name ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <strong>Strand</strong>
                <span>{{ $student->strand->strand_name ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <strong>Grade Level</strong>
                <span>{{ $student->grade_level }}</span>
            </div>
            <div class="info-item">
                <strong>Class Schedule</strong>
                <span>{{ $student->class_schedule }}</span>
            </div>
            <div class="info-item">
                <strong>Notes</strong>
                <span>{{ $student->additional_notes ?? 'N/A' }}</span>
            </div>
        </div>
        @endif
        <h3 class="section-title">Enrolled Subjects</h3>
        <div class="subjects-table">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Term</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Prerequisites</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $sections = [
                    ['grade' => 'Grade 11', 'semester' => '1st Sem'],
                    ['grade' => 'Grade 11', 'semester' => '2nd Sem'],
                    ['grade' => 'Grade 12', 'semester' => '1st Sem'],
                    ['grade' => 'Grade 12', 'semester' => '2nd Sem'],
                    ];

                    $termToSemester = [
                    '1st Term' => '1st Sem',
                    '2nd Term' => '1st Sem',
                    '3rd Term' => '2nd Sem',
                    '4th Term' => '2nd Sem',
                    ];

                    $groupedSubjects = $student->studentSubject->groupBy(function ($studentSubject) use
                    ($termToSemester) {
                    $term = $studentSubject->subject->term ?? $studentSubject->subject->semester ?? '1st Sem';
                    $semester = $termToSemester[$term] ?? $term;
                    return ($studentSubject->subject->grade_level ?? 'Grade 11') . '|' . $semester;
                    });
                    @endphp

                    @foreach ($sections as $section)
                    <tr class="tr-head">
                        <td colspan="6">{{ $section['grade'] }} / {{ $section['semester'] }}</td>
                    </tr>
                    @php
                    $sectionKey = $section['grade'] . '|' . $section['semester'];
                    $subjects = $groupedSubjects->get($sectionKey, collect([]));
                    @endphp
                    @if ($subjects->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No subjects enrolled</td>
                    </tr>
                    @else
                    @foreach ($subjects as $studentSubject)
                    <tr>
                        <td>{{ $studentSubject->subject->subject_code ?? 'N/A' }}</td>
                        <td>{{ $studentSubject->subject->term ?? $studentSubject->subject->semester ?? 'N/A' }}</td>
                        <td>{{ $studentSubject->subject->subject_name ?? 'N/A' }}</td>
                        <td>{{ $studentSubject->status ?? 'N/A' }}</td>
                        <td>{{ $studentSubject->subject->prerequisites ?? 'None' }}</td>
                        <td>
                            <a href="{{ route('subject.show', $studentSubject->subject->id) }}" class="action-link"><i
                                    class="fa-solid fa-angle-right"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Additional Information Tab -->
    <div class="tab-content" id="additional">
        @if($formtype === 'studentedit')
        <h3 class="section-title">Additional Information</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>Medical Info</label>
                <textarea name="medical_info">{{ old('medical_info', $student->medical_info) }}</textarea>
                @error('medical_info')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Accommodations</label>
                <textarea
                    name="special_accommodations">{{ old('special_accommodations', $student->special_accommodations) }}</textarea>
                @error('special_accommodations')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Additional Information</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Medical Info</strong>
                <span>{{ $student->medical_info ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <strong>Accommodations</strong>
                <span>{{ $student->special_accommodations ?? 'N/A' }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Payment Information Tab -->
    <div class="tab-content" id="payment">
        @if($formtype === 'studentedit')
        <h3 class="section-title">Payment Information</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>Payment Date</label>
                <input type="date" name="payment_date" value="{{ old('payment_date', $student->payment_date) }}"
                    required>
                @error('payment_date')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Downpayment</label>
                <input type="number" name="downpayment" value="{{ old('downpayment', $student->downpayment) }}"
                    required>
                @error('downpayment')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Payment Method</label>
                <select name="payment_method" required>
                    <option value="Cash"
                        {{ old('payment_method', $student->payment_method) === 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="Credit Card"
                        {{ old('payment_method', $student->payment_method) === 'Credit Card' ? 'selected' : '' }}>Credit
                        Card</option>
                    <option value="Bank Transfer"
                        {{ old('payment_method', $student->payment_method) === 'Bank Transfer' ? 'selected' : '' }}>Bank
                        Transfer</option>
                    <option value="Online Payment"
                        {{ old('payment_method', $student->payment_method) === 'Online Payment' ? 'selected' : '' }}>
                        Online Payment</option>
                </select>
                @error('payment_method')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Balance</label>
                <input type="number" name="balance" value="{{ old('balance', $student->balance) }}" required>
                @error('balance')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Receipt Number</label>
                <input type="text" name="receiptnumber" value="{{ old('receiptnumber', $student->receiptnumber) }}"
                    required>
                @error('receiptnumber')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Student ID</label>
                <input type="number" name="studentid" value="{{ old('studentid', $student->studentid) }}" required>
                @error('studentid')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Payment Information</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Payment Date</strong>
                <span>{{ $student->payment_date }}</span>
            </div>
            <div class="info-item">
                <strong>Downpayment</strong>
                <span>{{ $student->downpayment }}</span>
            </div>
            <div class="info-item">
                <strong>Payment Method</strong>
                <span>{{ $student->payment_method }}</span>
            </div>
            <div class="info-item">
                <strong>Balance</strong>
                <span>{{ $student->balance }}</span>
            </div>
            <div class="info-item">
                <strong>Receipt Number</strong>
                <span>{{ $student->receiptnumber }}</span>
            </div>
            <div class="info-item">
                <strong>Student ID</strong>
                <span>{{ $student->studentid }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Student Status Tab -->
    <div class="tab-content" id="status">
        @if($formtype === 'studentedit')
        <h3 class="section-title">Student Status</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>Status</label>
                <select name="status" required>
                    <option value="ongoing" {{ old('status', $student->status) === 'ongoing' ? 'selected' : '' }}>
                        Ongoing</option>
                    <option value="graduated" {{ old('status', $student->status) === 'graduated' ? 'selected' : '' }}>
                        Graduated</option>
                    <option value="dropped" {{ old('status', $student->status) === 'dropped' ? 'selected' : '' }}>
                        Dropped</option>
                </select>
                @error('status')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Student Status</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Status</strong>
                <span>{{ $student->status ?? 'N/A' }}</span>
            </div>
        </div>
        @endif
    </div>

    @if($formtype === 'studentedit')
    <div class="mt-3 text-center">
        <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
        </form>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.student-tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(tc => tc.classList.remove('active'));

                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');

                // Scroll to top of card if content height changes
                document.querySelector('.student-card').scrollTop = 0;
            });
        });

        // Handle section header clicks in subjects table
        const sectionHeaders = document.querySelectorAll('.tr-head');
        sectionHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const rows = [];
                let next = header.nextElementSibling;
                while (next && !next.classList.contains('tr-head')) {
                    rows.push(next);
                    next = next.nextElementSibling;
                }
                rows.forEach(row => row.classList.toggle('d-none'));
            });
        });
    });
</script>
@endsection