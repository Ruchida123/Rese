$(function () {
    // 予約日時が現在日時より30分以上過ぎていた場合グレーアウトする
    $('.reserve__content table').each(function (i, e) {
        var date = $(this).find('.reserve__content-date td').text();
        var time = $(this).find('.reserve__content-time td').text();
        var now = new Date();//現在日時
        now.setMinutes(now.getMinutes() - 30);
        var target = new Date(date + ' ' + time);//予約日時

        if (target <= now) {
            var frame = $('.reserve__frame')
            var content = $('.reserve__content')
            frame.eq(i).addClass('grayed');
            content.eq(i).addClass('grayed');
        }
    });
});