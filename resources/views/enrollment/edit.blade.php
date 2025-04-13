@extends('layouts.app')

@section('title', 'Edit Teacher\'s Form')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/teacher_form.css') }}">
@endsection

@section('content')
<div>
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Edit Teacher's Form</p>
  
    <form method="POST" action="{{ route('teachers.update', ['id' => $teacher->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Personal Information -->
        <h5 class="section-title">Personal Information</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 text-center col-md-3">
                    <div class="mb-3 profile-pic">
                        @if($teacher->profile_picture)
                            <img src="{{ asset('storage/' . $teacher->profile_picture) }}" alt="Profile Picture" class="img-fluid" style="max-width: 100px;">
                        @else
                            <i class="fas fa-user fa-3x"></i>
                        @endif
                    </div>
                    <input type="file" name="profile_picture" class="form-control" accept="image/*">
                    @error('profile_picture')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $teacher->first_name) }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="middle_name" class="form-label">Middle Name (Optional)</label>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name', $teacher->middle_name) }}">
                            @error('middle_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $teacher->last_name) }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $teacher->date_of_birth) }}" required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label class="form-label">Gender</label><br>
                            <div class="m-1 form-check form-check-inline">
                                <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="male" value="Male" {{ old('gender', $teacher->gender) == 'Male' ? 'checked' : '' }} required>
                                <label class="m-1 form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="female" value="Female" {{ old('gender', $teacher->gender) == 'Female' ? 'checked' : '' }}>
                                <label class="m-1 form-check-label" for="female">Female</label>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" min="1" value="{{ old('age', $teacher->age) }}" required>
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control @error('nationality') is-invalid @enderror" id="nationality" name="nationality" value="{{ old('nationality', $teacher->nationality) }}" required>
                            @error('nationality')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $teacher->address) }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number', $teacher->contact_number) }}" required>
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $teacher->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Educational Background -->
        <h5 class="section-title">Educational Background</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-3">
                    <label for="degree" class="form-label">Highest Degree</label>
                    <input type="text" class="form-control @error('degree') is-invalid @enderror" id="degree" name="degree" value="{{ old('degree', $teacher->degree) }}" required>
                    @error('degree')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="major" class="form-label">Major/Specialization</label>
                    <input type="text" class="form-control @error('major') is-invalid @enderror" id="major" name="major" value="{{ old('major', $teacher->major) }}" required>
                    @error('major')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="university" class="form-label">University</label>
                    <input type="text" class="form-control @error('university') is-invalid @enderror" id="university" name="university" value="{{ old('university', $teacher->university) }}" required>
                    @error('university')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="year_graduated" class="form-label">Year Graduated</label>
                    <input type="text" class="form-control @error('year_graduated') is-invalid @enderror" id="year_graduated" name="year_graduated" value="{{ old('year_graduated', $teacher->year_graduated) }}" required>
                    @error('year_graduated')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Teaching Credentials -->
        <h5 class="section-title">Teaching Credentials</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="prc_license" class="form-label">PRC License Number</label>
                    <input type="text" class="form-control @error('prc_license') is-invalid @enderror" id="prc_license" name="prc_license" value="{{ old('prc_license', $teacher->prc_license) }}" required>
                    @error('prc_license')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="license_validity" class="form-label">License Validity Date</label>
                    <input type="date" class="form-control @error('license_validity') is-invalid @enderror" id="license_validity" name="license_validity" value="{{ old('license_validity', $teacher->license_validity) }}" required>
                    @error('license_validity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="let_date" class="form-label">LET Passing Date</label>
                    <input type="date" class="form-control @error('let_date') is-invalid @enderror" id="let_date" name="let_date" value="{{ old('let_date', $teacher->let_date) }}" required>
                    @error('let_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="specialization" class="form-label">Teaching Specialization/Track</label>
                    <select class="form-select @error('specialization') is-invalid @enderror" id="specialization" name="specialization" required>
                        <option value="">Select</option>
                        <option value="Academic" {{ old('specialization', $teacher->specialization) == 'Academic' ? 'selected' : '' }}>Academic (STEM, ABM, HUMSS, GAS)</option>
                        <option value="TVL" {{ old('specialization', $teacher->specialization) == 'TVL' ? 'selected' : '' }}>Technical-Vocational-Livelihood (TVL)</option>
                        <option value="Sports" {{ old('specialization', $teacher->specialization) == 'Sports' ? 'selected' : '' }}>Sports</option>
                        <option value="Arts" {{ old('specialization', $teacher->specialization) == 'Arts' ? 'selected' : '' }}>Arts and Design</option>
                    </select>
                    @error('specialization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="prc_copy" class="form-label">PRC License Copy</label>
                    <input type="file" class="form-control @error('prc_copy') is-invalid @enderror" id="prc_copy" name="prc_copy" accept=".pdf,.jpg,.png">
                    @if($teacher->prc_copy)
                        <small>Current file: <a href="{{ asset('storage/' . $teacher->prc_copy) }}" target="_blank">View</a></small>
                    @endif
                    @error('prc_copy')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Employment Details -->
        <h5 class="section-title">Employment Details</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="previous_school" class="form-label">Previous School (Optional)</label>
                    <input type="text" class="form-control @error('previous_school') is-invalid @enderror" id="previous_school" name="previous_school" value="{{ old('previous_school', $teacher->previous_school) }}">
                    @error('previous_school')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="position" class="form-label">Previous Position (Optional)</label>
                    <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $teacher->position) }}">
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="years_experience" class="form-label">Years of Experience</label>
                    <input type="number" class="form-control @error('years_experience') is-invalid @enderror" id="years_experience" name="years_experience" min="0" value="{{ old('years_experience', $teacher->years_experience) }}">
                    @error('years_experience')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="employment_status" class="form-label">Employment Status</label>
                    <select class="form-select @error('employment_status') is-invalid @enderror" id="employment_status" name="employment_status" required>
                        <option value="">Select</option>
                        <option value="Full-time" {{ old('employment_status', $teacher->employment_status) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="Part-time" {{ old('employment_status', $teacher->employment_status) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                    </select>
                    @error('employment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="teaching_schedule" class="form-label">Preferred Schedule</label>
                    <select class="form-select @error('teaching_schedule') is-invalid @enderror" id="teaching_schedule" name="teaching_schedule" required>
                        <option value="">Select</option>
                        <option value="Morning" {{ old('teaching_schedule', $teacher->teaching_schedule) == 'Morning' ? 'selected' : '' }}>Morning</option>
                        <option value="Afternoon" {{ old('teaching_schedule', $teacher->teaching_schedule) == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                        <option value="Evening" {{ old('teaching_schedule', $teacher->teaching_schedule) == 'Evening' ? 'selected' : '' }}>Evening</option>
                    </select>
                    @error('teaching_schedule')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="subjects" class="form-label">Subjects Willing to Teach</label>
                    <input type="text" class="form-control @error('subjects') is-invalid @enderror" id="subjects" name="subjects" value="{{ old('subjects', $teacher->subjects) }}" required>
                    @error('subjects')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <h5 class="section-title">Additional Information</h5>
        <div class="mb-3 shadow card form-section">
            <div class="p-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="certifications" class="form-label">Certifications/Trainings</label>
                    <textarea class="form-control @error('certifications') is-invalid @enderror" id="certifications" name="certifications" rows="3">{{ old('certifications', $teacher->certifications) }}</textarea>
                    @error('certifications')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="medical_info" class="form-label">Medical Information</label>
                    <textarea class="form-control @error('medical_info') is-invalid @enderror" id="medical_info" name="medical_info" rows="3">{{ old('medical_info', $teacher->medical_info) }}</textarea>
                    @error('medical_info')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="accommodations" class="form-label">Special Accommodations</label>
                    <textarea class="form-control @error('accommodations') is-invalid @enderror" id="accommodations" name="accommodations" rows="3">{{ old('accommodations', $teacher->accommodations) }}</textarea>
                    @error('accommodations')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="resume" class="form-label">Resume/CV</label>
                    <input type="file" class="form-control @error('resume') is-invalid @enderror" id="resume" name="resume" accept=".pdf,.doc,.docx">
                    @if($teacher->resume)
                        <small>Current file: <a href="{{ asset('storage/' . $teacher->resume) }}" target="_blank">View</a></small>
                    @endif
                    @error('resume')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="transcript" class="form-label">Transcript of Records</label>
                    <input type="file" class="form-control @error('transcript') is-invalid @enderror" id="transcript" name="transcript" accept=".pdf,.doc,.docx">
                    @if($teacher->transcript)
                        <small>Current file: <a href="{{ asset('storage/' . $teacher->transcript) }}" target="_blank">View</a></small>
                    @endif
                    @error('transcript')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Administrative Use -->
        <h5 class="section-title">Administrative Use</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="date_hired" class="form-label">Date Hired</label>
                    <input type="date" class="form-control @error('date_hired') is-invalid @enderror" id="date_hired" name="date_hired" value="{{ old('date_hired', $teacher->date_hired) }}" required>
                    @error('date_hired')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="employee_id" class="form-label">Employee ID</label>
                    <input type="text" class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" value="{{ old('employee_id', $teacher->employee_id) }}" required>
                    @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="p-3 card">
            <div class="gap-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary btn-lg w-25">Update Teacher</button>
                <a href="{{ route('teachers.index') }}" class="btn btn-primary btn-lg w-25">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection