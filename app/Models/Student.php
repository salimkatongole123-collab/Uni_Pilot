<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'student_number', 'phone'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function registrations(): HasMany { return $this->hasMany(Registration::class); }
    public function courses(): BelongsToMany { return $this->belongsToMany(Course::class, 'registrations')->withTimestamps(); }
}
