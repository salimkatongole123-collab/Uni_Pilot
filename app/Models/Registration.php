<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = ['student_id', 'course_id', 'registered_at'];
    protected $casts = ['registered_at' => 'datetime'];
    public function student(): BelongsTo { return $this->belongsTo(Student::class); }
    public function course(): BelongsTo { return $this->belongsTo(Course::class); }
}
