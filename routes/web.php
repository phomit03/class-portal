<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//sign in google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

//middleware and import router for teacher, student
Route::middleware(["auth","is_teacher"])->group(function (){
    include_once "teacher.php";
});

Route::middleware(["auth"])->group(function (){
    include_once "student.php";
});

//check login
Route::get('/', function () {
    if (Auth::guest()) {
        return view('index');
    } else {
        return redirect('/home');
    }
});

//about us
Route::get('/about-us', function (){
    return view('pages.about');
});

//terms
Route::get('/terms', function (){
    return view('pages.terms');
});









