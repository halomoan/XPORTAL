<?php

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

Auth::routes(['verify' => true]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::prefix('manage')->group(function () {
//     Route::get('/', [App\Http\Controllers\HomeController::class, 'manage'])->name('manage');
//     Route::get('home', [App\Http\Controllers\HomeController::class, 'manage'])->name('manage.home');
//     Route::any('{path}', [App\Http\Controllers\HomeController::class, 'manage']);
// });

$MANAGE_PERMISSIONS = 'permission:view users|view roles|view dashboard';

Route::group(['middleware' => ['verified',$MANAGE_PERMISSIONS]],function(){
    Route::group([
            'prefix' => 'manage',
        ], function(){
            //admin Route
            Route::get('/', [App\Http\Controllers\HomeController::class, 'manage'])->name('manage');
            Route::get('home', [App\Http\Controllers\HomeController::class, 'manage'])->name('manage.home');
            Route::any('{path}', [App\Http\Controllers\HomeController::class, 'manage']);
        });

});

