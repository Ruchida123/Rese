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
        $user_id = Auth::user()->id; // ログインユーザーのid取得
        $shop_id = $request->shop_id; // 店舗idの取得

        Reservation::create([
            'user_id' => $user_id,
            'shop_id' => $shop_id,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
            'delete_flag' => false,
        ]);

        // 予約完了ページ表示
        return view('done', compact('shop_id'));
    }
}
