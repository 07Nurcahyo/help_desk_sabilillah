<?php

use App\Http\Controllers\main_controller;
use Illuminate\Support\Facades\Route;

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
    // return view('admin/main');
    return view('login');
});

Route::get('/login_admin', [main_controller::class, 'login'])->name('login');
Route::post('proses_login', [main_controller::class, 'proses_login'])->name('proses_login');
Route::get('logout', [main_controller::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function() {
    Route::group(['middleware' => ['cek_login']], function() {
        
        Route::group(['prefix' => 'user'], function() {
            Route::get('/', [main_controller::class, 'index']);
            // Route::get('/dashboard', [main_controller::class, 'index']);

            // Admin

            // User
            Route::get('/kelola_laporan', [main_controller::class, 'kelola_laporan']);
            Route::post('/tambah_data_laporan', [main_controller::class, 'tambah_data_laporan'])->name('tambah_data_laporan');
        });

        Route::get('/lihat_data_laporan', [main_controller::class, 'lihat_data_laporan']);
        // Route::group(['prefix' => 'user'], function() {
        // });

    });
});