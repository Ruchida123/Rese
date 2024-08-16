<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShopReviewRequest;
use App\Models\Shop;
use App\Models\ShopReview;
use Auth;

class ShopReviewController extends Controller
{
    public function index($shop_id)
    {
        $user_id = Auth::id();
        $shop = Shop::find($shop_id);

        // レビュー情報
        $review = ShopReview::UserShopReviewSearch($user_id, $shop_id)->first();

        // 評価ページ表示
        return view('review', compact('shop', 'review'));
    }

    public function posts(ShopReviewRequest $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->shop_id;

        // 既にレビューしていた場合、削除
        $review = ShopReview::UserShopReviewSearch($user_id, $shop_id)->first();

        if (isset($review)) {
            ShopReview::where('user_id', $user_id)->where('shop_id', $shop_id)->delete();
        } else {
            ShopReview::create([
                'user_id' => $user_id,
                'shop_id' => $shop_id,
                'evaluate' => $request->evaluate,
                'comment' => $request->comment
            ]);
        }

        // マイページに遷移
        return redirect('/mypage');
    }

}
