<?php

namespace App\Providers;

use App\Models\classroom;
use App\Models\taskStudent;
use App\Services\repo\classes\auth;
use App\Services\repo\classes\classroomClass;
use App\Services\repo\classes\courseClass;
use App\Services\repo\classes\imageClass;
use App\Services\repo\classes\sessionClass;
use App\Services\repo\classes\specialtyClass;
use App\Services\repo\classes\teacherClass;
use App\Services\repo\classes\studentClass;
use App\Services\repo\classes\taskClass;
use App\Services\repo\classes\taskStudentClass;
use App\Services\repo\interfaces\authInterface;
use App\Services\repo\interfaces\classroomInterface;
use App\Services\repo\interfaces\courseInterface;
use App\Services\repo\interfaces\imageInterface;
use App\Services\repo\interfaces\sessionInterface;
use App\Services\repo\interfaces\specialtInterface;
use App\Services\repo\interfaces\studentInterface;
use App\Services\repo\interfaces\taskInterface;
use App\Services\repo\interfaces\taskStudentInterface;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
