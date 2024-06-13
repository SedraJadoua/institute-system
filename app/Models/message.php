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
 * @property string $message
 * @property string|null $member_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\member|null $member
 * @method static \Database\Factories\messageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|message query()
 * @method static \Illuminate\Database\Eloquent\Builder|message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class message extends Model
{
    use HasFactory , HasUuids;

    protected $fillable = ['message' , 'member_id' ];
    /**
     * Get the member that owns the message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(member::class, 'member_id');
    }
}
