<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;


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

Route::get('/getAllProduct', [ProductController::class, 'getAllProduct']);
Route::get('/getAllCategories', [ProductController::class, 'getAllCategories']);

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::post('/storeCategory', [AdminController::class, 'storeCategory']);
Route::post('/DeleteDataCategory', [AdminController::class, 'DeleteDataCategory']);
Route::post('/updateDataCategory', [AdminController::class, 'updateDataCategory']);
Route::post('/uploadImage', [AdminController::class, 'uploadImage']);
Route::post('/storeProduct', [AdminController::class, 'storeProduct']);
Route::get('/dataProductAdmin', [AdminController::class, 'dataProductAdmin']);
Route::post('/deleteDataProduct', [AdminController::class, 'deleteDataProduct']);
Route::post('/updateDataProduct', [AdminController::class, 'updateDataProduct']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
