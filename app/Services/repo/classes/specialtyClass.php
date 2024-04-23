<?php

namespace App\Services\repo\classes;

use App\Http\Requests\specialty\storeRequest;
use App\Models\specialty;
use App\Rules\arabicLanguage;
use App\Rules\englishLanguage;
use App\Rules\uniqueJsonContent;
use App\Services\repo\interfaces\specialtInterface;
use App\Trait\ResponseJson;
use Illuminate\Support\Facades\Request;

class specialtyClass implements specialtInterface {
     
    use ResponseJson;
    
    public function index(){
        return specialty::with(['courseTeacher.course'])->get();
    }

    public function store(storeRequest $request)
    {
        $specialty = specialty::create([
            'specialty_name' => json_encode([
                'ar' => $request->specialty_name_ar,
                'en' => $request->specialty_name_en,
            ]),
        ]);
        return $this->returnSuccessMessage(__('strings.insert_specialty'), $specialty);
    }

    public function show(string $id){
        try {
            $specialty = specialty::with(['teachers'])->findOrFail($id);
            return $specialty;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_specialty_not_found'));
        }
    }


}