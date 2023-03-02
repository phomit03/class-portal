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

//Class router teacher
Route::group(['prefix' => 'class'], function() {
    //add, delete student (teacher)
    Route::get('/{class_id}/students', [UserController::class, 'showAll']);
    Route::post('/{class_id}/student', [ClassController::class, 'addStudents']);
    Route::get('/remove/student/{id}', [ClassController::class, 'removeStudent'])->name('remove.student.class');
    //class
    Route::get('/create', [ClassController::class, 'create']);
    Route::post('/create', [ClassController::class, 'store']);
    Route::put('/update/{id}', [ClassController::class, 'update']);
    Route::delete('/delete/{id}', [ClassController::class, 'destroy']);
});

//Subject Router
Route::group(['prefix' => 'subject'], function() {
    Route::get('/create', [SubjectController::class, 'form'])->name('form.subject');
    Route::post('/create', [SubjectController::class, 'create'])->name('create.subject');
    Route::post('/new/save', [ClassController::class, 'saveNewSubject']);   //create subject in class
    Route::get('/edit/{id}', [SubjectController::class, 'edit'])->name('edit.subject');
    Route::put('/update/{id}', [SubjectController::class, 'update'])->name('update.subject');
    Route::get('/delete/{id}', [SubjectController::class, 'destroy'])->name('delete.subject');
});

//Assignment Router
Route::group(['prefix' => 'assignments', 'namespace' => 'Teacher'], function(){
    //show list all
    Route::get('/', 'AssignmentController@index')->name('teacher.assignment.index');
    //create
    Route::get('/create','AssignmentController@create')->name('teacher.assignment.create');
    Route::post('/create','AssignmentController@store');
    //edit, update
    Route::get('/update/{id}','AssignmentController@edit')->name('teacher.assignment.update');
    Route::post('/update/{id}','AssignmentController@update');
    //delete
    Route::get('/delete/{id}','AssignmentController@delete')->name('teacher.assignment.delete');
    //select subject for create, edit
    Route::post('/get/subject/by/class','AssignmentController@getsSubjectByClass')->name('get.subject.by.class');
    //display list of student results (submitted && haven't submitted)
    Route::get('/answers/{id}', 'AssignmentController@answers')->name('teacher.assignment.answers');
    //student result details
    Route::get('/get/detail/answer/{id}','AssignmentController@detailAnswer')->name('get.detail.answer');
    //update result (mark, comment teacher)
    Route::post('/update/mark/answer/{id}','AssignmentController@updateMark')->name('update.mark.answer');
});
