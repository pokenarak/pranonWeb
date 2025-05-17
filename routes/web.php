<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PersonnelTypeController;
use App\Http\Controllers\PilgrimageController;
use App\Http\Controllers\RainsRetreatController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\StopImageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\VideoController;
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
Route::get('/activityUser/{year}/{type}',[UserDataController::class,'activityIndex'])->name('activityUser');
Route::get('/showActivityUser/{id}',[UserDataController::class,'activityShow'])->name('showActivityUser');
Route::get('/showPerson/{year}/{type}',[UserDataController::class,'userIndex'])->name('showPerson');
Route::get('/personInfo/{id}',[UserDataController::class,'personInfo'])->name('personInfo');
Route::get('/pilgrimageUser',[PilgrimageController::class,'display'])->name('pilgrimageUser');
Route::get('/showPilgrimage/{id}',[PilgrimageController::class,'show'])->name('showPilgrimage');
Route::get('/newsUser',[UserDataController::class,'newsIndex'])->name('newsUser');
Route::get('/showNews/{id}',[UserDataController::class,'newsInfo'])->name('showNews');
Route::get('/templeHistory',function(){return view('user.templeHistory');} )->name('templeHistory');
Route::get('/buddhaHistory',function(){return view('user.buddhaHistory');} )->name('buddhaHistory');
Route::get('/unseen',function(){return view('user.unseen');} )->name('unseen');
Route::get('/donationUser',[UserDataController::class,'donation'] )->name('donationUser');
Route::get('/videoUser',[UserDataController::class,'video'] )->name('videoUser');
Route::get('/courseUser/{year}/{type}',[UserDataController::class,'pali'])->name('courseUser');
Route::get('/lv9',[UserDataController::class,'lv9'] )->name('lv9');
Route::get('/calendarUser',[UserDataController::class,'calendar'] )->name('calendarUser');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    
    Route::get('/person/{type}', [PersonnelController::class,'index'])->name('person');
    Route::get('/personRelocate', [PersonnelController::class,'relocate'])->name('personRelocate');
    Route::get('/deleteImagePerson/{id}/{path}', [PersonnelController::class,'deleteImage'])->name('deleteImagePerson');
    Route::resource('personnel',PersonnelController::class)->only('show','create','store','edit','update','destroy');
    Route::get('/report/person/{type}',[PersonnelController::class,'exportPerson'])->name('exportPerson');

    Route::resource('rainsRetreat',RainsRetreatController::class)->only('show','store');
    Route::delete('/deleteRainsRetreat',[RainsRetreatController::class,'destroy'])->name('deleteRainsRetreat');

    Route::get('/personnelType',[PersonnelTypeController::class,'index'])->name('personnelType');
    Route::post('/addPersonnelType',[PersonnelTypeController::class,'store']);
    Route::put('/updatePersonnelType',[PersonnelTypeController::class,'update']);
    Route::delete('/destroyPersonnelType/{id}',[PersonnelTypeController::class,'destroy'])->name('destroyPersonnelType');

    Route::get('/student/{year}', [StudentController::class,'index'])->name('student');
    Route::post('/addStudent', [StudentController::class,'store']);
    Route::put('/pdateStudent', [StudentController::class,'update']);
    Route::delete('/destroyStudent', [StudentController::class,'destroyStudent']);
    Route::get('/report/pali/{year}/{type}',[StudentController::class,'exportPali'])->name('exportPali');

    Route::get('/course/{year}', [CourseController::class,'index'])->name('course');
    Route::post('/addCourse', [CourseController::class,'store'])->name('addCourse');
    Route::put('/updateCourse', [CourseController::class,'update'])->name('updateCourse');
    Route::delete('/destroyCourse/{id}', [CourseController::class,'destroy'])->name('destroyCourse');
    Route::post('/addNonFormal', [CourseController::class,'storeNonFormal'])->name('addNonFormal');

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
    Route::resource('type', TypeController::class)->only(['store','show']);
    Route::resource('rank', RankController::class)->only(['store','show']);
    Route::resource('donation',DonationController::class)->only('index','store','update','destroy');
    Route::resource('video', VideoController::class)->only('index','store','destroy');
    Route::resource('calendar',CalendarController::class)->only('index','show','store','destroy');


    Route::get('newPassword',function (){return view('admin.resetPassword');})->name('newPassword');

    Route::get('/dashboard',[PersonnelController::class,'index'])->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is_superadmin',
])->group(function () {
    Route::resource('admin',AdminController::class)->only('index','store','show','destroy');
});

Route::any('{url}',function() { return redirect('/'); })->where('url', '.*');
