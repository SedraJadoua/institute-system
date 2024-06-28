<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Lang;

/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property int|null $flag
 * @property string|null $clock
 * @property string|null $end_clock
 * @property string|null $classroom_id
 * @property string $teacher_course_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\classroom|null $classroom
 * @property-read \App\Models\teacherCourse $courseTeacher
 * @method static \Database\Factories\daysSystemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem query()
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereClassroomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereClock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereEndClock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereTeacherCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class daysSystem extends Model
{
   
    use HasFactory , HasUuids;
    
    protected $table = 'days_system';
    
    protected $fillable = ['work_day','day_workshop' , 'start_time' , 'end_time','teacher_course_id' , 'classroom_id', 'date'];

    protected $hidden = ['updated_at' , 'created_at'];
   
    public function getDayWorkshopAttribute($value)
    {
        $dayWorkshop = json_decode($value , true);
        return $dayWorkshop[Lang::getLocale()];
    }
    /**
     * Get the classroom that owns the daysSystem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(classroom::class, 'classroom_id');
    }


    /**
     * Get the courseTeacher that owns the daysSystem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseTeacher(): BelongsTo
    {
        return $this->belongsTo(teacherCourse::class, 'teacher_course_id');
    }
}
