<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserauthController;
use App\Http\Controllers\Backend\Api\AdminauthController;
use App\Http\Controllers\Backend\Api\AccounttypeController;
use App\Http\Controllers\Backend\Api\AccountpackageController;
use App\Http\Controllers\Backend\Api\UserRolesController;
use App\Http\Controllers\Backend\Api\UserController;

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

// user register api
Route::post('register', [UserauthController::class, 'userstore']);
Route::post('login', [UserauthController::class, 'userlogin']);
Route::post('logout', [UserauthController::class, 'userlogout']);
Route::get('gettypes', [AccounttypeController::class, 'gettype']);
Route::get('getpackages', [AccountpackageController::class, 'getpackage']);

Route::group(['prefix'=>'user','middleware' => ['auth:sanctum']], function () {

    Route::get('/details/{id}', [UserauthController::class,'userdetails']);

});

// admin login api
Route::post('admin/register', [AdminauthController::class, 'adminstore']);
Route::post('admin/login', [AdminauthController::class, 'adminlogin']);
Route::post('admin/logout', [AdminauthController::class, 'adminlogout']);


Route::group(['prefix'=>'admin','middleware' => ['auth:sanctum']], function () {

    Route::get('/details/{id}', [AdminauthController::class,'admindetails']);

    Route::resource('accounttypes', AccounttypeController::class,);
    Route::post('accounttype/update', [AccounttypeController::class, 'update']);

    Route::resource('accountpackages', AccountpackageController::class,);
    Route::post('accountpackage/update', [AccountpackageController::class, 'update']);

    Route::resource('userroles', UserRolesController::class);
    Route::post('userrole/update', );
    Route::get('getpermissions', [UserRolesController::class,'getpermissions']);

    Route::resource('users', UserController::class,);
    Route::post('user/update/{id}', [UserController::class,'update']);
    Route::get('getroles', [UserController::class,'getuserroles']);

});
