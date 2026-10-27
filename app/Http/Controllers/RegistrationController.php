<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index() { $user = Auth::user(); $registrations = $user->hasRole('student') ? $user->student?->registrations()->with('course')->latest()->get() : ($user->hasRole('lecturer') ? Registration::whereHas('course', fn ($query) => $query->where('lecturer_id', $user->id))->with(['student.user', 'course'])->latest()->get() : Registration::with(['student.user', 'course'])->latest()->get()); return view('registrations.index', compact('registrations')); }
    public function create() { return view('registrations.form', ['courses' => Course::all(), 'students' => Student::with('user')->get()]); }
    public function store(Request $request)
    {
        $user = Auth::user(); $rules = ['course_id' => ['required', 'exists:courses,id']];
        if ($user->hasRole('student')) { $studentId = $user->student?->id; abort_unless($studentId, 403); } else { $rules['student_id'] = ['required', 'exists:students,id']; $studentId = $request->input('student_id'); }
        $data = $request->validate($rules);
        if (Registration::where(['student_id' => $studentId, 'course_id' => $data['course_id']])->exists()) return back()->withErrors(['course_id' => 'This student is already registered for that course.']);
        Registration::create(['student_id' => $studentId, 'course_id' => $data['course_id']]);
        return redirect()->route('registrations.index')->with('success', 'Registration created successfully.');
    }
    public function destroy(Registration $registration) { $registration->delete(); return back()->with('success', 'Registration removed.'); }
}
