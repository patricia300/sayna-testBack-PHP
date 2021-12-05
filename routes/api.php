<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SongController;
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

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::group(['middleware' => ['auth:sanctum']],function () {
    //simple user
    Route::delete('/user',[AuthController::class,'destroy']);

    //subcribe access
    Route::get('/songs',[SongController::class,'index']);
    Route::get('/songs/{id}',[SongController::class,'show']);
    Route::put('/user/cart',[CartController::class,'update']);
    Route::get('/bills',[BillController::class,'index']);
    
});
