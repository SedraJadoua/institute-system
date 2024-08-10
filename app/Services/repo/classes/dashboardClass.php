<?php

namespace App\Services\repo\classes;

use App\Models\course;
use App\Models\courseTeacherStudent;
use App\Models\evaluation;
use App\Models\session;
use App\Models\teacherCourse;
use App\Services\repo\interfaces\dashboardInterface;
use DB;
use phpDocumentor\Reflection\Types\Boolean;

class dashboardClass implements dashboardInterface {

    public function statistics()
    {
    $data = [];
    $sessions = session::select('course_teacher_id' , DB::raw('count(*) as total'))
    ->groupby('course_teacher_id')
    ->get();

    $studentRegisterMoreThanCourse = courseTeacherStudent::select('student_id' , DB::raw('count(*) as total'))
    ->groupby('student_id')
    ->havingRaw('count(*) >= ?', [2])
    ->count();

    $studentCountByYear = courseTeacherStudent::selectRaw('YEAR(created_at) as year, COUNT(DISTINCT student_id) as total')
    ->whereNotNull('created_at')
    ->groupBy('year')
    ->get();

  $passingThreshold = 50; 

  $results = DB::table('courses as c')
    ->select(
        'c.name as course_name',
        'c.id as courseId',
        DB::raw('COUNT(DISTINCT cts.student_id) as registered_students'),
        DB::raw('COUNT(DISTINCT passed_students.student_id) as successful_students')
    )
    ->where('c.workshop' , 0)
    ->where('ct.accept' , 1)
    ->join('course_teacher as ct', 'c.id', '=', 'ct.course_id')
    ->join('course_teacher_student as cts', 'ct.id', '=', 'cts.course_teacher_id')
    ->leftJoinSub(
        DB::table('task_student as ts')
            ->select('ts.course_teacher_student_id', DB::raw('SUM(ts.studentMark) as totalMarks'))
            ->groupBy('ts.course_teacher_student_id'),
        'student_marks',
        'cts.id',
        '=',
        'student_marks.course_teacher_student_id'
    )
    ->leftJoinSub(
        DB::table('course_teacher_student as cts')
            ->select('cts.student_id')
            ->join('task_student as ts', 'cts.id', '=', 'ts.course_teacher_student_id')
            ->groupBy('cts.student_id')
            ->havingRaw('SUM(ts.studentMark) >= ?', [$passingThreshold]),
        'passed_students',
        'cts.student_id',
        '=',
        'passed_students.student_id'
    )
    ->groupBy('c.name' , 'c.id')
    ->get()
    ->map(function ($item){
    $course = course::find($item->courseId);
      
      return [
        'courseName' => $course->name,
        'registered_students' => $item->registered_students,
        'successful_students' => $item->successful_students,
      ];
    });
    ;
    
    $evaluations = evaluation::where('rate' , '>=' , 2)->count();

    $counter = 0;

    foreach($sessions as $session)
    {
        $totalDays = DB::table('course_teacher')
        ->where('id' , $session->course_teacher_id)
        ->value('total_days');

        if($totalDays == $session->total){
          $counter++;
        }
    }
     
    $totalCourses = teacherCourse::where('accept', 1)->count();
    $studentsCount = courseTeacherStudent::distinct('student_id')->count();
    $evaluationsCount = evaluation::count();
      
    $data['studentsCompleteCourses'] = $counter > 0 ? (float)(number_format(($counter/$totalCourses) * 100 , 2 )) : 0;
    $data['studentRegisterMoreThanCourse'] = $studentRegisterMoreThanCourse > 0 ? (float)(number_format(($studentRegisterMoreThanCourse/$studentsCount) * 100 , 2 )) : 0;
    $data['positiveEvaluation'] = $evaluations > 0 ? (float)(number_format(($evaluations/$evaluationsCount) * 100 , 2 )) : 0;
    $data['studentCountByYear'] = $studentCountByYear;
    $data['mostRegisterd'] = $results;
    return $data;
    }
 
     public function infoCoursesAndWorkshop(bool $workshop){
      
  
      $courseTeachers = teacherCourse::whereHas('course', function ($q) use ($workshop) {
        $q->where('workshop', $workshop);
    })
    ->whereNotNull('teacher_id')
    ->with(['course', 'attendance', 'daysSystem', 'teacher'])->get();
    
    $totalDays = 0;
    $presence = 0;
    
    $data = $courseTeachers->map(function ($item) use ($workshop, &$totalDays, &$presence) {
        if ($workshop == 0) {
            $totalDays += $item->total_days ?? 0;
            foreach ($item->attendance as $att) {
                $presence += ($att->status == 1) ? 1 : 0;
            }
        }
    
        return [
            'id' => $item->id,
            'price' => $item->total_cost,
            'date' => $item->daysSystem->date ?? null,
            'time' => $item->daysSystem->start_time ?? null,
            'course' => [
                'id' => $item->course->id,
                'name' => $item->course->name,
            ],
            'teacher' => [
                'id' => $item->teacher->id ,
                'name' => $item->teacher->first_name . ' ' . $item->teacher->last_name,
            ],
        ];
    })->toArray();
    $name =  $workshop == 0 ? 'courses' : 'workshops' ;
    $result = [
        $name => $data,
    ]; 
    
    if ($workshop == 0 && $totalDays > 0) {
        $result['percentage_of_presence'] = $presence / $totalDays;
    }
    
      return $result;
   }


     public function courses(){
     return  $this->infoCoursesAndWorkshop(0);
     }
     public function workshops(){
     return  $this->infoCoursesAndWorkshop(1);
     }
}