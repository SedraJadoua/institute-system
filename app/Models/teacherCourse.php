<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class teacherCourse extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'course_teacher';
    protected $hidden = ['pivot', 'created_at', 'updated_at', 'laravel_through_key'];

    /**
     * Get the teacher that owns the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(teacher::class, 'teacher_id');
    }
    /**
     * Get the course that owns the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(course::class, 'course_id');
    }
    /**
     * Get all of the daysSystem for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function daysSystem(): HasMany
    {
        return $this->hasMany(daysSystem::class, 'teacher_course_id');
    }
    /**
     * The students that belong to the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(student::class,  'course_teacher_student', 'course_teacher_id', 'student_id');
    }
    /**
     * Get all of the tasks for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(task::class, 'course_teacher_id');
    }
    /**
     * Get all of the sessions for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(session::class, 'course_teacher_id');
    }

    /**
     * Get all of the attendance for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function attendance(): HasManyThrough
    {
        return $this->hasManyThrough(attendance::class, session::class, 'course_teacher_id', 'session_id');
    }
}
