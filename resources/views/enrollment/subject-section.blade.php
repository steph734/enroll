@extends('layouts.app')
@section('styles')
<style>
    .subject-content {
        margin: 10px !important;
    }

    .card-table {
        min-height: 100vh !important;
        border: 1px solid var(--line-clr) !important;
        border-radius: 1em !important;
        box-shadow: 1px 7px 5px 0px rgba(0, 0, 0, 0.26);
        -webkit-box-shadow: 1px 7px 5px 0px rgba(0, 0, 0, 0.26);
        -moz-box-shadow: 1px 7px 5px 0px rgba(0, 0, 0, 0.26);
    }

    .card {
        /* border: 1px solid var(--line-clr) !important; */
        position: sticky !important;
        top: 0 !important;
        border-radius: 1em 1em !important;
        height: 100vh !important;
        /* box-shadow: 1px 7px 5px 0px rgba(0, 0, 0, 0.26);
    -webkit-box-shadow: 1px 7px 5px 0px rgba(0, 0, 0, 0.26);
    -moz-box-shadow: 1px 7px 5px 0px rgba(0, 0, 0, 0.26); */
    }

    .search-container-dash {
        /* margin-top: 10px !important; */
        position: relative !important;
    }

    .search-container-dash input {
        width: 300px !important;
        height: 40px !important;
        font-size: 16px !important;
        padding: 10px 20px 10px 40px !important;
        border-radius: 30px !important;
        border: 1px solid var(--line-clr) !important;
    }

    .search-container-dash i {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #bbc0c9 !important;
        font-size: 18px;
        pointer-events: none;
    }

    td {
        cursor: pointer;
    }

    tr {
        height: 50px !important;
    }

    th {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #333 !important;
        border-bottom: 2px solid #e0e0e0 !important;
        padding: 10px !important;
    }

    td {
        font-size: 14px !important;
        padding: 10px !important;
    }
</style>
@endsection
@section('content')
<div class="subject-content">
    <div class="container">
        <div class="d-flex justify-content-between mb-1">
            <div>
                <h2>List of Subjects</h2>
                <p style="font-size:18px; color:#555 !important;">For 1st Semester, Class of 2024-2025</p>
            </div>
            <div>
                <button class="btn-sm btn-primary p-1 text-primary" style="font-size: 14px !important;"><i
                        class="fa-solid fa-book"></i>
                    Subjects</button>
                <button class="btn-sm btn-dark p-1 " style="font-size: 14px !important;"><i
                        class="fa-solid fa-school"></i>
                    Sections</button>
            </div>
        </div>

        <div class="card p-3">
            <div class="d-flex justify-content-between">
                <div class="d-flex gap-2">
                    <a href="{{ route('enrollment.show', 'subjectform') }}">
                        <button class="btn btn-primary p-1"
                            style="font-size: 14px !important; text-decoration: none !important;"><i
                                class="fa fa-solid fa-plus"></i> Add Subject</button>
                    </a>
                    <div class="dropdown">
                        <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-filter"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <form action="" id="searchForm">
                        <div class="search-container-dash">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Search..." id="searchInput" class="form-control">
                            <div id="suggestions"
                                style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000;">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-2 gap-2">


            </div>
            <hr>
            <table class="table mt-3 table-responsive table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col p-1  text-center align-middle">Subject Code</th>
                        <th scope="col p-1  text-center align-middle">Subject Name</th>
                        <th scope="col p-1  text-center align-middle">Description</th>
                        <th scope="col p-1  text-center align-middle">Strand</th>
                        <th scope="col p-1  text-center align-middle">Track</th>
                        <th scope="col p-1  text-center align-middle">Status</th>
                        <th scope="col p-1  text-center align-middle">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row">1</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>STEM</td>
                        <td>Active</td>
                        <td>
                            <button class="btn text-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn text-danger"><i class="fa-solid fa-ban"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">2</td>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td>ABM</td>
                        <td>Inactive</td>
                        <td>
                            <button class="btn text-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn text-danger"><i class="fa-solid fa-ban"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">3</td>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                        <td>HUMMS</td>
                        <td>Active</td>
                        <td>
                            <button class="btn text-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn text-danger"><i class="fa-solid fa-ban"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">4</td>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td>ABM</td>
                        <td>Inactive</td>
                        <td>
                            <button class="btn text-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn text-danger"><i class="fa-solid fa-ban"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">5</td>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                        <td>HUMMS</td>
                        <td>Active</td>
                        <td>
                            <button class="btn text-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn text-danger"><i class="fa-solid fa-ban"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection