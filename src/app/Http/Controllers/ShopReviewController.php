<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ShopReviewRequest;
use App\Models\Shop;
use App\Models\ShopReview;
use Auth;

class ShopReviewController extends Controller
{
    public function index($shop_id, $prev_id)
    {
        $user_id = Auth::id();
        $shop = Shop::find($shop_id);

        // レビュー情報
        $review = ShopReview::UserShopReviewSearch($user_id, $shop_id)->first();

        // 評価ページ表示
        return view('review', compact('shop', 'review', 'prev_id'));
    }

    public function posts(ShopReviewRequest $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->shop_id;
        $image_url = null;
        $file = $request->file('image');

        // 既にレビューしていた場合、更新
        $review = ShopReview::UserShopReviewSearch($user_id, $shop_id)->first();

        if (isset($review)) {
            // 更新対象
            $shopReview = ShopReview::find($review->id);

            if (isset($file)) {
                // storageから画像を削除
                $search = 'storage/';
                Storage::disk('public')->delete(mb_substr($review->image_url, strlen($search), NULL, "UTF-8"));

                // ディレクトリ名を任意の名前で設定します
                $dir = 'img';

                // アップロードされたファイル名を取得
                $file_name = $user_id . $shop_id . "_" . $file->getClientOriginalName();

                // imgディレクトリを作成し画像を保存
                // storage/app/public/任意のディレクトリ名/
                $file->storeAs('public/' . $dir, $file_name);

                $image_url = 'storage/' . $dir . '/' . $file_name;

                // 画像URLを更新
                $shopReview->image_url = $image_url;
                $shopReview->save();
            }

            // レビュー情報を更新
            $shopReview->update([
                'evaluate' => $request->evaluate,
                'comment' => $request->comment,
            ]);

        } else {

            if (isset($file)) {
                // ディレクトリ名を任意の名前で設定します
                $dir = 'img';

                // アップロードされたファイル名を取得
                $file_name = $user_id . $shop_id . "_" . $file->getClientOriginalName();

                // imgディレクトリを作成し画像を保存
                // storage/app/public/任意のディレクトリ名/
                $file->storeAs('public/' . $dir, $file_name);

                $image_url = 'storage/' . $dir . '/' . $file_name;
            }

            ShopReview::create([
                'user_id' => $user_id,
                'shop_id' => $shop_id,
                'evaluate' => $request->evaluate,
                'comment' => $request->comment,
                'image_url' => $image_url
            ]);
        }

        if ($request->prev_id == 2) {
            // 詳細画面に遷移
            return redirect('/detail/' . $shop_id);
        }

        // マイページに遷移
        return redirect('/mypage');
    }

    public function deleteView($shop_id, $prev_id)
    {
        $user_id = Auth::id();
        $shop = Shop::find($shop_id);

        // レビュー情報
        $review = ShopReview::UserShopReviewSearch($user_id, $shop_id)->first();

        // 評価ページ表示
        return view('review_delete', compact('shop', 'review', 'prev_id'));
    }

    public function delete(ShopReviewRequest $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->shop_id;

        // 削除対象
        $shopReview = ShopReview::UserShopReviewSearch($user_id, $shop_id)->first();

        if (isset($shopReview->image_url)) {
            // storageから画像を削除
            $search = 'storage/';
            Storage::disk('public')->delete(mb_substr($shopReview->image_url, strlen($search), NULL, "UTF-8"));
        }

        $shopReview->delete();

        // 詳細画面に遷移
        return redirect('/detail/' . $shop_id);
    }

}
