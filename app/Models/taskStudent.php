<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property int $mark
 * @property float $studentMark
 * @property string $date
 * @property string|null $course_teacher_student_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\taskStudentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereCourseTeacherStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereStudentMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class taskStudent extends Model
{
    use HasFactory , HasUuids;

    protected $table = 'task_student';

    
    protected function getNameAttribute($value)
    {
        $name = json_decode($value , true);
        return $name[Lang::getLocale()];
    }
}
