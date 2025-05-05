<?php


namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{

    public function index()
    {
        $teacher = Teacher::all(); // Fetch all teachers from the database
        return view('enrollment.teachers', compact('teacher'));
    }

    public function create()
    {
        return view('enrollment.teacher_form');
    }


    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully');
    }

    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'profile_picture' => 'nullable|image|max:2048',
            'prc_copy' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'transcript' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle file uploads
        $paths = [];
        if ($request->hasFile('profile_picture')) {
            $paths['profile_picture'] = $request->file('profile_picture')->store('public/teachers/profiles');
        }
        $paths['prc_copy'] = $request->file('prc_copy')->store('public/teachers/documents');
        $paths['resume'] = $request->file('resume')->store('public/teachers/documents');
        $paths['transcript'] = $request->file('transcript')->store('public/teachers/documents');

        // Create teacher record
        $teacher = Teacher::create(array_merge(
            $request->all(),
            $paths
        ));

        return redirect()->route('teachers.index')->with('success', 'Teacher registered successfully');
    }


    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('enrollment.edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'age' => 'required|integer|min:1',
            'specialization' => 'required|in:Academic,TVL,Sports,Arts',
            'employment_status' => 'required|in:Full-time,Part-time',
            'subjects' => 'required|string',
            'profile_picture' => 'nullable|image|max:2048',
            'middle_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'degree' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'university' => 'required|string|max:255',
            'year_graduated' => 'required|string|max:4',
            'prc_license' => 'required|string|max:255',
            'license_validity' => 'required|date',
            'let_date' => 'required|date',
            'prc_copy' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'previous_school' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'teaching_schedule' => 'required|in:Morning,Afternoon,Evening',
            'certifications' => 'nullable|string',
            'medical_info' => 'nullable|string',
            'accommodations' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'transcript' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'date_hired' => 'required|date',
            'employee_id' => 'required|string|max:255',
        ]);

        $teacher = Teacher::findOrFail($id);

        // Handle file uploads
        if ($request->hasFile('profile_picture')) {
            if ($teacher->profile_picture) {
                Storage::disk('public')->delete($teacher->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('teachers', 'public');
        }
        if ($request->hasFile('prc_copy')) {
            if ($teacher->prc_copy) {
                Storage::disk('public')->delete($teacher->prc_copy);
            }
            $validated['prc_copy'] = $request->file('prc_copy')->store('teachers', 'public');
        }
        if ($request->hasFile('resume')) {
            if ($teacher->resume) {
                Storage::disk('public')->delete($teacher->resume);
            }
            $validated['resume'] = $request->file('resume')->store('teachers', 'public');
        }
        if ($request->hasFile('transcript')) {
            if ($teacher->transcript) {
                Storage::disk('public')->delete($teacher->transcript);
            }
            $validated['transcript'] = $request->file('transcript')->store('teachers', 'public');
        }

        $teacher->update($validated);
        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }
}
