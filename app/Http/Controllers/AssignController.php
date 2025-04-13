<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssignController extends Controller
{
    public function index()
    {
        $assign = Assign::all();
        return view('enrollment.subject-section', compact('assign'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'teacher' => 'required|exists:teachers,id',
                'section' => 'required|exists:sections,id',
                'subject' => 'required|exists:subjects,id',
                'time' => 'required',
                'status' => 'required|in:ongoing,completed,cancelled',
            ]);

            $teacher = Teacher::findOrFail($request->teacher);
            $section = Section::findOrFail($request->section);
            $subject = Subject::findOrFail($request->subject);

            [$start_time, $end_time] = explode(' - ', $request->time);

            $assignment = Assign::create([
                'teacher' => $teacher->first_name . ' ' . $teacher->last_name,
                'employmentstatus' => $teacher->employment_status ?? 'N/A',
                'email' => $teacher->email,
                'section' => $section->sectioname . ' - ' . $section->code,
                'subject' => $subject->subjectname,
                'start_time' => \Carbon\Carbon::parse($start_time)->format('H:i:s'),
                'end_time' => \Carbon\Carbon::parse($end_time)->format('H:i:s'),
                'status' => $request->status,
            ]);

            Log::info('Assignment created', ['id' => $assignment->id]);

            return redirect()->back()->with('success', 'Assignment created successfully.');
        } catch (\Exception $e) {
            Log::error('Error in store: ' . $e->getMessage());
            return back()->with('error', 'Failed to create assignment.');
        }
    }

    public function destroy($id)
    {
        try {
            $assign = Assign::findOrFail($id);
            $assign->delete();

            Log::info('Assignment deleted', ['id' => $id]);

            return redirect()->back()->with('success', 'Assignment removed successfully.');
        } catch (\Exception $e) {
            Log::error('Error in destroy: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete assignment.');
        }
    }
}