<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Strands;
use Illuminate\Http\Request;

class SubjectManageController extends Controller
{
    public function index(Request $request)
    {
        $activePage = 'subject-section';
        $students = Student::with('strand')->get();
        $subjects = Subject::with('strand')->get();
        $teachers = Teacher::all();
        $strands = Strands::pluck('strand_name', 'id');
        $specializations = Teacher::select('specialization')->distinct()->whereNotNull('specialization')->pluck('specialization');
        $strand = $request->input('strand', '');
        $gradeLevel = $request->input('grade_level', '');
        $specialization = $request->input('specialization', '');

        return view('enrollment.subjectmanage', compact('activePage', 'students', 'subjects', 'teachers', 'strands', 'specializations', 'strand', 'gradeLevel', 'specialization'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'subject_ids' => 'required|array',
        ]);

        foreach ($request->student_ids as $studentId) {
            foreach ($request->subject_ids as $subjectId) {
                \App\Models\StudentSubject::firstOrCreate([
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'school_year' => date('Y') . '-' . (date('Y') + 1), // Default to current school year
                    'status' => 'enrolled',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Subjects assigned to students successfully.');
    }

    public function assignTeacher(Request $request)
    {
        $request->validate([
            'teacher_ids' => 'required|array',
            'subject_ids' => 'required|array',
        ]);

        foreach ($request->teacher_ids as $teacherId) {
            foreach ($request->subject_ids as $subjectId) {
                \App\Models\TeacherSubject::firstOrCreate([
                    'teacher_id' => $teacherId,
                    'subject_id' => $subjectId,
                    'school_year' => date('Y') . '-' . (date('Y') + 1), // Default to current school year
                    'status' => 'assigned',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Subjects assigned to teachers successfully.');
    }
}
