<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ShopService
{
    // 飲食店一覧を評価順に並べる
    public function sortShops(Collection $shopCollections, String $sortKey)
    {
        if (strcmp("1", $sortKey) == 0) {
            // ランダム
            return $shopCollections->shuffle();

        } else if (strcmp("2", $sortKey) == 0) {
            // 評価が高い順
            return $shopCollections->sortByDesc(function($shop){
                        return $shop->shopReview->avg('evaluate');
                    });
        } else if (strcmp("3", $sortKey) == 0) {
            // 評価が低い順
            return $shopCollections->sortBy(function($shop){
                        $avgEvaluate = $shop->shopReview->avg('evaluate');
                        return $avgEvaluate == null ? PHP_FLOAT_MAX : $avgEvaluate;
                    });
        }

        // そのまま返す
        return $shopCollections;

    }
}