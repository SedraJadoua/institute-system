<?php

namespace App\Services\repo\classes;

use App\Http\Requests\classroom\storeRequest;
use App\Models\classroom;
use App\Services\repo\interfaces\classroomInterface;
use App\Trait\ResponseJson;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class classroomClass implements classroomInterface
{
    use ResponseJson;

    public function index()
    {
      return classroom::select(['name' , 'id'])->get();
    }


    public function store(storeRequest $request)
    {
      if($request->has('status')){
        $classRoom = classroom::Create([
            'name' => json_encode([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
            ]),
            'status' => $request->status,
            'size' => $request->size,
        ]);
      }
      else {
        $classRoom = classroom::Create([
            'name' => json_encode([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
            ]),
            'size' => $request->size,
        ]);
      }
      
      return $classRoom;
    }

    public function show($id)
    {
       try {
        $classRoom = classroom::select('name' , 'id')->whereHas('daysSystem' , function($q){
          $q->whereNotNull('work_day');
        }) 
        ->with(['daysSystem' => function($q){
          $q->select('id', 'classroom_id', 'work_day', 'teacher_course_id') // Add your specific columns here
          ->with(['courseTeacher' => function($q) {
              $q->select('id', 'total_cost' , 'course_id', 'teacher_id')
              ->whereNotNull('teacher_id')->with(
                ['teacher' => function($q) {
                  $q->select(['id', 'first_name', 'last_name']);
              }, 'course' => function($q) {
                  $q->select(['id', 'name']);
              }]);
          }]);
        }])
        ->findOrFail($id);
        return $classRoom;
       }catch (ModelNotFoundException $e) {
        return $this->returnError(trans('strings.error_classroom_not_found'));
         }
        catch (\Throwable $th) {
          return  $th->getMessage();
      }
    }

}
