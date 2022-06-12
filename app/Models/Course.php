<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find(int $id)
 */
class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function lecturers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_allocations')->withPivot('semester_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(CourseAllocation::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }
}
