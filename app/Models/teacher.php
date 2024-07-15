<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Lang;
use Laravel\Passport\HasApiTokens;

class teacher extends Authenticatable
{
    use HasFactory , HasUuids , HasApiTokens , SoftDeletes;

    protected $fillable = ['speciality_id' , 'is_admin' , 'photo' , 'description'];

    protected $hidden = [ 'is_admin'  ,'deleted_at' , 'created_at' , 'updated_at', 'password'];


    protected function getFirstNameAttribute($value){
        $first_name = json_decode($value , true);
        return $first_name[Lang::getLocale()];
    }

    protected function getDescriptionAttribute($value){
        if(is_null($value))
          return ;
        $desc = json_decode($value , true);
        return $desc[Lang::getLocale()];
    }

    protected function getLastNameAttribute($value){
        $last_name = json_decode($value , true);
    return $last_name[Lang::getLocale()];
    }


    protected function getPhotoAttribute($value){
        return asset('storage/images/'.$value);
     }


     /**
      * Get all of the teacherCourse for the teacher
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasMany
      */
     public function teacherCourse(): HasMany
     {
         return $this->hasMany(teacherCourse::class, 'teacher_id');
     }


     /**
      * Get all of the session for the teacher
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
      */
     public function session(): HasManyThrough
     {
         return $this->hasManyThrough(session::class, teacherCourse::class ,'teacher_id' , 'course_teacher_id' );
     }
    /**
     * The courses that belong to the teacher
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(course::class, 'course_teacher', 'teacher_id', 'course_id')
        ->withPivot( 'id', 'level', 'total_cost', 'total_days');      
    }

    /**
     * Get the specialty that owns the teacher
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(specialty::class, 'speciality_id');
    }
}
