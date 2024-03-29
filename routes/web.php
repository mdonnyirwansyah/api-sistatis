<?php

use App\Http\Controllers\SeminarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('seminar')->controller(SeminarController::class)->group(function () {
    Route::get('undangan/{id}', 'undangan');
    Route::get('berita-acara/{id}', 'beritaAcara');
});
