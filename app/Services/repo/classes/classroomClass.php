<?php

namespace App\Services\repo\classes;

use App\Http\Requests\course\storeRequest;
use App\Http\Requests\course\updateRequest;
use App\Models\classroom;
use App\Models\course;
use App\Models\session;
use App\Models\teacherCourse;
use App\Services\repo\interfaces\classroomInterface;
use App\Services\repo\interfaces\courseInterface;
use App\Trait\ResponseJson;
use Illuminate\Support\Facades\Storage;

class classroomClass implements classroomInterface
{



    use ResponseJson;

    public function index()
    {
       return classroom::with('daysSystem')->get();
    }
}
