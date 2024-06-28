<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lang;

/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $teacher_course_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\teacherCourse|null $courseTeacher
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\member> $members
 * @property-read int|null $members_count
 * @method static \Database\Factories\groupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|group query()
 * @method static \Illuminate\Database\Eloquent\Builder|group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|group whereTeacherCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|group whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class group extends Model
{
    use HasFactory , HasUuids;
      
    protected $fillable = ['name' , 'teacher_course_id'];

    public function getNameAttribute(string $value)
    {
        $name = json_decode($value , true);
        return $name[Lang::getLocale()];
    }

    /**
     * Get the couresTeacher that owns the group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseTeacher(): BelongsTo
    {
        return $this->belongsTo(teacherCourse::class, 'teacher_course_id');
    }
   
    /**
     * Get all of the members for the group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members(): HasMany
    {
        return $this->hasMany(member::class, 'group_id');
    }
}


