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

/**
 * 
 *
 * @property string $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $phoneNumber
 * @property string|null $photo
 * @property string $password
 * @property string $user_name
 * @property string|null $speciality_id
 * @property int $is_admin
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\course> $courses
 * @property-read int|null $courses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\session> $session
 * @property-read int|null $session_count
 * @property-read \App\Models\specialty|null $specialty
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacherCourse> $teacherCourse
 * @property-read int|null $teacher_course_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\teacherFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|teacher onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereSpecialityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|teacher withoutTrashed()
 * @mixin \Eloquent
 */
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
