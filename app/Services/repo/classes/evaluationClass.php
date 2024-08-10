<?php

namespace App\Services\repo\classes;

use App\Http\Requests\evaluation\storeRequest;
use App\Http\Requests\teacher\courseTeacherRequest;
use App\Models\evaluation;
use App\Services\repo\interfaces\evaluationInterface;
use App\Trait\ResponseJson;
use Carbon\Carbon;

class evaluationClass implements evaluationInterface {
 
    use ResponseJson;


    public function index(courseTeacherRequest $request){
        
        $evaluations =  evaluation::select('feedback' , 'created_at')
        ->where('course_teacher_id' , $request->course_teacher_id)
        ->whereNotNull('feedback')
        ->get();

       return $evaluations->map(function($item){
        $date = Carbon::parse($item['created_at']);
            $date=  $date->format('g:i A') ;
           return [
               'feedback' => $item->feedback,
               'time' => $date,
           ];
       });
    }

    public function store(storeRequest $request){
    
        try {
            $evaluation = evaluation::create([
                'course_teacher_id' => $request->course_teacher_id,
                'rate' => $request->rate,
                'feedback' => $request->feedback,
            ]);
            
            return $this->sendResponse($evaluation , trans('strings.feedback_sent_successfully'));
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage());
        }
    }
}