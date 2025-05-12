<?php

namespace App\Http\Controllers;

use App\Models\Strands;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $strands = Strands::all()->pluck('strand_name', 'id')->toArray();
        $search = $request->query('search');
        $strand = $request->query('strand');
        $sort = $request->query('sort', 'newest');

        $query = Schedule::query()->with('strand');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($strand) {
            $query->whereHas('strand', function ($q) use ($strand) {
                $q->where('strand_name', 'like', "%{$strand}%");
            });
        }

        switch ($sort) {
            case 'a-z':
                $query->orderBy('title', 'asc');
                break;
            case 'z-a':
                $query->orderBy('title', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $schedules = $query->paginate(10)->appends($request->query());
        $activePage = 'schedule';
        return view('enrollment.schedule', compact('schedules', 'strands', 'search', 'strand', 'sort', 'activePage'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $strands = Strands::all();
        $teachers = Teacher::all();
        $sections = Section::all();
        $activePage = 'schedule';
        return view('enrollment.schedulecreate', compact('sections', 'teachers', 'subjects', 'strands', 'activePage'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|exists:subjects,subject_code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section' => 'required|string|exists:sections,section_name',
            'days' => 'required|string|regex:/^[MTWThFS]+$/',
            'term' => 'required|string|in:1st Term,2nd Term,3rd Term,4th Term',
            'time' => 'required|string',
            'room' => 'required|string',
            'teacher_id' => 'nullable|exists:teachers,id', // Changed to teacher_id
            'strand_id' => 'required|exists:strands,id',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Schedule::create($request->all());

        return redirect()->route('schedule.index')->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        $subjects = Subject::all();
        $strands = Strands::all();
        $teachers = Teacher::all();
        $sections = Section::all();
        $activePage = 'schedule';
        return view('enrollment.scheduleedit', compact(
            'schedule',
            'subjects',
            'strands',
            'teachers',
            'sections',
            'activePage'
        ));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|exists:subjects,subject_code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section' => 'required|string|exists:sections,section_name',
            'days' => 'required|string|regex:/^[MTWThFS]+$/',
            'term' => 'required|string|in:1st Term,2nd Term,3rd Term,4th Term',
            'time' => 'required|string',
            'room' => 'required|string',
            'teacher_id' => 'nullable|exists:teachers,id', // Changed to teacher_id
            'strand_id' => 'required|exists:strands,id',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $schedule->update($request->all());

        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedule.index')->with('success', 'Schedule deleted successfully.');
    }
}
