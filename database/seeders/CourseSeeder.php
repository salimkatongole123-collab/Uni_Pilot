<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturer = User::where('email', 'lecturer@unipilot.test')->first();
        foreach ([['CS101', 'Introduction to Computing'], ['DB201', 'Database Systems'], ['WD301', 'Web Development'], ['SE401', 'Software Engineering']] as [$code, $name]) Course::firstOrCreate(['code' => $code], ['name' => $name, 'description' => 'Core university course', 'credits' => 3, 'lecturer_id' => $lecturer?->id]);
        $student = Student::where('student_number', 'STU001')->first();
        Registration::firstOrCreate(['student_id' => $student->id, 'course_id' => Course::where('code', 'CS101')->value('id')]);
        Registration::firstOrCreate(['student_id' => $student->id, 'course_id' => Course::where('code', 'DB201')->value('id')]);
    }
}
