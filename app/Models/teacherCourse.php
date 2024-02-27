<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class teacherCourse extends Model
{
    use HasFactory , HasUuids;

    protected $table = 'course_teacher';



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
        return $this->belongsToMany(student::class,  'course_teacher_student', 'course_teacher_id' , 'student_id' );
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
}
