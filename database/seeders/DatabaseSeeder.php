<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\course::factory(2)->create();
        // \App\Models\specialty::factory(2)->create();
        // \App\Models\teacher::factory(2)->create();
        // \App\Models\teacherCourse::factory(2)->create();
        // \App\Models\group::factory(2)->create();
        // \App\Models\classroom::factory(2)->create();
        \App\Models\daysSystem::factory(2)->create(); //2
        // \App\Models\student::factory(2)->create();
        // \App\Models\member::factory(2)->create(); 
        \App\Models\message::factory(2)->create(); //2
        // \App\Models\session::factory(2)->create(); 
        \App\Models\task::factory(2)->create();  //2
        // \App\Models\courseTeacherStudent::factory(2)->create(); 
        \App\Models\attendance::factory(2)->create(); //2
        \App\Models\file::factory(2)->create(); //2
        \App\Models\taskStudent::factory(2)->create(); //2
        \App\Models\payment::factory(2)->create(); //2
        \App\Models\evaluation::factory(2)->create(); //2
    }
}
