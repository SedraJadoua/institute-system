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
use Auth;
use Illuminate\Http\Request;

class messageClass implements messageInterface
{
    use ResponseJson;

    public function index(Request $request)
    {
        // $user_id = Auth::guard('student')->check() ?
        // Auth::guard('student')->user()->id :
        // Auth::guard('teacher')->user()->id ;
        $user_id = $request->user_id;
        return  group::whereHas('members', function ($q) use ($user_id) {
            $q->where('student_id',$user_id)
            ->orWhere('teacher_id' , $user_id);
        })
        ->with('members.messages' , 'members.student' , 'courseTeacher.teacher')
        ->get(); 
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
            $group =  group::findOrFail($group_id)
            ->with(['members.messages'])
            ->first();

           return $group;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
          return $this->returnError(__('strings.error_group_not_found'));
        }
    }

}
