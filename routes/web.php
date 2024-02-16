<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PersonnelTypeController;
use App\Http\Controllers\PilgrimageController;
use App\Http\Controllers\RainsRetreatController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\StopImageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserDataController;
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

Route::get('/',[UserDataController::class,'welcome'])->name('home');
Route::get('/activityUser/{year}',[UserDataController::class,'activityIndex'])->name('activityUser');
Route::get('/showActivityUser/{id}',[UserDataController::class,'activityShow'])->name('showActivityUser');
Route::get('/showPerson/{year}/{type}',[UserDataController::class,'userIndex'])->name('showPerson');
Route::get('/pilgrimageUser',[PilgrimageController::class,'display'])->name('pilgrimageUser');
Route::get('/showPilgrimage/{id}',[PilgrimageController::class,'show'])->name('showPilgrimage');
Route::get('/newsUser',[UserDataController::class,'newsIndex'])->name('newsUser');
Route::get('/showNews/{id}',[UserDataController::class,'newsInfo'])->name('showNews');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/person/{type}', [PersonnelController::class,'index'])->name('person');
    Route::resource('personnel',PersonnelController::class)->only('show','create','store','edit','update','destroy');
    Route::resource('rainsRetreat',RainsRetreatController::class)->only('show','store');
    Route::delete('/deleteRainsRetreat',[RainsRetreatController::class,'destroy'])->name('deleteRainsRetreat');

    Route::get('/personnelType',[PersonnelTypeController::class,'index'])->name('personnelType');
    Route::post('/addPersonnelType',[PersonnelTypeController::class,'store']);
    Route::put('/updatePersonnelType',[PersonnelTypeController::class,'update']);
    Route::delete('/destroyPersonnelType/{id}',[PersonnelTypeController::class,'destroy'])->name('destroyPersonnelType');

    Route::get('/student/{year}', [StudentController::class,'index'])->name('student');
    Route::post('addStudent', [StudentController::class,'store']);
    Route::put('updateStudent', [StudentController::class,'update']);
    Route::delete('destroyStudent', [StudentController::class,'destroyStudent']);

    Route::get('/course/{year}', [CourseController::class,'index'])->name('course');
    Route::post('/addCourse', [CourseController::class,'store'])->name('addCourse');
    Route::put('/updateCourse', [CourseController::class,'update'])->name('updateCourse');
    Route::delete('/destroyCourse/{id}', [CourseController::class,'destroy'])->name('destroyCourse');

    Route::put('/updateTeacher', [CourseController::class,'updateTeacher'])->name('updateTeacher');
    Route::delete('/destroyTeacher/{id}', [CourseController::class,'destroyTeacher'])->name('destroyTeacher');

    Route::get('/activity/{year}',[ActivityController::class,'index'])->name('activity');
    Route::post('/addActivity',[ActivityController::class,'store']);
    Route::get('/editActivity/{id}',[ActivityController::class,'edit'])->name('editActivity');
    Route::put('/updateActivity',[ActivityController::class,'update']);
    Route::delete('/destroyActivity/{id}',[ActivityController::class,'destroy'])->name('destroyActivity');

    Route::get('/news',[NewsController::class,'index'])->name('news');
    Route::post('/addNews',[NewsController::class,'store']);
    Route::put('/updateNews',[NewsController::class,'update']);
    Route::delete('/destroyNews/{id}',[NewsController::class,'destroy'])->name('destroyNews');

    Route::resource('pilgrimage',PilgrimageController::class)->only('index','create','store','edit','update','destroy');
    Route::resource('stopImage',StopImageController::class)->only('edit','update','destroy');
    Route::resource('stop',StopController::class)->only('store','destroy');

    Route::get('newPassword',function (){return view('admin.resetPassword');})->name('newPassword');

    Route::get('/dashboard',[PersonnelController::class,'index'])->name('dashboard');
});

Route::any('{url}',function() { return redirect('/'); })->where('url', '.*');
