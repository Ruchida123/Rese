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
        changeTimeSelectValue(val);
    })

    var time = $(".reserve__content-time").children('td');
    var timeValue = $('select[class="reserve__time-item"]').val()
    // 予約時間の初期表示処理
    if (timeValue !== '') {
        changeTimeSelectValue(dateValue, timeValue);
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
    function changeText(selector, val) {
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

    // 予約時間の選択項目を変更する
    function changeTimeSelectValue(val, timeVal) {
        var dtToday = new Date();
        var dtSelectVal = new Date(val);
        // 予約時間テーブル
        var time_table = [
            {value: "", label: "予約時間を選択してください"},
        ]

        // 予約時間のセレクトを初期化
        $('select[class="reserve__time-item"]').children().remove();

        if (compareDateOnly(dtToday, dtSelectVal)) {
            var hour = dtToday.getHours();
            var minute = dtToday.getMinutes();

            for (let i = hour; i < 24; i++) {
                if (i == hour) {
                    if (minute < 30) {
                        time_table.push({
                            value: ('0' + i).slice(-2) + ':30', label: ('0' + i).slice(-2) + ':30'
                        });
                    }
                    continue;
                }
                time_table.push({
                    value: ('0' + i).slice(-2) + ':00', label: ('0' + i).slice(-2) + ':00'
                });
                time_table.push({
                    value: ('0' + i).slice(-2) + ':30', label: ('0' + i).slice(-2) + ':30'
                });
            };
        } else {
            for (let i = 0; i < 24; i++) {
                time_table.push({
                    value: ('0' + i).slice(-2) + ':00', label: ('0' + i).slice(-2) + ':00'
                });
                time_table.push({
                    value: ('0' + i).slice(-2) + ':30', label: ('0' + i).slice(-2) + ':30'
                });
            };
        }

        // 予約時間テーブルをセット
        time_table.forEach( function(table)
        {
            // 初期値選択
            if (table.value == timeVal) {
                $('select[class="reserve__time-item"]').append($("<option>").attr({ value: table.value }).prop('selected', true).text(table.label));
            } else {
                $('select[class="reserve__time-item"]').append($("<option>").attr({ value: table.value }).text(table.label));
            };
        });
    }

    // 日付が同じかどうか
    function compareDateOnly(date1, date2) {
        var year1 = date1.getFullYear();
        var month1 = date1.getMonth() + 1;
        var day1 = date1.getDate();

        var year2 = date2.getFullYear();
        var month2= date2.getMonth() + 1;
        var day2 = date2.getDate();

        if (year1 == year2 && month1 == month2 && day1 == day2) {
            return true;
        }
        return false;
    }
});