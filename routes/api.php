<?php

use App\Http\Controllers\attendanceController;
use App\Http\Controllers\auth;
use App\Http\Controllers\classroomController;
use App\Http\Controllers\courseController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\evaluationController;
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
Route::prefix('auth')->controller(auth::class)->group(function(){
       Route::post('studentRegister', 'studentRegister');
       Route::post('teacherRegister', 'teacherRegister');
       Route::post('loginAdmin', 'loginAdmin');
       Route::post('login', 'login')->name('login');
       Route::post('forgot-password-student' , 'forgotPassword');
       Route::post('change-password', 'changePassword');
       Route::get('all-teachers-students' , 'allTeachersAndStudents');
});
Route::prefix('course')->controller(courseController::class)->group(function(){
       Route::get('/NewestWorkshops', 'newestWorkshop');
       Route::get('/NewestCourses', 'newestCourses');
       Route::get('/progress-of-course', 'progressOfCourse');
       // ->middleware('auth:student');
       Route::post('/open-new-course', 'openNewCourse');
       Route::post('/accept', 'accept');
       Route::get('/course-need-teacher-in-dash', 'courseNeedTeacherInDash');
       Route::post('/return-hour-Available', 'returnHoursAvilable');
       Route::get('/course-need-teacher', 'courseNeedTeacher');
       Route::get('/teacher-accept', 'acceptTeacher');
       Route::get('/get-courses-of-speciality', 'getCoursesofSpeciality');
       Route::get('/get-courses-added-only', 'getCoursesAddedOnly');
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

Route::get('get-tasks-student' , [taskStudentController::class , 'getTasksStudent']);
 
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
       Route::get('/attendance-and-presence','attendanceAndPresence');
       Route::get('/attendance-and-presence-two','attendanceAndPresence2');
       Route::get('/student-attendance-and-presence','studentAttendanceAndPresence');
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
       Route::get('/marks-student-in-course', 'marksStudentInCourse');
       Route::get('/get-marks-for-teacher', 'getMarksForTeacher');
});
Route::prefix('dash')
// ->middleware('auth:teacher')
->controller(dashboardController::class)
->group(function(){
       Route::get('/statistics' ,'statistics');
       Route::get('/courses' , 'courses');
       Route::get('/workshops' , 'workshops');
});

Route::prefix('payment')
->controller(localPaymentController::class)
->group(function(){
       Route::get('/show', 'show');
});

Route::resource('/course', courseController::class);
Route::resource('/local-payment', localPaymentController::class)->only('store' , 'index' );
Route::resource('/evaluation', evaluationController::class);
Route::resource('/file', fileController::class);
Route::resource('/classRoom', classroomController::class);
Route::resource('/session', sessionController::class);
Route::resource('/specialty', specialtyController::class);
Route::resource('/attendance', attendanceController::class);
Route::resource('/teacher', teacherController::class);
// ->middleware('admin');
Route::resource('/student', studentController::class);
// ->middleware('admin');
Route::resource('/taskStudent', taskStudentController::class);
Route::resource('/task', taskController::class);
Route::resource('/message' , MessageController::class);

