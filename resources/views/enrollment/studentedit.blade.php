@extends('layouts.app')

@section('title', 'Student Details')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/enrollment.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    a {
        text-decoration: none !important;
    }

    .tr-head {
        background-color: #e7f3fe;
        border-left: 4px solid #007bff;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    .note-div {
        background-color: #e7f3fe;
        border-left: 4px solid #007bff;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    .note-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .note-header h6 {
        margin: 0;
        color: #333;
        font-weight: bold;
    }

    .note-header .toggle-icon {
        font-size: 16px;
        color: #666;
        transition: transform 0.3s ease;
    }

    .note-header .toggle-icon.expanded {
        transform: rotate(180deg);
    }

    .note-details {
        display: none;
        margin-top: 10px;
        padding-left: 20px;
        color: #555;
    }

    .note-details.show {
        display: block;
    }

    .note-details ul {
        margin: 0;
        padding-left: 20px;
    }

    .note-details ul li {
        margin-bottom: 5px;
    }

    .note-details ul ul {
        padding-left: 20px;
        list-style-type: circle;
    }
</style>
@endsection

@section('content')
<div class="container">
    @if($formtype === 'studentedit')
    <!-- Edit Form -->
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Edit Student</p>
    <hr>
    <div class="mb-3 mt-2 d-flex gap-2">
        <a href="{{ route('enrollment.show', 'students') }}" class="p-1"><i class="fa-solid fa-house"></i>
            <span class="text-muted">Home</span>
        </a>
        <a href="{{ route('student.edit', [$student->id, 'formtype' => 'view']) }}" class="p-1"><i
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
                    </div>
                    <input type="file" name="profile_picture" class="form-control mt-2">
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>First Name:</strong></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}"
                                class="form-control" required>
                            @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Middle Name:</strong></label>
                            <input type="text" name="middle_name"
                                value="{{ old('middle_name', $student->middle_name) }}" class="form-control">
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Last Name:</strong></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}"
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
                                value="{{ old('date_of_birth', $student->date_of_birth) }}" class="form-control"
                                required>
                            @error('date_of_birth')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Gender:</strong></label>
                            <select name="gender" class="form-control" required>
                                <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>
                                    Male</option>
                                <option value="Female"
                                    {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other"
                                    {{ old('gender', $student->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Age:</strong></label>
                            <input type="number" name="age" value="{{ old('age', $student->age) }}" class="form-control"
                                required>
                            @error('age')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Nationality:</strong></label>
                            <input type="text" name="nationality"
                                value="{{ old('nationality', $student->nationality) }}" class="form-control" required>
                            @error('nationality')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Home Address:</strong></label>
                            <input type="text" name="home_address"
                                value="{{ old('home_address', $student->home_address) }}" class="form-control" required>
                            @error('home_address')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Zip Code:</strong></label>
                            <input type="text" name="zip_code" value="{{ old('zip_code', $student->zip_code) }}"
                                class="form-control" required>
                            @error('zip_code')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Contact Number:</strong></label>
                            <input type="text" name="contact_number"
                                value="{{ old('contact_number', $student->contact_number) }}" class="form-control"
                                required>
                            @error('contact_number')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Secondary Contact:</strong></label>
                            <input type="text" name="secondary_contact"
                                value="{{ old('secondary_contact', $student->secondary_contact) }}"
                                class="form-control">
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label><strong>Email Address:</strong></label>
                            <input type="email" name="email" value="{{ old('email', $student->email) }}"
                                class="form-control" required>
                            @error('email')
                            <div class="text-danger">{{$message }}</div>
                            @enderror
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
                    <label><strong>First Name:</strong></label>
                    <input type="text" name="guardian_first_name"
                        value="{{ old('guardian_first_name', $student->guardian_first_name) }}" class="form-control"
                        required>
                    @error('guardian_first_name')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Middle Name:</strong></label>
                    <input type="text" name="guardian_middle_name"
                        value="{{ old('guardian_middle_name', $student->guardian_middle_name) }}" class="form-control">
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Last Name:</strong></label>
                    <input type="text" name="guardian_last_name"
                        value="{{ old('guardian_last_name', $student->guardian_last_name) }}" class="form-control"
                        required>
                    @error('guardian_last_name')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Relationship:</strong></label>
                    <select name="relationship" class="form-control" required>
                        <option value="Mother"
                            {{ old('relationship', $student->relationship) === 'Mother' ? 'selected' : '' }}>Mother
                        </option>
                        <option value="Father"
                            {{ old('relationship', $student->relationship) === 'Father' ? 'selected' : '' }}>Father
                        </option>
                        <option value="Guardian"
                            {{ old('relationship', $student->relationship) === 'Guardian' ? 'selected' : '' }}>Guardian
                        </option>
                        <option value="Other"
                            {{ old('relationship', $student->relationship) === 'Other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    @error('relationship')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Contact Number:</strong></label>
                    <input type="text" name="guardian_contact"
                        value="{{ old('guardian_contact', $student->guardian_contact) }}" class="form-control" required>
                    @error('guardian_contact')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Email Address:</strong></label>
                    <input type="email" name="guardian_email"
                        value="{{ old('guardian_email', $student->guardian_email) }}" class="form-control">
                    @error('guardian_email')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Academic Background -->
        <h5 class="section-title">Academic Background</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label><strong>Previous School Name:</strong></label>
                    <input type="text" name="previous_school"
                        value="{{ old('previous_school', $student->previous_school) }}" class="form-control" required>
                    @error('previous_school')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Grade Level Completed:</strong></label>
                    <select name="grade_completed" class="form-control" required>
                        @foreach(['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade
                        8', 'Grade 9', 'Grade 10'] as $grade)
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
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>School Year Completed:</strong></label>
                    <input type="text" name="school_year_completed"
                        value="{{ old('school_year_completed', $student->school_year_completed) }}" class="form-control"
                        required>
                    @error('school_year_completed')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label><strong>GPA:</strong></label>
                    <input type="text" name="gpa" value="{{ old('gpa', $student->gpa) }}" class="form-control">
                    @error('gpa')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Program Enrollment -->
        <h5 class="section-title">Program Enrollment</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Track:</strong></label>
                    <select name="track_id" class="form-control" required>
                        @foreach($tracks as $track)
                        <option value="{{ $track->id }}"
                            {{ old('track_id', $student->track_id) == $track->id ? 'selected' : '' }}>
                            {{ $track->track_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('track_id')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Strand:</strong></label>
                    <select name="strand_id" class="form-control" required>
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
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Grade Level:</strong></label>
                    <select name="grade_level" class="form-control" required>
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
                <div class="p-1 mb-3 col-md-3">
                    <label><strong>Class Schedule:</strong></label>
                    <select name="class_schedule" class="form-control" required>
                        <option value="Morning"
                            {{ old('class_schedule', $student->class_schedule) === 'Morning' ? 'selected' : '' }}>
                            Morning</option>
                        <option value="Afternoon"
                            {{ old('class_schedule', $student->class_schedule) === 'Afternoon' ? 'selected' : '' }}>
                            Afternoon</option>
                        <option value="Evening"
                            {{ old('class_schedule', $student->class_schedule) === 'Evening' ? 'selected' : '' }}>
                            Evening</option>
                    </select>
                    @error('class_schedule')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-12">
                    <label><strong>Additional Notes:</strong></label>
                    <textarea name="additional_notes"
                        class="form-control">{{ old('additional_notes', $student->additional_notes) }}</textarea>
                    @error('additional_notes')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <h5 class="section-title">Additional Information</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="p-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label><strong>Medical Information:</strong></label>
                    <textarea name="medical_info"
                        class="form-control">{{ old('medical_info', $student->medical_info) }}</textarea>
                    @error('medical_info')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label><strong>Special Accommodations:</strong></label>
                    <textarea name="special_accommodations"
                        class="form-control">{{ old('special_accommodations', $student->special_accommodations) }}</textarea>
                    @error('special_accommodations')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <h5 class="section-title">Payment Information</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Payment Date:</strong></label>
                    <input type="date" name="payment_date" value="{{ old('payment_date', $student->payment_date) }}"
                        class="form-control" required>
                    @error('payment_date')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Downpayment:</strong></label>
                    <input type="number" name="downpayment" value="{{ old('downpayment', $student->downpayment) }}"
                        class="form-control" required>
                    @error('downpayment')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Payment Method:</strong></label>
                    <select name="payment_method" class="form-control" required>
                        <option value="Cash"
                            {{ old('payment_method', $student->payment_method) === 'Cash' ? 'selected' : '' }}>Cash
                        </option>
                        <option value="Credit Card"
                            {{ old('payment_method', $student->payment_method) === 'Credit Card' ? 'selected' : '' }}>
                            Credit Card</option>
                        <option value="Bank Transfer"
                            {{ old('payment_method', $student->payment_method) === 'Bank Transfer' ? 'selected' : '' }}>
                            Bank Transfer</option>
                        <option value="Online Payment"
                            {{ old('payment_method', $student->payment_method) === 'Online Payment' ? 'selected' : '' }}>
                            Online Payment</option>
                    </select>
                    @error('payment_method')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Balance:</strong></label>
                    <input type="number" name="balance" value="{{ old('balance', $student->balance) }}"
                        class="form-control" required>
                    @error('balance')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Receipt Number:</strong></label>
                    <input type="text" name="receiptnumber" value="{{ old('receiptnumber', $student->receiptnumber) }}"
                        class="form-control" required>
                    @error('receiptnumber')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Student ID:</strong></label>
                    <input type="number" name="studentid" value="{{ old('studentid', $student->studentid) }}"
                        class="form-control" required>
                    @error('studentid')
                    <div class="text-danger">{{$message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Student Status -->
        <h5 class="section-title">Student Status</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label><strong>Status:</strong></label>
                    <select name="status" class="form-control" required>
                        <option value="ongoing" {{ old('status', $student->status) === 'ongoing' ? 'selected' : '' }}>
                            Ongoing</option>
                        <option value="graduated"
                            {{ old('status', $student->status) === 'graduated' ? 'selected' : '' }}>Graduated</option>
                        <option value="dropped" {{ old('status', $student->status) === 'dropped' ? 'selected' : '' }}>
                            Dropped</option>
                    </select>
                    @error('status')
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
    <!-- Display Student Details (Original View) -->
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Student Details</p>
    <hr>
    <div class="mb-3 mt-2 d-flex gap-2">
        <a href="{{ route('enrollment.show', 'students') }}" class="p-1"><i class="fa-solid fa-house"></i> <span
                class="text-muted">Home</span></a>
        <a href="{{ route('student.edit', ['id' => $student->id, 'formtype' => 'studentedit']) }}" class="p-1"><i
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

    <!-- Student Status -->
    <h5 class="section-title">Student Status</h5>
    <div class="mb-3 shadow-sm card form-section">
        <div class="m-3 row">
            <div class="p-1 mb-3 col-md-4">
                <strong>Status:</strong> {{ $student->status ?? 'N/A' }}
            </div>
        </div>
    </div>


    <!-- Enrolled Subjects Note -->
    <div class="note-div" id="enrolledSubjectsNote">
        <div class="note-header">
            <h6 style="color: #007bff;">Enrolled Subjects Table</h6>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover mb-0 rounded-2">
                <thead>
                    <tr>
                        <th class="border-top-0 border-left border-bottom-0 text-nowrap">Title</th>
                        <th class="border-top-0 border-left border-bottom-0 text-nowrap">Term</th>
                        <th class="border-top-0 border-left border-bottom-0 text-nowrap">Description</th>
                        <th class="border-top-0 border-left border-bottom-0 text-nowrap">Status</th>
                        <th class="border-top-0 border-left border-bottom-0 text-nowrap pr-md-4">
                            Prerequisites/Co-requisites</th>
                        <th class="border-top-0 border-left border-bottom-0 text-nowrap pr-md-4">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    // Define the sections to display
                    $sections = [
                    ['grade' => 'Grade 11', 'semester' => '1st Sem'],
                    ['grade' => 'Grade 11', 'semester' => '2nd Sem'],
                    ['grade' => 'Grade 12', 'semester' => '1st Sem'],
                    ['grade' => 'Grade 12', 'semester' => '2nd Sem'],
                    ];

                    // Map term values to semesters
                    $termToSemester = [
                    '1st Term' => '1st Sem',
                    '2nd Term' => '1st Sem',
                    '3rd Term' => '2nd Sem',
                    '4th Term' => '2nd Sem',

                    ];

                    // Group subjects by grade and term
                    $groupedSubjects = $student->studentSubject->groupBy(function ($studentSubject) use
                    ($termToSemester) {
                    $term = $studentSubject->subject->term ?? $studentSubject->subject->semester ?? '1st Sem';
                    $semester = $termToSemester[$term] ?? $term;
                    return ($studentSubject->subject->grade_level ?? 'Grade 11') . '|' . $semester;
                    });
                    @endphp

                    @foreach ($sections as $section)
                    <tr class="fw-bold text-danger tr-head">
                        <td colspan="6" class="px-md-4 text-primary">{{ $section['grade'] }} /
                            {{ $section['semester'] }}
                        </td>
                    </tr>
                    @php
                    $sectionKey = $section['grade'] . '|' . $section['semester'];
                    $subjects = $groupedSubjects->get($sectionKey, collect([]));
                    @endphp
                    @if ($subjects->isEmpty())
                    <tr>
                        <td colspan="6" class="border-left text-center">No subjects enrolled</td>
                    </tr>
                    @else
                    @foreach ($subjects as $studentSubject)
                    <tr>
                        <td class="border-left">{{ $studentSubject->subject->subject_code ?? 'N/A' }}</td>
                        <td class="border-left">
                            {{ $studentSubject->subject->term ?? $studentSubject->subject->semester ?? 'N/A' }}
                        </td>
                        <td class="border-left">{{ $studentSubject->subject->subject_name ?? 'N/A' }}</td>
                        <td class="border-left">{{ $studentSubject->status ?? 'N/A' }}</td>
                        <td class="border-left pr-md-4">{{ $studentSubject->subject->prerequisites ?? '' }}</td>
                        <td>
                            <a href=""><i class="fa-solid fa-angle-right"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
</script>
@endsection