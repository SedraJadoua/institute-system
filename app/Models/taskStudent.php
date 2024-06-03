<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class taskStudent extends Model
{
    use HasFactory , HasUuids;

    protected $table = 'task_student';

    
    protected function getNameAttribute($value)
    {
        $name = json_decode($value , true);
        return $name[Lang::getLocale()];
    }
}
