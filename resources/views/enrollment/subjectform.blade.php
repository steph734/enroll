@extends('layouts.app')

@section('styles')
<style>
    .card {
        position: sticky !important;
        top: 0 !important;
        border-radius: 1em !important;
        height: 100vh !important;
    }

    /* Add spacing between icon and text in dropdown items */
    .dropdown-item i {
        margin-right: 8px;
    }

    /* Debug section styling */
    .debug-section {
        background-color: #f8f9fa;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="subject-content">
    <!-- <div class="container"> -->
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
            <form action="{{ route('subject.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3 d-flex gap-2">
                    <div class="p-1">
                        <label for="track_id" class="form-label">Track</label><br>
                        <div class="dropdown">
                            <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false" id="trackDropdownBtn">
                                <i class="fa-solid fa-signs-post"></i> <span class="track-label">Select a
                                    Track</span>
                            </a>
                            <input type="hidden" name="track_id" id="track_id" value="{{ old('track_id') }}" required>
                            <ul class="dropdown-menu" id="trackDropdown">
                                @foreach($tracks as $track)
                                <li><a class="dropdown-item track-option" data-value="{{ $track->id }}" href="#">
                                        @php
                                        $icon = 'fa-question'; // Default icon
                                        $trackNameLower = strtolower($track->track_name);
                                        switch (true) {
                                        case str_contains($trackNameLower, 'academic'):
                                        $icon = 'fa-graduation-cap';
                                        break;
                                        case str_contains($trackNameLower, 'tvl'):
                                        $icon = 'fa-tools';
                                        break;
                                        case str_contains($trackNameLower, 'sports'):
                                        $icon = 'fa-basketball';
                                        break;
                                        case str_contains($trackNameLower, 'arts'):
                                        $icon = 'fa-brush';
                                        break;
                                        }
                                        @endphp
                                        <i class="fa-solid {{ $icon }}" aria-hidden="true"></i>
                                        {{ $track->track_name }}
                                    </a></li>
                                @endforeach
                            </ul>
                        </div>
                        @error('track_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="p-1">
                        <label for="strand_id" class="form-label">Strand</label><br>
                        <div class="dropdown">
                            <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false" id="strandDropdownBtn">
                                <i class="fa-solid fa-person"></i> <span class="strand-label">Select a Strand</span>
                            </a>
                            <input type="hidden" name="strand_id" id="strand_id" value="{{ old('strand_id') }}"
                                required>
                            <ul class="dropdown-menu" id="strandDropdown">
                                @foreach($strands as $strand)
                                <li><a class="dropdown-item strand-option" data-value="{{ $strand->id }}" href="#">
                                        @php
                                        $icon = 'fa-question'; // Default icon
                                        $strandNameLower = strtolower($strand->strand_name);
                                        switch (true) {
                                        case str_contains($strandNameLower, 'accountancy') ||
                                        str_contains($strandNameLower, 'abm'):
                                        $icon = 'fa-briefcase';
                                        break;
                                        case str_contains($strandNameLower, 'science') ||
                                        str_contains($strandNameLower, 'stem'):
                                        $icon = 'fa-flask';
                                        break;
                                        case str_contains($strandNameLower, 'humanities') ||
                                        str_contains($strandNameLower, 'humss'):
                                        $icon = 'fa-book';
                                        break;
                                        case str_contains($strandNameLower, 'general academic') ||
                                        str_contains($strandNameLower, 'gas'):
                                        $icon = 'fa-pencil';
                                        break;
                                        case str_contains($strandNameLower, 'agri-fishery'):
                                        $icon = 'fa-plate-heat';
                                        break;
                                        case str_contains($strandNameLower, 'home economics'):
                                        $icon = 'fa-house';
                                        break;
                                        case str_contains($strandNameLower, 'information') ||
                                        str_contains($strandNameLower, 'ict'):
                                        $icon = 'fa-laptop';
                                        break;
                                        case str_contains($strandNameLower, 'industrial arts'):
                                        $icon = 'fa-hammer';
                                        break;
                                        case str_contains($strandNameLower, 'sports'):
                                        $icon = 'fa-basketball';
                                        break;
                                        case str_contains($strandNameLower, 'arts'):
                                        $icon = 'fa-brush';
                                        break;
                                        }
                                        @endphp
                                        <i class="fa-solid {{ $icon }}" aria-hidden="true"></i>
                                        {{ $strand->strand_name }}
                                    </a></li>
                                @endforeach
                            </ul>
                        </div>
                        @error('strand_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="subject_code" class="form-label">Subject Code</label>
                    <input type="text" class="form-control p-1" id="subject_code" name="subject_code"
                        placeholder="Enter subject code" required>
                    @error('subject_code')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="subject_name" class="form-label">Subject Name</label>
                    <input type="text" class="form-control p-1" id="subject_name" name="subject_name"
                        placeholder="Enter subject name" required>
                    @error('subject_name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control p-1" id="description" name="description" rows="4"
                        placeholder="Enter subject description"></textarea>
                    @error('description')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary btn-sm p-1"><i class="fa-solid fa-floppy-disk"></i>
                        Save Subject</button>
                    <a href="{{ route('subject.index') }}" class="btn btn-outline-primary ms-2 btn-sm p-1">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <!-- </div> -->
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trackDropdownItems = document.querySelectorAll('.track-option');
        const strandDropdownItems = document.querySelectorAll('.strand-option');
        const trackHiddenInput = document.getElementById('track_id');
        const strandHiddenInput = document.getElementById('strand_id');
        const trackDropdownBtn = document.getElementById('trackDropdownBtn');
        const strandDropdownBtn = document.getElementById('strandDropdownBtn');
        const trackLabel = trackDropdownBtn.querySelector('.track-label');
        const strandLabel = strandDropdownBtn.querySelector('.strand-label');

        // Initialize the dropdown labels if there's an old value (e.g., after validation error)
        if (trackHiddenInput.value) {
            const selectedTrack = document.querySelector(`.track-option[data-value="${trackHiddenInput.value}"]`);
            if (selectedTrack) {
                trackLabel.textContent = selectedTrack.textContent.replace(/.*<\/i>/, '').trim();
            }
        }
        if (strandHiddenInput.value) {
            const selectedStrand = document.querySelector(
                `.strand-option[data-value="${strandHiddenInput.value}"]`);
            if (selectedStrand) {
                strandLabel.textContent = selectedStrand.textContent.replace(/.*<\/i>/, '').trim();
            }
        }

        // Handle track selection
        trackDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const value = this.getAttribute('data-value');
                const text = this.textContent.replace(/.*<\/i>/, '').trim();

                // Update the hidden input value
                trackHiddenInput.value = value;

                // Update the button label to show the selected track
                trackLabel.textContent = text;
            });
        });

        // Handle strand selection
        strandDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const value = this.getAttribute('data-value');
                const text = this.textContent.replace(/.*<\/i>/, '').trim();

                // Update the hidden input value
                strandHiddenInput.value = value;

                // Update the button label to show the selected strand
                strandLabel.textContent = text;
            });
        });
    });
</script>
@endsection
@endsection