<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Region;
use App\Models\Genre;
use App\Models\Favorite;
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
        // 地域一覧
        $genres = Genre::all();

        // 飲食店一覧ページ表示
        return view('index', compact('shops', 'regions', 'genres', 'favorites'));
    }

    public function detail($shop_id)
    {
        // 飲食店
        $shop = Shop::with('region', 'genre')->find($shop_id);

        // 飲食店詳細ページ表示
        return view('detail', compact('shop'));
    }

}
