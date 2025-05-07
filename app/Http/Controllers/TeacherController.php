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
        return view('enrollment.teachers', compact('teachers'));
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
        $validated = $request->validate([
            'employee_id' => 'required|string|max:255|unique:teachers,employee_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'date_of_birth' => 'required|date',
            'age' => 'required|integer|min:20',
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
            'specialization' => 'required|string', // Adjust based on Strand model
            'previous_school' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'employment_status' => 'required|in:Full-time,Part-time',
            'teaching_schedule' => 'required|in:Morning,Afternoon,Evening',
            'subjects' => 'required|string',
            'certifications' => 'nullable|string',
            'medical_info' => 'nullable|string',
            'accommodations' => 'nullable|string',
            'date_hired' => 'required|date',
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
        $teacher = Teacher::create([
            'employee_id' => $request->employee_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'age' => $request->age,
            'gender' => $request->gender,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'degree' => $request->degree,
            'major' => $request->major,
            'university' => $request->university,
            'year_graduated' => $request->year_graduated,
            'prc_license' => $request->prc_license,
            'license_validity' => $request->license_validity,
            'let_date' => $request->let_date,
            'specialization' => $request->specialization,
            'previous_school' => $request->previous_school,
            'position' => $request->position,
            'years_experience' => $request->years_experience,
            'employment_status' => $request->employment_status,
            'teaching_schedule' => $request->teaching_schedule,
            'subjects' => $request->subjects,
            'certifications' => $request->certifications,
            'medical_info' => $request->medical_info,
            'accommodations' => $request->accommodations,
            'date_hired' => $request->date_hired,
            'profile_picture' => $paths['profile_picture'] ?? null,
            'prc_copy' => $paths['prc_copy'],
            'resume' => $paths['resume'],
            'transcript' => $paths['transcript'],
        ]);

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
