<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class daysSystem extends Model
{
   
    use HasFactory , HasUuids;
    
    protected $table = 'days_system';

    /**
     * Get the classroom that owns the daysSystem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(classroom::class, 'classroom_id');
    }


    /**
     * Get the courseTeacher that owns the daysSystem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseTeacher(): BelongsTo
    {
        return $this->belongsTo(teacherCourse::class, 'teacher_course_id');
    }
}
