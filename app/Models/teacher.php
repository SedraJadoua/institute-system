<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Lang;
use Laravel\Passport\HasApiTokens;

class teacher extends Authenticatable
{
    use HasFactory , HasUuids , HasApiTokens , SoftDeletes;

    protected $fillable = ['speciality_id' , 'is_admin'];

    protected $hidden = ['pivot' , 'is_admin'  ,'deleted_at' , 'created_at' , 'updated_at', 'password'];


    protected function getFirstNameAttribute($value){
        $first_name = json_decode($value , true);
        return $first_name[Lang::getLocale()];
    }

    protected function getLastNameAttribute($value){
        $last_name = json_decode($value , true);
        return $last_name[Lang::getLocale()];
    }


    /**
     * The courses that belong to the teacher
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(course::class, 'course_teacher', 'teacher_id', 'course_id');
        
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
