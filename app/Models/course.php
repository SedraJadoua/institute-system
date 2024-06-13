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

/**
 * 
 *
 * @property string $id
 * @property int $workshop
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacherCourse> $courseTeacher
 * @property-read int|null $course_teacher_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\courseTeacherStudent> $courseTeacherStudent
 * @property-read int|null $course_teacher_student_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\daysSystem> $daysSystem
 * @property-read int|null $days_system_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacher> $teachers
 * @property-read int|null $teachers_count
 * @method static \Database\Factories\courseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|course query()
 * @method static \Illuminate\Database\Eloquent\Builder|course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course whereWorkshop($value)
 * @mixin \Eloquent
 */
class course extends Model implements HasMedia
{
use HasFactory , HasUuids  , InteractsWithMedia;
    
    protected $fillable = ['name' , 'description' , 'workshop'];
    protected $hidden  = ['created_at' , 'updated_at'  ];


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
        ->withPivot(['id', 'level' , 'total_cost' , 'total_days', 'updated_at' , 'created_at' ]);
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