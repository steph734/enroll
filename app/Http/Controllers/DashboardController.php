<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('enrollment.dashboard');
    }

    public function students()
    {
        return view('enrollment.students');
    }

    public function teachers()
    {
        return view('teachers');
    }

    public function subjectSection()
    {
        return view('subject-section');
    }

    public function subjects()
    {
        return view('subjects');
    }

    public function sections()
    {
        return view('sections');
    }

    public function payment()
    {
        return view('payment');
    }

    public function classSchedule()
    {
        return view('class_schedule');
    }

    public function reports()
    {
        return view('reports');
    }

    public function accounts()
    {
        return view('accounts');
    }

    public function enrollmentForm()
    {
        return view('enrollment_form');
    }

    public function teacherForm()
    {
        return view('teacher_form');
    }
}
