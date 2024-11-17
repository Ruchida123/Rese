<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Reservation;
use App\Http\Requests\RepresentRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Auth;

class RepresentController extends Controller
{
    public function index()
    {
        // 店舗情報を取得
        $shops = Shop::with('region', 'genre')->orderBy('updated_at', 'desc')->Paginate(10);

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

    public function import(RepresentRequest $request)
    {
        if ($request->hasFile('csvFile')) {
            // リクエストからファイルを取得
            $file = $request->file('csvFile');

            // CSVファイルではない場合エラーとする
            if (!(strcmp($file->getClientMimeType(), 'text/csv') == 0)) {
                $error = '拡張子が「.csv」のファイルを選択してください。';
                return redirect('/represent')->with(compact('error'));
            }
            $path = $file->getRealPath();
            // ファイルを開く
            $fp = fopen($path, 'r');
            // ヘッダー行をスキップ
            fgetcsv($fp);
            // 1行ずつ読み込む
            while (($csvData = fgetcsv($fp)) !== FALSE) {
                $this->InsertCsvData($csvData);
            }
            // ファイルを閉じる
            fclose($fp);
        } else {
            $error = 'CSVファイルの取得に失敗しました。';
            return redirect('/represent')->with(compact('error'));
        }

        // ページ表示
        return redirect('/represent');
    }

    public function InsertCsvData($csvData)
    {
        // csvファイル情報をインサートする
        $shop = new Shop;
        $shop->name = $csvData[0];
        $region = Region::select('id')->where('name', $csvData[1])->first();
        $shop->region_id = $region->id;
        $genre = Genre::select('id')->where('name', $csvData[2])->first();
        $shop->genre_id = $genre->id;
        $shop->summary = $csvData[3];
        $shop->image_url = $csvData[4];
        $shop->save();
    }

    public function export(Request $request)
    {
        // csvインポート用の様式をダウンロード
        $csvHeader = ['店舗名', '地域', 'ジャンル', '店舗概要', '画像URL'];
        $csvData = ['', '', '', '', ''];

        $response = new StreamedResponse(function () use ($csvHeader, $csvData) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $csvHeader);
            fputcsv($handle, $csvData);

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="shopImport.csv"',
        ]);

        return $response;
    }

}
