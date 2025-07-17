<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DataAbsensiController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\SettingController;

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

    Route::get('/dashboard', [GuruController::class,'index'])->name('dashboard');

    Route::get('/absensi', [AbsensiController::class,'index'])->name('absensi');
    Route::post('/absensi/getLog', [AbsensiController::class,'getAttendanceLog'])->name('absensi.log');
    Route::post('/absensi', [AbsensiController::class,'absen'])->name('scan');
    Route::post('/absensi-izin', [AbsensiController::class,'absenIzin'])->name('absen-izin');

    Route::post('/import/student-import', [DataSiswaController::class, 'ImportStudenData'])->name('import.student');
    Route::get('/import/get-template', [DataSiswaController::class, 'GetTemplateData'])->name('import.get-template');

    // Route::get('/rekap-absensi', [DataAbsensiController::class, 'showGetReportForm'])->name('data-absensi.get-report-form');
    Route::post('/data-absensi/get-report', [DataAbsensiController::class, 'getReport'])->name('data-absensi.get-report');

    Route::resource('/data-siswa', DataSiswaController::class);
    Route::resource('/data-absensi', DataAbsensiController::class);

    // i really want to make it using resource but i'll do normal route since there's no create method ::))
    Route::get('/jam-masuk', [SettingController::class, 'attendanceTime'])->name('setting.attendance-time');
    Route::post('/jam-masuk', [SettingController::class, 'updateAttendanceTime'])->name('update.attendance-time');

    Route::get('/kelola-pesan', [SettingController::class, 'attendanceMessage'])->name('setting.attendance-message');
    Route::post('/kelola-pesan', [SettingController::class, 'updateAttendanceMessage'])->name('update.attendance-message');

});
