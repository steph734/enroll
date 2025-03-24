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
    $home_address = trim($_POST['home_address'] ?? '');
    $zip_code = trim($_POST['zip_code'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');
    $secondary_contact = trim($_POST['secondary_contact'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $guardian_first_name = trim($_POST['guardian_first_name'] ?? '');
    $guardian_middle_name = trim($_POST['guardian_middle_name'] ?? '');
    $guardian_last_name = trim($_POST['guardian_last_name'] ?? '');
    $relationship = $_POST['relationship'] ?? '';
    $guardian_contact = trim($_POST['guardian_contact'] ?? '');
    $guardian_email = trim($_POST['guardian_email'] ?? '');

    $previous_school = trim($_POST['previous_school'] ?? '');
    $grade_completed = $_POST['grade_completed'] ?? '';
    $school_year_completed = trim($_POST['school_year_completed'] ?? '');
    $gpa = trim($_POST['gpa'] ?? '');

    $track = $_POST['track'] ?? '';
    $strand = $_POST['strand'] ?? '';
    $grade_level = $_POST['grade_level'] ?? '';
    $class_schedule = $_POST['class_schedule'] ?? '';
    $additional_notes = trim($_POST['additional_notes'] ?? '');

    $medical_info = trim($_POST['medical_info'] ?? '');
    $special_accommodations = trim($_POST['special_accommodations'] ?? '');

    $payment_amount = trim($_POST['payment_amount'] ?? '');
    $payment_date = $_POST['payment_date'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';
    $receipt_number = trim($_POST['receipt_number'] ?? '');

    // Basic validation
    if (empty($first_name) || empty($last_name) || empty($date_of_birth) || empty($gender) || empty($contact_number) || empty($email)) {
        $error = "Please fill in all required personal information fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (empty($guardian_first_name) || empty($guardian_last_name) || empty($guardian_contact)) {
        $error = "Please fill in all required guardian information fields.";
    } elseif (empty($previous_school) || empty($grade_completed)) {
        $error = "Please fill in all required academic background fields.";
    } elseif (empty($track) || empty($grade_level)) {
        $error = "Please select a track and grade level.";
    } elseif (empty($payment_amount) || empty($payment_date) || empty($payment_method)) {
        $error = "Please fill in all required payment details.";
    } else {
        // Handle file uploads (profile picture and transcript)
        $profile_picture = $_FILES['profile_picture']['name'] ?? '';
        $transcript = $_FILES['transcript']['name'] ?? '';

        // Insert into database (example table: students)
        try {
            $stmt = $pdo->prepare("
                INSERT INTO students (
                    first_name, middle_name, last_name, date_of_birth, gender, age, nationality, home_address, zip_code, 
                    contact_number, secondary_contact, email, 
                    guardian_first_name, guardian_middle_name, guardian_last_name, relationship, guardian_contact, guardian_email,
                    previous_school, grade_completed, school_year_completed, gpa,
                    track, strand, grade_level, class_schedule, additional_notes,
                    medical_info, special_accommodations,
                    payment_amount, payment_date, payment_method, receipt_number, profile_picture, transcript
                ) VALUES (
                    :first_name, :middle_name, :last_name, :date_of_birth, :gender, :age, :nationality, :home_address, :zip_code,
                    :contact_number, :secondary_contact, :email,
                    :guardian_first_name, :guardian_middle_name, :guardian_last_name, :relationship, :guardian_contact, :guardian_email,
                    :previous_school, :grade_completed, :school_year_completed, :gpa,
                    :track, :strand, :grade_level, :class_schedule, :additional_notes,
                    :medical_info, :special_accommodations,
                    :payment_amount, :payment_date, :payment_method, :receipt_number, :profile_picture, :transcript
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
                'home_address' => $home_address,
                'zip_code' => $zip_code,
                'contact_number' => $contact_number,
                'secondary_contact' => $secondary_contact,
                'email' => $email,
                'guardian_first_name' => $guardian_first_name,
                'guardian_middle_name' => $guardian_middle_name,
                'guardian_last_name' => $guardian_last_name,
                'relationship' => $relationship,
                'guardian_contact' => $guardian_contact,
                'guardian_email' => $guardian_email,
                'previous_school' => $previous_school,
                'grade_completed' => $grade_completed,
                'school_year_completed' => $school_year_completed,
                'gpa' => $gpa,
                'track' => $track,
                'strand' => $strand,
                'grade_level' => $grade_level,
                'class_schedule' => $class_schedule,
                'additional_notes' => $additional_notes,
                'medical_info' => $medical_info,
                'special_accommodations' => $special_accommodations,
                'payment_amount' => $payment_amount,
                'payment_date' => $payment_date,
                'payment_method' => $payment_method,
                'receipt_number' => $receipt_number,
                'profile_picture' => $profile_picture,
                'transcript' => $transcript
            ]);

            // Redirect to a success page or dashboard
            header("Location: success.php");
            exit();
        } catch (PDOException $e) {
            $error = "Error saving data: " . $e->getMessage();
        }
    }
}
?>

<link rel="stylesheet" href="../css/enrollement.css">

<div>
    <p class="h4 text-center mb-4 " style="color: var(--text-clr) !important;">Student Enrollment Form</p>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <!-- Personal Information -->
        <h5 class="section-title">Personal Information</h5>
        <div class="card form-section mb-3 shadow">

            <div class="row m-3 ">
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
                            <label for="home_address" class="form-label">Home Address</label>
                            <input type="text" class="form-control" id="home_address" name="home_address" required>
                        </div>
                        <div class="col-md-4 mb-3 p-1">
                            <label for="zip_code" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3 p-1">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                        </div>
                        <div class="col-md-4 mb-3 p-1">
                            <label for="secondary_contact" class="form-label">Secondary Contact (Optional)</label>
                            <input type="text" class="form-control" id="secondary_contact" name="secondary_contact">
                        </div>
                        <div class="col-md-4 mb-3 p-1">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parent/Guardian Information -->
        <h5 class="section-title">Parent/Guardian Information</h5>
        <div class="card form-section mb-3 shadow">

            <div class="row m-3">
                <div class="col-md-4 mb-3 p-1">
                    <label for="guardian_first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name"
                        required>
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="guardian_middle_name" class="form-label">Middle Name (Optional)</label>
                    <input type="text" class="form-control" id="guardian_middle_name" name="guardian_middle_name">
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="guardian_last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name" required>
                </div>
            </div>
            <div class="row m-3">
                <div class="col-md-4 mb-3 p-1">
                    <label for="relationship" class="form-label">Relationship</label>
                    <select class="form-select" id="relationship" name="relationship" required>
                        <option value="">Select</option>
                        <option value="Mother">Mother</option>
                        <option value="Father">Father</option>
                        <option value="Guardian">Guardian</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="guardian_contact" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="guardian_contact" name="guardian_contact" required>
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="guardian_email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="guardian_email" name="guardian_email">
                </div>
            </div>
        </div>

        <!-- Academic Background -->
        <h5 class="section-title">Academic Background</h5>
        <div class="card form-section mb-3 shadow">

            <div class="row m-3">
                <div class="col-md-6 mb-3 p-1">
                    <label for="previous_school" class="form-label">Previous School Name</label>
                    <input type="text" class="form-control" id="previous_school" name="previous_school" required>
                </div>
                <div class="col-md-3 mb-3 p-1">
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
                <div class="col-md-3 mb-3 p-1">
                    <label for="school_year_completed" class="form-label">School Year Completed</label>
                    <input type="text" class="form-control" id="school_year_completed" name="school_year_completed"
                        placeholder="e.g., 2023-2024" required>
                </div>
            </div>
            <div class="row m-3">
                <div class="col-md-6 mb-3 p-1">
                    <label for="gpa" class="form-label">GPA (Optional)</label>
                    <input type="text" class="form-control" id="gpa" name="gpa">
                </div>
                <div class="col-md-6 mb-3 p-1">
                    <label for="transcript" class="form-label">Transcript/Report Card</label>
                    <input type="file" class="form-control" id="transcript" name="transcript" accept=".pdf,.doc,.docx"
                        required>
                </div>
            </div>
        </div>

        <!-- Program Enrollment -->
        <h5 class="section-title">Program Enrollment</h5>
        <div class="card form-section mb-3 shadow">

            <div class="row m-3">
                <div class="col-md-3 mb-3 p-1">
                    <label for="track" class="form-label">Track</label>
                    <select class="form-select" id="track" name="track" required>
                        <option value="">Select</option>
                        <option value="Academic">Academic</option>
                        <option value="Technical">Technical</option>
                        <option value="Vocational">Vocational</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 p-1">
                    <label for="strand" class="form-label">Strand</label>
                    <select class="form-select" id="strand" name="strand">
                        <option value="">Select</option>
                        <option value="STEM">STEM</option>
                        <option value="HUMSS">HUMSS</option>
                        <option value="ABM">ABM</option>
                        <option value="GAS">GAS</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 p-1">
                    <label for="grade_level" class="form-label">Grade Level</label>
                    <select class="form-select" id="grade_level" name="grade_level" required>
                        <option value="">Select</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 p-1">
                    <label for="class_schedule" class="form-label">Preferred Class Schedule</label>
                    <select class="form-select" id="class_schedule" name="class_schedule" required>
                        <option value="">Select</option>
                        <option value="Morning">Morning</option>
                        <option value="Afternoon">Afternoon</option>
                        <option value="Evening">Evening</option>
                    </select>
                </div>
            </div>
            <div class="row m-3">
                <div class="col-md-12 mb-3 p-1">
                    <label for="additional_notes" class="form-label">Additional Notes</label>
                    <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3"></textarea>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <h5 class="section-title">Additional Information</h5>
        <div class="card form-section mb-3 shadow">

            <div class="row p-3">
                <div class="col-md-6 mb-3 p-1">
                    <label for="medical_info" class="form-label">Medical Information (e.g., Allergies)</label>
                    <textarea class="form-control" id="medical_info" name="medical_info" rows="3"></textarea>
                </div>
                <div class="col-md-6 mb-3 p-1">
                    <label for="special_accommodations" class="form-label">Special Accommodations</label>
                    <textarea class="form-control" id="special_accommodations" name="special_accommodations"
                        rows="3"></textarea>
                </div>
            </div>
        </div>

        <!-- Payment -->
        <h5 class="section-title">Payment</h5>
        <div class="card form-section mb-3 shadow">

            <div class="row m-3">
                <div class="col-md-4 mb-3 p-1">
                    <label for="payment_amount" class="form-label">Payment Amount</label>
                    <input type="number" class="form-control" id="payment_amount" name="payment_amount" step="0.01"
                        required min="0">
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                </div>
                <div class="col-md-4 mb-3 p-1">
                    <label for="receipt_number" class="form-label">Receipt Number</label>
                    <input type="text" class="form-control" id="receipt_number" name="receipt_number" value="P03"
                        required>
                </div>
            </div>
            <div class="row m-3">
                <div class="col-md-4 mb-3 p-1">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="">Select</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Debit Card">Debit Card</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="card p-3">
            <div class="d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-outline-primary btn-lg w-25">Enroll</button>
                <button type="button" class="btn btn-primary btn-lg w-25">
                    Cancel
                </button>
            </div>
        </div>
    </form>
</div>