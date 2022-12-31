<?php

use App\Http\Controllers\FieldController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ThesisController;
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
Route::prefix('field')->name('field.')->group(function () {
    Route::get('', [FieldController::class, 'index'])->name('index');
    Route::get('{field}/lecturers', [FieldController::class, 'lecturers'])->name('lecturers');
});
Route::prefix('location')->name('location.')->group(function () {
    Route::get('', [LocationController::class, 'index'])->name('index');
});
Route::prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('', [LecturerController::class, 'index'])->name('index');
    Route::post('import', [LecturerController::class, 'import'])->name('import');
});
Route::prefix('thesis')->name('thesis.')->group(function () {
    Route::get('', [ThesisController::class, 'index'])->name('index');
    Route::get('{thesis}', [ThesisController::class, 'show'])->name('show');
    Route::post('import', [ThesisController::class, 'import'])->name('import');
});
