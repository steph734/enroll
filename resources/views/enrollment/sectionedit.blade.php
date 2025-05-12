@extends('layouts.app')

@section('styles')
<style>
    .card {
        position: sticky !important;
        top: 0 !important;
        border-radius: 1em !important;
        min-height: 100vh !important;
    }

    .dropdown-item i {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="subject-content">
    <div class="card p-3">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h2>Edit Section</h2>
                <p style="font-size:14px; color:#555 !important;">
                    Easily edit an existing section. Update the section name, description,
                    and other details to manage your courses effectively.
                </p>
            </div>
        </div>
        <hr>

        @if ($errors->any())
        <div class="alert alert-danger p-1 mb-3">
            <i class="fa-solid fa-circle-exclamation"></i>
            <strong>Whoops!</strong> There were some problems with your input.
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('section.update', $section->id) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 d-flex gap-2">
                        <div class="p-1">
                            <label for="track_id" class="form-label">Track</label><br>
                            <div class="dropdown">
                                <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" id="trackDropdownBtn">
                                    <i class="fa-solid fa-signs-post"></i> <span class="track-label">Select a
                                        Track</span>
                                </a>
                                <input type="hidden" name="track_id" id="track_id"
                                    value="{{ old('track_id', $section->track_id) }}" required>
                                <ul class="dropdown-menu" id="trackDropdown">
                                    @foreach($tracks as $track)
                                    <li><a class="dropdown-item track-option" data-value="{{ $track->id }}" href="#">
                                            @php
                                            $icon = 'fa-question';
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
                                <a class="btn btn-outline-dark p-1 btn-sm" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" id="strandDropdownBtn">
                                    <i class="fa-solid fa-person"></i> <span class="strand-label">Select a Strand</span>
                                </a>
                                <input type="hidden" name="strand_id" id="strand_id"
                                    value="{{ old('strand_id', $section->strand_id) }}" required>
                                <ul class="dropdown-menu" id="strandDropdown">
                                    @foreach($strands as $strand)
                                    <li><a class="dropdown-item strand-option" data-value="{{ $strand->id }}" href="#">
                                            @php
                                            $icon = 'fa-question';
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
                                            $icon = 'fa-plate-wheat';
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
                        <label for="section_name" class="form-label">Section Name</label>
                        <input type="text" class="form-control p-1" id="section_name" name="section_name"
                            value="{{ old('section_name', $section->section_name) }}"
                            class="@error('section_name') is-invalid @enderror" required>
                        @error('section_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control p-1" id="description" name="description"
                            rows="4">{{ old('description', $section->description) }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="school_year" class="form-label">School Year (e.g., 2024-2025)</label>
                        <input type="text" class="form-control p-1" id="school_year" name="school_year"
                            value="{{ old('school_year', $section->school_year) }}"
                            class="@error('school_year') is-invalid @enderror" required>
                        @error('school_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="GradeLevel" class="form-label">Grade Level</label>
                        <select class="form-control p-1" name="GradeLevel" id="GradeLevel"
                            class="@error('GradeLevel') is-invalid @enderror" required>
                            <option value="" disabled {{ old('GradeLevel', $section->GradeLevel) ? '' : 'selected' }}>
                                Select Grade Level</option>
                            <option value="G11"
                                {{ old('GradeLevel', $section->GradeLevel) === 'G11' ? 'selected' : '' }}>Grade 11
                            </option>
                            <option value="G12"
                                {{ old('GradeLevel', $section->GradeLevel) === 'G12' ? 'selected' : '' }}>Grade 12
                            </option>
                        </select>
                        @error('GradeLevel')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control p-1" name="status" id="status"
                            class="@error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', $section->status) === 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive"
                                {{ old('status', $section->status) === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="adviser" class="form-label">Adviser (Optional)</label>
                        <input type="text" class="form-control p-1" id="adviser" name="adviser"
                            value="{{ old('adviser', $section->adviser) }}"
                            class="@error('adviser') is-invalid @enderror">
                        @error('adviser')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="room" class="form-label">Room (Optional)</label>
                        <input type="text" class="form-control p-1" id="room" name="room"
                            value="{{ old('room', $section->room) }}" class="@error('room') is-invalid @enderror">
                        @error('room')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="number" class="form-control p-1" id="capacity" name="capacity"
                            value="{{ old('capacity', $section->capacity) }}"
                            class="@error('capacity') is-invalid @enderror" required>
                        @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary btn-sm p-1"><i class="fa-solid fa-floppy-disk"></i>
                    Update Section</button>
                <a href="{{ route('section.index') }}" class="btn btn-outline-primary ms-2 btn-sm p-1">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

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
        const gradeLevelSelect = document.getElementById('GradeLevel');
        const form = document.querySelector('form');

        // Debug: Log initial values
        console.log('Initial track_id:', trackHiddenInput.value);
        console.log('Initial strand_id:', strandHiddenInput.value);
        console.log('Initial GradeLevel:', gradeLevelSelect.value);

        // Initialize the dropdown labels
        if (trackHiddenInput.value) {
            const selectedTrack = document.querySelector(`.track-option[data-value="${trackHiddenInput.value}"]`);
            if (selectedTrack) {
                trackLabel.textContent = selectedTrack.textContent.replace(/.*<\/i>/, '').trim();
            } else {
                console.warn('No track found for track_id:', trackHiddenInput.value);
            }
        }
        if (strandHiddenInput.value) {
            const selectedStrand = document.querySelector(
                `.strand-option[data-value="${strandHiddenInput.value}"]`);
            if (selectedStrand) {
                strandLabel.textContent = selectedStrand.textContent.replace(/.*<\/i>/, '').trim();
            } else {
                console.warn('No strand found for strand_id:', strandHiddenInput.value);
            }
        }

        // Handle track selection
        trackDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const value = this.getAttribute('data-value');
                const text = this.textContent.replace(/.*<\/i>/, '').trim();
                trackHiddenInput.value = value;
                trackLabel.textContent = text;
                console.log('Selected track_id:', value);
            });
        });

        // Handle strand selection
        strandDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const value = this.getAttribute('data-value');
                const text = this.textContent.replace(/.*<\/i>/, '').trim();
                strandHiddenInput.value = value;
                strandLabel.textContent = text;
                console.log('Selected strand_id:', value);
            });
        });

        // Validate GradeLevel on form submission
        form.addEventListener('submit', function(e) {
            if (!gradeLevelSelect.value) {
                e.preventDefault();
                gradeLevelSelect.classList.add('is-invalid');
                const errorDiv = gradeLevelSelect.nextElementSibling || document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = 'Please select a grade level.';
                gradeLevelSelect.parentNode.appendChild(errorDiv);
            }
        });
    });
</script>
@endsection