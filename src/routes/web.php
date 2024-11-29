<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopReviewController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RepresentController;
use App\Http\Controllers\MailSendController;
use App\Http\Controllers\StripePaymentsController;

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

Route::get('/redirects', [LoginController::class, 'authenticated']);
Route::get('/', [ShopController::class, 'index']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);
Route::get('/search', [ShopController::class, 'search']);
Route::get('/thanks', [RegisterController::class, 'thanks']);
Route::post('/reserve', [ReservationController::class, 'reserve']);

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::post('/favorite', [FavoriteController::class, 'favorite']);
    Route::get('/mypage', [ShopController::class, 'mypage']);
    Route::get('/sort', [ShopController::class, 'sort']);
    Route::delete('/reserve', [ReservationController::class, 'delete']);
    Route::patch('/reserve', [ReservationController::class, 'update']);
    Route::get('/update_reserve', [ReservationController::class, 'updateView']);
    Route::get('/review/{shop_id}/{prev_id}', [ShopReviewController::class, 'index']);
    Route::get('/review/delete', [ShopReviewController::class, 'deleteView']);
    Route::post('/review', [ShopReviewController::class, 'posts']);
    Route::delete('/review', [ShopReviewController::class, 'delete']);
    Route::get('success', function () {
        return view('success');
    })->name('success');
    Route::get('cancel', function () {
        return view('cancel');
    })->name('cancel');
    Route::get('/checkout-payment', [StripePaymentsController::class, 'checkout']); // Stripeフォームへ遷移する処理

});

// 管理画面用
Route::group(['middleware' => ['auth', 'verified', 'role:admin']], function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/register', [AdminController::class, 'register_view']);
    Route::post('/admin/register', [AdminController::class, 'register']);
    Route::post('/mail', [MailSendController::class, 'send']);
    Route::post('/import', [RepresentController::class, 'import']);
    Route::post('/export', [RepresentController::class, 'export']);
});

Route::group(['middleware' => ['auth', 'verified', 'role:admin|represent']], function () {
    Route::get('/represent', [RepresentController::class, 'index']);
    Route::get('/represent/register', [RepresentController::class, 'register_view']);
    Route::post('/represent/register', [RepresentController::class, 'register']);
    Route::get('/represent/update', [RepresentController::class, 'update_view']);
    Route::post('/represent/update', [RepresentController::class, 'update']);
    Route::get('/represent/reserve', [RepresentController::class, 'reserve_view']);
});

Route::group(['middleware' => ['auth', 'verified', 'role:admin|user']], function () {
    Route::get('/allReview/{shop_id}', [ShopReviewController::class, 'review_all']);
});