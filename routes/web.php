<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DataAbsensiController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\DataSiswaController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

// Login & Logout things~
Route::get('/login', [LoginController::class, 'showLoginPage'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware([AuthMiddleware::class])->group(function () {

    // Your authenticated routes here
    Route::get('/dashboard', [GuruController::class,'index'])->name('dashboard');
    Route::get('/absensi', [AbsensiController::class,'index'])->name('absensi');

    Route::post('/import/student-import', [DataSiswaController::class, 'ImportStudenData'])->name('import.student');
    Route::get('/import/get-template', [DataSiswaController::class, 'GetTemplateData'])->name('import.get-template');

    Route::resource('/data-siswa', DataSiswaController::class);
    Route::resource('/data-absensi', DataAbsensiController::class);

});
