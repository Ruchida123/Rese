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
Route::get('/thanks', [RegisterController::class, 'thanks']);
Route::post('/reserve', [ReservationController::class, 'reserve']);

Route::middleware('auth')->group(function () {
    Route::post('/favorite', [FavoriteController::class, 'favorite']);
});
