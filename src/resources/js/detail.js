$(function () {
    // 予約日付が変更された場合の処理
    var date = $(".reserve__content-date").children('td');
    $(document).on('change', 'input[class="reserve__date-item"]', function() {
        var val = $(this).val();
        changeText(date, val);
    })

    // 予約時間が変更された場合の処理
    var time = $(".reserve__content-time").children('td');
    $(document).on('change', 'select[class="reserve__time-item"]', function() {
        var val = $(this).val();
        changeText(time, val);
    })

    // 予約人数が変更された場合の処理
    var number = $(".reserve__content-num").children('td');
    $(document).on('change', 'select[class="reserve__num-item"]', function() {
        var val = $(this).val();
        var text = val.length ? val + '人' : '-';
        number.text(text);
    })

    // テキストを書き換える
    function changeText (selector, val) {
        if (val.length) {
            selector.text(val);
        } else {
            selector.text('-');
        }
    }
});