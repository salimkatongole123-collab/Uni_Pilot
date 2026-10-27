<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name', 'description', 'credits', 'lecturer_id'];
    public function lecturer(): BelongsTo { return $this->belongsTo(User::class, 'lecturer_id'); }
    public function registrations(): HasMany { return $this->hasMany(Registration::class); }
    public function students(): BelongsToMany { return $this->belongsToMany(Student::class, 'registrations')->withTimestamps(); }
}
