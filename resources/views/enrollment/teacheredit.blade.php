@extends('layouts.app')

@section('title', 'Teacher Details')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .teacher-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding: 0.5rem;
        background: #f3f4f6;
        border-radius: 0.25rem;
    }

    .teacher-tab {
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

    .teacher-tab.active {
        background: #fff;
        color: #1f2937;
        border-bottom: 2px solid #2563eb;
    }

    .teacher-card {
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
<div class="teacher-card">
    @if($formtype === 'teacheredit')
    <h2>Edit Teacher</h2>
    @else
    <h2>Teacher Details</h2>
    @endif
    <div class="nav-links">
        <a href="{{ route('teachers.index') }}"><i class="fa-solid fa-house"></i> Home</a>
        @if($formtype === 'view')
        <a href="{{ route('teachers.edit', ['id' => $teacher->id, 'formtype' => 'teacheredit']) }}"><i
                class="fa-solid fa-pen-to-square"></i> Edit</a>
        @else
        <a href="{{ route('teachers.edit', ['id' => $teacher->id, 'formtype' => 'view']) }}"><i
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

    <div class="teacher-tabs">
        <div class="teacher-tab active" data-tab="personal">Personal Info</div>
        <div class="teacher-tab" data-tab="education">Educational Background</div>
        <div class="teacher-tab" data-tab="credentials">Teaching Credentials</div>
        <div class="teacher-tab" data-tab="employment">Employment Details</div>
        <div class="teacher-tab" data-tab="additional">Additional Info</div>
        <div class="teacher-tab" data-tab="admin">Administrative Use</div>
        <div class="teacher-tab" data-tab="subjects">Assigned Subjects</div>
    </div>

    <!-- Personal Information Tab -->
    <div class="tab-content active" id="personal">
        @if($formtype === 'teacheredit')
        <h3 class="section-title">Personal Information</h3>
        <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-item">
                    <div class="profile-pic">
                        @if($teacher->profile_picture)
                        <img src="{{ Storage::url($teacher->profile_picture) }}" alt="Profile Picture">
                        @else
                        <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <input type="file" name="profile_picture" class="form-control mt-2" accept="image/*">
                    @error('profile_picture')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $teacher->first_name) }}" required>
                    @error('first_name')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $teacher->middle_name) }}">
                    @error('middle_name')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $teacher->last_name) }}" required>
                    @error('last_name')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $teacher->date_of_birth) }}"
                        required>
                    @error('date_of_birth')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="Male" {{ old('gender', $teacher->gender) === 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ old('gender', $teacher->gender) === 'Female' ? 'selected' : '' }}>
                            Female</option>
                    </select>
                    @error('gender')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Age</label>
                    <input type="number" name="age" value="{{ old('age', $teacher->age) }}" min="1" required>
                    @error('age')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Nationality</label>
                    <input type="text" name="nationality" value="{{ old('nationality', $teacher->nationality) }}"
                        required>
                    @error('nationality')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Address</label>
                    <input type="text" name="address" value="{{ old('address', $teacher->address) }}" required>
                    @error('address')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number"
                        value="{{ old('contact_number', $teacher->contact_number) }}" required>
                    @error('contact_number')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="form-item">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $teacher->email) }}" required>
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
                        @if($teacher->profile_picture)
                        <img src="{{ Storage::url($teacher->profile_picture) }}" alt="Profile Picture">
                        @else
                        <i class="fas fa-user"></i>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <strong>First Name</strong>
                    <span>{{ $teacher->first_name }}</span>
                </div>
                <div class="info-item">
                    <strong>Middle Name</strong>
                    <span>{{ $teacher->middle_name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <strong>Last Name</strong>
                    <span>{{ $teacher->last_name }}</span>
                </div>
                <div class="info-item">
                    <strong>Date of Birth</strong>
                    <span>{{ $teacher->date_of_birth }}</span>
                </div>
                <div class="info-item">
                    <strong>Gender</strong>
                    <span>{{ $teacher->gender }}</span>
                </div>
                <div class="info-item">
                    <strong>Age</strong>
                    <span>{{ $teacher->age }}</span>
                </div>
                <div class="info-item">
                    <strong>Nationality</strong>
                    <span>{{ $teacher->nationality }}</span>
                </div>
                <div class="info-item">
                    <strong>Address</strong>
                    <span>{{ $teacher->address }}</span>
                </div>
                <div class="info-item">
                    <strong>Contact Number</strong>
                    <span>{{ $teacher->contact_number }}</span>
                </div>
                <div class="info-item">
                    <strong>Email Address</strong>
                    <span>{{ $teacher->email }}</span>
                </div>
            </div>
            @endif
    </div>

    <!-- Educational Background Tab -->
    <div class="tab-content" id="education">
        @if($formtype === 'teacheredit')
        <h3 class="section-title">Educational Background</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>Highest Degree</label>
                <input type="text" name="degree" value="{{ old('degree', $teacher->degree) }}" required>
                @error('degree')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Major/Specialization</label>
                <input type="text" name="major" value="{{ old('major', $teacher->major) }}" required>
                @error('major')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>University</label>
                <input type="text" name="university" value="{{ old('university', $teacher->university) }}" required>
                @error('university')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Year Graduated</label>
                <input type="text" name="year_graduated" value="{{ old('year_graduated', $teacher->year_graduated) }}"
                    required>
                @error('year_graduated')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Educational Background</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Highest Degree</strong>
                <span>{{ $teacher->degree }}</span>
            </div>
            <div class="info-item">
                <strong>Major/Specialization</strong>
                <span>{{ $teacher->major }}</span>
            </div>
            <div class="info-item">
                <strong>University</strong>
                <span>{{ $teacher->university }}</span>
            </div>
            <div class="info-item">
                <strong>Year Graduated</strong>
                <span>{{ $teacher->year_graduated }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Teaching Credentials Tab -->
    <div class="tab-content" id="credentials">
        @if($formtype === 'teacheredit')
        <h3 class="section-title">Teaching Credentials</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>PRC License Number</label>
                <input type="text" name="prc_license" value="{{ old('prc_license', $teacher->prc_license) }}" required>
                @error('prc_license')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>License Validity Date</label>
                <input type="date" name="license_validity"
                    value="{{ old('license_validity', $teacher->license_validity) }}" required>
                @error('license_validity')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>LET Passing Date</label>
                <input type="date" name="let_date" value="{{ old('let_date', $teacher->let_date) }}" required>
                @error('let_date')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Teaching Specialization/Track</label>
                <select name="specialization" required>
                    <option value="Academic"
                        {{ old('specialization', $teacher->specialization) == 'Academic' ? 'selected' : '' }}>
                        Academic (STEM, ABM, HUMSS, GAS)</option>
                    <option value="TVL"
                        {{ old('specialization', $teacher->specialization) == 'TVL' ? 'selected' : '' }}>
                        Technical-Vocational-Livelihood (TVL)</option>
                    <option value="Sports"
                        {{ old('specialization', $teacher->specialization) == 'Sports' ? 'selected' : '' }}>
                        Sports</option>
                    <option value="Arts"
                        {{ old('specialization', $teacher->specialization) == 'Arts' ? 'selected' : '' }}>
                        Arts and Design</option>
                </select>
                @error('specialization')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>PRC License Copy</label>
                <input type="file" name="prc_copy" accept=".pdf,.jpg,.png">
                @if($teacher->prc_copy)
                <small>Current file: <a href="{{ Storage::url($teacher->prc_copy) }}" target="_blank">View</a></small>
                @endif
                @error('prc_copy')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Teaching Credentials</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>PRC License Number</strong>
                <span>{{ $teacher->prc_license }}</span>
            </div>
            <div class="info-item">
                <strong>License Validity Date</strong>
                <span>{{ $teacher->license_validity }}</span>
            </div>
            <div class="info-item">
                <strong>LET Passing Date</strong>
                <span>{{ $teacher->let_date }}</span>
            </div>
            <div class="info-item">
                <strong>Teaching Specialization/Track</strong>
                <span>{{ $teacher->specialization }}</span>
            </div>
            <div class="info-item">
                <strong>PRC License Copy</strong>
                <span>
                    @if($teacher->prc_copy)
                    <a href="{{ Storage::url($teacher->prc_copy) }}" target="_blank">View</a>
                    @else
                    N/A
                    @endif
                </span>
            </div>
        </div>
        @endif
    </div>

    <!-- Employment Details Tab -->
    <div class="tab-content" id="employment">
        @if($formtype === 'teacheredit')
        <h3 class="section-title">Employment Details</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>Previous School</label>
                <input type="text" name="previous_school"
                    value="{{ old('previous_school', $teacher->previous_school) }}">
                @error('previous_school')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Previous Position</label>
                <input type="text" name="position" value="{{ old('position', $teacher->position) }}">
                @error('position')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Years of Experience</label>
                <input type="number" name="years_experience"
                    value="{{ old('years_experience', $teacher->years_experience) }}" min="0">
                @error('years_experience')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Employment Status</label>
                <select name="employment_status" required>
                    <option value="Full-time"
                        {{ old('employment_status', $teacher->employment_status) == 'Full-time' ? 'selected' : '' }}>
                        Full-time</option>
                    <option value="Part-time"
                        {{ old('employment_status', $teacher->employment_status) == 'Part-time' ? 'selected' : '' }}>
                        Part-time</option>
                </select>
                @error('employment_status')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Preferred Schedule</label>
                <select name="teaching_schedule" required>
                    <option value="Morning"
                        {{ old('teaching_schedule', $teacher->teaching_schedule) == 'Morning' ? 'selected' : '' }}>
                        Morning</option>
                    <option value="Afternoon"
                        {{ old('teaching_schedule', $teacher->teaching_schedule) == 'Afternoon' ? 'selected' : '' }}>
                        Afternoon</option>
                    <option value="Evening"
                        {{ old('teaching_schedule', $teacher->teaching_schedule) == 'Evening' ? 'selected' : '' }}>
                        Evening</option>
                </select>
                @error('teaching_schedule')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Subjects Willing to Teach</label>
                <input type="text" name="subjects" value="{{ old('subjects', $teacher->subjects) }}" required>
                @error('subjects')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Employment Details</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Previous School</strong>
                <span>{{ $teacher->previous_school ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <strong>Previous Position</strong>
                <span>{{ $teacher->position ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <strong>Years of Experience</strong>
                <span>{{ $teacher->years_experience ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <strong>Employment Status</strong>
                <span>{{ $teacher->employment_status }}</span>
            </div>
            <div class="info-item">
                <strong>Preferred Schedule</strong>
                <span>{{ $teacher->teaching_schedule }}</span>
            </div>
            <div class="info-item">
                <strong>Subjects Willing to Teach</strong>
                <span>{{ $teacher->subjects }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Additional Information Tab -->
    <div class="tab-content" id="additional">
        @if($formtype === 'teacheredit')
        <h3 class="section-title">Additional Information</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>Certifications/Trainings</label>
                <textarea name="certifications">{{ old('certifications', $teacher->certifications) }}</textarea>
                @error('certifications')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Medical Information</label>
                <textarea name="medical_info">{{ old('medical_info', $teacher->medical_info) }}</textarea>
                @error('medical_info')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Special Accommodations</label>
                <textarea name="accommodations">{{ old('accommodations', $teacher->accommodations) }}</textarea>
                @error('accommodations')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Resume/CV</label>
                <input type="file" name="resume" accept=".pdf,.doc,.docx">
                @if($teacher->resume)
                <small>Current file: <a href="{{ Storage::url($teacher->resume) }}" target="_blank">View</a></small>
                @endif
                @error('resume')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Transcript of Records</label>
                <input type="file" name="transcript" accept=".pdf,.doc,.docx">
                @if($teacher->transcript)
                <small>Current file: <a href="{{ Storage::url($teacher->transcript) }}" target="_blank">View</a></small>
                @endif
                @error('transcript')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Additional Information</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Certifications/Trainings</strong>
                <span>{{ $teacher->certifications ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <strong>Medical Information</strong>
                <span>{{ $teacher->medical_info ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <strong>Special Accommodations</strong>
                <span>{{ $teacher->accommodations ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <strong>Resume/CV</strong>
                <span>
                    @if($teacher->resume)
                    <a href="{{ Storage::url($teacher->resume) }}" target="_blank">View</a>
                    @else
                    N/A
                    @endif
                </span>
            </div>
            <div class="info-item">
                <strong>Transcript of Records</strong>
                <span>
                    @if($teacher->transcript)
                    <a href="{{ Storage::url($teacher->transcript) }}" target="_blank">View</a>
                    @else
                    N/A
                    @endif
                </span>
            </div>
        </div>
        @endif
    </div>

    <!-- Administrative Use Tab -->
    <div class="tab-content" id="admin">
        @if($formtype === 'teacheredit')
        <h3 class="section-title">Administrative Use</h3>
        <div class="form-grid">
            <div class="form-item">
                <label>Date Hired</label>
                <input type="date" name="date_hired" value="{{ old('date_hired', $teacher->date_hired) }}" required>
                @error('date_hired')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-item">
                <label>Employee ID</label>
                <input type="text" name="employee_id" value="{{ old('employee_id', $teacher->employee_id) }}" required>
                @error('employee_id')
                <div class="text-danger">{{$message }}</div>
                @enderror
            </div>
        </div>
        @else
        <h3 class="section-title">Administrative Use</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>Date Hired</strong>
                <span>{{ $teacher->date_hired }}</span>
            </div>
            <div class="info-item">
                <strong>Employee ID</strong>
                <span>{{ $teacher->employee_id }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Assigned Subjects Tab -->
    <div class="tab-content" id="subjects">
        <h3 class="section-title">Assigned Subjects</h3>
        <div class="subjects-table">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Term</th>
                        <th>Title</th>
                        <th>Status</th>
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

                    $groupedSubjects = $teacher->teacherSubject->groupBy(function ($teacherSubject) use
                    ($termToSemester) {
                    $term = $teacherSubject->subject->term ?? $teacherSubject->subject->semester ?? '1st Sem';
                    $semester = $termToSemester[$term] ?? $term;
                    return ($teacherSubject->subject->grade_level ?? 'Grade 11') . '|' . $semester;
                    });
                    @endphp

                    @foreach ($sections as $section)
                    <tr class="tr-head">
                        <td colspan="5">{{ $section['grade'] }} / {{ $section['semester'] }}</td>
                    </tr>
                    @php
                    $sectionKey = $section['grade'] . '|' . $section['semester'];
                    $subjects = $groupedSubjects->get($sectionKey, collect([]));
                    @endphp
                    @if ($subjects->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No subjects assigned</td>
                    </tr>
                    @else
                    @foreach ($subjects as $teacherSubject)
                    <tr>
                        <td>{{ $teacherSubject->subject->subject_code ?? 'N/A' }}</td>
                        <td>{{ $teacherSubject->subject->term ?? $teacherSubject->subject->semester ?? 'N/A' }}</td>
                        <td>{{ $teacherSubject->subject->subject_name ?? 'N/A' }}</td>
                        <td>{{ $teacherSubject->status ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('subject.show', $teacherSubject->subject->id) }}" class "action-link"><i
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

    @if($formtype === 'teacheredit')
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
        const tabs = document.querySelectorAll('.teacher-tab');
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
                document.querySelector('.teacher-card').scrollTop = 0;
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