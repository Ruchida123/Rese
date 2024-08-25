<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Reservation;
use App\Http\Requests\RepresentRequest;

class RepresentController extends Controller
{
    public function index()
    {
        // 店舗情報を取得
        $shops = Shop::with('region', 'genre')->Paginate(5);

        // ページ表示
        return view('represent.index', compact('shops'));
    }

    public function register_view()
    {
        // 地域、ジャンルを取得
        $regions = Region::all();
        $genres = Genre::all();

        // ページ表示
        return view('represent.register', compact('regions', 'genres'));
    }

    public function register(RepresentRequest $request)
    {
        // ジャンル
        $genre_id = $request['genre_id'];

        // 画像URL
        $image_url = '';
        if ($genre_id == 1) {
            $image_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg';
        } elseif ($genre_id == 2) {
            $image_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg';
        } elseif ($genre_id == 3) {
            $image_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg';
        } elseif ($genre_id == 4) {
            $image_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg';
        } elseif ($genre_id == 5) {
            $image_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg';
        }

        // 店舗情報を作成
        Shop::create([
            'name' => $request['name'],
            'region_id' => $request['region_id'],
            'genre_id' => $genre_id,
            'summary' => $request['summary'],
            'image_url' => $image_url
        ]);

        // ページ表示
        return redirect('/represent');
    }

    public function update_view(RepresentRequest $request)
    {
        // 店舗情報を取得
        $shop = Shop::with('region', 'genre')->find($request->id);

        // 地域、ジャンルを取得
        $regions = Region::all();
        $genres = Genre::all();

        // ページ表示
        return view('represent.update', compact('shop', 'regions', 'genres'));
    }

    public function update(RepresentRequest $request)
    {
        // ジャンル
        $genre_id = $request['genre_id'];

        // 画像URL
        $image_url = '';
        if ($genre_id == 1) {
            $image_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg';
        } elseif ($genre_id == 2) {
            $image_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg';
        } elseif ($genre_id == 3) {
            $image_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg';
        } elseif ($genre_id == 4) {
            $image_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg';
        } elseif ($genre_id == 5) {
            $image_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg';
        }

        // 店舗情報を変更
        Shop::find($request->id)->update([
            'name' => $request['name'],
            'region_id' => $request['region_id'],
            'genre_id' => $genre_id,
            'summary' => $request['summary'],
            'image_url' => $image_url
        ]);

        // ページ表示
        return redirect('/represent');
    }

    public function reserve_view(RepresentRequest $request)
    {
        // 予約情報の取得
        $reservations = Reservation::with('shop', 'shop.region', 'shop.genre' , 'user')->ShopSearch($request->id)->paginate(5);

        // 店舗情報を取得
        $shop = Shop::with('region', 'genre')->find($request->id);

        // ページ表示
        return view('represent.reservation', compact('reservations', 'shop'));
    }
}
