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

//home
Route::get('/home', [HomeController::class, 'index'])->name('home');

//Student join class with code
Route::get('/join/class/{classCode?}', [ClassController::class, 'joinClass'])->name('join.class');

//Profile Router
Route::get('/profile', [UserController::class, 'show']);
Route::post('/profile/update', [UserController::class, 'update']);

//ShowClass Router
Route::get('/class/{id}', [ClassController::class, 'show'])->name('class.detail');

//Subjects ListAll Router
Route::get('/subjects/showAll', [SubjectController::class, 'showAll'])->name('subjects.show_all');

//Router Assignment
Route::group(['prefix' => 'assignments', 'namespace' => 'Student'], function(){
    //show in subject
    Route::get('/show/{id}', 'AssignmentController@show')->name('student.assignment.show');
    //show list all
    Route::get('/showAll', 'AssignmentController@showAll')->name('student.assignment.show_all');
    //assignment details + submit assignment
    Route::get('/detail/{id}', 'AssignmentController@detail')->name('student.assignment.show-details');
});

//Router Result
Route::post('/result/{id}',[ResultController::class, 'sendResult'])->name('student.assignment.result');

// Message Router
Route::get('/message/', [MessageController::class, 'show']);
Route::post('message/user/{user_id}', [MessageController::class, 'store']);
Route::delete('/message/{message_id}', [MessageController::class, 'destroy']);

//Router Issues (Form Support)
Route::post('/Issues', [IssueController::class, 'store']);
