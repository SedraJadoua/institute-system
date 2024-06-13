<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Lang;

/**
 * 
 *
 * @property string $id
 * @property string $specialty_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacherCourse> $courseTeacher
 * @property-read int|null $course_teacher_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacher> $teachers
 * @property-read int|null $teachers_count
 * @method static \Database\Factories\specialtyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|specialty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|specialty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|specialty query()
 * @method static \Illuminate\Database\Eloquent\Builder|specialty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|specialty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|specialty whereSpecialtyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|specialty whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class specialty extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['specialty_name'];
    protected $hidden = ['created_at', 'updated_at'];


    protected function getSpecialtyNameAttribute($value)
    {
        $name = json_decode($value, true);
        return $name[Lang::getLocale()];
    }

    /**
     * Get all of the teachers for the specialty
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teachers(): HasMany
    {
        return $this->hasMany(teacher::class, 'speciality_id');
    }


    /**
     * Get all of the courseTeacher for the specialty
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function courseTeacher(): HasManyThrough
    {
        return $this->hasManyThrough(teacherCourse::class, teacher::class, 'speciality_id', 'teacher_id');
    }
}
