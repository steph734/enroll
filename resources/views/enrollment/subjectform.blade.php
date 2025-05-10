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
        position: sticky !important;
        top: 0 !important;
        border-radius: 1em !important;
        height: 100vh !important;
    }
</style>
@endsection

@section('content')
<div class="subject-content">
    <div class="container">
        <div class="card p-3">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <h2>Add New Subject</h2>
                    <p style="font-size:14px; color:#555 !important;">
                        Easily add a new subject to your curriculum. Enter the subject name,
                        description, and any relevant details to <br> organize your courses effectively.
                    </p>
                </div>
            </div>
            <hr>
            <div class="col-md-8">
                <form action="" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter subject name"
                            required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"
                            placeholder="Enter subject description" required></textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class=" mb-3 row">
                        <div class="col-md-4 p-1">
                            <label for="description" class="form-label">Track</label><br>
                            <select class="form-select w-100" aria-label="Select a track">
                                <option selected>Select a Track</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-md-4 p-1">
                            <label for="description" class="form-label">Strand</label><br>
                            <select class="form-select w-100" aria-label="Select a track">
                                <option selected>Select a Strand</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-md-4 p-1">
                            <label for="description" class="form-label">Grade Level</label><br>
                            <select class="form-select w-100" aria-label="Select a track">
                                <option selected>Grade Level</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>

                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary btn-sm p-1"><i class="fa-solid fa-floppy-disk"></i>
                            Save Subject</button>
                        <a href="{{ route('enrollment.show','subject-section') }}"
                            class="btn btn-outline-primary ms-2 btn-sm p-1">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection