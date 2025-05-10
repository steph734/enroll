@extends('layouts.app')

@section('title', 'Enrollment Form')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/enrollment.css') }}">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Student Enrollment Form</p>
    <hr>
    <form method="POST" action="{{ route('student.store') }}" enctype="multipart/form-data" class="mt-3">
        @csrf

        <!-- Personal Information -->
        <h5 class="section-title">Personal Information</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 text-center col-md-3">
                    <div class="mb-3 profile-pic">
                        <i class="fas fa-user fa-3x"></i>
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
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                value="{{ old('first_name') }}" required>
                            @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="middle_name" class="form-label">Middle Name (Optional)</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name"
                                value="{{ old('middle_name') }}">
                            @error('middle_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                value="{{ old('last_name') }}" required>
                            @error('last_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                value="{{ old('date_of_birth') }}" required>
                            @error('date_of_birth')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label class="form-label">Gender</label><br>
                            <div class="m-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="Male"
                                    {{ old('gender') == 'Male' ? 'checked' : '' }} required>
                                <label class="m-1 form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="Female"
                                    {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                <label class="m-1 form-check-label" for="female">Female</label>
                            </div>
                            @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" min="1"
                                value="{{ old('age') }}" required>
                            @error('age')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality"
                                value="{{ old('nationality') }}" required>
                            @error('nationality')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="home_address" class="form-label">Home Address</label>
                            <input type="text" class="form-control" id="home_address" name="home_address"
                                value="{{ old('home_address') }}" required>
                            @error('home_address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="zip_code" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code"
                                value="{{ old('zip_code') }}" required>
                            @error('zip_code')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number"
                                value="{{ old('contact_number') }}" required>
                            @error('contact_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="secondary_contact" class="form-label">Secondary Contact (Optional)</label>
                            <input type="text" class="form-control" id="secondary_contact" name="secondary_contact"
                                value="{{ old('secondary_contact') }}">
                            @error('secondary_contact')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                required>
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
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name"
                        value="{{ old('guardian_first_name') }}" required>
                    @error('guardian_first_name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_middle_name" class="form-label">Middle Name (Optional)</label>
                    <input type="text" class="form-control" id="guardian_middle_name" name="guardian_middle_name"
                        value="{{ old('guardian_middle_name') }}">
                    @error('guardian_middle_name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name"
                        value="{{ old('guardian_last_name') }}" required>
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
                        <option value="Mother" {{ old('relationship') == 'Mother' ? 'selected' : '' }}>Mother</option>
                        <option value="Father" {{ old('relationship') == 'Father' ? 'selected' : '' }}>Father</option>
                        <option value="Guardian" {{ old('relationship') == 'Guardian' ? 'selected' : '' }}>Guardian
                        </option>
                        <option value="Other" {{ old('relationship') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('relationship')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_contact" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="guardian_contact" name="guardian_contact"
                        value="{{ old('guardian_contact') }}" required>
                    @error('guardian_contact')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="guardian_email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="guardian_email" name="guardian_email"
                        value="{{ old('guardian_email') }}">
                    @error('guardian_email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Academic Background -->
        <h5 class="section-title">Academic Background</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="previous_school" class="form-label">Previous School Name</label>
                    <input type="text" class="form-control" id="previous_school" name="previous_school"
                        value="{{ old('previous_school') }}" required>
                    @error('previous_school')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="grade_completed" class="form-label">Grade Level Completed</label>
                    <select class="form-select" id="grade_completed" name="grade_completed" required>
                        <option value="">Select</option>
                        @foreach (['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade
                        8', 'Grade 9', 'Grade 10'] as $grade)
                        <option value="{{ $grade }}" {{ old('grade_completed') == $grade ? 'selected' : '' }}>
                            {{ $grade }}
                        </option>
                        @endforeach
                    </select>
                    @error('grade_completed')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="school_year_completed" class="form-label">School Year Completed</label>
                    <input type="text" class="form-control" id="school_year_completed" name="school_year_completed"
                        placeholder="e.g., 2023-2024" value="{{ old('school_year_completed') }}" required>
                    @error('school_year_completed')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="gpa" class="form-label">GPA (Optional)</label>
                    <input type="text" class="form-control" id="gpa" name="gpa" value="{{ old('gpa') }}">
                    @error('gpa')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="transcript" class="form-label">Transcript/Report Card</label>
                    <input type="file" class="form-control" id="transcript" name="transcript" accept=".pdf,.doc,.docx"
                        required>
                    @error('transcript')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Program Enrollment -->
        <h5 class="section-title">Program Enrollment</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-3">
                    <label class="mb-1 form-label" for="track">Track</label>
                    <select class="form-select" name="track_id" id="track" onchange="loadStrands()" required>
                        <option value="">Select a track</option>
                        @if($tracks = App\Models\Tracks::all())
                        @foreach ($tracks as $track)
                        <option value="{{ $track->id }}" {{ old('track_id') == $track->id ? 'selected' : '' }}>
                            {{ $track->track_name }}
                        </option>
                        @endforeach
                        @else
                        <option value="">No tracks available</option>
                        @endif
                    </select>
                    @error('track_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label" for="strand">Strand</label>
                    <select class="form-select" id="strand" name="strand_id" required>
                        <option value="">Select a strand</option>
                    </select>
                    @error('strand_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label" for="grade_level">Grade Level</label>
                    <select class="form-select" id="grade_level" name="grade_level" required>
                        <option value="">Select</option>
                        <option value="Grade 11" {{ old('grade_level') == 'Grade 11' ? 'selected' : '' }}>Grade 11
                        </option>
                        <option value="Grade 12" {{ old('grade_level') == 'Grade 12' ? 'selected' : '' }}>Grade 12
                        </option>
                    </select>
                    @error('grade_level')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label class="form-label" for="class_schedule">Preferred Class Schedule</label>
                    <select class="form-select" id="class_schedule" name="class_schedule" required>
                        <option value="">Select</option>
                        <option value="Morning" {{ old('class_schedule') == 'Morning' ? 'selected' : '' }}>Morning
                        </option>
                        <option value="Afternoon" {{ old('class_schedule') == 'Afternoon' ? 'selected' : '' }}>Afternoon
                        </option>
                        <option value="Evening" {{ old('class_schedule') == 'Evening' ? 'selected' : '' }}>Evening
                        </option>
                    </select>
                    @error('class_schedule')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-12">
                    <label class="form-label" for="additional_notes">Additional Notes</label>
                    <textarea class="form-control" id="additional_notes" name="additional_notes"
                        rows="3">{{ old('additional_notes') }}</textarea>
                    @error('additional_notes')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <h5 class="section-title">Additional Information</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="p-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="medical_info" class="form-label">Medical Information (e.g., Allergies)</label>
                    <textarea class="form-control" id="medical_info" name="medical_info"
                        rows="3">{{ old('medical_info') }}</textarea>
                    @error('medical_info')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="special_accommodations" class="form-label">Special Accommodations</label>
                    <textarea class="form-control" id="special_accommodations" name="special_accommodations"
                        rows="3">{{ old('special_accommodations') }}</textarea>
                    @error('special_accommodations')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <h5 class="section-title">Payment Information</h5>
        <div class="mb-3 shadow-sm card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date"
                        value="{{ old('payment_date') }}" required>
                    @error('payment_date')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="downpayment" class="form-label">Downpayment</label>
                    <input type="number" class="form-control" id="downpayment" name="downpayment" min="0" step="0.01"
                        value="{{ old('downpayment') }}" required>
                    @error('downpayment')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="">Select</option>
                        <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>
                            Credit Card</option>
                        <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>
                            Bank Transfer</option>
                        <option value="Online Payment"
                            {{ old('payment_method') == 'Online Payment' ? 'selected' : '' }}>Online Payment</option>
                    </select>
                    @error('payment_method')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="balance" class="form-label">Balance</label>
                    <input type="number" class="form-control" id="balance" name="balance"
                        value="{{ old('balance', 30000) }}" readonly required>
                    @error('balance')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="receiptnumber" class="form-label">Receipt Number</label>
                    <input type="text" class="form-control" id="receiptnumber" name="receiptnumber"
                        value="{{ old('receiptnumber') }}" readonly required>
                    @error('receiptnumber')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="p-1 mb-3 col-md-4">
            <label for="studentid" class="form-label">Student ID</label>
            <input type="text" class="form-control" id="studentid" name="studentid" value="{{ old('studentid') }}"
                readonly required>
            @error('studentid')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="p-3 card">
            <div class="gap-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm w-25">Enroll</button>
                <a href="{{ route('student.index') }}" class="btn btn-outline-primary btn-sm w-25">Cancel</a>
            </div>
        </div>
    </form>
</div>

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- CSRF Token for AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    // Function to generate a 6-digit student ID
    function generateStudentID() {
        return Math.floor(100000 + Math.random() * 900000);
    }

    // Function to generate a 6-digit receipt number
    function generateReceiptNumber() {
        return Math.floor(100000 + Math.random() * 900000);
    }

    // Set student ID and receipt number on page load, respecting old() values
    document.addEventListener('DOMContentLoaded', () => {
        const studentIDField = document.getElementById('studentid');
        if (!studentIDField.value) {
            studentIDField.value = generateStudentID();
        }

        const receiptNumberField = document.getElementById('receiptnumber');
        if (!receiptNumberField.value) {
            receiptNumberField.value = generateReceiptNumber();
        }

        // Trigger loadStrands if a track is already selected (e.g., from old input)
        const trackSelect = document.getElementById('track');
        if (trackSelect.value) {
            loadStrands();
        }
    });

    // Function to load strands based on selected track
    function loadStrands() {
        const trackId = $('#track').val();
        const strandSelect = $('#strand');
        const oldStrandId = '{{ old('
        strand_id ') }}';

        // Clear existing strand options except the default
        strandSelect.find('option:not(:first)').remove();

        if (trackId) {
            // Show loading state
            strandSelect.append('<option value="">Loading...</option>');

            // Make AJAX request to fetch strands
            $.ajax({
                url: '{{ route("strands.get") }}',
                type: 'GET',
                data: {
                    track_id: trackId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // Clear loading option
                    strandSelect.find('option[value=""]').remove();

                    // Add default option
                    strandSelect.append('<option value="">Select a strand</option>');

                    if (data.length === 0) {
                        strandSelect.append('<option value="">No strands available</option>');
                    } else {
                        // Populate strands
                        data.forEach(strand => {
                            const selected = oldStrandId == strand.id ? 'selected' : '';
                            strandSelect.append(
                                `<option value="${strand.id}" ${selected}>${strand.strand_name}</option>`
                            );
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching strands:', xhr.responseText);
                    strandSelect.find('option[value=""]').remove();
                    strandSelect.append('<option value="">Error loading strands</option>');
                }
            });
        }
    }
</script>
@endsection