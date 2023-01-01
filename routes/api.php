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
    Route::get('{field}/lecturer', 'lecturers')->name('lecturers');
});
Route::prefix('location')->name('location.')->controller(LocationController::class)->group(function () {
    Route::get('', 'index')->name('index');
});
Route::prefix('lecturer')->name('lecturer.')->controller(LecturerController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::post('import', 'import')->name('import');
});
Route::prefix('thesis')->name('thesis.')->controller(ThesisController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('{thesis}', 'show')->name('show');
    Route::post('', 'store')->name('store');
    Route::post('import', 'import')->name('import');
});
Route::prefix('seminar')->name('seminar.')->controller(SeminarController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('{seminar}', 'show')->name('show');
});
