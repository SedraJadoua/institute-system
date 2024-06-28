<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 
 *
 * @property string $id
 * @property string $teacher_id
 * @property string $course_id
 * @property int $total_days
 * @property string $level
 * @property float $total_cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\attendance> $attendance
 * @property-read int|null $attendance_count
 * @property-read \App\Models\course $course
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\daysSystem> $daysSystem
 * @property-read int|null $days_system_count
 * @property-read \App\Models\group|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\session> $sessions
 * @property-read int|null $sessions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\student> $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\teacher $teacher
 * @method static \Database\Factories\teacherCourseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereTotalDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class teacherCourse extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'course_teacher';
    protected $fillable = ['course_id' , 'level' , 'total_days' , 'total_cost' , 'teacher_id'];
    protected $hidden = [ 'created_at', 'updated_at'];

    /**
     * Get the teacher that owns the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(teacher::class, 'teacher_id');
    }
    /**
     * Get the course that owns the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(course::class, 'course_id');
    }
    /**
     * Get all of the daysSystem for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function daysSystem(): HasOne
    {
        return $this->hasOne(daysSystem::class, 'teacher_course_id');
    }
    /**
     * The students that belong to the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(student::class,  'course_teacher_student', 'course_teacher_id', 'student_id')
        ->withPivot('paid');
    }

    /**
     * Get all of the evaluation for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluation(): HasMany
    {
        return $this->hasMany(evaluation::class, 'course_teacher_id');
    }
    /**
     * Get all of the tasks for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(task::class, 'course_teacher_id');
    }
    /**
     * Get all of the sessions for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(session::class, 'course_teacher_id');
    }

    /**
     * Get all of the attendance for the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function attendance(): HasManyThrough
    {
        return $this->hasManyThrough(attendance::class, session::class, 'course_teacher_id', 'session_id');
    }

    /**
     * Get the group associated with the teacherCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group(): HasOne
    {
        return $this->hasOne(group::class, 'teacher_course_id');
    }
}
