<?php 

namespace App\Services\repo\classes;

use App\Events\sendMessage;
use App\Http\Requests\message\storeRequest;
use App\Models\group;
use App\Models\member;
use App\Models\message;
use App\Services\repo\interfaces\messageInterface;
use App\Trait\ResponseJson;

class messageClass implements messageInterface
{
    use ResponseJson;


    public function index()
    {
      return  group::with(['members.messages'])->get();
    }

    public function store(storeRequest $request)
    {
        try {
            $group = group::findOrFail($request->group_id);
            if(auth()->guard('student')->check())
            { 
                $member = member::where('group_id',$group->id)
                ->where('student_id',auth()->guard('student')->user()->id)
                ->first();
            }
            else 
            { 
                $member = member::where('group_id',$group->id)
                ->where('teacher_id',auth()->guard('teacher')->user()->id)
                ->first();
            }
            if(!$member){
              return $this->returnError(trans('strings.error_member_not_found'));
            }
            $message =  message::Create([
             'member_id' => $member->id,
             'message' => $request->message,
            ]);
            broadcast(new sendMessage($request->message , $group->id))->toOthers();
            return $this->returnSuccessMessage(trans('strings.insert_message'),$message );    
           
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
          return $this->returnError(__('strings.error_group_not_found'));
        }
    }
  

    public function show(string $group_id)
    {
        try {
            $group =  group::findOrFail($group_id)
            ->with(['members.messages'])
            ->where('id', $group_id)
            ->get();

           return $group;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
          return $this->returnError(__('strings.error_group_not_found'));
        }
    }

}