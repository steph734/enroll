@extends('layouts.app')
@section('content')

<div class="schedule-content">
    <!-- Header Section with Search -->
    <div class="mb-3 row">
        <div class="row">
            <div class="p-3 card card-header-payment">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="card-title d-flex align-items-center">
                            <div class="container">
                                <h2>Class Schedule</h2>
                                <p>First Semester Academic Year of 2024 - 2025</p>
                            </div>
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
                    <div class="mt-3 filters d-flex justify-content-between align-items-center">
                        <!-- Tabs for filtering by payment status -->
                        <div class="gap-3 tabs d-flex">
                            <button class="tab active">ALL Schedule</button>
                            <button class="tab">STEM</button>
                            <button class="tab">ABM</button>
                            <button class="tab">HUMMS</button>
                        </div>

                        <!-- Dropdowns for Filter by and Sort by -->
                        <div class="gap-2 dropdowns d-flex">
                            <select class="form-select" style="width: 150px;">
                                <option>Filter by</option>
                                <option value="grade">Grade & Section</option>
                                <option value="status">Status</option>
                                <option value="payment-date">Payment Date</option>
                            </select>
                            <select class="form-select" style="width: 150px;">
                                <option>Sort by</option>
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                                <option value="amount-due-asc">Amount Due (Low to High)</option>
                                <option value="amount-due-desc">Amount Due (High to Low)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Table -->
    <div class="mb-3 row">
        <div class="p-3 card card-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle">Subject</th>
                                <th scope="col" class="align-middle">Section</th>
                                <th scope="col" class="align-middle">Grade Level</th>
                                <th scope="col" class="align-middle">Day</th>
                                <th scope="col" class="align-middle">Semester</th>
                                <th scope="col" class="align-middle">Time</th>
                                <th scope="col" class="align-middle">Room</th>
                                <th scope="col" class="align-middle">Strand</th>
                                <th scope="col" class="align-middle">Status</th>
                                <th scope="col" class="align-middle">Teachername</th>
                                <th scope="col" class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection