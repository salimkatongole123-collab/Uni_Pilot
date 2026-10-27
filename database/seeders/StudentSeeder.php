<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([['Alex Morgan', 'alex@unipilot.test', 'STU001'], ['Bella Nsubuga', 'bella@unipilot.test', 'STU002'], ['Chris Okello', 'chris@unipilot.test', 'STU003'], ['Diana Achieng', 'diana@unipilot.test', 'STU004'], ['Ethan Kato', 'ethan@unipilot.test', 'STU005']] as [$name, $email, $number]) {
            $user = User::firstOrCreate(['email' => $email], ['name' => $name, 'password' => Hash::make('password')]); $user->assignRole('student');
            Student::firstOrCreate(['student_number' => $number], ['user_id' => $user->id]);
        }
    }
}
