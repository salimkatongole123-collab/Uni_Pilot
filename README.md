# UniPilot Student Management System

Laravel application for managing students, courses, lecturers, and course registrations.

## Installation

```bash
git clone <repository-url>
cd Uni_Pilot
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

The default configuration uses SQLite. Set `DB_CONNECTION`, `DB_DATABASE`, and the other database variables in `.env` if your group uses MySQL.

## Roles and sample accounts

All sample accounts use the password `password`:

| Role | Email | Access |
| --- | --- | --- |
| Administrator | `admin@unipilot.test` | Manage students, courses, registrations, and access |
| Lecturer | `lecturer@unipilot.test` | View assigned courses and registered students |
| Student | `alex@unipilot.test` | View courses and personal registrations |

## Key implementation points

- `Student`, `Course`, and `Registration` use Eloquent `hasMany`, `belongsTo`, and `belongsToMany` relationships.
- Registration foreign keys cascade on deletion and the student/course pair has a unique database constraint.
- Spatie Laravel Permission provides roles and permissions, with route middleware enforcing access.
- Seeders are repeatable with `firstOrCreate` and create five students, four courses, users, roles, permissions, and sample registrations.

## GitHub collaboration

Keep `main` stable and use `develop` for integration. Each member should create a feature branch, make focused commits, push it, and open a pull request into `develop` for review. Test the integrated branch before merging to `main`.

Suggested branches: `feature/student-management`, `feature/course-management`, `feature/relationships`, `feature/auth-permissions`, and `feature/documentation`.

Add screenshots and the group contribution report to `docs/screenshots/` and `docs/contribution-report.md` before submission. The report should list members, assigned tasks, branches, pull requests, and merged contributions.
