<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BankGaransiController;
use App\Http\Controllers\AsuransiController;
use App\Http\Controllers\TitikReklameController;
use App\Http\Controllers\SewaLahanController;
use App\Http\Controllers\SkpdController;
use App\Http\Controllers\ImbController;
use App\Http\Controllers\IprController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\LaporanKegiatanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
Route::get('/laporankegiatans/generate-report', [LaporanKegiatanController::class, 'generateReport'])->name('laporankegiatans.generateReport');
*/

Auth::routes(); // Pastikan Anda sudah memiliki route untuk login
Route::get('/', function () {return redirect('/login');});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () {return view('welcome');});});
Route::get('/iprs/generate-report', [IprController::class, 'generateReport'])->name('iprs.generateReport');
Route::get('/skpds/generate-report', [SkpdController::class, 'generateReport'])->name('skpds.generateReport');
Route::get('/titikreklames/generate-report', [TitikReklameController::class, 'generateReport'])->name('titikreklames.generateReport');
Route::get('/bankgaransis/generate-report', [BankGaransiController::class, 'generateReport'])->name('bankgaransis.generateReport');
Route::get('/laporankegiatans/generate-report', [LaporanKegiatanController::class, 'generateReport'])->name('laporankegiatans.generateReport');
Route::get('/asuransis/generate-report', [AsuransiController::class, 'generateReport'])->name('asuransis.generateReport');
Route::get('/sewalahans/generate-report', [SewaLahanController::class, 'generateReport'])->name('sewalahans.generateReport');
Route::get('/imbs/generate-report', [ImbController::class, 'generateReport'])->name('imbs.generateReport');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/login', function () {return view('login');})->name('login');
Route::post('/logout', function () {Auth::logout();return redirect('/login');})->name('logout');
Route::get('/logout', function () {Auth::logout();return redirect('/login');})->name('logout');
Route::resource('users', UserController::class);
Route::resource('laporankegiatans', LaporanKegiatanController::class);
Route::resource('pegawais', PegawaiController::class);
Route::resource('skpds', SkpdController::class);
Route::resource('iprs', IprController::class);
Route::resource('imbs', ImbController::class);
Route::resource('bankgaransis', BankGaransiController::class);
Route::resource('sewalahans', SewaLahanController::class);
Route::resource('asuransis', AsuransiController::class);
Route::get('/laporankegiatans/{laporankegiatan}', [LaporanKegiatanController::class, 'show'])->name('laporankegiatans.show');
Route::resource('titikreklames', TitikReklameController::class);
