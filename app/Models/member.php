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
 * @property string|null $student_id
 * @property string|null $teacher_id
 * @property string $group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\group $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\message> $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\student|null $student
 * @method static \Database\Factories\memberFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|member query()
 * @method static \Illuminate\Database\Eloquent\Builder|member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|member whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|member whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|member whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|member whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class member extends Model
{

    use HasFactory , HasUuids;

    protected $fillable = ['student_id' , 'group_id' , 'teacher_id'];
    /** 
     * Get the group that owns the member
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(group::class, 'group_id');
    }

    /**
     * Get all of the messages for the member
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(message::class, 'member_id');
    }

    /**
     * Get the student that owns the member
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(student::class, 'student_id');
    }
    
}
