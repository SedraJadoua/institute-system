<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property string $id
 * @property int $rate
 * @property string|null $feedback
 * @property string $student_id
 * @property string $course_teacher_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\teacherCourse $courseTeacher
 * @property-read \App\Models\student $student
 * @method static \Database\Factories\evaluationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation query()
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereCourseTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class evaluation extends Model
{
    use HasFactory , HasUuids;

    /**
     * Get the student that owns the evaluation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(student::class, 'student_id');
    }

    /**
     * Get the courseTeacher that owns the evaluation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseTeacher(): BelongsTo
    {
        return $this->belongsTo(teacherCourse::class, 'course_teacher_id');
    }
}
