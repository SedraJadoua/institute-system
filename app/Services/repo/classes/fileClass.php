<?php

namespace App\Services\repo\classes;

use App\Http\Requests\File\storeRequest;
use App\Models\file;
use App\Models\session;
use App\Services\repo\interfaces\fileInterface;
use App\Trait\ResponseJson;
use Illuminate\Support\Facades\File as FacadesFile;

class fileClass implements fileInterface{

    use ResponseJson;
    public function index(string $sessionId){
       
        try {
            $session = session::with(['files'])->findOrFail($sessionId);
         return $session;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
         return $this->returnError(__('strings.error_session_not_found'));
        }
    }
    
    public function store(storeRequest $request)
    {
       $file = $request->file('file');
       $fileSize  = $file->getSize();
       if($fileSize > 30034714)
       { 
         return $this->returnError(trans('strings.file_is_large'));
       }
       $fileName = $request->name_file . '.'.$file->extension();
       $file->move(public_path('files/'), $fileName);
       $file = file::Create([
          'session_id' => $request->session_id,
          'description' => json_encode([
            'ar' => $request->description_ar,
            'en' => $request->description_en,
          ]),
          'size' => $fileSize,
          'name' => $fileName,
        ]);
      return $file;
    }


    public function destroy(string $id)
    {
      try {
        $file = file::findOrFail($id);
        $originalName = $file->getRawOriginal('name');
        FacadesFile::delete(public_path('files/'.$originalName));
        $file->delete();
        return $this->returnSuccessMessage(trans('strings.delete'),null);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return $this->returnError(__('strings.error_file_not_found'));
    }
  }
}