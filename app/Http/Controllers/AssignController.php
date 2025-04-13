<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class AssignController extends Controller
{
    public function index()
    {
        $assignments = Assign::all(); // Fetch all assignments
        $teachers = Teacher::all();
        $sections = Section::whereNotNull('sectioname')->whereNotNull('code')->get();
        $subjects = Subject::all();
        return view('enrollment.subject-section', compact('assignments', 'teachers', 'sections', 'subjects'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $sections = Section::whereNotNull('sectioname')->whereNotNull('code')->get();
        $subjects = Subject::all();
        $assignments = Assign::all();
        return view('enrollment.subject-section', compact('teachers', 'section', 'subjects', 'assign'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'assignments' => 'required|array',
            'assignments.*.section_id' => 'required|exists:sections,id',
            'assignments.*.subject_id' => 'required|exists:subjects,id',
            'assignments.*.time_id' => 'required|exists:subjects,id',
        ]);

        $teacher = Teacher::findOrFail($request->teacher_id);

        foreach ($request->assignments as $assignment) {
            $section = Section::findOrFail($assignment['section_id']);
            $subject = Subject::findOrFail($assignment['subject_id']);
            $timeSubject = Subject::findOrFail($assignment['time_id']);

            Assign::create([
                'teachername' => $teacher->first_name . ' ' . $teacher->last_name,
                'employmentstatus' => $teacher->employment_status,
                'email' => $teacher->email,
                'section' => $section->sectioname . ' - ' . $section->code,
                'subject' => $subject->subjectname,
                'start_time' => $timeSubject->start_time,
                'end_time' => $timeSubject->end_time,
                'status' => 'ongoing', // Default status
            ]);
        }

        return redirect()->route('assign.create')->with('success', 'Assignment registered successfully');
    }

    public function destroy($id)
    {
        $assignment = Assign::findOrFail($id);
        $assignment->delete();

        return redirect()->route('assign.index')->with('success', 'Assignment deleted successfully');
    }
}