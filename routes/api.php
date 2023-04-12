<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ThesisController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('auth/login', [AuthController::class, 'login'])->name('login');
Route::middleware(['auth:api'])->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::post('me', 'me');
    });
    Route::prefix('field')->controller(FieldController::class)->group(function () {
        Route::get('', 'index');
    });
    Route::prefix('location')->controller(LocationController::class)->group(function () {
        Route::get('', 'index');
    });
    Route::prefix('lecturer')->controller(LecturerController::class)->group(function () {
        Route::get('', 'index');
        Route::get('classification', 'classification');
        Route::get('{id}', 'show');
        Route::post('import', 'import');
    });
    Route::prefix('thesis')->controller(ThesisController::class)->group(function () {
        Route::get('', 'index');
        Route::get('classification', 'classification');
        Route::get('filter', 'filter');
        Route::get('nim/{nim}', 'showByNim');
        Route::get('{id}', 'show');
        Route::post('register', 'register');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
        Route::post('import', 'import');
    });
    Route::prefix('seminar')->controller(SeminarController::class)->group(function () {
        Route::get('', 'index');
        Route::post('register', 'register');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::put('schedule/{id}', 'schedule');
        Route::put('validate/{id}', 'validated');
        Route::delete('{id}', 'destroy');
        Route::get('undangan/{id}', 'undangan');
        Route::get('berita-acara/{id}', 'beritaAcara');
    });
    Route::prefix('semester')->controller(SemesterController::class)->group(function () {
        Route::get('', 'index');
    });
    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::put('{user}', 'update');
    });
});
