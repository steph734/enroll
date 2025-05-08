<?php

namespace App\Http\Controllers;

use App\Models\Tracks;
use App\Models\Strands;
use Illuminate\Http\Request;

class TrackStrandController extends Controller
{
    // Fetch all tracks for the enrollment form
    public function getTracks()
    {
        $tracks = Tracks::all();
        return view('enrollment-form', compact('tracks')); // Your Blade view
    }

    // Fetch strands for a given track_id via AJAX
    public function getStrands(Request $request)
    {
        $trackId = $request->input('track_id');
        $strands = Strands::where('track_id', $trackId)->get(['id', 'strand_name']);
        return response()->json($strands);
    }
}
