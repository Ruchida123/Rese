$(document).on('click', '.openbtn', function () {//ボタンがクリックされたら
	$(this).toggleClass('active');//ボタン自身に activeクラスを付与し
    $('#g-nav').toggleClass('panelactive');//ナビゲーションにpanelactiveクラスを付与
});

$(document).on('click', '#g-nav a', function () {//ナビゲーションのリンクがクリックされたら
    $('.openbtn').removeClass('active');//ボタンの activeクラスを除去し
    $('#g-nav').removeClass('panelactive');//ナビゲーションのpanelactiveクラスも除去
});

// スクロールしたらクラス付与
$(window).scroll(function () {
    if($(window).scrollTop() > 20) {
        $('.openbtn').addClass('opacity');
    } else {
        $('.openbtn').removeClass('opacity');
    }
});

$(function () {
    $(document).on('change', 'select[name="region"]', function () {// 地域が変更された場合の処理
        searchShop();
    });

    $(document).on('change', 'select[name="genre"]', function () {// ジャンルが変更された場合の処理
        searchShop();
    });

    $(document).on('change', 'input[name="keyword"]', function () {// キーワードが変更された場合の処理
        searchShop();
    });

    $('input[name="keyword"]').on('keydown', function (e) {// enterが押下された場合の処理
        if (e.key === 'Enter' || e.keyCode === 13) {
            searchShop();
        };
    });

    // 並び替えが変更された場合の処理
    $(document).on('change', 'select[name="sort"]', function () {
        sortShop();
    });
});

// 飲食店検索処理
function searchShop() {
    //ajax処理スタート
    $.ajax({
        url: '/search', //通信先アドレスで、このURLをあとでルートで設定します
        method: 'GET', //HTTPメソッドの種別を指定します。
        data: getFormData(),
        dataType: 'html'
    })
    //通信成功した時の処理
    .done(function (data) {
        console.log('Shop search success');
        var innerHTML = $('.shop', $(data)).html(); // 取得したHTMLから飲食店一覧を抽出
        $('.shop').html(innerHTML); // 抽出したもので現在のページの中身を置き換える
    })
    //通信失敗した時の処理
    .fail(function (data) {
        console.log('fail',data);
    });
};

// 飲食店一覧ソート処理
function sortShop() {
    //ajax処理スタート
    $.ajax({
        url: '/sort', //通信先アドレスで、このURLをあとでルートで設定します
        method: 'GET', //HTTPメソッドの種別を指定します。
        data: getFormData(),
        dataType: 'html'
    })
    //通信成功した時の処理
    .done(function (data) {
        console.log('Shop sort success');
        var innerHTML = $('.shop', $(data)).html(); // 取得したHTMLから飲食店一覧を抽出
        $('.shop').html(innerHTML); // 抽出したもので現在のページの中身を置き換える
    })
    //通信失敗した時の処理
    .fail(function (data) {
        console.log('fail',data);
    });
};

// サーバーに送信するデータを取得
function getFormData() {
    let region = $('select[name="region"]').val();
    let genre = $('select[name="genre"]').val();
    let keyword = $('input[name="keyword"]').val();
    let sort = $('select[name="sort"]').val() ?? '0';

    return {
        'region': region,
        'genre': genre,
        'keyword': keyword,
        'sort': sort
    };
};
