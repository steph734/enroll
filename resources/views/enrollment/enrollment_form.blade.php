@extends('layouts.app')
@section('title','enrollment-form')
@section('styles')
<link rel="stylesheet" href="{{asset('css/enrollment.css')}}">
@endsection
@section('content')
<div>
    <p class="mb-4 text-center h4 " style="color: var(--text-clr) !important;">Student Enrollment Form</p>
    <form method="POST" action="{{ route('student.store') }}" enctype="multipart/form-data">
        @csrf
        <!-- Personal Information -->
        <h5 class="section-title">Personal Information</h5>
        <div class="mb-3 shadow card form-section">

            <div class="m-3 row ">
                <div class="p-1 text-center col-md-3">
                    <div class="mb-3 profile-pic">
                        <i class="fas fa-user fa-3x"></i>
                    </div>
                    <input type="file" name="profile_picture" class="form-control" accept="image/*">
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="middle_name" class="form-label">Middle Name (Optional)</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label class="form-label">Gender</label><br>
                            <div class="m-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="Male"
                                    required>
                                <label class="m-1 form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
                                <label class="m-1 form-check-label" for="female">Female</label>
                            </div>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" m in="1" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="home_address" class="form-label">Home Address</label>
                            <input type="text" class="form-control" id="home_address" name="home_address" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="zip_code" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="secondary_contact" class="form-label">Secondary Contact (Optional)</label>
                            <input type="text" class="form-control" id="secondary_contact" name="secondary_contact">
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
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
                    <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name"
                        required>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_middle_name" class="form-label">Middle Name (Optional)</label>
                    <input type="text" class="form-control" id="guardian_middle_name" name="guardian_middle_name">
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name" required>
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="relationship" class="form-label">Relationship</label>
                    <select class="form-select" id="relationship" name="relationship" required>
                        <option value="">Select</option>
                        <option value="Mother">Mother</option>
                        <option value="Father">Father</option>
                        <option value="Guardian">Guardian</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_contact" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="guardian_contact" name="guardian_contact" required>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="guardian_email" name="guardian_email">
                </div>
            </div>
        </div>

        <!-- Academic Background -->
        <h5 class="section-title">Academic Background</h5>
        <div class="mb-3 shadow card form-section">

            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="previous_school" class="form-label">Previous School Name</label>
                    <input type="text" class="form-control" id="previous_school" name="previous_school" required>
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="grade_completed" class="form-label">Grade Level Completed</label>
                    <select class="form-select" id="grade_completed" name="grade_completed" required>
                        <option value="">Select</option>
                        <option value="Grade 1">Grade 1</option>
                        <option value="Grade 2">Grade 2</option>
                        <option value="Grade 3">Grade 3</option>
                        <option value="Grade 4">Grade 4</option>
                        <option value="Grade 5">Grade 5</option>
                        <option value="Grade 6">Grade 6</option>
                        <option value="Grade 7">Grade 7</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
                    </select>
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="school_year_completed" class="form-label">School Year Completed</label>
                    <input type="text" class="form-control" id="school_year_completed" name="school_year_completed"
                        placeholder="e.g., 2023-2024" required>
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="gpa" class="form-label">GPA (Optional)</label>
                    <input type="text" class="form-control" id="gpa" name="gpa">
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="transcript" class="form-label">Transcript/Report Card</label>
                    <input type="file" class="form-control" id="transcript" name="transcript" accept=".pdf,.doc,.docx"
                        required>
                </div>
            </div>
        </div>
        <!-- Program Enrollment -->
        <h5 class="section-title">Program Enrollment</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label mb-1" for="track">Track</label>
                    <select class="form-select" name="track" id="track" onchange="loadStrands()">
                        <option value="">Select a track</option>
                        @foreach(\App\Models\Track::all() as $track)
                        <option value="{{ $track->id }}" {{ old('track') == $track->id ? 'selected' : '' }}>
                            {{ $track->trackname }}
                        </option>
                        @endforeach
                    </select>
                    @error('track')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label" for="strand">Strand</label>
                    <select class="form-select" id="strand" name="strand">
                        <option value="">Select a strand</option>
                        @if(old('track'))
                        @foreach(\App\Models\Strand::where('track_id', old('track'))->get() as $strand)
                        <option value="{{ $strand->strandname }}"
                            {{ old('strand') == $strand->strandname ? 'selected' : '' }}>
                            {{ $strand->strandname }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                    @error('strand')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label" for="grade_level">Grade Level</label>
                    <select class="form-select" id="grade_level" name="grade_level" required>
                        <option value="">Select</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>
                    @error('grade_level')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label" for="class_schedule">Preferred Class Schedule</label>
                    <select class="form-select" id="class_schedule" name="class_schedule" required>
                        <option value="">Select</option>
                        <option value="Morning">Morning</option>
                        <option value="Afternoon">Afternoon</option>
                        <option value="Evening">Evening</option>
                    </select>
                    @error('class_schedule')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-12">
                    <label class="form-label" for="additional_notes">Additional Notes</label>
                    <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3"></textarea>
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
                    <textarea class="form-control" id="medical_info" name="medical_info" rows="3"></textarea>
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="special_accommodations" class="form-label">Special Accommodations</label>
                    <textarea class="form-control" id="special_accommodations" name="special_accommodations"
                        rows="3"></textarea>
                </div>
            </div>
        </div>
        <!-- Payment Information -->
        <h5 class="section-title">Payment Information</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="downpayment" class="form-label">Downpayment</label>
                    <input type="number" class="form-control" id="downpayment" name="downpayment" min="0" step="0.01"
                        required>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="">Select</option>
                        <option value="Cash">Cash</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Online Payment">Online Payment</option>
                    </select>
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="balance" class="form-label">Balance</label>
                    <input type="number" class="form-control" id="balance" name="balance" value="30000" readonly
                        required>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="receiptnumber" class="form-label">Receipt Number</label>
                    <input type="text" class="form-control" id="receiptnumber" name="receiptnumber" readonly required>
                </div>
            </div>
        </div>

        <div class="p-1 mb-3 col-md-4">
            <label for="studentid" class="form-label">StudentID</label>
            <input type="text" class="form-control" id="studentid" name="studentid" value="{{ $studentid ?? '' }}"
                readonly required>
        </div>
        <!-- Submit Button -->
        <div class="p-3 card">
            <div class="gap-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary btn-lg w-25">Enroll</button>
                <a href="{{ route('students.index') }}" class="btn btn-primary btn-lg w-25">Cancel</a>

            </div>
        </div>
    </form>
</div>
@endsection
<<script>
    // Function to generate a 6-digit student ID
    function generateStudentID() {
    return Math.floor(100000 + Math.random() * 900000); // Generates number between 100000 and 999999
    }

    // Set the student ID value when the page loads
    document.addEventListener('DOMContentLoaded', () => {
    const studentIDField = document.getElementById('studentid');
    if (!studentIDField.value) { // Only set if the field is empty
    studentIDField.value = generateStudentID();
    }
    });

    // Generate a random 6-digit number (e.g., 100000 to 999999)
    function generateReceiptNumber() {
    return Math.floor(100000 + Math.random() * 900000);
    }

    // Set the receipt number when the page loads
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('receiptnumber').value = generateReceiptNumber();
    });
    </script>