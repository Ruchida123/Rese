<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;
use App\Http\Requests\ShopReviewRequest;
use App\Models\Shop;
use App\Models\ShopReview;
use App\Models\Favorite;
use Auth;

class ShopReviewController extends Controller
{
    public function index($shop_id, $prev_id)
    {
        $user_id = Auth::id();
        $shop = Shop::find($shop_id);

        // レビュー情報
        $review = ShopReview::UserShopReviewSearch($user_id, $shop_id)->first();

        // お気に入り情報
        $favorite = Favorite::FavoriteShopSearch($user_id, $shop_id)->first();

        // 評価ページ表示
        return view('review', compact('shop', 'review', 'favorite', 'prev_id'));
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

    public function deleteView(Request $request)
    {
        $review_id = $request->review;
        $prev_id = $request->prev;

        // レビュー情報
        $review = ShopReview::find($review_id);

        // 店舗情報
        $shop = Shop::find($review->shop_id);

        // 評価ページ表示
        return view('review_delete', compact('shop', 'review', 'prev_id'));
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $shop_id = $request->shop;

        // 削除対象
        $shopReview = ShopReview::find($request->review);

        if (!isset($shopReview)) {
            // 対象の口コミ情報がない場合、ホームに遷移
            if ($user->hasRole('admin')) {
                return redirect('/represent');
            }
            return redirect('/');
        }

        if ($user->hasRole('user')) {
            if ($user->id != $shopReview->user_id) {
                $message = new MessageBag();
                $message->add('user', '自身の口コミ以外は削除できません');
                return back()->withErrors($message);
            }
        }

        if (isset($shopReview->image_url)) {
            // storageから画像を削除
            $search = 'storage/';
            Storage::disk('public')->delete(mb_substr($shopReview->image_url, strlen($search), NULL, "UTF-8"));
        }

        $shopReview->delete();

        // 詳細画面に遷移
        return redirect($request->prev_url);
    }

    public function review_all($shop_id)
    {
        $user_id = Auth::id();
        $shop = Shop::find($shop_id);

        // レビュー情報
        $reviews = ShopReview::where('shop_id', $shop_id)->Paginate(10);

        // 評価ページ表示
        return view('review_all', compact('shop', 'reviews', 'user_id'));
    }

}
