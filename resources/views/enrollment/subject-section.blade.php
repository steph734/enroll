@extends('layouts.app')
@section('title','subjects&sections')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/subject_section.css')}}">
@endsection
@section('content')

<div class="assignment-content">
    <div class="alert alert-success" style="display: none;">Profile updated successfully!</div>
    <div class="alert alert-danger" style="display: none;">Invalid email format.</div>

    <div class="mb-5 row">
        <!-- Assigned Subjects & Sections -->
        <div class="col-8 assignment-section">
            <h4 class="m-2 mb-0 section-title">Assigned Subjects & Sections</h4>
            <div class="p-3 m-2 mt-0 card card-table-assigned">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="cursor: pointer;">
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
            <h4 class="m-2 mb-0 section-title">Teacher's Profile</h4>
            <div class="p-3 m-2 mt-0 card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="mb-3 text-center">
                            <div class="mx-auto profile-pic"></div>
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
                            <button type="submit" name="save_profile" class="mt-3 btn btn-primary w-100">Save
                                Info</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Subject/Section -->
    <div class="row">
        <h4 class="m-2 mb-0 section-title">Subject/Section</h4>
        <div class="p-3 m-2 mt-0 card">
            <div class="card-body">
                <ul class="mt-3 nav nav-tabs">
                    <li class="mx-1 nav-item">
                        <a class="nav-link active" href="#section" data-bs-toggle="tab">Section</a>
                    </li>
                    <li class="mx-1 nav-item">
                        <a class="nav-link" href="#subject" data-bs-toggle="tab">Subject</a>
                    </li>
                </ul>
                <div class="mt-3 tab-content">
                    <!-- Section Tab -->
                    <div class="tab-pane fade show active" id="section">
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="search-container">
                                <input type="text" id="sectionSearch" class="p-1 form-control w-100"
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
                        <table class="table table-hover table-striped" style="cursor: pointer;">
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
                                    <td><span class="p-1 badge bg-danger">Occupied</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success assign-btn">Assign</button>
                                        <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                                    </td>
                                </tr>
                                <tr class="section-row">
                                    <td>HUMSS 11-C</td>
                                    <td>Grade 11</td>
                                    <td>HUMSS</td>
                                    <td><span class="p-1 badge bg-danger">Occupied</span></td>
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
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="search-container">
                                <input type="text" id="subjectSearch" class="p-1 form-control w-100"
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
                            <table class="table table-striped table-hover" style="cursor: pointer;">
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
@endsection