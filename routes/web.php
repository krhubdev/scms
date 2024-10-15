<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\StudentController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AssignedController;
use App\Http\Controllers\ReportsController;

Route::get('/', [AuthController::class, 'index'])->name('index');
Route::get('/auth/progress', [AuthController::class, 'progress'])->name('progress');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update.password');

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

route::get('/attendance/{event_id}', [AttendanceController::class, 'index']);
route::get('/attendance/check/in', [AttendanceController::class, 'checkIn']);
route::get('/attendance/check/out', [AttendanceController::class, 'checkOut']);

route::get('/student/activity', [StudentController::class, 'index']);
route::get('/student/activity/{event_id}', [StudentController::class, 'profile']);

route::get('/activity/list', [ActivityController::class, 'index']);
route::get('/activity/list/filter/{id}', [ActivityController::class, 'filter']);

route::get('/reports', [ReportsController::class, 'index']);
route::get('/reports/filter/{id}', [ReportsController::class, 'filter']);
route::get('/reports/event/{id}', [ReportsController::class, 'events']);

route::get('/auth/assign/new', [AssignedController::class, 'index']);
route::post('/auth/assign/save', [AssignedController::class, 'store'])->name('assign.save');

route::get('/ssc/events/new', [EventController::class, 'index']);
route::post('/ssc/events/save', [EventController::class, 'store'])->name('event.save');

route::get('/dashboard', [ReportsController::class, 'dashboard']);

Route::get('/student/schedules', function () {
    return view('students.schedules');
});
Route::get('/student/records', function () {
    return view('students.academic');
});
