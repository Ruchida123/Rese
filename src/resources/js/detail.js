$(function () {
    var date = $(".reserve__content-date").children('td');
    var dateValue = $('input[class="reserve__date-item"]').val()
    // 予約日付の初期表示処理
    if (dateValue !== '') {
        changeText(date, dateValue);
    }
    // 予約日付が変更された場合の処理
    $(document).on('change', 'input[class="reserve__date-item"]', function() {
        var val = $(this).val();
        changeText(date, val);
    })

    var time = $(".reserve__content-time").children('td');
    var timeValue = $('select[class="reserve__time-item"]').val()
    // 予約時間の初期表示処理
    if (timeValue !== '') {
        changeText(time, timeValue);
    }
    // 予約時間が変更された場合の処理
    $(document).on('change', 'select[class="reserve__time-item"]', function() {
        var val = $(this).val();
        changeText(time, val);
    })

    var number = $(".reserve__content-num").children('td');
    var numberValue = $('select[class="reserve__num-item"]').val()
    // 予約人数の初期表示処理
    if (numberValue !== '') {
        changeText(number, numberValue + '人');
    }
    // 予約人数が変更された場合の処理
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

    // 今日より過去の日付選択を不可
    var dtToday= new Date();
    var year = dtToday.getFullYear();
    var month = ("00" + (dtToday.getMonth() + 1)).slice(-2);
    var day = ("00" + dtToday.getDate()).slice(-2);
    var minDate = year + '-' + month + '-' + day;
    $('#reserveDate').attr('min', minDate);
});