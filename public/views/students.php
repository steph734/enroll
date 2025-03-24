<?php
?>
<link rel="stylesheet" href="../css/students.css">

<div class="students-content">
    <div class="row mb-3">
        <div class="row row-header-student">
            <div class="card p-3 card-header-student sticky-card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="card-title d-flex align-items-center">
                            <h5>List of Students</h5>
                            <form action="" id="searchForm" style="margin-left: 230px !important;">
                                <div class="search-container-dash">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" placeholder="Search..." id="searchInput">
                                    <!-- Suggestions dropdown -->
                                    <div id="suggestions"
                                        style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000;">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- Filters Section -->
                    <div class="filters d-flex justify-content-between align-items-center mt-3">
                        <!-- Tabs for filtering by category -->
                        <div class="tabs d-flex gap-3">
                            <button class="tab active">ALL Students</button>
                            <button class="tab">STEM</button>
                            <button class="tab">ABM</button>
                            <button class="tab">HUMMMS</button>
                        </div>

                        <!-- Dropdowns for Filter by and Sort by -->
                        <div class="dropdowns d-flex gap-2">
                            <select class="form-select" style="width: 150px;">
                                <option>Filter by</option>
                                <option value="grade">Grade</option>
                                <option value="age">Age</option>
                                <option value="status">Status</option>
                            </select>
                            <select class="form-select" style="width: 150px;">
                                <option>Sort by</option>
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                                <option value="grade-asc">Grade (Low to High)</option>
                                <option value="grade-desc">Grade (High to Low)</option>
                            </select>
                        </div>

                        <!-- Add Student Button -->
                        <a href="../layout/web-layout.php?page=enrollment_form">
                            <button class="btn btn-primary add-student">Add Student</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="card p-3 card-table ">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped ">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle">#</th>
                                <th scope="col" class="align-middle">First</th>
                                <th scope="col" class="align-middle">Last</th>
                                <th scope="col" class="align-middle">Handle</th>
                            </tr>
                        </thead>
                        <tbody d-flex align-items-center>
                            <tr>
                                <th scope="row" class="align-middle">1</th>
                                <td class="align-middle">Mark</td>
                                <td class="align-middle">Otto</td>
                                <td class="align-middle">@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row" class="align-middle">2</th>
                                <td class="align-middle">Jacob</td>
                                <td class="align-middle">Thornton</td>
                                <td class="align-middle">@fat</td>
                            </tr>
                            <tr>
                                <th scope="row" class="align-middle">3</th>
                                <td colspan="2" class="align-middle">Larry the Bird</td>
                                <td class="align-middle">@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>