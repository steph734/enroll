@extends('layouts.app')

@section('title', 'Subject and Section Assignment')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subject_section.css') }}">
@endsection

@section('content')

<div class="assignment-content">

    <p class="h4 mb-4" style="color: var(--text-clr) !important;">Subject and Section Management</->

        <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item m-1">
            <a class="nav-link active p-1" href="#assign" data-bs-toggle="tab">Assign</a>
        </li>
        <li class="nav-item m-1">
            <a class="nav-link p-1" href="#section" data-bs-toggle="tab">Section</a>
        </li>
        <li class="nav-item m-1">
            <a class="nav-link p-1  " href="#subject" data-bs-toggle="tab">Subject</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Assign Tab -->

        <div class="tab-pane fade show active" id="assign">
            <div class="card mb-4 p-3">
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-3 p-1 profile d-flex justify-content-center">
                                <i class="fa-solid fa-image" style="font-size: 100px; color:gray;"></i>
                            </div>
                            <div class="col-md-9 p-1 d-flex ">
                                <div class="col-md-4 p-1">
                                    <label class="form-label mb-1">Teacher</label>
                                    <select class="form-select" name="teacher">
                                        <option value="">Select a teacher</option>
                                        @forelse(\App\Models\Teacher::all() as $teacher)
                                            <option value="{{ $teacher->id }}"
                                                data-id="{{ $teacher->teacher_id }}"
                                                data-email="{{ $teacher->email }}">
                                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                                            </option>
                                        @empty
                                            <option value="">No teachers available</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-4 p-1">
                                    <label class="form-label mb-1">ID</label>
                                    <input type="text" class="form-control" name="id" placeholder="ID" readonly>
                                </div>
                                <div class="col-md-4 m-1">
                                    <label class="form-label mb-1">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3 mt-1 d-flex justify-content-center">
                            <div class="col-md-4 p-1">
                                <label class="form-label mb-1">Section</label>
                                <select class="form-select" name="section">
                                    <option value="STEM-A1">STEM-A1</option>
                                    <option value="HUMSS 11-C">HUMSS 11-C</option>
                                </select>
                            </div>
                            <div class="col-md-4 p-1">
                                <label class="form-label mb-1">Subject</label>
                                <select class="form-select" name="subject">
                                    <option value="Biology">Biology</option>
                                    <option value="Gen Math">Gen Math</option>
                                    <option value="English">English</option>
                                </select>
                            </div>
                            <div class="col-md-4 p-1">
                                <label class="form-label mb-1">Time</label>
                                <select class="form-select" name="time">
                                    <option value="8:00 AM - 9:00 AM">8:00 AM - 9:00 AM</option>
                                    <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                                    <option value="10:00 AM - 12:00 PM">10:00 AM - 12:00 PM</option>
                                </select>
                            </div>
                            <div class="col-md-2 m-1">
                                <button type="button" class="btn btn-outline-secondary w-100"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center gap-1">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">Assign</button>
                            </div>
                            <div class="col-md-3">
                                <button type="reset" class="btn btn-outline-secondary w-100">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card p-3">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="search-container">
                            <input type="text" id="assignmentSearch" class="p-1 form-control w-100"
                                placeholder="Search here...">
                        </div>
                        <div class="filter-container">
                            <select class="form-select" style="width: 150px;">
                                <option>Filter by</option>
                                <option value="teacher">Teacher</option>
                                <option value="subject">Subject</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>Teacher</th>
                                    <th>Subject Name</th>
                                    <th>Grade Level</th>
                                    <th>Section</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="assignmentTable">
                                <tr class="assignment-row">
                                    <td>Eli Sorono</td>
                                    <td>Gen Math</td>
                                    <td>Grade 11</td>
                                    <td>STEM-A1</td>
                                    <td>8:00 AM - 9:00 AM</td>
                                    <td><span class="p-1 badge bg-blue">Ongoing</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                                        <button class="btn btn-sm btn-danger remove-btn">Remove</button>
                                    </td>
                                </tr>
                                <tr class="assignment-row">
                                    <td>Eli Sorono</td>
                                    <td>Biology</td>
                                    <td>Grade 11</td>
                                    <td>STEM-A1</td>
                                    <td>10:00 AM - 12:00 PM</td>
                                    <td><span class="p-1 badge bg-blue">Ongoing</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                                        <button class="btn btn-sm btn-danger remove-btn">Remove</button>
                                    </td>
                                </tr>
                                <tr class="assignment-row">
                                    <td>Eli Sorono</td>
                                    <td>Biology</td>
                                    <td>Grade 11</td>
                                    <td>STEM-A1</td>
                                    <td>9:00 AM - 10:00 AM</td>
                                    <td><span class="p-1 badge bg-blue">Canceled</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                                        <button class="btn btn-sm btn-danger remove-btn">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Tab (Retained from Original) -->

        <div class="tab-pane fade" id="section">
            <div class="card p-3">
                <div class="card-body">
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
                                <th>Slot</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="sectionTable">
                            <tr class="section-row">
                                <td>STEM-A1</td>
                                <td>Grade 11</td>
                                <td>STEM</td>
                                <td><span class="p-1 badge bg-blue">Full</span></td>
                                <td class="text-center"><i class="fa fa-eye"></i></td>
                            </tr>
                            <tr class="section-row">
                                <td>HUMSS 11-C</td>
                                <td>Grade 11</td>
                                <td>HUMSS</td>
                                <td><span class="p-1 badge bg-blue">38/40</span></td>
                                <td class="text-center"><i class="fa fa-eye"></i></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Subject Tab (Retained from Original) -->
        <div class="tab-pane fade" id="subject">
            <div class="card p-3">
                <div class="card-body">
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
                                        <i class="fa fa-eye"></i>

                                    </td>
                                </tr>
                                <tr class="subject-row">
                                    <td>English</td>
                                    <td>Grade 11</td>
                                    <td>HUMSS</td>
                                    <td>
                                        <i class="fa fa-eye"></i>
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

<script>



// Search functionality for assignments
const assignmentSearch = document.getElementById('assignmentSearch');
const assignmentRows = document.querySelectorAll('.assignment-row');

assignmentSearch.addEventListener('input', () => {
    const searchTerm = assignmentSearch.value.toLowerCase();
    assignmentRows.forEach(row => {
        const teacher = row.cells[0].textContent.toLowerCase();
        const subject = row.cells[1].textContent.toLowerCase();
        const gradeLevel = row.cells[2].textContent.toLowerCase();
        const section = row.cells[3].textContent.toLowerCase();
        if (teacher.includes(searchTerm) || subject.includes(searchTerm) || gradeLevel.includes(
                searchTerm) || section.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

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