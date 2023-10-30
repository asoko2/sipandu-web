<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DesaController;
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

        Route::prefix('master-role')->group(function (){
            Route::get('/', [RoleController::class, 'index']);
            Route::post('/get-role-json', [RoleController::class, 'getRoleJSON'])->name('get-role-json');
            Route::get('/edit/{id}', [RoleController::class, 'edit']);
            Route::put('/edit/{id}', [RoleController::class, 'update'])->name('update-role');
        });

        Route::prefix('master-desa')->group(function (){
            Route::get('/', [DesaController::class, 'index']);
            Route::post('/get-desa-json', [DesaController::class, 'getDesaJSON'])->name('get-desa-json');
            Route::get('/edit/{id}', [DesaController::class, 'edit']);
            Route::put('/edit/{id}', [DesaController::class, 'update'])->name('update-desa');
        });

    })->middleware('checkRole:1');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
