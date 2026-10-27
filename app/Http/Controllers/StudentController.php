<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index() { return view('students.index', ['students' => Student::with('user')->latest()->paginate(10)]); }
    public function create() { return view('students.form', ['student' => new Student()]); }
    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'unique:users,email'], 'password' => ['required', 'min:8'], 'student_number' => ['required', 'unique:students,student_number'], 'phone' => ['nullable', 'string', 'max:30']]);
        $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => Hash::make($data['password'])]); $user->assignRole('student');
        Student::create(['user_id' => $user->id, 'student_number' => $data['student_number'], 'phone' => $data['phone'] ?? null]);
        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }
    public function edit(Student $student) { return view('students.form', compact('student')); }
    public function update(Request $request, Student $student)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'unique:users,email,'.$student->user_id], 'student_number' => ['required', 'unique:students,student_number,'.$student->id], 'phone' => ['nullable', 'string', 'max:30']]);
        $student->user->update(['name' => $data['name'], 'email' => $data['email']]); $student->update(['student_number' => $data['student_number'], 'phone' => $data['phone'] ?? null]);
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }
    public function destroy(Student $student) { $student->user?->delete(); return back()->with('success', 'Student deleted successfully.'); }
}
