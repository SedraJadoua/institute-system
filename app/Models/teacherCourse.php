<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class teacherCourse extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'course_teacher';
    protected $fillable = ['course_id' , 'level' , 'total_days' , 'total_cost' , 'teacher_id'];
    protected $hidden = [ 'created_at', 'updated_at'];

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
    public function daysSystem(): HasOne
    {
        return $this->hasOne(daysSystem::class, 'teacher_course_id');
    }
    /**
     * The students that belong to the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(student::class,  'course_teacher_student', 'course_teacher_id', 'student_id')
        ->withPivot('paid');
    }

    /**
     * Get all of the courseTeacherStudent for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseTeacherStudent(): HasMany
    {
        return $this->hasMany(courseTeacherStudent::class, 'course_teacher_id');
    }
    /**
     * Get all of the evaluation for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluation(): HasMany
    {
        return $this->hasMany(evaluation::class, 'course_teacher_id');
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

    /**
     * Get the group associated with the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group(): HasOne
    {
        return $this->hasOne(group::class, 'teacher_course_id');
    }
}
