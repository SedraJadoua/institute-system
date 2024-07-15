<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class courseTeacherStudent extends Model
{
    use HasFactory  , HasUuids;

    protected $table = 'course_teacher_student';
    protected $hidden = ['created_at' , 'updated_at'];

    /**
     * Get all of the taskStudent for the courseTeacherStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskStudent(): HasMany
    {
        return $this->hasMany(taskStudent::class, 'course_teacher_student_id');
    }  
    
    
    /**
     * Get all of the payments for the courseTeacherStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(payment::class, 'teacher_course_student_id');
    }



    /**
     * Get the student that owns the courseTeacherStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(student::class, 'student_id');
    }

    /**
     * Get the courseTeacher that owns the courseTeacherStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseTeacher(): BelongsTo
    {
        return $this->belongsTo(teacherCourse::class, 'course_teacher_id');
    }
}
