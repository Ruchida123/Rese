<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use Auth;

class ReservationController extends Controller
{
    public function reserve(ReservationRequest $request)
    {
        // メールアドレス確認しているかどうか
        if (!Auth::user()->email_verified_at) {
            return view('auth.verify-email');
        }
        $user_id = Auth::id(); // ログインユーザーのid取得
        $shop_id = $request->shop_id; // 店舗idの取得
        $prev_url = $request->prev_url;// 直前のURL

        Reservation::create([
            'user_id' => $user_id,
            'shop_id' => $shop_id,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number
        ]);

        // 予約完了ページ表示
        return view('done', compact('shop_id', 'prev_url'));
    }

    public function delete(Request $request)
    {
        $user_id = Auth::id(); // ログインユーザーのid取得
        $reserve_id = $request->reserve_id; // 予約idの取得

        Reservation::find($reserve_id)->delete();

        // マイページ遷移
        return redirect('/mypage');
    }

    public function update(ReservationRequest $request)
    {
        $user_id = Auth::id(); // ログインユーザーのid取得
        $reserve_id = $request->reserve_id; // 予約idの取得

        Reservation::ReserveShopsSearch($user_id, $reserve_id)->update([
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number
        ]);

        // マイページ遷移
        return redirect('/mypage');
    }

    public function updateView(Request $request)
    {
        $user_id = Auth::id(); // ログインユーザーのid取得
        $reserve_id = $request->reserve_id; // 予約idの取得
        $prev_url = url()->previous();// 直前のURL

        $reservation = Reservation::with('shop', 'shop.region','shop.genre')->ReserveShopsSearch($user_id, $reserve_id)->first();

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

        // 予約完了ページ表示
        return view('update_reserve', compact('reservation', 'times', 'numbers', 'prev_url'));
    }
}
