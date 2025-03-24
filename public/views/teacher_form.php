<?php
// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'enrollment_system';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $first_name = trim($_POST['first_name'] ?? '');
    $middle_name = trim($_POST['middle_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $age = $_POST['age'] ?? '';
    $nationality = trim($_POST['nationality'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $degree = trim($_POST['degree'] ?? '');
    $major = trim($_POST['major'] ?? '');
    $university = trim($_POST['university'] ?? '');
    $year_graduated = trim($_POST['year_graduated'] ?? '');

    $prc_license = trim($_POST['prc_license'] ?? '');
    $license_validity = $_POST['license_validity'] ?? '';
    $let_date = $_POST['let_date'] ?? '';
    $specialization = $_POST['specialization'] ?? '';

    $previous_school = trim($_POST['previous_school'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $years_experience = trim($_POST['years_experience'] ?? '');
    $employment_status = $_POST['employment_status'] ?? '';
    $teaching_schedule = $_POST['teaching_schedule'] ?? '';
    $subjects = trim($_POST['subjects'] ?? '');

    $certifications = trim($_POST['certifications'] ?? '');
    $medical_info = trim($_POST['medical_info'] ?? '');
    $accommodations = trim($_POST['accommodations'] ?? '');

    $date_hired = $_POST['date_hired'] ?? '';
    $employee_id = trim($_POST['employee_id'] ?? '');

    // Basic validation
    if (empty($first_name) || empty($last_name) || empty($date_of_birth) || empty($gender) || empty($contact_number) || empty($email)) {
        $error = "Please fill in all required personal information fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (empty($degree) || empty($university) || empty($year_graduated)) {
        $error = "Please fill in all required educational background fields.";
    } elseif (empty($prc_license) || empty($license_validity)) {
        $error = "Please provide PRC license details.";
    } else {
        // Handle file uploads
        $profile_picture = $_FILES['profile_picture']['name'] ?? '';
        $resume = $_FILES['resume']['name'] ?? '';
        $transcript = $_FILES['transcript']['name'] ?? '';
        $prc_copy = $_FILES['prc_copy']['name'] ?? '';

        // Insert into database (example table: teachers)
        try {
            $stmt = $pdo->prepare("
                INSERT INTO teachers (
                    first_name, middle_name, last_name, date_of_birth, gender, age, nationality, address, contact_number, email,
                    degree, major, university, year_graduated,
                    prc_license, license_validity, let_date, specialization,
                    previous_school, position, years_experience, employment_status, teaching_schedule, subjects,
                    certifications, medical_info, accommodations,
                    date_hired, employee_id, profile_picture, resume, transcript, prc_copy
                ) VALUES (
                    :first_name, :middle_name, :last_name, :date_of_birth, :gender, :age, :nationality, :address, :contact_number, :email,
                    :degree, :major, :university, :year_graduated,
                    :prc_license, :license_validity, :let_date, :specialization,
                    :previous_school, :position, :years_experience, :employment_status, :teaching_schedule, :subjects,
                    :certifications, :medical_info, :accommodations,
                    :date_hired, :employee_id, :profile_picture, :resume, :transcript, :prc_copy
                )
            ");
            $stmt->execute([
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'date_of_birth' => $date_of_birth,
                'gender' => $gender,
                'age' => $age,
                'nationality' => $nationality,
                'address' => $address,
                'contact_number' => $contact_number,
                'email' => $email,
                'degree' => $degree,
                'major' => $major,
                'university' => $university,
                'year_graduated' => $year_graduated,
                'prc_license' => $prc_license,
                'license_validity' => $license_validity,
                'let_date' => $let_date,
                'specialization' => $specialization,
                'previous_school' => $previous_school,
                'position' => $position,
                'years_experience' => $years_experience,
                'employment_status' => $employment_status,
                'teaching_schedule' => $teaching_schedule,
                'subjects' => $subjects,
                'certifications' => $certifications,
                'medical_info' => $medical_info,
                'accommodations' => $accommodations,
                'date_hired' => $date_hired,
                'employee_id' => $employee_id,
                'profile_picture' => $profile_picture,
                'resume' => $resume,
                'transcript' => $transcript,
                'prc_copy' => $prc_copy
            ]);

            // Redirect to success page
            header("Location: success.php");
            exit();
        } catch (PDOException $e) {
            $error = "Error saving data: " . $e->getMessage();
        }
    }
}
?>

<link rel="stylesheet" href="../css/teacher_form.css">

<div>
    <p class="h4 text-center mb-4" style="color: var(--text-clr) !important;">Teacher's Form</p>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <!-- Personal Information -->
        <h5 class="section-title">Personal Information</h5>
        <div class="card form-section mb-3 shadow">
            <div class="row m-3">
                <div class="col-md-3 text-center p-1">
                    <div class="profile-pic mb-3">
                        <i class="fas fa-user fa-3x"></i>
                    </div>
                    <input type="file" name="profile_picture" class="form-control" accept="image/*">
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-4 mb-3 p-1">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-md-4 mb-3 p-1">
                            <label for="middle_name" class="form-label">Middle Name (Optional)</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>
                        <div class="col-md-4 mb-3 p-1">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3 p-1">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                        </div>
                        <div class="col-md-4 mb-3 p-1">
                            <label class="form-label">Gender</label><br>
                            <div class="form-check form-check-inline m-1">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="Male"
                                    required>
                                <label class="form-check-label m-1" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
                                <label class="form-check-label m-1" for="female">Female</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 p-1">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" min="1" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3 p-1">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality" required>
                        </div>
                        <div class="col-md-4 mb-3 p-1">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="col-md-4 mb-3 p-1">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3 p-1">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Educational Background -->
        <h5 class="section-title">Educational Background</h5>
        <div class="card form-section mb-3 shadow">
            <div class="row m-3">
                <div class="col-md-3 mb-3 p-1">
                    <label for="degree" class="form-label">Highest Degree</label>
                    <input type="text" class="form-control" id="degree" name="degree" required>
                </div>
                <div class="col-md-3 mb-3 p-1">
                    <label for="major" class="form-label">Major/Specialization</label>
                    <input type="text" class="form-control" id="major" name="major" required>
                </div>
                <div class="col-md-3 mb-3 p-1">
                    <label for="university" class="form-label">University</label>
                    <input type="text" class="form-control" id="university" name="university" required>
                </div>
                <div class="col-md-3 mb-3 p-1">
                    <label for="year_graduated" class="form-label">Year Graduated</label>
                    <input type="text" class="form-control" id="year_graduated" name="year_graduated" required>
                </div>
            </div>
        </div>

        <!-- Teaching Credentials -->
        <h5 class="section-title">Teaching Credentials</h5>
        <div class="card form-section mb-3 shadow">
            <div class="row m-3">
                <div class="col-md-4 mb-3 p-1">
                    <label for="prc_license" class="form-label">PRC License Number</label>
                    <input type="text" class="form-control" id="prc_license" name="prc_license" required>
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="license_validity" class="form-label">License Validity Date</label>
                    <input type="date" class="form-control" id="license_validity" name="license_validity" required>
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="let_date" class="form-label">LET Passing Date</label>
                    <input type="date" class="form-control" id="let_date" name="let_date" required>
                </div>
            </div>
            <div class="row m-3">
                <div class="col-md-6 mb-3 p-1">
                    <label for="specialization" class="form-label">Teaching Specialization/Track</label>
                    <select class="form-select" id="specialization" name="specialization" required>
                        <option value="">Select</option>
                        <option value="Academic">Academic (STEM, ABM, HUMSS, GAS)</option>
                        <option value="TVL">Technical-Vocational-Livelihood (TVL)</option>
                        <option value="Sports">Sports</option>
                        <option value="Arts">Arts and Design</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3 p-1">
                    <label for="prc_copy" class="form-label">PRC License Copy</label>
                    <input type="file" class="form-control" id="prc_copy" name="prc_copy" accept=".pdf,.jpg,.png"
                        required>
                </div>
            </div>
        </div>

        <!-- Employment Details -->
        <h5 class="section-title">Employment Details</h5>
        <div class="card form-section mb-3 shadow">
            <div class="row m-3">
                <div class="col-md-4 mb-3 p-1">
                    <label for="previous_school" class="form-label">Previous School (Optional)</label>
                    <input type="text" class="form-control" id="previous_school" name="previous_school">
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="position" class="form-label">Previous Position (Optional)</label>
                    <input type="text" class="form-control" id="position" name="position">
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="years_experience" class="form-label">Years of Experience</label>
                    <input type="number" class="form-control" id="years_experience" name="years_experience" min="0">
                </div>
            </div>
            <div class="row m-3">
                <div class="col-md-4 mb-3 p-1">
                    <label for="employment_status" class="form-label">Employment Status</label>
                    <select class="form-select" id="employment_status" name="employment_status" required>
                        <option value="">Select</option>
                        <option value="Full-time">Full-time</option>
                        <option value="Part-time">Part-time</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="teaching_schedule" class="form-label">Preferred Schedule</label>
                    <select class="form-select" id="teaching_schedule" name="teaching_schedule" required>
                        <option value="">Select</option>
                        <option value="Morning">Morning</option>
                        <option value="Afternoon">Afternoon</option>
                        <option value="Evening">Evening</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="subjects" class="form-label">Subjects Willing to Teach</label>
                    <input type="text" class="form-control" id="subjects" name="subjects" required>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <h5 class="section-title">Additional Information</h5>
        <div class="card form-section mb-3 shadow">
            <div class="row p-3">
                <div class="col-md-4 mb-3 p-1">
                    <label for="certifications" class="form-label">Certifications/Trainings</label>
                    <textarea class="form-control" id="certifications" name="certifications" rows="3"></textarea>
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="medical_info" class="form-label">Medical Information</label>
                    <textarea class="form-control" id="medical_info" name="medical_info" rows="3"></textarea>
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="accommodations" class="form-label">Special Accommodations</label>
                    <textarea class="form-control" id="accommodations" name="accommodations" rows="3"></textarea>
                </div>
            </div>
            <div class="row m-3">
                <div class="col-md-6 mb-3 p-1">
                    <label for="resume" class="form-label">Resume/CV</label>
                    <input type="file" class="form-control" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                </div>
                <div class="col-md-6 mb-3 p-1">
                    <label for="transcript" class="form-label">Transcript of Records</label>
                    <input type="file" class="form-control" id="transcript" name="transcript" accept=".pdf,.doc,.docx"
                        required>
                </div>
            </div>
        </div>

        <!-- Administrative Use -->
        <h5 class="section-title">Administrative Use</h5>
        <div class="card form-section mb-3 shadow">
            <div class="row m-3">
                <div class="col-md-6 mb-3 p-1">
                    <label for="date_hired" class="form-label">Date Hired</label>
                    <input type="date" class="form-control" id="date_hired" name="date_hired" required>
                </div>
                <div class="col-md-6 mb-3 p-1">
                    <label for="employee_id" class="form-label">Employee ID</label>
                    <input type="text" class="form-control" id="employee_id" name="employee_id" required>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="card p-3">
            <div class="d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-outline-primary btn-lg w-25">Register Teacher</button>
                <button type="button" class="btn btn-primary btn-lg w-25">Cancel</button>
            </div>
        </div>
    </form>
</div>