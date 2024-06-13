<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;

/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property int $size
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\daysSystem> $daysSystem
 * @property-read int|null $days_system_count
 * @method static \Database\Factories\classroomFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|classroom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|classroom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|classroom query()
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class classroom extends Model
{
    use HasFactory , HasUuids;
    protected $fillable = ['name'  ,'status' , 'size'];
    protected $hidden = ['created_at' , 'updated_at'];



    public function getNameAttribute($value) 
    {  
       $name = json_decode($value , true);
        return $name['name_'.Lang::getLocale()];
    }


    /**
     * Get all of the daysSystem for the classroom
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function daysSystem(): HasMany
    {
        return $this->hasMany(daysSystem::class, 'classroom_id');
    }
}
