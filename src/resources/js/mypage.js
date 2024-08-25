$(function () {
    // 予約日時が現在日時を過ぎていた場合グレーアウトする
    $('.reserve__content table').each(function (i, e) {
        var date = $(this).find('.reserve__content-date td').text();
        var time = $(this).find('.reserve__content-time td').text();
        var now = new Date();//現在日時
        // now.setMinutes(now.getMinutes() - 30);
        var target = new Date(date + ' ' + time);//予約日時

        if (target <= now) {
            var frame = $('.reserve__frame')
            var content = $('.reserve__content')
            frame.eq(i).addClass('grayed');
            content.eq(i).addClass('grayed');

            // 変更ボタンを非表示にする
            var update = $('.update');
            update.eq(i).addClass('display-none');

            // 評価ボタンを表示させる
            var review = $('.review');
            var review_btn = $('.review-form__button');
            review.eq(i).removeClass('display-none');
            review_btn.eq(i).addClass('grayed');
        }
    });
});