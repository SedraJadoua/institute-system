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
 * @property string $date
 * @property string $course_teacher_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\taskFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|task query()
 * @method static \Illuminate\Database\Eloquent\Builder|task whereCourseTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class task extends Model
{
    use HasFactory , HasUuids;
  
    protected $fillable = ['name' , 'mark' , 'course_teacher_id' , 'date'];
  

    protected function getNameAttribute(string $value)
    {
        $name = json_decode($value , true);
        return $name[Lang::getLocale()];
    }
}
