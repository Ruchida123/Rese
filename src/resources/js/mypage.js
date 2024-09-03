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

            // QRコードボタンのグレーアウト
            $('.qr-code__button').eq(i).addClass('grayed');
        }
    });

    let qr_code = $('.qr-code__button'),
        close = $('.qr-close'),
        container = $('.qr-container');

    // QRコードクリック時
    qr_code.on('click', function () {
        var index = qr_code.index($(this));
        // QRコードを表示する
        container.eq(index).addClass('active');
        return false;
    });

    //閉じるボタンをクリックしたらモーダルを閉じる
    close.on('click', function () {
        container.removeClass('active');
    });

    //モーダルの外側をクリックしたらモーダルを閉じる
    $(document).on('click',function(e) {
        if (!$(e.target).closest('.qr-body').length) {
            container.removeClass('active');
        }
    });
});