<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class specialty extends Model
{
    use HasFactory , HasUuids;


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
