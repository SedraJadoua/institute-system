<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class student extends Model
{
    use HasFactory , HasUuids;

    protected $hidden = ['pivot'];

    /**
     * Get all of the members for the student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members(): HasMany
    {
        return $this->hasMany(member::class, 'student_id');
    }

    /**
     * Get all of the attendances for the student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(attendance::class, 'student_id');
    }

    /**
     * The courseTeacher that belong to the student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courseTeacher(): BelongsToMany
    {
        return $this->belongsToMany(teacherCourse::class, 'course_teacher_student', 'student_id', 'course_teacher_id');
    }


    /**
     * The sessions that belong to the student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(session::class, 'attendances', 'student_id', 'session_id');
    }


    /**
     * Get all of the taskStudent for the student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function taskStudent(): HasManyThrough
    {
        return $this->hasManyThrough(taskStudent::class, courseTeacherStudent::class);
 
    }
   
}
