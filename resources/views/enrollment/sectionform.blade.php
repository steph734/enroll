@extends('layouts.app')

@section('styles')
<style>
    .card {
        position: sticky !important;
        top: 0 !important;
        border-radius: 1em !important;
        min-height: 100vh !important;
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

    /* Note styling */
    .note {
        font-size: 12px;
        font-style: italic;
        color: #666;
        margin-top: 5px;
    }

    /* Hide strands that don't match the selected track */
    .dropdown-menu .hidden {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="subject-content">
    <div class="card p-3">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h2>Add New Section</h2>
                <p style="font-size:14px; color:#555 !important;">
                    Easily add a new section to your curriculum. Enter the section name,
                    description, and other details to organize your courses effectively.
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

        <form action="{{ route('section.store') }}" method="POST" class="mt-4">
            @csrf
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
                                <input type="hidden" name="track_id" id="track_id" value="{{ old('track_id') }}"
                                    required>
                                <ul class="dropdown-menu" id="trackDropdown">
                                    @php
                                    $trackGroups = [
                                    'Academic' => [],
                                    'TVL' => [],
                                    'Sports' => [],
                                    'Arts' => [],
                                    'Other' => [],
                                    ];

                                    foreach ($tracks as $track) {
                                    $trackNameLower = strtolower($track->track_name);
                                    if (str_contains($trackNameLower, 'academic')) {
                                    $trackGroups['Academic'][] = $track;
                                    } elseif (str_contains($trackNameLower, 'tvl')) {
                                    $trackGroups['TVL'][] = $track;
                                    } elseif (str_contains($trackNameLower, 'sports')) {
                                    $trackGroups['Sports'][] = $track;
                                    } elseif (str_contains($trackNameLower, 'arts')) {
                                    $trackGroups['Arts'][] = $track;
                                    } else {
                                    $trackGroups['Other'][] = $track;
                                    }
                                    }
                                    @endphp

                                    @foreach ($trackGroups as $groupName => $groupTracks)
                                    @if (!empty($groupTracks))
                                    <li>
                                        <h6 class="dropdown-header">{{ $groupName }}</h6>
                                    </li>
                                    @foreach ($groupTracks as $track)
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
                                    @endif
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
                                <input type="hidden" name="strand_id" id="strand_id" value="{{ old('strand_id') }}"
                                    required>
                                <ul class="dropdown-menu" id="strandDropdown">
                                    @php
                                    $strandGroups = [
                                    'Academic' => [],
                                    'TVL' => [],
                                    'Sports' => [],
                                    'Arts' => [],
                                    'Other' => [],
                                    ];

                                    foreach ($strands as $strand) {
                                    $strandNameLower = strtolower($strand->strand_name);
                                    if (str_contains($strandNameLower, 'accountancy') || str_contains($strandNameLower,
                                    'abm') ||
                                    str_contains($strandNameLower, 'science') || str_contains($strandNameLower, 'stem')
                                    ||
                                    str_contains($strandNameLower, 'humanities') || str_contains($strandNameLower,
                                    'humss') ||
                                    str_contains($strandNameLower, 'general academic') || str_contains($strandNameLower,
                                    'gas')) {
                                    $strandGroups['Academic'][] = $strand;
                                    } elseif (str_contains($strandNameLower, 'agri-fishery') ||
                                    str_contains($strandNameLower, 'home economics') ||
                                    str_contains($strandNameLower, 'information') || str_contains($strandNameLower,
                                    'ict') ||
                                    str_contains($strandNameLower, 'industrial arts')) {
                                    $strandGroups['TVL'][] = $strand;
                                    } elseif (str_contains($strandNameLower, 'sports')) {
                                    $strandGroups['Sports'][] = $strand;
                                    } elseif (str_contains($strandNameLower, 'arts')) {
                                    $strandGroups['Arts'][] = $strand;
                                    } else {
                                    $strandGroups['Other'][] = $strand;
                                    }
                                    }
                                    @endphp

                                    @foreach ($strandGroups as $groupName => $groupStrands)
                                    @if (!empty($groupStrands))
                                    <li class="strand-group" data-group="{{ $groupName }}">
                                        <h6 class="dropdown-header">{{ $groupName }}</h6>
                                    </li>
                                    @foreach ($groupStrands as $strand)
                                    <li class="strand-item" data-group="{{ $groupName }}"><a
                                            class="dropdown-item strand-option" data-value="{{ $strand->id }}" href="#">
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
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="note">Please select the strand that matches your track to avoid errors.</div>
                            @error('strand_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="section_name" class="form-label">Section Name</label>
                        <input type="text" class="form-control p-1" id="section_name" name="section_name"
                            value="{{ old('section_name') }}" class="@error('section_name') is-invalid @enderror"
                            required>
                        @error('section_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control p-1" id="description" name="description"
                            rows="4">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="school_year" class="form-label">School Year (e.g., 2024-2025)</label>
                        <input type="text" class="form-control p-1" id="school_year" name="school_year"
                            value="{{ old('school_year') }}" class="@error('school_year') is-invalid @enderror"
                            required>
                        @error('school_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Inside the <div class="col-md-6"> -->
                    <div class="mb-3">
                        <label for="GradeLevel" class="form-label">Grade Level</label>
                        <select class="form-control p-1" name="GradeLevel" id="GradeLevel"
                            class="@error('GradeLevel') is-invalid @enderror" required>
                            <option value="">Select Grade Level</option>
                            <option value="G11" {{ old('GradeLevel') === 'G11' ? 'selected' : '' }}>Grade 11</option>
                            <option value="G12" {{ old('GradeLevel') === 'G12' ? 'selected' : '' }}>Grade 12</option>
                        </select>
                        @error('GradeLevel')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control p-1" name="status" id="status"
                            class="@error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ old('status', 'active') === 'inactive' ? 'selected' : '' }}>
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
                            value="{{ old('adviser') }}" class="@error('adviser') is-invalid @enderror">
                        @error('adviser')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="room" class="form-label">Room (Optional)</label>
                        <input type="text" class="form-control p-1" id="room" name="room" value="{{ old('room') }}"
                            class="@error('room') is-invalid @enderror">
                        @error('room')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="number" class="form-control p-1" id="capacity" name="capacity"
                            value="{{ old('capacity', 50) }}" class="@error('capacity') is-invalid @enderror" required>
                        @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary btn-sm p-1"><i class="fa-solid fa-floppy-disk"></i>
                        Save Section</button>
                    <a href="{{ route('section.index') }}" class="btn btn-outline-primary ms-2 btn-sm p-1">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trackDropdownItems = document.querySelectorAll('.track-option');
        const strandDropdownItems = document.querySelectorAll('.strand-item');
        const strandGroups = document.querySelectorAll('.strand-group');
        const trackHiddenInput = document.getElementById('track_id');
        const strandHiddenInput = document.getElementById('strand_id');
        const trackDropdownBtn = document.getElementById('trackDropdownBtn');
        const strandDropdownBtn = document.getElementById('strandDropdownBtn');
        const trackLabel = trackDropdownBtn.querySelector('.track-label');
        const strandLabel = strandDropdownBtn.querySelector('.strand-label');

        // Function to filter strands based on selected track
        function filterStrands(selectedTrackGroup) {
            strandDropdownItems.forEach(item => {
                const itemGroup = item.getAttribute('data-group');
                if (selectedTrackGroup === 'Other' || itemGroup === selectedTrackGroup) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });

            strandGroups.forEach(group => {
                const groupName = group.getAttribute('data-group');
                const groupItems = Array.from(strandDropdownItems).filter(item => item.getAttribute(
                    'data-group') === groupName);
                const hasVisibleItems = groupItems.some(item => !item.classList.contains('hidden'));
                if (hasVisibleItems) {
                    group.classList.remove('hidden');
                } else {
                    group.classList.add('hidden');
                }
            });

            // Reset strand selection if the current strand is not in the filtered group
            const currentStrandGroup = strandDropdownItems.find(item => item.querySelector('.strand-option')
                .getAttribute('data-value') === strandHiddenInput.value)?.getAttribute('data-group');
            if (currentStrandGroup && currentStrandGroup !== selectedTrackGroup && selectedTrackGroup !== 'Other') {
                strandHiddenInput.value = '';
                strandLabel.textContent = 'Select a Strand';
            }
        }

        // Initialize the dropdown labels if there's an old value (e.g., after validation error)
        if (trackHiddenInput.value) {
            const selectedTrack = document.querySelector(`.track-option[data-value="${trackHiddenInput.value}"]`);
            if (selectedTrack) {
                trackLabel.textContent = selectedTrack.textContent.replace(/.*<\/i>/, '').trim();
                const trackText = selectedTrack.textContent.toLowerCase().trim();
                let trackGroup = 'Other';
                if (trackText.includes('academic')) trackGroup = 'Academic';
                else if (trackText.includes('tvl')) trackGroup = 'TVL';
                else if (trackText.includes('sports')) trackGroup = 'Sports';
                else if (trackText.includes('arts')) trackGroup = 'Arts';
                filterStrands(trackGroup);
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

                // Filter strands based on the selected track
                const trackText = text.toLowerCase();
                let trackGroup = 'Other';
                if (trackText.includes('academic')) trackGroup = 'Academic';
                else if (trackText.includes('tvl')) trackGroup = 'TVL';
                else if (trackText.includes('sports')) trackGroup = 'Sports';
                else if (trackText.includes('arts')) trackGroup = 'Arts';
                filterStrands(trackGroup);
            });
        });

        // Handle strand selection
        strandDropdownItems.forEach(item => {
            const strandOption = item.querySelector('.strand-option');
            strandOption.addEventListener('click', function(e) {
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