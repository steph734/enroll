<link rel="stylesheet" href="../css/subject_section.css">

<div class="assignment-content">
    <div class="alert alert-success" style="display: none;">Profile updated successfully!</div>
    <div class="alert alert-danger" style="display: none;">Invalid email format.</div>

    <div class="row mb-5">
        <!-- Assigned Subjects & Sections -->
        <div class="col-8 assignment-section">
            <h4 class="section-title m-2 mb-0">Assigned Subjects & Sections</h4>
            <div class="card p-3 m-2 mt-0 card-table-assigned">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Teacher's Name</th>
                                    <th>Section</th>
                                    <th>Subject(s)</th>
                                    <th>Schedule</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>STEM 11-A</td>
                                    <td>Mathematics</td>
                                    <td>8:00 AM - 9:00 AM</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger">Remove</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>John Doe</td>
                                    <td>HUMSS 11-C</td>
                                    <td>English</td>
                                    <td>9:00 AM - 10:00 AM</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger">Remove</button>
                                    </td>
                                </tr>
                                <!-- Placeholder for empty state -->
                                <tr style="display: none;">
                                    <td colspan="5" class="text-center">No assignments found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher's Profile -->
        <div class="col-4 profile-section">
            <h4 class="section-title m-2 mb-0">Teacher's Profile</h4>
            <div class="card p-3 m-2 mt-0">
                <div class="card-body">
                    <div class="card-title">
                        <div class="text-center mb-3">
                            <div class="profile-pic mx-auto"></div>
                            <h5 class="mt-2">433123</h5>
                        </div>
                        <form>
                            <h6>Personal Information</h6>
                            <div class="mb-2">
                                <label class="form-label">First Name:</label>
                                <input type="text" class="form-control" name="first_name" value="John" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Last Name:</label>
                                <input type="text" class="form-control" name="last_name" value="Doe" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">M.I.:</label>
                                <input type="text" class="form-control" name="middle_initial" value="">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email" value="john.doe@example.com"
                                    required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Phone Number:</label>
                                <input type="text" class="form-control" name="phone_number" value="">
                            </div>

                            <h6 class="mt-3">Professional Details</h6>
                            <div class="mb-2">
                                <label class="form-label">Strand:</label>
                                <select class="form-select" name="strand">
                                    <option value="STEM" selected>STEM</option>
                                    <option value="ABM">ABM</option>
                                    <option value="HUMSS">HUMSS</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Grade Level:</label>
                                <select class="form-select" name="grade_level">
                                    <option value="Grade 11" selected>Grade 11</option>
                                    <option value="Grade 12">Grade 12</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Section:</label>
                                <select class="form-select" name="section">
                                    <option value="">Select Section</option>
                                    <option value="STEM 11-A">STEM 11-A</option>
                                    <option value="HUMSS 11-C">HUMSS 11-C</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Subject(s):</label>
                                <select class="form-select" name="subjects">
                                    <option value="">Select Subject</option>
                                    <option value="Mathematics">Mathematics</option>
                                    <option value="English">English</option>
                                    <option value="Science">Science</option>
                                </select>
                            </div>
                            <button type="submit" name="save_profile" class="btn btn-primary w-100 mt-3">Save
                                Info</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Subject/Section -->
    <div class="row">
        <h4 class="section-title m-2 mb-0">Subject/Section</h4>
        <div class="card p-3 m-2 mt-0">
            <div class="card-body">
                <ul class="nav nav-tabs mt-3">
                    <li class="nav-item mx-1">
                        <a class="nav-link active" href="#section" data-bs-toggle="tab">Section</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="#subject" data-bs-toggle="tab">Subject</a>
                    </li>
                </ul>
                <div class="tab-content mt-3">
                    <!-- Section Tab -->
                    <div class="tab-pane fade show active" id="section">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="search-container">
                                <input type="text" id="sectionSearch" class="form-control w-100 p-1"
                                    placeholder="Search...">
                            </div>
                            <div class="filter-container">
                                <select class="form-select" style="width: 150px;">
                                    <option>Filter by</option>
                                    <option value="strand">Strand</option>
                                    <option value="grade_level">Grade Level</option>
                                </select>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Section Name</th>
                                    <th>Grade Level</th>
                                    <th>Strand</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="sectionTable">
                                <tr class="section-row">
                                    <td>STEM 11-A</td>
                                    <td>Grade 11</td>
                                    <td>STEM</td>
                                    <td><span class="badge bg-danger p-1">Occupied</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success assign-btn">Assign</button>
                                        <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                                    </td>
                                </tr>
                                <tr class="section-row">
                                    <td>HUMSS 11-C</td>
                                    <td>Grade 11</td>
                                    <td>HUMSS</td>
                                    <td><span class="badge bg-danger p-1">Occupied</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success assign-btn">Assign</button>
                                        <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Subject Tab -->
                    <div class="tab-pane fade" id="subject">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="search-container">
                                <input type="text" id="subjectSearch" class="form-control w-100 p-1"
                                    placeholder="Search...">
                            </div>
                            <div class="filter-container">
                                <select class="form-select" style="width: 150px;">
                                    <option>Filter by</option>
                                    <option value="strand">Strand</option>
                                    <option value="grade_level">Grade Level</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Grade Level</th>
                                        <th>Strand</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="subjectTable">
                                    <tr class="subject-row">
                                        <td>Mathematics</td>
                                        <td>Grade 11</td>
                                        <td>STEM</td>
                                        <td>
                                            <button class="btn btn-sm btn-success assign-btn">Assign</button>
                                            <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                                        </td>
                                    </tr>
                                    <tr class="subject-row">
                                        <td>English</td>
                                        <td>Grade 11</td>
                                        <td>HUMSS</td>
                                        <td>
                                            <button class="btn btn-sm btn-success assign-btn">Assign</button>
                                            <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Search functionality for sections
    const sectionSearch = document.getElementById('sectionSearch');
    const sectionRows = document.querySelectorAll('.section-row');

    sectionSearch.addEventListener('input', () => {
        const searchTerm = sectionSearch.value.toLowerCase();
        sectionRows.forEach(row => {
            const sectionName = row.cells[0].textContent.toLowerCase();
            const gradeLevel = row.cells[1].textContent.toLowerCase();
            const strand = row.cells[2].textContent.toLowerCase();
            if (sectionName.includes(searchTerm) || gradeLevel.includes(searchTerm) || strand.includes(
                    searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Search functionality for subjects
    const subjectSearch = document.getElementById('subjectSearch');
    const subjectRows = document.querySelectorAll('.subject-row');

    subjectSearch.addEventListener('input', () => {
        const searchTerm = subjectSearch.value.toLowerCase();
        subjectRows.forEach(row => {
            const subjectName = row.cells[0].textContent.toLowerCase();
            const gradeLevel = row.cells[1].textContent.toLowerCase();
            const strand = row.cells[2].textContent.toLowerCase();
            if (subjectName.includes(searchTerm) || gradeLevel.includes(searchTerm) || strand.includes(
                    searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>