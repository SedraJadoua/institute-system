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
 * @property string $student_id
 * @property string $session_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\session $session
 * @property-read \App\Models\student $student
 * @method static \Database\Factories\attendanceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class attendance extends Model
{
    use HasFactory , HasUuids;

    protected $hidden = ['created_at' , 'updated_at'];
    /**
     * Get the student that owns the attendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(student::class, 'student_id');
    }

    /**
     * Get the session that owns the attendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(session::class, 'session_id');
    }
    
}
