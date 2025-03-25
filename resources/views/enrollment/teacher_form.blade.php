@extends('layouts.app')

@section('title','Teacher\'s Form')
@section('styles')
<link rel="stylesheet" href="{{asset('css/teacher_form.css')}}">
@endsection
@section('content')
<div>
    <p class="mb-4 text-center h4" style="color: var(--text-clr) !important;">Teacher's Form</p>
  
    <form method="POST" action="" enctype="multipart/form-data">
        <!-- Personal Information -->
        <h5 class="section-title">Personal Information</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
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
                            <input type="number" class="form-control" id="age" name="age" min="1" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="p-1 mb-3 col-md-4">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-1 mb-3 col-md-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
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
                    <input type="text" class="form-control" id="degree" name="degree" required>
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="major" class="form-label">Major/Specialization</label>
                    <input type="text" class="form-control" id="major" name="major" required>
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="university" class="form-label">University</label>
                    <input type="text" class="form-control" id="university" name="university" required>
                </div>
                <div class="p-1 mb-3 col-md-3">
                    <label for="year_graduated" class="form-label">Year Graduated</label>
                    <input type="text" class="form-control" id="year_graduated" name="year_graduated" required>
                </div>
            </div>
        </div>

        <!-- Teaching Credentials -->
        <h5 class="section-title">Teaching Credentials</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="prc_license" class="form-label">PRC License Number</label>
                    <input type="text" class="form-control" id="prc_license" name="prc_license" required>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="license_validity" class="form-label">License Validity Date</label>
                    <input type="date" class="form-control" id="license_validity" name="license_validity" required>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="let_date" class="form-label">LET Passing Date</label>
                    <input type="date" class="form-control" id="let_date" name="let_date" required>
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="specialization" class="form-label">Teaching Specialization/Track</label>
                    <select class="form-select" id="specialization" name="specialization" required>
                        <option value="">Select</option>
                        <option value="Academic">Academic (STEM, ABM, HUMSS, GAS)</option>
                        <option value="TVL">Technical-Vocational-Livelihood (TVL)</option>
                        <option value="Sports">Sports</option>
                        <option value="Arts">Arts and Design</option>
                    </select>
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="prc_copy" class="form-label">PRC License Copy</label>
                    <input type="file" class="form-control" id="prc_copy" name="prc_copy" accept=".pdf,.jpg,.png"
                        required>
                </div>
            </div>
        </div>

        <!-- Employment Details -->
        <h5 class="section-title">Employment Details</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="previous_school" class="form-label">Previous School (Optional)</label>
                    <input type="text" class="form-control" id="previous_school" name="previous_school">
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="position" class="form-label">Previous Position (Optional)</label>
                    <input type="text" class="form-control" id="position" name="position">
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="years_experience" class="form-label">Years of Experience</label>
                    <input type="number" class="form-control" id="years_experience" name="years_experience" min="0">
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="employment_status" class="form-label">Employment Status</label>
                    <select class="form-select" id="employment_status" name="employment_status" required>
                        <option value="">Select</option>
                        <option value="Full-time">Full-time</option>
                        <option value="Part-time">Part-time</option>
                    </select>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="teaching_schedule" class="form-label">Preferred Schedule</label>
                    <select class="form-select" id="teaching_schedule" name="teaching_schedule" required>
                        <option value="">Select</option>
                        <option value="Morning">Morning</option>
                        <option value="Afternoon">Afternoon</option>
                        <option value="Evening">Evening</option>
                    </select>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="subjects" class="form-label">Subjects Willing to Teach</label>
                    <input type="text" class="form-control" id="subjects" name="subjects" required>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <h5 class="section-title">Additional Information</h5>
        <div class="mb-3 shadow card form-section">
            <div class="p-3 row">
                <div class="p-1 mb-3 col-md-4">
                    <label for="certifications" class="form-label">Certifications/Trainings</label>
                    <textarea class="form-control" id="certifications" name="certifications" rows="3"></textarea>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="medical_info" class="form-label">Medical Information</label>
                    <textarea class="form-control" id="medical_info" name="medical_info" rows="3"></textarea>
                </div>
                <div class="p-1 mb-3 col-md-4">
                    <label for="accommodations" class="form-label">Special Accommodations</label>
                    <textarea class="form-control" id="accommodations" name="accommodations" rows="3"></textarea>
                </div>
            </div>
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="resume" class="form-label">Resume/CV</label>
                    <input type="file" class="form-control" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="transcript" class="form-label">Transcript of Records</label>
                    <input type="file" class="form-control" id="transcript" name="transcript" accept=".pdf,.doc,.docx"
                        required>
                </div>
            </div>
        </div>

        <!-- Administrative Use -->
        <h5 class="section-title">Administrative Use</h5>
        <div class="mb-3 shadow card form-section">
            <div class="m-3 row">
                <div class="p-1 mb-3 col-md-6">
                    <label for="date_hired" class="form-label">Date Hired</label>
                    <input type="date" class="form-control" id="date_hired" name="date_hired" required>
                </div>
                <div class="p-1 mb-3 col-md-6">
                    <label for="employee_id" class="form-label">Employee ID</label>
                    <input type="text" class="form-control" id="employee_id" name="employee_id" required>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="p-3 card">
            <div class="gap-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary btn-lg w-25">Register Teacher</button>
                <button type="button" class="btn btn-primary btn-lg w-25">Cancel</button>
            </div>
        </div>
    </form>
</div>
@endsection