<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\AuthController;
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
});

Route::post('/login', [AuthController::class, 'authenticate']);

Route::group(['middleware' => ['auth']], function (){
    Route::prefix('admin')->group(function() {
        Route::get('/dashboard', [HomeController::class, 'index']);
    })->middleware('checkRole:1');
});