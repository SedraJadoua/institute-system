<?php

use App\Events\sendMessage;
use App\Models\course;
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
     return view('index');
});

Route::get('/push' , function (){
  broadcast(new sendMessage('sedra is hereeeee'))->toOthers();
  return 'success';
});
