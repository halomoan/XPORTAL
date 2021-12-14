<?php

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

//Route::apiResources(['user' => 'App\Http\Controllers\API\UserController']);
//Route::apiResources(['perm' => 'App\Http\Controllers\API\PermController']);

Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::apiResources(['notification' => 'App\Http\Controllers\API\NotificationController']);
});

$MANAGE_PERMISSIONS = 'permission:view users|view roles|view dashboard';

Route::group(['middleware' => ['auth:sanctum',$MANAGE_PERMISSIONS]],function(){
    Route::group([
            'prefix' => 'manage',
            'as' => 'manage'
        ], function(){
            //admin Route
            Route::apiResources(['user' => 'App\Http\Controllers\API\UserController']);
            Route::apiResources(['role' => 'App\Http\Controllers\API\RoleController']);
            Route::apiResources(['profile' => 'App\Http\Controllers\API\ProfileController']);
            Route::get('/role/{id}/permissions',[App\Http\Controllers\API\RoleController::class,'permissions']);
            Route::apiResources(['perm' => 'App\Http\Controllers\API\PermController']);
        });

});
