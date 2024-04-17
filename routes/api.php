<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\courseController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\teacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('auth')->controller(auth::class)->group(function(){
       Route::post('studentRegister', 'studentRegister');
       Route::post('teacherRegister', 'teacherRegister');
       Route::post('loginAdmin', 'loginAdmin');
       Route::post('login', 'login');
});
Route::prefix('course')->controller(courseController::class)->group(function(){
       Route::get('/NewestWorkshops', 'newestWorkshop');
       Route::get('/NewestCourses', 'newestCourses');
});
Route::prefix('teacher')
->controller(teacherController::class)
->middleware('admin')
->group(function(){
       Route::get('/restoreAll', 'restoreAll');
       Route::post('/restore/{id}', 'restore');
});
Route::prefix('student')
->controller(studentController::class)
->middleware('admin')
->group(function(){
       Route::get('/restoreAll', 'restoreAll');
       Route::post('/restore/{id}', 'restore');
});
Route::resource('/course', courseController::class);
Route::resource('/teacher', teacherController::class)->middleware('admin');
Route::resource('/student', studentController::class)->middleware('admin');