<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\SectionLine;
use App\Models\Student;
use App\Models\Tracks;
use App\Models\Strands;

class SectionLineController extends Controller
{
    public function index($sectionId)
    {
        // Fetch the section with its strand, track, and section lines (students)
        $section = Section::with(['strand', 'track', 'sectionLines.student', 'sectionLines.strand', 'sectionLines.track'])
            ->findOrFail($sectionId);

        // Fetch available students who belong to the section's strand and are not already assigned
        $availableStudents = Student::where('strand_id', $section->strand_id)
            ->whereNotIn('id', $section->sectionLines->pluck('student_id'))
            ->with('strand')
            ->get();

        $tracks = Tracks::all();
        $strands = Strands::all();
        $activePage = 'subject-section'; // Adjust based on your navigation

        return view('enrollment.managesection', compact('section', 'tracks', 'strands', 'availableStudents', 'activePage'));
    }

    public function store(Request $request, $sectionId)
    {
        $section = Section::findOrFail($sectionId);

        $validatedData = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $errors = [];
        foreach ($validatedData['student_ids'] as $studentId) {
            $student = Student::findOrFail($studentId);

            // Verify the student belongs to the section's strand
            if ($student->strand_id !== $section->strand_id) {
                $errors[] = "Student {$student->first_name} {$student->last_name} does not belong to the section's strand.";
                continue;
            }

            // Check section capacity
            if ($section->sectionLines()->count() >= $section->capacity) {
                $errors[] = "The section has reached its capacity. Cannot add {$student->first_name} {$student->last_name}.";
                break;
            }

            // Create sectionline record
            SectionLine::create([
                'section_id' => $section->id,
                'student_id' => $student->id,
                'strand_id' => $section->strand_id,
                'track_id' => $section->track_id,
            ]);
        }

        if (!empty($errors)) {
            return back()->withErrors($errors);
        }

        return redirect()->route('sectionline.index', $section->id)
            ->with('success', 'Students added to section successfully.');
    }

    public function destroy($sectionLineId)
    {
        $sectionLine = SectionLine::findOrFail($sectionLineId);
        $sectionId = $sectionLine->section_id;
        $sectionLine->delete();

        return redirect()->route('sectionline.index', $sectionId)
            ->with('success', 'Student removed from section successfully.');
    }
}
