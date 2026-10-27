<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;

class CourseController extends Controller
{
    public function index() { return view('courses.index', ['courses' => Course::with('lecturer')->latest()->paginate(10)]); }
    public function create() { return view('courses.form', ['course' => new Course(), 'lecturers' => User::role('lecturer')->get()]); }
    public function store(Request $request) { Course::create($this->validated($request)); return redirect()->route('courses.index')->with('success', 'Course created successfully.'); }
    public function edit(Course $course) { return view('courses.form', ['course' => $course, 'lecturers' => User::role('lecturer')->get()]); }
    public function update(Request $request, Course $course) { $course->update($this->validated($request, $course)); return redirect()->route('courses.index')->with('success', 'Course updated successfully.'); }
    public function destroy(Course $course) { $course->delete(); return back()->with('success', 'Course deleted successfully.'); }
    private function validated(Request $request, ?Course $course = null): array { return $request->validate(['code' => ['required', 'string', 'max:20', 'unique:courses,code,'.($course?->id ?? 'NULL')], 'name' => ['required', 'string', 'max:255'], 'description' => ['nullable', 'string'], 'credits' => ['required', 'integer', 'min:1', 'max:12'], 'lecturer_id' => ['nullable', 'exists:users,id']]); }
}
