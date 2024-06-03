<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;

class classroom extends Model
{
    use HasFactory , HasUuids;
    protected $hidden = ['created_at' , 'updated_at'];



    public function getNameAttribute($value) 
    {  
       $name = json_decode($value , true);
        return $name[Lang::getLocale()];
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
