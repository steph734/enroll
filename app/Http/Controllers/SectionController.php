<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Strands;
use App\Models\Tracks;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $strand = $request->query('strand');
        $sort = $request->query('sort');
        $search = $request->query('search');

        $strands = Strands::pluck('strand_name', 'id')->all();

        $query = Section::with(['strand', 'track']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('section_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('school_year', 'like', "%{$search}%")
                    ->orWhere('GradeLevel', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('adviser', 'like', "%{$search}%")
                    ->orWhere('room', 'like', "%{$search}%");
            });
        }

        if ($strand) {
            $fullStrandName = collect($strands)->filter(function ($name) use ($strand) {
                return str_contains(strtolower($name), strtolower($strand));
            })->first();

            if ($fullStrandName) {
                $query->whereHas('strand', function ($q) use ($fullStrandName) {
                    $q->where('strand_name', $fullStrandName);
                });
            }
        }

        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'a-z':
                $query->orderBy('section_name', 'asc');
                break;
            case 'z-a':
                $query->orderBy('section_name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $sections = $query->get();

        $activePage = 'subject-section';

        return view('enrollment.section', compact('sections', 'strand', 'sort', 'strands', 'search', 'activePage'));
    }

    public function create()
    {
        $tracks = Tracks::all();
        $strands = Strands::all();
        $activePage = 'subject-section';
        return view('enrollment.sectionform', compact('tracks', 'strands', 'activePage'));
    }

    public function edit($id)
    {
        $section = Section::findOrFail($id);
        $tracks = Tracks::all();
        $strands = Strands::all();
        $activePage = 'subject-section';
        return view('enrollment.sectionedit', compact('section', 'tracks', 'strands', 'activePage'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'section_name' => 'required|string|max:255|unique:sections,section_name',
            'description' => 'nullable|string|max:1000',
            'track_id' => 'required|exists:tracks,id',
            'strand_id' => 'required|exists:strands,id',
            'school_year' => 'nullable|string|max:9', // e.g., "2024-2025"
            'GradeLevel' => 'required|in:G11,G12', // Restrict to G11 or G12
            'status' => 'required|in:active,inactive',
            'adviser' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:50',
            'capacity' => 'required|integer|min:1|max:50',
        ]);

        // Retrieve the selected track and strand
        $track = Tracks::findOrFail($validatedData['track_id']);
        $strand = Strands::findOrFail($validatedData['strand_id']);

        $trackNameLower = strtolower($track->track_name);
        $strandNameLower = strtolower($strand->strand_name);

        // Define compatibility rules
        $isAcademicTrack = str_contains($trackNameLower, 'academic');
        $isTVLTrack = str_contains($trackNameLower, 'tvl');
        $isSportsTrack = str_contains($trackNameLower, 'sports');
        $isArtsTrack = str_contains($trackNameLower, 'arts');

        $isAcademicStrand = str_contains($strandNameLower, 'accountancy') || str_contains($strandNameLower, 'abm') ||
            str_contains($strandNameLower, 'science') || str_contains($strandNameLower, 'stem') ||
            str_contains($strandNameLower, 'humanities') || str_contains($strandNameLower, 'humss') ||
            str_contains($strandNameLower, 'general academic') || str_contains($strandNameLower, 'gas');
        $isTVLStrand = str_contains($strandNameLower, 'agri-fishery') || str_contains($strandNameLower, 'home economics') ||
            str_contains($strandNameLower, 'information') || str_contains($strandNameLower, 'ict') ||
            str_contains($strandNameLower, 'industrial arts');
        $isSportsStrand = str_contains($strandNameLower, 'sports');
        $isArtsStrand = str_contains($strandNameLower, 'arts');

        // Validate track-strand compatibility
        if ($isAcademicTrack && !$isAcademicStrand) {
            return back()->withErrors(['strand_id' => 'The selected strand does not match the Academic track.'])->withInput();
        } elseif ($isTVLTrack && !$isTVLStrand) {
            return back()->withErrors(['strand_id' => 'The selected strand does not match the TVL track.'])->withInput();
        } elseif ($isSportsTrack && !$isSportsStrand) {
            return back()->withErrors(['strand_id' => 'The selected strand does not match the Sports track.'])->withInput();
        } elseif ($isArtsTrack && !$isArtsStrand) {
            return back()->withErrors(['strand_id' => 'The selected strand does not match the Arts track.'])->withInput();
        }

        // Create the section if validation passes
        Section::create($validatedData);

        return redirect()->route('section.index')->with('success', value: 'Section created successfully.');
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        $validatedData = $request->validate([
            'section_name' => 'required|string|max:255|unique:sections,section_name,' . $section->id,
            'description' => 'nullable|string|max:1000',
            'track_id' => 'required|exists:tracks,id',
            'strand_id' => 'required|exists:strands,id',
            'school_year' => 'nullable|string|max:9', // e.g., "2024-2025"
            'GradeLevel' => 'required|in:G11,G12', // Restrict to G11 or G12
            'status' => 'required|in:active,inactive',
            'adviser' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:50',
            'capacity' => 'required|integer|min:1|max:50',
        ]);

        $section->update($validatedData);
        return redirect()->route('section.index')->with('success', 'Section updated successfully.');
    }
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->route('section.index')->with('success', 'Section deleted successfully.');
    }
}
