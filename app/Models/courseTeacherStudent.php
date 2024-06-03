<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class courseTeacherStudent extends Model
{
    use HasFactory  , HasUuids;

    protected $table = 'course_teacher_student';

    /**
     * Get all of the taskStudent for the courseTeacherStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskStudent(): HasMany
    {
        return $this->hasMany(taskStudent::class, 'course_teacher_student_id');
    }    
}
