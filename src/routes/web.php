<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;

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

Route::get('/', [ShopController::class, 'index']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);
Route::get('/search', [ShopController::class, 'search']);
Route::get('/thanks', [RegisterController::class, 'thanks']);
Route::post('/reserve', [ReservationController::class, 'reserve']);

Route::middleware('verified')->group(function () {
    Route::get('/mypage', [ShopController::class, 'mypage']);
    Route::delete('/reserve', [ReservationController::class, 'delete']);
    Route::patch('/reserve', [ReservationController::class, 'update']);
    Route::get('/update_reserve', [ReservationController::class, 'updateView']);
});

Route::post('/favorite', [FavoriteController::class, 'favorite'])->middleware('auth')->middleware('verified');