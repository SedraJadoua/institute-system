<?php

namespace App\Providers;

use App\Services\repo\classes\auth;
use App\Services\repo\classes\courseClass;
use App\Services\repo\classes\teacherClass;
use App\Services\repo\classes\studentClass;
use App\Services\repo\interfaces\authInterface;
use App\Services\repo\interfaces\courseInterface;
use App\Services\repo\interfaces\studentInterface;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
