<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class group extends Model
{
    use HasFactory , HasUuids;

    /**
     * Get the courseTeacher associated with the group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function courseTeacher(): HasOne
    {
        return $this->hasOne(teacherCourse::class, 'teacher_course_id');
    }


    /**
     * Get all of the members for the group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members(): HasMany
    {
        return $this->hasMany(member::class, 'group_id');
    }
}


