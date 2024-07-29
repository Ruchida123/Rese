<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Region;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use Auth;

class ShopController extends Controller
{
    public function index()
    {
        $favorites = []; // お気に入り情報
        if (Auth::check()) { // ログインしてたらお気に入り情報取得
            $user_id = Auth::user()->id;
            $favorites = Favorite::UserFavoriteShopsSearch($user_id)->get();
        }
        // 飲食店一覧
        $shops = Shop::with('region', 'genre')->get();
        // 地域一覧
        $regions = Region::all();
        // ジャンル一覧
        $genres = Genre::all();

        // 飲食店一覧ページ表示
        return view('index', compact('shops', 'regions', 'genres', 'favorites'));
    }

    public function detail($shop_id)
    {
        // 飲食店
        $shop = Shop::with('region', 'genre')->find($shop_id);

        // 時間用リスト
        $times = array();
        for ($i = 0; $i < 24; $i++) {
            // 2桁で0埋め
            $hour = sprintf('%02d', $i);
            // 30分単位
            for ($j = 0; $j < 60; $j += 30) {
                $times[] = $hour.':'.sprintf('%02d', $j);
            }
        };

        // 人数用リスト
        $numbers = array();
        $ranges = range(1,100);
        foreach ($ranges as $range) {
            $numbers[] = strval($range);
        };

        // 飲食店詳細ページ表示
        return view('detail', compact('shop', 'times', 'numbers'));
    }

    public function mypage()
    {
        $user = Auth::user();
        $user_id = $user->id;
        // 予約情報
        $reserves = Reservation::with('shop')->UserReserveShopsSearch($user_id)->orderByRaw('date asc, time asc')->get();
        // お気に入り情報
        $favorites = Favorite::with('shop.region', 'shop.genre')->UserFavoriteShopsSearch($user_id)->get();

        // マイページ表示
        return view('mypage', compact('user', 'reserves', 'favorites'));
    }

}