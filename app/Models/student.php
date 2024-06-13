<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Lang;
use Laravel\Passport\HasApiTokens;

/**
 * 
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_name
 * @property string $phoneNumber
 * @property int $age
 * @property string $email
 * @property string $password
 * @property int $gender
 * @property string|null $photo
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacherCourse> $courseTeacher
 * @property-read int|null $course_teacher_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\member> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\session> $sessions
 * @property-read int|null $sessions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\taskStudent> $taskStudent
 * @property-read int|null $task_student_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\studentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|student onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|student query()
 * @method static \Illuminate\Database\Eloquent\Builder|student whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|student withoutTrashed()
 * @mixin \Eloquent
 */
class student extends Authenticatable
{
    use HasFactory , HasUuids , HasApiTokens, Notifiable , CanResetPassword, SoftDeletes;

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
