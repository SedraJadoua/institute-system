<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;

/**
 * 
 *
 * @property string $id
 * @property string $title
 * @property string $date
 * @property string $course_teacher_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\teacherCourse $courseTeacher
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\file> $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\student> $students
 * @property-read int|null $students_count
 * @method static \Database\Factories\sessionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|session newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|session newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|session query()
 * @method static \Illuminate\Database\Eloquent\Builder|session whereCourseTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|session whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|session whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|session whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|session whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|session whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class session extends Model
{
    use HasFactory , HasUuids;

    protected $table = 'sessions';
    protected $fillable = ['date' , 'title' , 'course_teacher_id'];
    protected $hidden = ['created_at' , 'updated_at'];

    public function getTitleAttribute($value){
       $title = json_decode($value , true);
       return $title[Lang::getLocale()]; 
    }

    /**
     * Get all of the files for the session
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(file::class, 'session_id');
    }
    
    /**
     * The students that belong to the session
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(student::class, 'attendances', 'session_id', 'student_id');
    }

    /**
     * Get the courseTeacher that owns the session
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseTeacher(): BelongsTo
    {
        return $this->belongsTo(teacherCourse::class, 'course_teacher_id');
    }


    /**
     * Get all of the attendances for the session
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(attendance::class, 'session_id');
    }
}

