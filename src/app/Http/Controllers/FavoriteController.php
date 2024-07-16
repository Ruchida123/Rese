<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Auth;

class FavoriteController extends Controller
{
    public function favorite(Request $request)
    {
        $user_id = Auth::user()->id; // ログインユーザーのid取得
        $shop_id = $request->shop_id; // 店舗idの取得

        $favorite_shop = Favorite::FavoriteShopSearch($user_id, $shop_id)->first(); // お気に入り店舗の取得

        $favorite_flag = false; // お気に入り登録したかどうかのフラグ

        if (isset($favorite_shop)) { // もし既にお気に入り登録していた場合、削除
            Favorite::where('shop_id', $shop_id)->where('user_id', $user_id)->delete();
        } else { // お気に入り登録
            Favorite::create([
                'user_id' => $user_id,
                'shop_id' => $shop_id,
            ]);
            $favorite_flag = true;
        }

        $param = [
            'favorite_flag' => $favorite_flag,
        ];
        return response()->json($param); // JSONデータをjQueryに返す
    }
}
