@extends('layouts.app')
@section('title','students')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/teachers.css')}}">
@endsection
@section('content')

<div class="teachers-content">
    <div class="row mb-3">
        <div class="row">
            <div class="card p-3 card-header-teacher">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="card-title d-flex align-items-center">
                            <h5>List of Teachers</h5>
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
                            <button class="tab active">ALL Teachers</button>
                            <button class="tab">STEM</button>
                            <button class="tab">ABM</button>
                            <button class="tab">HUMMMS</button>
                        </div>

                        <!-- Dropdowns for Filter by and Sort by -->
                        <div class="dropdowns d-flex gap-2">
                            <select class="form-select" style="width: 150px;">
                                <option>Filter by</option>
                                <option value="department">Strand</option>
                                <option value="years">Years of Service</option>
                                <option value="status">Status</option>
                            </select>
                            <select class="form-select" style="width: 150px;">
                                <option>Sort by</option>
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                                <option value="years-asc">Years (Low to High)</option>
                                <option value="years-desc">Years (High to Low)</option>
                            </select>
                        </div>

                        <!-- Add Teacher Button -->
                        <a href="../layout/web-layout.php?page=teacher_form">
                            <button class="btn btn-primary add-teacher p-1 rounded-5">Add Teacher</button>
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
                                <th scope="col" class="align-middle">Strand</th>
                            </tr>
                        </thead>
                        <tbody d-flex align-items-center>
                            <tr>
                                <th scope="row" class="align-middle">1</th>
                                <td class="align-middle">Mark</td>
                                <td class="align-middle">Otto</td>
                                <td class="align-middle">STEM</td>
                            </tr>
                            <tr>
                                <th scope="row" class="align-middle">2</th>
                                <td class="align-middle">Jacob</td>
                                <td class="align-middle">Thornton</td>
                                <td class="align-middle">ABM</td>
                            </tr>
                            <tr>
                                <th scope="row" class="align-middle">3</th>
                                <td colspan="2" class="align-middle">Larry the Bird</td>
                                <td class="align-middle">HUMMMS</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection