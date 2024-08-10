<?php

namespace App\Services\repo\classes;

use App\Http\Requests\student\courseTeacherStudentRequest;
use App\Http\Requests\task\indexRequest;
use App\Http\Requests\taskStudent\storeRequest;
use App\Http\Requests\teacher\courseTeacherRequest;
use App\Models\courseTeacherStudent;
use App\Models\task;
use App\Models\taskStudent;
use App\Models\teacherCourse;
use App\Services\repo\interfaces\taskStudentInterface;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class taskStudentClass implements taskStudentInterface
{
    use ResponseJson;

    public function index(indexRequest $request)
    {
        $tasks = task::whereRaw('DATE(date) = ?',$request->date)
        ->whereHas('courseTeacher.courseTeacherStudent'  , function($q) use ($request) {
              $q->where('student_id',$request->student_id);
        })
        ->with(['courseTeacher.course'])
        ->get();
         return $this->returnJsonData($tasks);
    }


    public function store(storeRequest $request) 
    {
        $task = task::findOrFail($request->task_id);
        $courseTeacherStudent = courseTeacherStudent::where('course_teacher_id' , $request->course_teacher_id)
        ->where('student_id' , $request->student_id)
        ->first();
    //    return $courseTeacherStudent;
        if($courseTeacherStudent)
        {
            $taskStudent = taskStudent::where('course_teacher_student_id', $courseTeacherStudent->id)->first();
            // return $taskStudent;
            if($taskStudent){
            $taskStudent->studentMark = $request->studentMark;
            if($taskStudent->mark < $request->studentMark)
            {
              return $this->returnError(trans('strings.student_mark_be_smaller_than_total_mark') ." " . $taskStudent->mark);
            }
            $taskStudent->save();
            return $this->sendResponse($taskStudent , trans('strings.update'));
           }
          $taskStudent = new taskStudent();
          $taskStudent->course_teacher_student_id = $courseTeacherStudent->id;
          $taskStudent->studentMark = $task->studentMark;
          $taskStudent->date = $task->date;
          $taskStudent->mark = $task->mark;
          $taskStudent->name = $task->getRawOriginal('name'); // Assign a value to the 'name' field
          if($taskStudent->mark < $request->studentMark)
          {
            return $this->returnError(trans('strings.student_mark_be_smaller_than_total_mark') . " " . $taskStudent->mark);
          }
          $taskStudent->save();
          return $this->sendResponse($taskStudent , trans('strings.insert_taskStudent'));

        }

        return $this->returnError(trans('strings.student_does_not_exist_in_this_course'));
        
    }

   protected function returnJsonData(string $tasks) {
    
    $tasks = json_decode($tasks , true);
    return  collect($tasks)->map(function ($item) {
        return [
                'id' => $item['id'],
                'name' => $item['name'],
                'mark' => $item['mark'],
                'date' => $item['date'],
                'course_teacher_id' => $item['course_teacher_id'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
                'course' => [
                    'id' => $item['course_teacher']['course']['id'],
                    'name' => $item['course_teacher']['course']['name'],
                    'description' => $item['course_teacher']['course']['description'],
                    'specialty_id' => $item['course_teacher']['course']['specialty_id'],
                    'workshop' => $item['course_teacher']['course']['workshop'],
            ],
        ];
    })->values();
    
    return $tasks;

   }
    public function getTasksStudent(Request $request){

        $validate = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
        ]);
         if($validate->fails()){
            return $this->sendListError($validate->errors());
         }

         $tasks = task::whereHas('courseTeacher.courseTeacherStudent'  , function($q) use ($request) {
              $q->where('student_id',$request->student_id);
        })
        ->with(['courseTeacher.course'])
        ->get();

        return $this->returnJsonData($tasks);
    }

    public function marksStudentInCourse(courseTeacherStudentRequest $request){
      $courseTeacherStudent = courseTeacherStudent::where('course_teacher_id' , $request->course_teacher_id)
      ->where('student_id' , $request->student_id)->first();
      return $courseTeacherStudent->taskStudent->makeHidden(['course_teacher_student_id']);
    }
   
    public function getStudentInCourse(Request $request)
    {
      try {
        return teacherCourse::where('id' , $request->course_teacher_id)
        ->with(['courseTeacherStudent' => function($q){
            $q->with(['student' , 'taskStudent']);
            }])->first();

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_course_not_found'));
        }
    }   

    public function getMarksForTeacher(courseTeacherRequest $request)
    {

        try {
            $teacherCourse =  teacherCourse::findOrFail($request->course_teacher_id);
            $tasks = Task::where('course_teacher_id', $request->course_teacher_id)
            ->pluck('name')
            ->toArray();
            $data =  [
                'students' => $teacherCourse->students->map(function($item) use ($teacherCourse , $tasks) {
                    $student_id = $item->id;
                    $courseTeacherStudents = courseTeacherStudent::where('student_id', $student_id)
                    ->where('course_teacher_id', $teacherCourse->id)
                    ->with('taskStudent')
                    ->first();
                    return [
                        'id' => $student_id,
                        'name' => $item->first_name . ' ' . $item->last_name,
                        'tasks' => $courseTeacherStudents->taskStudent->map(function ($item)use ($tasks){
                                    if (in_array($item->name , $tasks)) {
                                        return  [
                                            'id' => $item->id,
                                            'task_name' => $item->name,
                                            'student_mark' => $item->studentMark,
                                        ];
                                    } 
                                })->filter()->values()->toArray(),
                            ];
                   
        })->toArray(),
    ];
    return $data ;
   }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    return $this->returnError(__('strings.error_course_not_found'));
   }  
   catch (Throwable $e) {
    return $this->returnError($e->getMessage());
   }
    
    }
}