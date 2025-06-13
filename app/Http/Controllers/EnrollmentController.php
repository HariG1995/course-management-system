<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course'])->latest()->get();
        return view('pages.view_enrollments', compact('enrollments'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        if ($course->students()->where('student_id', $request->student_id)->exists()) {
            return back()->with('error', 'Student is already enrolled in this course!');
        }

        $course->students()->attach($request->student_id, [
            'enrolled_at' => now()
        ]);

        return back()->with('success', 'Student enrolled successfully!');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return back()->with('success', 'Enrollment removed successfully!');
    }
}
