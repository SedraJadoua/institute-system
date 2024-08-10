<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\teacher;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // teacher::Create([
        //   'email' => 'admin@dev.com' , 
        //   'first_name' => json_encode([
        //     'en' => 'sedra' ,
        //     'ar' => 'سدرة'
        //   ]),
        //   'last_name' => json_encode([
        //     'en' => 'jadoua' ,
        //     'ar' => 'جدوع'
        //   ]),
        //   'phoneNumber' => '+9639343439434',
        //   'password' => Hash::make('admin'),
        //   'user_name' => 'admin',
        //   'is_admin' => true,
        // ]);
        // \App\Models\course::factory(2)->create();
        // \App\Models\specialty::factory(2)->create();
        // \App\Models\teacher::factory(2)->create();
        // \App\Models\teacherCourse::factory(2)->create();
        \App\Models\group::factory(2)->create(); //1
        // \App\Models\classroom::factory(2)->create();
         \App\Models\daysSystem::factory(2)->create(); //2
        // \App\Models\student::factory(2)->create();
        \App\Models\member::factory(2)->create(); //3
         \App\Models\message::factory(2)->create(); //4
        // \App\Models\session::factory(2)->create(); 
        \App\Models\task::factory(2)->create();  //5
        // \App\Models\courseTeacherStudent::factory(2)->create(); 
         \App\Models\attendance::factory(2)->create(); //6
         \App\Models\file::factory(2)->create(); //7
         \App\Models\taskStudent::factory(2)->create();  //8
         \App\Models\payment::factory(2)->create(); //9
         \App\Models\evaluation::factory(2)->create();  //10
    }
}
