<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Schedule;
class ScheduleController extends Controller
{
   /**
     * Display the class schedule with filtering, sorting, and searching.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get query parameters
        $strand = $request->query('strand', 'ALL'); // Default to ALL
        $search = $request->query('search', '');
        $filter = $request->query('filter', '');
        $sort = $request->query('sort', '');

        // Build the query
        $query = Schedule::query();

        // Apply strand filter
        if ($strand !== 'ALL') {
            $query->where('strand', $strand);
        }

        // Apply search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('section', 'like', "%{$search}%")
                  ->orWhere('teachername', 'like', "%{$search}%")
                  ->orWhere('room', 'like', "%{$search}%");
            });
        }

        // Apply filters
        if ($filter === 'grade') {
            $query->orderBy('grade_level');
        } elseif ($filter === 'status') {
            $query->orderBy('status');
        } elseif ($filter === 'payment-date') {
            $query->orderBy('created_at'); // Adjust based on your schema
        }

        // Apply sorting
        if ($sort === 'name-asc') {
            $query->orderBy('subject', 'asc');
        } elseif ($sort === 'name-desc') {
            $query->orderBy('subject', 'desc');
        } elseif ($sort === 'amount-due-asc') {
            $query->orderBy('amount_due', 'asc'); // Adjust if you have this field
        } elseif ($sort === 'amount-due-desc') {
            $query->orderBy('amount_due', 'desc'); // Adjust if you have this field
        }

        // Fetch paginated results
        $schedules = $query->paginate(10); // Adjust pagination as needed

        // Pass data to the view
        return view('schedules.index', compact('schedules', 'strand', 'search', 'filter', 'sort'));
    }

    /**
     * Handle search suggestions for the autocomplete feature.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->query('q');

        // Fetch suggestions
        $schedules = Schedule::where('subject', 'like', "%{$query}%")
            ->orWhere('teachername', 'like', "%{$query}%")
            ->orWhere('section', 'like', "%{$query}%")
            ->orWhere('room', 'like', "%{$query}%")
            ->take(10)
            ->get(['subject', 'teachername', 'section', 'room']);

        // Return JSON response
        return response()->json($schedules);
    }

    /**
     * Show the form for editing a schedule.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified schedule in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'section' => 'required|string|max:50',
            'grade_level' => 'required|string|max:50',
            'day' => 'required|string|max:50',
            'semester' => 'required|string|max:50',
            'time' => 'required|string|max:50',
            'room' => 'required|string|max:50',
            'strand' => 'required|in:STEM,ABM,HUMMS',
            'status' => 'required|string|max:50',
            'teachername' => 'required|string|max:255',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified schedule from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
