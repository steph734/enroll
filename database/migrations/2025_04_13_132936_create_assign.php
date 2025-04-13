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
        $assignments = Assign::all();
        $teachers = Teacher::all();
        $sections = Section::whereNotNull('sectioname')->whereNotNull('code')->get();
        $subjects = Subject::all();

        return view('assign.index', compact('assign'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher' => 'required|exists:teachers,id',
            'section' => 'required|exists:sections,id',
            'subject' => 'required|exists:subjects,id',
            'time' => 'required|exists:subjects,id',
        ]);

        // Fetch teacher details
        $teacher = Teacher::find($request->teacher);
        $section = Section::find($request->section);
        $subject = Subject::find($request->subject);
        $timeSubject = Subject::find($request->time); // Assuming time is tied to subject

        Assign::create([
            'teachername' => $teacher->first_name . ' ' . $teacher->last_name,
            'employmentstatus' => $teacher->teacher_id ?? 'N/A', // Adjust based on actual field
            'email' => $teacher->email,
            'section' => $section->sectioname . ' - ' . $section->code,
            'subject' => $subject->subjectname,
            'start_time' => $timeSubject->start_time,
            'end_time' => $timeSubject->end_time,
            'status' => 'ongoing', // Default status
        ]);

        return redirect()->route('assign.index')->with('success', 'Assignment created successfully.');
    }
}