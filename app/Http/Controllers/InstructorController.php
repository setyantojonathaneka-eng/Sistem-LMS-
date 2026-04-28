<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;

class InstructorController extends Controller
{
    public function index()
    {
        return view('instructor.dashboard');
    }
    public function myCourses()
    {

        $courses = Course::where('instructor_id', auth()->user()->id)->get();
        return view('instructor.courses', compact('courses'));
    }
}