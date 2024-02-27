<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class course extends Model
{
    use HasFactory , HasUuids ;
    
    protected $fillable = ['name' , 'description'];

    /**
     * The teachers that belong to the course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(teacher::class, 'course_teacher', 'course_id', 'teacher_id');
    }


    /**
     * Get all of the tasks for the course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tasks(): HasManyThrough
    {
        return $this->hasManyThrough(task::class, teacherCourse::class , 'course_id' , 'course_teacher_id' , 'id' , 'id');
    }

    
}
