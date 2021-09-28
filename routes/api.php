<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\uploadController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('register',[authController::class,'register']);
Route::post('login',[authController::class,'login']);

Route::post('uploadsImage',[uploadController::class,'uploadsImage']);
Route::post('postCategory',[uploadController::class,'postCategory']);
Route::post('postProduct',[uploadController::class,'postProduct']);
Route::get('idProduct',[uploadController::class,'idProduct']);
Route::get('foodMenu',[uploadController::class,'foodMenu']);
Route::get('suggestMenu',[uploadController::class,'suggestMenu']);


Route::get('categoryProducts',[uploadController::class,'categoryProducts']);