<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Lang;

class daysSystem extends Model
{
   
    use HasFactory , HasUuids;
    
    protected $table = 'days_system';


    public function getNameAttribute($value)
    {
        $name = json_decode($value , true);
        return $name[Lang::getLocale()];
    }
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
