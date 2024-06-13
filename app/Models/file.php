<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property int $size
 * @property string|null $description
 * @property string|null $session_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\session|null $session
 * @method static \Database\Factories\fileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|file newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|file newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|file query()
 * @method static \Illuminate\Database\Eloquent\Builder|file whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class file extends Model
{
    use HasFactory , HasUuids;
  
    protected $fillable = ['session_id', 'name' , 'size' , 'description'];

    public function getNameAttribute(string $value)
    {
        return asset('files/'.$value);
    }
    public function getDescriptionAttribute(string $value)
    {
        $description = json_decode($value , true);
        return $description[Lang::locale()];
    }
    

    /**
     * Get the session that owns the file
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(session::class, 'session_id');
    }
}
