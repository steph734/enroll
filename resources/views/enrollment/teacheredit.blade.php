@extends('layouts.app')

@section('title', 'Teacher Details')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/teacher_form.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
a {
    text-decoration: none !important;
}
</style>
@endsection

@section('content')
<div class="container">
    @if($formtype === 'teacheredit')
    <!-- Edit Form -->
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Edit Teacher</p>
    <hr>
    <div class="mb-3 mt-2 d-flex gap-2">
        <a href="{{ route('teachers.index') }}" class="p-1"><i class="fa-solid fa-house"></i> <span
                class="text-muted">Home</span></a>
        <a href="{{ route('teachers.edit', ['id' => $teacher->id, 'formtype' => 'view']) }}" class="p-1"><i
                class="fa-solid fa-arrow-left"></i> <span class="text-muted">Return</span></a>
    </div>

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
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Personal Information -->
        <h5 class="section-title">Personal Information</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 text-center col-md-3">
                    <div class="mb-3 profile-pic">
                        @if($teacher->profile_picture)
                        <img src="{{ Storage::url($teacher->profile_picture) }}" alt="Profile Picture"
                            class="img-fluid rounded-circle" style="max-width: 150px;">
                        @else
                        <i class="fas fa-user fa-3x"></i>
                        @endif
                    </div>
                    <input type="file" name="profile_picture" class="form-control mt-2" accept="image/*">
                    @error('profile_picture')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>First Name:</strong></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $teacher->first_name) }}"
                                class="form-control" required>
                            @error('first_name')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Middle Name:</strong></label>
                            <input type="text" name="middle_name"
                                value="{{ old('middle_name', $teacher->middle_name) }}" class="form-control">
                            @error('middle_name')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Last Name:</strong></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $teacher->last_name) }}"
                                class="form-control" required>
                            @error('last_name')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Date of Birth:</strong></label>
                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', $teacher->date_of_birth) }}" class="form-control"
                                required>
                            @error('date_of_birth')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Gender:</strong></label>
                            <select name="gender" class="form-control" required>
                                <option value="Male" {{ old('gender', $teacher->gender) === 'Male' ? 'selected' : '' }}>
                                    Male</option>
                                <option value="Female"
                                    {{ old('gender', $teacher->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Age:</strong></label>
                            <input type="number" name="age" value="{{ old('age', $teacher->age) }}" class="form-control"
                                min="1" required>
                            @error('age')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Nationality:</strong></label>
                            <input type="text" name="nationality"
                                value="{{ old('nationality', $teacher->nationality) }}" class="form-control" required>
                            @error('nationality')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Address:</strong></label>
                            <input type="text" name="address" value="{{ old('address', $teacher->address) }}"
                                class="form-control" required>
                            @error('address')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Contact Number:</strong></label>
                            <input type="text" name="contact_number"
                                value="{{ old('contact_number', $teacher->contact_number) }}" class="form-control"
                                required>
                            @error('contact_number')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Email Address:</strong></label>
                            <input type="email" name="email" value="{{ old('email', $teacher->email) }}"
                                class="form-control" required>
                            @error('email')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Educational Background -->
        <h5 class="section-title">Educational Background</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Highest Degree:</strong></label>
                    <input type="text" name="degree" value="{{ old('degree', $teacher->degree) }}" class="form-control"
                        required>
                    @error('degree')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Major/Specialization:</strong></label>
                    <input type="text" name="major" value="{{ old('major', $teacher->major) }}" class="form-control"
                        required>
                    @error('major')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>University:</strong></label>
                    <input type="text" name="university" value="{{ old('university', $teacher->university) }}"
                        class="form-control" required>
                    @error('university')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Year Graduated:</strong></label>
                    <input type="text" name="year_graduated"
                        value="{{ old('year_graduated', $teacher->year_graduated) }}" class="form-control" required>
                    @error('year_graduated')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Teaching Credentials -->
        <h5 class="section-title">Teaching Credentials</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>PRC License Number:</strong></label>
                    <input type="text" name="prc_license" value="{{ old('prc_license', $teacher->prc_license) }}"
                        class="form-control" required>
                    @error('prc_license')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>License Validity Date:</strong></label>
                    <input type="date" name="license_validity"
                        value="{{ old('license_validity', $teacher->license_validity) }}" class="form-control" required>
                    @error('license_validity')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>LET Passing Date:</strong></label>
                    <input type="date" name="let_date" value="{{ old('let_date', $teacher->let_date) }}"
                        class="form-control" required>
                    @error('let_date')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label><strong>Teaching Specialization/Track:</strong></label>
                    <select name="specialization" class="form-control" required>
                        <option value="Academic"
                            {{ old('specialization', $teacher->specialization) == 'Academic' ? 'selected' : '' }}>
                            Academic (STEM, ABM, HUMSS, GAS)</option>
                        <option value="TVL"
                            {{ old('specialization', $teacher->specialization) == 'TVL' ? 'selected' : '' }}>
                            Technical-Vocational-Livelihood (TVL)</option>
                        <option value="Sports"
                            {{ old('specialization', $teacher->specialization) == 'Sports' ? 'selected' : '' }}>Sports
                        </option>
                        <option value="Arts"
                            {{ old('specialization', $teacher->specialization) == 'Arts' ? 'selected' : '' }}>Arts and
                            Design</option>
                    </select>
                    @error('specialization')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label><strong>PRC License Copy:</strong></label>
                    <input type="file" name="prc_copy" class="form-control" accept=".pdf,.jpg,.png">
                    @if($teacher->prc_copy)
                    <small>Current file: <a href="{{ Storage::url($teacher->prc_copy) }}"
                            target="_blank">View</a></small>
                    @endif
                    @error('prc_copy')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Employment Details -->
        <h5 class="section-title">Employment Details</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Previous School:</strong></label>
                    <input type="text" name="previous_school"
                        value="{{ old('previous_school', $teacher->previous_school) }}" class="form-control">
                    @error('previous_school')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Previous Position:</strong></label>
                    <input type="text" name="position" value="{{ old('position', $teacher->position) }}"
                        class="form-control">
                    @error('position')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Years of Experience:</strong></label>
                    <input type="number" name="years_experience"
                        value="{{ old('years_experience', $teacher->years_experience) }}" class="form-control" min="0">
                    @error('years_experience')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Employment Status:</strong></label>
                    <select name="employment_status" class="form-control" required>
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
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Preferred Schedule:</strong></label>
                    <select name="teaching_schedule" class="form-control" required>
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
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Subjects Willing to Teach:</strong></label>
                    <input type="text" name="subjects" value="{{ old('subjects', $teacher->subjects) }}"
                        class="form-control" required>
                    @error('subjects')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <h5 class="section-title">Additional Information</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="p-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Certifications/Trainings:</strong></label>
                    <textarea name="certifications"
                        class="form-control">{{ old('certifications', $teacher->certifications) }}</textarea>
                    @error('certifications')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Medical Information:</strong></label>
                    <textarea name="medical_info"
                        class="form-control">{{ old('medical_info', $teacher->medical_info) }}</textarea>
                    @error('medical_info')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Special Accommodations:</strong></label>
                    <textarea name="accommodations"
                        class="form-control">{{ old('accommodations', $teacher->accommodations) }}</textarea>
                    @error('accommodations')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label><strong>Resume/CV:</strong></label>
                    <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
                    @if($teacher->resume)
                    <small>Current file: <a href="{{ Storage::url($teacher->resume) }}" target="_blank">View</a></small>
                    @endif
                    @error('resume')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label><strong>Transcript of Records:</strong></label>
                    <input type="file" name="transcript" class="form-control" accept=".pdf,.doc,.docx">
                    @if($teacher->transcript)
                    <small>Current file: <a href="{{ Storage::url($teacher->transcript) }}"
                            target="_blank">View</a></small>
                    @endif
                    @error('transcript')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Administrative Use -->
        <h5 class="section-title">Administrative Use</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label><strong>Date Hired:</strong></label>
                    <input type="date" name="date_hired" value="{{ old('date_hired', $teacher->date_hired) }}"
                        class="form-control" required>
                    @error('date_hired')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label><strong>Employee ID:</strong></label>
                    <input type="text" name="employee_id" value="{{ old('employee_id', $teacher->employee_id) }}"
                        class="form-control" required>
                    @error('employee_id')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-3 text-center">
            <button type="submit" class="btn btn-dark p-1"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
        </div>
    </form>
    @else
    <!-- Display Teacher Details -->
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Teacher Details</p>
    <hr>
    <div class="mb-3 mt-2 d-flex gap-2">
        <a href="{{ route('teachers.index') }}" class="p-1"><i class="fa-solid fa-house"></i> <span
                class="text-muted">Home</span></a>
        <a href="{{ route('teachers.edit', ['id' => $teacher->id, 'formtype' => 'teacheredit']) }}" class="p-1"><i
                class="fa-solid fa-pen-to-square"></i> <span class="text-muted">Edit</span></a>
    </div>

    @if (session('success'))
    <div class="alert alert-success p-1 mb-3">
        <i class="fa-solid fa-circle-check"></i>
        <strong>Success!</strong> {{ session('success') }}
    </div>
    @endif

    <!-- Personal Information -->
    <h5 class="section-title">Personal Information</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 text-center col-md-3">
                <div class="mb-3 profile-pic">
                    @if($teacher->profile_picture)
                    <img src="{{ Storage::url($teacher->profile_picture) }}" alt="Profile Picture"
                        class="img-fluid rounded-circle" style="max-width: 150px;">
                    @else
                    <i class="fas fa-user fa-3x"></i>
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="p-1 mb-3 col-md-4">
                        <strong>First Name:</strong> {{ $teacher->first_name }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Middle Name:</strong> {{ $teacher->middle_name ?? 'N/A' }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Last Name:</strong> {{ $teacher->last_name }}
                    </div>
                </div>
                <div class="row">
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Date of Birth:</strong> {{ $teacher->date_of_birth }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Gender:</strong> {{ $teacher->gender }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Age:</strong> {{ $teacher->age }}
                    </div>
                </div>
                <div class="row">
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Nationality:</strong> {{ $teacher->nationality }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Address:</strong> {{ $teacher->address }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Contact Number:</strong> {{ $teacher->contact_number }}
                    </div>
                </div>
                <div class="row">
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Email Address:</strong> {{ $teacher->email }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Educational Background -->
    <h5 class="section-title">Educational Background</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-3">
                <strong>Highest Degree:</strong> {{ $teacher->degree }}
            </div>
            <div class="p-1 mb-3 col-md-3">
                <strong>Major/Specialization:</strong> {{ $teacher->major }}
            </div>
            <div class="p-1 mb-3 col-md-3">
                <strong>University:</strong> {{ $teacher->university }}
            </div>
            <div class="p-1 mb-3 col-md-3">
                <strong>Year Graduated:</strong> {{ $teacher->year_graduated }}
            </div>
        </div>
    </div>

    <!-- Teaching Credentials -->
    <h5 class="section-title">Teaching Credentials</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-4">
                <strong>PRC License Number:</strong> {{ $teacher->prc_license }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>License Validity Date:</strong> {{ $teacher->license_validity }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>LET Passing Date:</strong> {{ $teacher->let_date }}
            </div>
        </div>
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-6">
                <strong>Teaching Specialization/Track:</strong> {{ $teacher->specialization }}
            </div>
            <div class="p-1 mb-3 col-md-6">
                <strong>PRC License Copy:</strong>
                @if($teacher->prc_copy)
                <a href="{{ Storage::url($teacher->prc_copy) }}" target="_blank">View</a>
                @else
                N/A
                @endif
            </div>
        </div>
    </div>

    <!-- Employment Details -->
    <h5 class="section-title">Employment Details</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-4">
                <strong>Previous School:</strong> {{ $teacher->previous_school ?? 'N/A' }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Previous Position:</strong> {{ $teacher->position ?? 'N/A' }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Years of Experience:</strong> {{ $teacher->years_experience ?? 'N/A' }}
            </div>
        </div>
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-4">
                <strong>Employment Status:</strong> {{ $teacher->employment_status }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Preferred Schedule:</strong> {{ $teacher->teaching_schedule }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Subjects Willing to Teach:</strong> {{ $teacher->subjects }}
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <h5 class="section-title">Additional Information</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="p-3 row">
            <div class="p-1 mb-3 col-md-4">
                <strong>Certifications/Trainings:</strong> {{ $teacher->certifications ?? 'N/A' }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Medical Information:</strong> {{ $teacher->medical_info ?? 'N/A' }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Special Accommodations:</strong> {{ $teacher->accommodations ?? 'N/A' }}
            </div>
        </div>
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-6">
                <strong>Resume/CV:</strong>
                @if($teacher->resume)
                <a href="{{ Storage::url($teacher->resume) }}" target="_blank">View</a>
                @else
                N/A
                @endif
            </div>
            <div class="p-1 mb-3 col-md-6">
                <strong>Transcript of Records:</strong>
                @if($teacher->transcript)
                <a href="{{ Storage::url($teacher->transcript) }}" target="_blank">View</a>
                @else
                N/A
                @endif
            </div>
        </div>
    </div>

    <!-- Administrative Use -->
    <h5 class="section-title">Administrative Use</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-6">
                <strong>Date Hired:</strong> {{ $teacher->date_hired }}
            </div>
            <div class="p-1 mb-3 col-md-6">
                <strong>Employee ID:</strong> {{ $teacher->employee_id }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection