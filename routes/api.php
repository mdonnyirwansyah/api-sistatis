<?php

use App\Http\Controllers\FieldController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ThesisController;
use App\Http\Controllers\SeminarController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('field')->name('field.')->controller(FieldController::class)->group(function () {
    Route::get('', 'index')->name('index');
});
Route::prefix('location')->name('location.')->controller(LocationController::class)->group(function () {
    Route::get('', 'index')->name('index');
});
Route::prefix('lecturer')->name('lecturer.')->controller(LecturerController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('field', 'get_lecturers_by_field')->name('get_lecturers_by_field');
    Route::post('import', 'import')->name('import');
});
Route::prefix('thesis')->name('thesis.')->controller(ThesisController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('show', 'show_by_nim')->name('show_by_nim');
    Route::get('{thesis}', 'show')->name('show');
    Route::post('', 'store')->name('store');
    Route::put('{thesis}', 'update')->name('update');
    Route::delete('{thesis}', 'destroy')->name('destroy');
    Route::post('import', 'import')->name('import');
});
Route::prefix('seminar')->name('seminar.')->controller(SeminarController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::post('', 'store')->name('store');
    Route::get('{seminar}', 'show')->name('show');
    Route::put('{seminar}', 'update')->name('update');
    Route::delete('{seminar}', 'destroy')->name('destroy');
});
