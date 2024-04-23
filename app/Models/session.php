<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;

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

