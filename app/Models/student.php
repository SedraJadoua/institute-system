<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Lang;
use Laravel\Passport\HasApiTokens;

class student extends Authenticatable
{
    use HasFactory , HasUuids , HasApiTokens , SoftDeletes;

    protected $hidden = ['pivot' , 'deleted_at' , 'created_at' , 'updated_at', 'password'];
    protected $fillable = ['email' , 'photo' ];
    
    
    protected function getFirstNameAttribute($value){
       $FirtName = json_decode($value , true);
       return $FirtName[Lang::getLocale()];
    }

    protected function getLastNameAttribute($value){
       $LastName = json_decode($value , true);
       return $LastName[Lang::getLocale()];
    }

    protected function getPhotoAttribute($value){
        return asset('storage/images/'.$value);
     }

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
