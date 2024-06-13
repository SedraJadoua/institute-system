<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property string $id
 * @property int $paid
 * @property string $course_teacher_id
 * @property string $student_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\student $student
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\taskStudent> $taskStudent
 * @property-read int|null $task_student_count
 * @method static \Database\Factories\courseTeacherStudentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent whereCourseTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class courseTeacherStudent extends Model
{
    use HasFactory  , HasUuids;

    protected $table = 'course_teacher_student';

    /**
     * Get all of the taskStudent for the courseTeacherStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskStudent(): HasMany
    {
        return $this->hasMany(taskStudent::class, 'course_teacher_student_id');
    }    

    /**
     * Get the student that owns the courseTeacherStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(student::class, 'student_id');
    }
}
