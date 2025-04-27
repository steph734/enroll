@extends('layouts.app')
@section('title', 'edit-enrollment-form')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/enrollment.css') }}">
@endsection
@section('content')
<div>
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Edit Student Enrollment Form</p>
    <form method="POST" action="{{ route('student.update', $student->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Personal Information -->
        <h5 class="section-title">Personal Information</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 text-center col-md-3">
                    <div class="mb-3 profile-pic">
                        @if ($student->profile_picture)
                            <img src="{{ asset('storage/' . $student->profile_picture) }}" alt="Profile Picture" class="img-fluid" style="max-width: 100px;">
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
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $student->first_name) }}" required>
                            @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="middle_name" class="form-label">Middle Name (Optional)</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name', $student->middle_name) }}">
                            @error('middle_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}" required>
                            @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}" required>
                            @error('date_of_birth')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label class="form-label">Gender</label><br>
                            <div class="m-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="Male" {{ old('gender', $student->gender) == 'Male' ? 'checked' : '' }} required>
                                <label class="m-1 form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="Female" {{ old('gender', $student->gender) == 'Female' ? 'checked' : '' }}>
                                <label class="m-1 form-check-label" for="female">Female</label>
                            </div>
                            @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" min="1" value="{{ old('age', $student->age) }}" required>
                            @error('age')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality" value="{{ old('nationality', $student->nationality) }}" required>
                            @error('nationality')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="home_address" class="form-label">Home Address</label>
                            <input type="text" class="form-control" id="home_address" name="home_address" value="{{ old('home_address', $student->home_address) }}" required>
                            @error('home_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="zip_code" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code', $student->zip_code) }}" required>
                            @error('zip_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number', $student->contact_number) }}" required>
                            @error('contact_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="secondary_contact" class="form-label">Secondary Contact (Optional)</label>
                            <input type="text" class="form-control" id="secondary_contact" name="secondary_contact" value="{{ old('secondary_contact', $student->secondary_contact) }}">
                            @error('secondary_contact')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student->email) }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parent/Guardian Information -->
        <h5 class="section-title">Parent/Guardian Information</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name" value="{{ old('guardian_first_name', $student->guardian_first_name) }}" required>
                    @error('guardian_first_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_middle_name" class="form-label">Middle Name (Optional)</label>
                    <input type="text" class="form-control" id="guardian_middle_name" name="guardian_middle_name" value="{{ old('guardian_middle_name', $student->guardian_middle_name) }}">
                    @error('guardian_middle_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name" value="{{ old('guardian_last_name', $student->guardian_last_name) }}" required>
                    @error('guardian_last_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="relationship" class="form-label">Relationship</label>
                    <select class="form-select" id="relationship" name="relationship" required>
                        <option value="">Select</option>
                        <option value="Mother" {{ old('relationship', $student->relationship) == 'Mother' ? 'selected' : '' }}>Mother</option>
                        <option value="Father" {{ old('relationship', $student->relationship) == 'Father' ? 'selected' : '' }}>Father</option>
                        <option value="Guardian" {{ old('relationship', $student->relationship) == 'Guardian' ? 'selected' : '' }}>Guardian</option>
                        <option value="Other" {{ old('relationship', $student->relationship) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('relationship')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_contact" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="guardian_contact" name="guardian_contact" value="{{ old('guardian_contact', $student->guardian_contact) }}" required>
                    @error('guardian_contact')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="guardian_email" name="guardian_email" value="{{ old('guardian_email', $student->guardian_email) }}">
                    @error('guardian_email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Academic Background -->
        <h5 class="section-title">Academic Background</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="previous_school" class="form-label">Previous School Name</label>
                    <input type="text" class="form-control" id="previous_school" name="previous_school" value="{{ old('previous_school', $student->previous_school) }}" required>
                    @error('previous_school')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="grade_completed" class="form-label">Grade Level Completed</label>
                    <select class="form-select" id="grade_completed" name="grade_completed" required>
                        <option value="">Select</option>
                        <option value="Grade 1" {{ old('grade_completed', $student->grade_completed) == 'Grade 1' ? 'selected' : '' }}>Grade 1</option>
                        <option value="Grade 2" {{ old('grade_completed', $student->grade_completed) == 'Grade 2' ? 'selected' : '' }}>Grade 2</option>
                        <option value="Grade 3" {{ old('grade_completed', $student->grade_completed) == 'Grade 3' ? 'selected' : '' }}>Grade 3</option>
                        <option value="Grade 4" {{ old('grade_completed', $student->grade_completed) == 'Grade 4' ? 'selected' : '' }}>Grade 4</option>
                        <option value="Grade 5" {{ old('grade_completed', $student->grade_completed) == 'Grade 5' ? 'selected' : '' }}>Grade 5</option>
                        <option value="Grade 6" {{ old('grade_completed', $student->grade_completed) == 'Grade 6' ? 'selected' : '' }}>Grade 6</option>
                        <option value="Grade 7" {{ old('grade_completed', $student->grade_completed) == 'Grade 7' ? 'selected' : '' }}>Grade 7</option>
                        <option value="Grade 8" {{ old('grade_completed', $student->grade_completed) == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                        <option value="Grade 9" {{ old('grade_completed', $student->grade_completed) == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                        <option value="Grade 10" {{ old('grade_completed', $student->grade_completed) == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                    </select>
                    @error('grade_completed')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="school_year_completed" class="form-label">School Year Completed</label>
                    <input type="text" class="form-control" id="school_year_completed" name="school_year_completed" placeholder="e.g., 2023-2024" value="{{ old('school_year_completed', $student->school_year_completed) }}" required>
                    @error('school_year_completed')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="gpa" class="form-label">GPA (Optional)</label>
                    <input type="text" class="form-control" id="gpa" name="gpa" value="{{ old('gpa', $student->gpa) }}">
                    @error('gpa')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="transcript" class="form-label">Transcript/Report Card</label>
                    <input type="file" class="form-control" id="transcript" name="transcript" accept=".pdf,.doc,.docx">
                    @if ($student->transcript)
                        <small>Current file: {{ basename($student->transcript) }}</small>
                    @endif
                    @error('transcript')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Program Enrollment -->
        <h5 class="section-title">Program Enrollment</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label mb-1" for="track">Track</label>
                    <select class="form-select" name="track" id="track">
                        <option value="">Select a track</option>
                        @forelse(\App\Models\Strand::all() as $track)
                            <option value="{{ $track->track }}" {{ old('track', $student->track) == $track->track ? 'selected' : '' }}>
                                {{ $track->track }}
                            </option>
                        @empty
                            <option value="">No tracks available</option>
                        @endforelse
                    </select>
                    @error('track')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label" for="strand">Strand</label>
                    <select class="form-select" id="strand" name="strand">
                        @forelse(\App\Models\Strand::all() as $strand)
                            <option value="{{ $strand->strandname }}" {{ old('strand', $student->strand) == $strand->strandname ? 'selected' : '' }}>
                                {{ $strand->strandname }}
                            </option>
                        @empty
                            <option value="">No strands available</option>
                        @endforelse
                    </select>
                    @error('strand')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label" for="grade_level">Grade Level</label>
                    <select class="form-select" id="grade_level" name="grade_level" required>
                        <option value="">Select</option>
                        <option value="Grade 11" {{ old('grade_level', $student->grade_level) == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                        <option value="Grade 12" {{ old('grade_level', $student->grade_level) == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                    </select>
                    @error('grade_level')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label" for="class_schedule">Preferred Class Schedule</label>
                    <select class="form-select" id="class_schedule" name="class_schedule" required>
                        <option value="">Select</option>
                        <option value="Morning" {{ old('class_schedule', $student->class_schedule) == 'Morning' ? 'selected' : '' }}>Morning</option>
                        <option value="Afternoon" {{ old('class_schedule', $student->class_schedule) == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                        <option value="Evening" {{ old('class_schedule', $student->class_schedule) == 'Evening' ? 'selected' : '' }}>Evening</option>
                    </select>
                    @error('class_schedule')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="ongoing" {{ old('status', $student->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                        <option value="dropped" {{ old('status', $student->status) == 'dropped' ? 'selected' : '' }}>Dropped</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-9">
                    <label class="form-label" for="additional_notes">Additional Notes</label>
                    <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3">{{ old('additional_notes', $student->additional_notes) }}</textarea>
                    @error('additional_notes')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <h5 class="section-title">Additional Information</h5>
        <div class="mb-3 shadow card form-section">
            <div class="p-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="medical_info" class="form-label">Medical Information (e.g., Allergies)</label>
                    <textarea class="form-control" id="medical_info" name="medical_info" rows="3">{{ old('medical_info', $student->medical_info) }}</textarea>
                    @error('medical_info')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="special_accommodations" class="form-label">Special Accommodations</label>
                    <textarea class="form-control" id="special_accommodations" name="special_accommodations" rows="3">{{ old('special_accommodations', $student->special_accommodations) }}</textarea>
                    @error('special_accommodations')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="p-3 card">
            <div class="gap-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary btn-lg w-25">Update</button>
                <a href="{{ route('students.index') }}" class="btn btn-primary btn-lg w-25">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection