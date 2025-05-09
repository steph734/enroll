@extends('layouts.app')

@section('title', 'Student Details')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/enrollment.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    @if(isset($formType) && $formType === 'studentedit')
    <!-- Edit Form -->
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Edit Student</p>
    <hr>
    <div class="mb-3">
        <a href="{{ route('students.index') }}" class="btn btn-primary">Back to Students List</a>
    </div>

    <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Personal Information -->
        <h5 class="section-title">Personal Information</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 text-center col-md-3">
                    <div class="mb-3 profile-pic">
                        @if($student->profile_picture)
                        <img src="{{ Storage::url($student->profile_picture) }}" alt="Profile Picture"
                            class="img-fluid rounded-circle" style="max-width: 150px;">
                        @endif
                        <input type="file" name="profile_picture" class="form-control mt-2">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>First Name:</strong></label>
                            <input type="text" name="first_name" value="{{ $student->first_name }}" class="form-control"
                                required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Middle Name:</strong></label>
                            <input type="text" name="middle_name" value="{{ $student->middle_name }}"
                                class="form-control">
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Last Name:</strong></label>
                            <input type="text" name="last_name" value="{{ $student->last_name }}" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Date of Birth:</strong></label>
                            <input type="date" name="date_of_birth" value="{{ $student->date_of_birth }}"
                                class="form-control" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Gender:</strong></label>
                            <select name="gender" class="form-control" required>
                                <option value="Male" {{ $student->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $student->gender === 'Female' ? 'selected' : '' }}>Female
                                </option>
                                <option value="Other" {{ $student->gender === 'Other' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Age:</strong></label>
                            <input type="number" name="age" value="{{ $student->age }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Nationality:</strong></label>
                            <input type="text" name="nationality" value="{{ $student->nationality }}"
                                class="form-control" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Home Address:</strong></label>
                            <input type="text" name="home_address" value="{{ $student->home_address }}"
                                class="form-control" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Zip Code:</strong></label>
                            <input type="text" name="zip_code" value="{{ $student->zip_code }}" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Contact Number:</strong></label>
                            <input type="text" name="contact_number" value="{{ $student->contact_number }}"
                                class="form-control" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Secondary Contact:</strong></label>
                            <input type="text" name="secondary_contact" value="{{ $student->secondary_contact }}"
                                class="form-control">
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Email Address:</strong></label>
                            <input type="email" name="email" value="{{ $student->email }}" class="form-control"
                                required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Program Enrollment (Example: Track Selection) -->
        <h5 class="section-title">Program Enrollment</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Track:</strong></label>
                    <select name="track_id" class="form-control" required>
                        @foreach($tracks as $track)
                        <option value="{{ $track->id }}" {{ $student->track_id == $track->id ? 'selected' : '' }}>
                            {{ $track->track_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Grade Level:</strong></label>
                    <input type="text" name="grade_level" value="{{ $student->grade_level }}" class="form-control"
                        required>
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Class Schedule:</strong></label>
                    <input type="text" name="class_schedule" value="{{ $student->class_schedule }}" class="form-control"
                        required>
                </div>
            </div>
        </div>

        <div class="mt-3 text-center">
            <button type="submit" class="btn btn-primary">Update Student</button>
        </div>
    </form>
    @else
    <!-- Display Student Details (Original View) -->
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Student Details</p>
    <hr>
    <div class="mb-3 mt-2">
        <a href="{{ route('student.index') }}" class="btn btn-primary p-1"><i class="fa-solid fa-rotate-left"></i> Back
        </a>
    </div>

    <!-- Personal Information -->
    <h5 class="section-title">Personal Information</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 text-center col-md-3">
                <div class="mb-3 profile-pic">
                    @if($student->profile_picture)
                    <img src="{{ Storage::url($student->profile_picture) }}" alt="Profile Picture"
                        class="img-fluid rounded-circle" style="max-width: 150px;">
                    @else
                    <i class="fas fa-user fa-3x"></i>
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="p-1 mb-3 col-md-4">
                        <strong>First Name:</strong> {{ $student->first_name }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Middle Name:</strong> {{ $student->middle_name ?? 'N/A' }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Last Name:</strong> {{ $student->last_name }}
                    </div>
                </div>
                <div class="row">
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Date of Birth:</strong> {{ $student->date_of_birth }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Gender:</strong> {{ $student->gender }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Age:</strong> {{ $student->age }}
                    </div>
                </div>
                <div class="row">
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Nationality:</strong> {{ $student->nationality }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Home Address:</strong> {{ $student->home_address }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Zip Code:</strong> {{ $student->zip_code }}
                    </div>
                </div>
                <div class="row">
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Contact Number:</strong> {{ $student->contact_number }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Secondary Contact:</strong> {{ $student->secondary_contact ?? 'N/A' }}
                    </div>
                    <div class="p-1 mb-3 col-md-4">
                        <strong>Email Address:</strong> {{ $student->email }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Parent/Guardian Information -->
    <h5 class="section-title">Parent/Guardian Information</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-4">
                <strong>First Name:</strong> {{ $student->guardian_first_name }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Middle Name:</strong> {{ $student->guardian_middle_name ?? 'N/A' }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Last Name:</strong> {{ $student->guardian_last_name }}
            </div>
        </div>
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-4">
                <strong>Relationship:</strong> {{ $student->relationship }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Contact Number:</strong> {{ $student->guardian_contact }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Email Address:</strong> {{ $student->guardian_email ?? 'N/A' }}
            </div>
        </div>
    </div>

    <!-- Academic Background -->
    <h5 class="section-title">Academic Background</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-6">
                <strong>Previous School Name:</strong> {{ $student->previous_school }}
            </div>
            <div class="p-1 mb-3 col-md-3">
                <strong>Grade Level Completed:</strong> {{ $student->grade_completed }}
            </div>
            <div class="p-1 mb-3 col-md-3">
                <strong>School Year Completed:</strong> {{ $student->school_year_completed }}
            </div>
        </div>
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-6">
                <strong>GPA:</strong> {{ $student->gpa ?? 'N/A' }}
            </div>
        </div>
    </div>

    <!-- Program Enrollment -->
    <h5 class="section-title">Program Enrollment</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-3">
                <strong>Track:</strong> {{ $student->track->track_name ?? 'N/A' }}
            </div>
            <div class="p-1 mb-3 col-md-3">
                <strong>Strand:</strong> {{ $student->strand->strand_name ?? 'N/A' }}
            </div>
            <div class="p-1 mb-3 col-md-3">
                <strong>Grade Level:</strong> {{ $student->grade_level }}
            </div>
            <div class="p-1 mb-3 col-md-3">
                <strong>Class Schedule:</strong> {{ $student->class_schedule }}
            </div>
        </div>
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-12">
                <strong>Additional Notes:</strong> {{ $student->additional_notes ?? 'N/A' }}
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <h5 class="section-title">Additional Information</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="p-3 row">
            <div class="p-1 mb-3 col-md-6">
                <strong>Medical Information:</strong> {{ $student->medical_info ?? 'N/A' }}
            </div>
            <div class="p-1 mb-3 col-md-6">
                <strong>Special Accommodations:</strong> {{ $student->special_accommodations ?? 'N/A' }}
            </div>
        </div>
    </div>

    <!-- Payment Information -->
    <h5 class="section-title">Payment Information</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-4">
                <strong>Payment Date:</strong> {{ $student->payment_date }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Downpayment:</strong> {{ $student->downpayment }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Payment Method:</strong> {{ $student->payment_method }}
            </div>
        </div>
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-4">
                <strong>Balance:</strong> {{ $student->balance }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Receipt Number:</strong> {{ $student->receiptnumber }}
            </div>
            <div class="p-1 mb-3 col-md-4">
                <strong>Student ID:</strong> {{ $student->studentid }}
            </div>
        </div>
    </div>

    <!-- Status -->
    <h5 class="section-title">Student Status</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-4">
                <strong>Status:</strong> {{ $student->status ?? 'N/A' }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection