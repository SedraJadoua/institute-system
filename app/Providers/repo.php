<?php

namespace App\Providers;

use App\Services\repo\classes\attendanceClass;
use App\Services\repo\classes\auth;
use App\Services\repo\classes\classroomClass;
use App\Services\repo\classes\courseClass;
use App\Services\repo\classes\daysSystemClass;
use App\Services\repo\classes\messageClass;
use App\Services\repo\classes\paymentClass;
use App\Services\repo\classes\fileClass;
use App\Services\repo\classes\imageClass;
use App\Services\repo\classes\localPaymentClass;
use App\Services\repo\classes\sessionClass;
use App\Services\repo\classes\specialtyClass;
use App\Services\repo\classes\teacherClass;
use App\Services\repo\classes\studentClass;
use App\Services\repo\classes\taskClass;
use App\Services\repo\classes\taskStudentClass;
use App\Services\repo\interfaces\attendanceInterface;
use App\Services\repo\interfaces\authInterface;
use App\Services\repo\interfaces\classroomInterface;
use App\Services\repo\interfaces\courseInterface;
use App\Services\repo\interfaces\daysSystemInterface;
use App\Services\repo\interfaces\imageInterface;
use App\Services\repo\interfaces\sessionInterface;
use App\Services\repo\interfaces\specialtInterface;
use App\Services\repo\interfaces\studentInterface;
use App\Services\repo\interfaces\taskInterface;
use App\Services\repo\interfaces\taskStudentInterface;
use App\Services\repo\interfaces\fileInterface;
use App\Services\repo\interfaces\localPaymentInterface;
use App\Services\repo\interfaces\messageInterface;
use App\Services\repo\interfaces\paymentInterface;
use App\Services\repo\interfaces\teacherInterface;
use Illuminate\Support\ServiceProvider;

class repo extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
       $this->app->bind(authInterface::class , auth::class);
       $this->app->bind(courseInterface::class , courseClass::class);
       $this->app->bind(teacherInterface::class , teacherClass::class);
       $this->app->bind(studentInterface::class , studentClass::class);
       $this->app->bind(sessionInterface::class , sessionClass::class);
       $this->app->bind(specialtInterface::class , specialtyClass::class);
       $this->app->bind(classroomInterface::class , classroomClass::class);
       $this->app->bind(imageInterface::class , imageClass::class);
       $this->app->bind(taskStudentInterface::class , taskStudentClass::class);
       $this->app->bind(taskInterface::class , taskClass::class);
       $this->app->bind(attendanceInterface::class , attendanceClass::class);
       $this->app->bind(fileInterface::class , fileClass::class);
       $this->app->bind(messageInterface::class , messageClass::class);
       $this->app->bind(paymentInterface::class , paymentClass::class);
       $this->app->bind(daysSystemInterface::class , daysSystemClass::class);
       $this->app->bind(localPaymentInterface::class , localPaymentClass::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
