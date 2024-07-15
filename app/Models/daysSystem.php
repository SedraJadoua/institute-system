<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Lang;

class daysSystem extends Model
{
    use HasFactory , HasUuids;
    
    protected $table = 'days_system'; 
    protected $fillable = ['work_day' ,'start_time' , 'end_time','teacher_course_id' , 
     'classroom_id', 'date' , 'day'];
    protected $hidden = ['updated_at' , 'created_at'];
    protected $casts = [
    ];

    public function getDayWorkshopAttribute($value)
    {
        if(is_null($value))
           return;
        $dayWorkshop = json_decode($value , true);
        return $dayWorkshop[Lang::getLocale()];
    }

    public static function getSpecificDays($startDate, $endDate , $workDay)
    {
        $workDay == 0 ? $workDay  = [1,2,3,4,6,7] :
        ($workDay == 1 ? $workDay = [1,3,6]       : $workDay  = [2,4,7]);
        $resultDates = [];
        $period = CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {        
            if (in_array($date->dayOfWeekIso, $workDay)) {
                $resultDates[] = $date->format('Y-m-d');
            }
        }
        return $resultDates;
    }

    public static function getEndDate($startDate , $workDay , $totalWorkDays){

        $workDay == 0 ? $workDay  = [1,2,3,4,6,7] :
        ($workDay == 1 ? $workDay = [1,3,6]       : $workDay  = [2,4,7]);
        $currentDate = Carbon::parse($startDate);
        $total = 0;
        while($total < $totalWorkDays){   
            if(in_array($currentDate->dayOfWeekIso , $workDay)){
                $total++;    
            }
            $currentDate->addDay();      
        }
        return $currentDate->subDay()->toDateString();
    }

    public static function convertObjectToArray($times){
        $result = [];
        foreach($times as $time) {
            $startTime = $time->start_time;
            $startTime = Carbon::parse($startTime)->hour;
            $endTime = $time->end_time;
            $endTime = Carbon::parse($endTime)->hour;
            $result[] = [$startTime , $endTime];   
        }  
        return $result;
    }


   public static function getDateArray($workDay , $date){
   $workDay = 1 ?  $workDay = [1,3,6] : $workDay  = [2,4,7] ;
    $date = Carbon::parse($date);
    foreach ($workDay as $dayNumber) {
        $nextOccurrence = $date->copy()->next($dayNumber);
        $workDayDates[] = $nextOccurrence->toDateString();
    }
   }

    public static function isNotBetween($from , $to , $value){
        if($from > $value ||  $to < $value)
             return true; 
        return false;
    }
    /**
     * Get the classroom that owns the daysSystem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(classroom::class, 'classroom_id');
    }


    /**
     * Get the courseTeacher that owns the daysSystem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseTeacher(): BelongsTo
    {
        return $this->belongsTo(teacherCourse::class, 'teacher_course_id');
    }
}
