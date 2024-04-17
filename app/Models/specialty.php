<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;

class specialty extends Model
{
    use HasFactory , HasUuids;

    protected $hidden = [ 'created_at' , 'updated_at'];


    protected function getSpecialtyNameAttribute($value){
        $name = json_decode($value , true);
        return $name[Lang::getLocale()];
    }

    /**
     * Get all of the teachers for the specialty
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teachers(): HasMany
    {
        return $this->hasMany(teacher::class, 'speciality_id');
    }
}
