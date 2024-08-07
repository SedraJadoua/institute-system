<?php

use App\Http\Controllers\attendanceController;
use App\Http\Controllers\auth;
use App\Http\Controllers\classroomController;
use App\Http\Controllers\courseController;
use App\Http\Controllers\daysSystemController;
use App\Http\Controllers\fileController;
use App\Http\Controllers\imageController;
use App\Http\Controllers\localPaymentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\sessionController;
use App\Http\Controllers\specialtyController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\taskController;
use App\Http\Controllers\taskStudentController;
use App\Http\Controllers\teacherController;
use App\Models\attendance;
use App\Rules\noTimeConflict;
use App\Services\repo\classes\localPaymentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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
Route::prefix('auth')->controller(auth::class)->group(function(){
       Route::post('studentRegister', 'studentRegister');
       Route::post('teacherRegister', 'teacherRegister');
       Route::post('loginAdmin', 'loginAdmin');
       Route::post('login', 'login')->name('login');
       Route::post('forgot-password-student' , 'forgotPassword');
       Route::post('change-password', 'changePassword');
});
Route::prefix('course')->controller(courseController::class)->group(function(){
       Route::get('/NewestWorkshops', 'newestWorkshop');
       Route::get('/NewestCourses', 'newestCourses');
       Route::get('/progress-of-course', 'progressOfCourse');
       // ->middleware('auth:student');
       Route::post('/open-new-course', 'openNewCourse');
       Route::post('/return-hour-Available', 'returnHoursAvilable');

});
Route::prefix('teacher')
->controller(teacherController::class)
// ->middleware('admin')
->group(function(){
       Route::get('/restoreAll', 'restoreAll');
       Route::post('/restore/{id}', 'restore');
       Route::post('/addPhoto', 'addPhoto');
       Route::post('/updatePhoto', 'updatePhoto');
});
Route::prefix('session')
->controller(sessionController::class)
->group(function(){
       Route::post('/restore/{id}', 'restore');
});
Route::prefix('classroom')
->controller(classroomController::class)
->group(function(){
       Route::get('/appointments/{id}', 'appointments');
});
Route::prefix('message')
->controller(MessageController::class)
->group(function(){
       Route::get('/show', 'show');
});

Route::prefix('payment')
->controller(paymentController::class)
->group(function(){
       Route::post('/charge', 'charge');
       Route::get('/success', 'success')->name('success');
       Route::get('/payError', 'payError')->name('payError');
});

Route::prefix('student')
->controller(studentController::class)
// ->middleware('admin')
->group(function(){
       Route::get('/restoreAll', 'restoreAll');
       Route::post('/restore/{id}', 'restore');
       Route::post('/addPhoto', 'addPhoto');
       Route::post('/updatePhoto', 'updatePhoto');
});

Route::prefix('attendance')
->controller(attendanceController::class)
// ->middleware('auth:teacher')
->group(function(){
       Route::get('/get-teacher-courses',  'getTeacherCourses');
       Route::get('/attendance-and-presence','attendanceAndPresence');
});

Route::prefix('image')
->controller(imageController::class)
->group(function(){
       Route::post('/update/{id}', 'update');
       Route::post('/delete/{id}', 'destroy');
       Route::post('/store', 'store');
});
Route::prefix('file')
->controller(fileController::class)
->group(function(){
       Route::get('/index/{sessionId}', 'index');
});

Route::prefix('taskStudent')
// ->middleware('auth:teacher')
->controller(taskStudentController::class)
->group(function(){
       Route::get('/getStudentInCourse', 'getStudentInCourse');
});

Route::prefix('payment')
->controller(localPaymentController::class)
->group(function(){
       Route::get('/show', 'show');
});

Route::resource('/course', courseController::class);
Route::resource('/local-payment', localPaymentController::class)->only('store' , 'index' );
Route::resource('/days_system', daysSystemController::class);
Route::resource('/file', fileController::class);
Route::resource('/classRoom', classroomController::class);
Route::resource('/session', sessionController::class);
Route::resource('/specialty', specialtyController::class);
Route::resource('/teacher', teacherController::class);
// ->middleware('admin');
Route::resource('/student', studentController::class);
// ->middleware('admin');
Route::resource('/taskStudent', taskStudentController::class);
Route::resource('/task', taskController::class);
Route::resource('/message' , MessageController::class);