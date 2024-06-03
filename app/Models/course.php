<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Lang;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class course extends Model implements HasMedia
{
use HasFactory , HasUuids  , InteractsWithMedia;
    
    protected $fillable = ['name' , 'description' , 'workshop'];
    protected $hidden  = ['created_at' , 'updated_at' ];


    protected function getNameAttribute($value){ 
        $name = json_decode($value , true);
        return $name[Lang::getLocale()];
    }
 
    protected function getDescriptionAttribute($value){
        $des = json_decode($value , true);
        return $des[Lang::getLocale()];
    }

    /**
     * The teachers that belong to the course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(teacher::class, 'course_teacher', 'course_id', 'teacher_id')
        ->withPivot(['level' , 'total_cost' , 'total_days', 'updated_at' , 'created_at' ]);
    }

    /**
     * Get all of the daysSystem for the course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function daysSystem(): HasManyThrough
    {
        return $this->hasManyThrough(daysSystem::class, teacherCourse::class, 'course_id', 'teacher_course_id');
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


    public function courseTeacherStudent(): HasManyThrough
    {
        return $this->hasManyThrough(courseTeacherStudent::class, teacherCourse::class , 'course_id' , 'course_teacher_id');
    }

    /**
     * Get the courseTeacher that owns the course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseTeacher(): HasMany
    {
        return $this->hasMany(teacherCourse::class, 'course_id');
    }

  

}