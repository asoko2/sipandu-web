<?php

use App\Http\Controllers\Admin\AnggaranController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DesaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Operator\AjuanController;
use App\Http\Controllers\Operator\HomeController as OperatorHomeController;
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

Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name('login');

Route::post('/login', [AuthController::class, 'authenticate']);

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index']);

        Route::prefix('master-role')->group(function () {
            Route::get('/', [RoleController::class, 'index']);
            Route::post('/get-role-json', [RoleController::class, 'getRoleJSON'])->name('get-role-json');
            Route::get('/edit/{id}', [RoleController::class, 'edit']);
            Route::put('/edit/{id}', [RoleController::class, 'update'])->name('update-role');
        });

        Route::prefix('master-desa')->group(function () {
            Route::get('/', [DesaController::class, 'index']);
            Route::post('/get-desa-json', [DesaController::class, 'getDesaJSON'])->name('get-desa-json');
            Route::get('/tambah-desa', [DesaController::class, 'create'])->name('tambah-desa');
            Route::post('/save', [DesaController::class, 'store'])->name('store-desa');
            Route::get('/edit/{id}', [DesaController::class, 'edit']);
            Route::put('/edit/{id}', [DesaController::class, 'update'])->name('update-desa');
            Route::post('/get-desa-by-id', [DesaController::class, 'getDesaById'])->name('get-desa-by-id');
            Route::post('/delete-desa-by-id', [DesaController::class, 'deleteDesaById'])->name('delete-desa-by-id');
        });

        Route::prefix('master-user')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/get-user-json', [UserController::class, 'getUserJSON'])->name('get-user-json');
            Route::get('/tambah-user', [UserController::class, 'create'])->name('tambah-user');
            Route::post('/save', [UserController::class, 'store'])->name('store-user');
            Route::get('/edit/{id}', [UserController::class, 'edit']);
            Route::put('/edit/{id}', [UserController::class, 'update'])->name('update-user');
            Route::post('/get-user-by-id', [UserController::class, 'getUserById'])->name('get-user-by-id');
            Route::post('/delete-user-by-id', [UserController::class, 'deleteUserById'])->name('delete-user-by-id');
        });

        Route::prefix('master-anggaran')->group(function () {
            Route::get('/', [AnggaranController::class, 'index']);
            Route::post('/get-anggaran-json', [AnggaranController::class, 'getAnggaranJSON'])->name('get-anggaran-json');
            Route::get('/tambah-anggaran', [AnggaranController::class, 'create'])->name('tambah-anggaran');
            Route::post('/save', [AnggaranController::class, 'store'])->name('store-anggaran');
            Route::get('/edit/{id}', [AnggaranController::class, 'edit']);
            Route::put('/edit/{id}', [AnggaranController::class, 'update'])->name('update-anggaran');
            Route::post('/get-anggaran-by-id', [AnggaranController::class, 'getAnggaranById'])->name('get-anggaran-by-id');
            Route::post('/delete-anggaran-by-id', [AnggaranController::class, 'deleteAnggaranById'])->name('delete-anggaran-by-id');
        });
    })->middleware('checkRole:1');

    Route::prefix('operator')->group(function () {
        Route::get('/dashboard', [OperatorHomeController::class, 'index']);

        Route::get('/pengajuan', [AjuanController::class, 'index']);
    })->middleware('checkRole:3');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
