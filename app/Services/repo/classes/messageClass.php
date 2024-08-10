<?php 

namespace App\Services\repo\classes;

use App\Events\sendMessage;
use App\Http\Requests\message\storeRequest;
use App\Models\group;
use App\Models\member;
use App\Models\message;
use App\Models\student;
use App\Models\teacher;
use App\Services\repo\interfaces\messageInterface;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;

class messageClass implements messageInterface
{
    use ResponseJson;

    public function index(Request $request)
    {
       try {
         // $user_id = Auth::guard('student')->check() ?
        // Auth::guard('student')->user()->id :
        // Auth::guard('teacher')->user()->id ;
        $user_id = $request->user_id;

    
        //  $course =    course::where('id' , $request->course_id)->first();
        // //  return $course;
        // $media = $course->getFirstMedia('photos') ;
        // return $media->getUrl();



        $groups =   group::whereHas('members', function ($q) use ($user_id) {
            $q->where('student_id',$user_id)
            ->orWhere('teacher_id' , $user_id);
        })
        ->withCount(['members'])
        ->get()
        ->map(function ($group) {
            $group->last_message_updated_at = $group->members->flatMap(function ($member) {
                return $member->messages;
            })->pluck('updated_at')->max();
            $media = $group->courseTeacher->course->getFirstMedia('photos');
            $group->image = $media ? $media->getUrl() : null;
            return $group->makeHidden(['course_teacher' , 'members']);
        });  
        return  $groups->map(function($item){
            return [
                'id' => $item->id,
            'name' => $item->name,
            'members_count' => $item->members_count,
            'last_message_updated_at' => $item->last_message_updated_at,
            'image'=> $item->image,
            'teacher_course_id' => $item->teacher_course_id,
            ]; 

        });
    
        }
       catch (\Throwable $th) {
        return $this->returnError($th->getMessage());
       }
    }

    public function store(storeRequest $request)
    {
        try {
            $group = group::findOrFail($request->group_id);
            if($request->has('student_id'))
            { 
                $user_id = $request->student_id;
                $user = student::findorFail($user_id);
                $member = member::where('group_id',$group->id)
                ->where('student_id', $user_id)
                ->first();
            }
            else 
            { 
                $user_id = $request->teacher_id;
                $user = teacher::findorFail($user_id);
                $member = member::where('group_id',$group->id)
                ->where('teacher_id',$user_id)
                ->first();
            }
            if(!$member){
              return $this->returnError(trans('strings.error_member_not_found'));
            }
            $message =  $member->messages()->create([
             'message' => $request->message,
            ]);
            broadcast(new sendMessage($request->message , $group->id , $user))->toOthers();
            return $this->returnSuccessMessage(trans('strings.insert_message'),$message );    
           
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
          return $this->returnError(__('strings.error_group_not_found'));
        }
    }
  

    public function show(Request $request)
    {
        try {

            $group_id = $request->group_id;
             $messages = message::whereHas('member' , function($q) use ($group_id)
            {
                $q->where('group_id' , $group_id);
            })
            ->with('member.student', 'member.group.courseTeacher.teacher' )
            ->orderBy('updated_at', 'desc') 
            ->get();
            
             return $messages->map(function($item){
               return [
                      'id' => $item['id'],
                      'message' => $item['message'],
                      'member_id' => $item['member_id'],
                      'created_at' => $item['created_at'],
                      'updated_at' => $item['updated_at'],
                      'user' => [
                          'id' => $item['member']['student']['id'] ??  $item['member']['group']['courseTeacher']['teacher']['id'],
                          'first_name' => $item['member']['student']['first_name'] ?? $item['member']['group']['courseTeacher']['teacher']['first_name'],
                          'last_name' => $item['member']['student']['last_name'] ?? $item['member']['group']['courseTeacher']['teacher']['last_name'],
                      ]
               ];
             });
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
          return $this->returnError(__('strings.error_group_not_found'));
        }
    }

}
