<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('region', 'genre')->get();
        // 飲食店一覧ページ表示
        return view('index', compact('shops'));
    }

}
