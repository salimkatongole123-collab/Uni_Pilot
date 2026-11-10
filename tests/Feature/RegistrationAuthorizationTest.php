<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_lecturers_cannot_create_registrations(): void
    {
        $this->seed(RolePermissionSeeder::class);
        $lecturer = User::where('email', 'lecturer@unipilot.test')->firstOrFail();
        $course = Course::create([
            'code' => 'TEST101',
            'name' => 'Test Course',
            'description' => 'Course used for authorization testing.',
            'credits' => 3,
        ]);

        $response = $this->actingAs($lecturer)->post(route('registrations.store'), [
            'course_id' => $course->id,
            'student_id' => 1,
        ]);

        $response->assertForbidden();
    }
}
