<?php

use App\Models\course;
use App\Models\file;
use App\Models\member;
use App\Models\message;
use App\Models\session;
use App\Models\specialty;
use App\Models\student;
use App\Models\teacher;
use App\Models\teacherCourse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('data' , function(){
     return student::with([ 'taskStudent' ])->get();
});

Route::get('/course', function () {
    return student::all();
    
});
