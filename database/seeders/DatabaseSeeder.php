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
        teacher::Create([
          'email' => 'admin@dev.com' , 
          'first_name' => json_encode([
            'en' => 'sedra' ,
            'ar' => 'سدرة'
          ]),
          'last_name' => json_encode([
            'en' => 'jadoua' ,
            'ar' => 'جدوع'
          ]),
          'phoneNumber' => '+9639343439434',
          'password' => Hash::make('admin'),
          'user_name' => 'admin',
          'is_admin' => true,
        ]);
        // \App\Models\course::factory(2)->create();
        // \App\Models\specialty::factory(2)->create();
        // \App\Models\teacher::factory(2)->create();
        // \App\Models\teacherCourse::factory(2)->create();
        // \App\Models\group::factory(2)->create();
        // \App\Models\classroom::factory(2)->create();
        \App\Models\daysSystem::factory(2)->create(); 
        // \App\Models\student::factory(2)->create();
        // \App\Models\member::factory(2)->create(); 
        \App\Models\message::factory(2)->create(); 
        // \App\Models\session::factory(2)->create(); 
        \App\Models\task::factory(2)->create();  
        // \App\Models\courseTeacherStudent::factory(2)->create(); 
        \App\Models\attendance::factory(2)->create(); 
        \App\Models\file::factory(2)->create(); 
        \App\Models\taskStudent::factory(2)->create();
        \App\Models\payment::factory(2)->create(); 
        \App\Models\evaluation::factory(2)->create();
    }
}
