<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ThesisController;
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
        Route::get('field', 'get_lecturers_by_field');
        Route::post('import', 'import');
    });
    Route::prefix('thesis')->controller(ThesisController::class)->group(function () {
        Route::get('', 'index');
        Route::get('filter', 'filter');
        Route::get('show', 'show_by_nim');
        Route::get('{thesis}', 'show');
        Route::post('', 'store');
        Route::put('{thesis}', 'update');
        Route::delete('{thesis}', 'destroy');
        Route::post('import', 'import');
    });
    Route::prefix('seminar')->controller(SeminarController::class)->group(function () {
        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('{seminar}', 'show');
        Route::put('{seminar}', 'update');
        Route::put('schedule/{seminar}', 'schedule_update');
        Route::put('validate/{seminar}', 'validate_update');
        Route::delete('{seminar}', 'destroy');
        Route::get('undangan/{seminar}', 'undangan');
    });
    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::put('{user}', 'update');
    });
});
