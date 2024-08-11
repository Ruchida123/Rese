$(function () {
  // 変数に要素を入れる
  var close = $('.modal-close'),
    container = $('.modal-container'),
    text = $('.modal-content').children('p');

  let like = $('.favorite-img'); //favorite-imgのついたimgタグを取得し代入。
  like.on('click', function () { //onはイベントハンドラー
    let $this = $(this); //this=イベントの発火した要素＝imgタグを代入
    shopId = $this.data('shop_id'); //iタグに仕込んだdata-shop_idの値を取得
    //ajax処理スタート
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/favorite', //通信先アドレスで、このURLをあとでルートで設定します
      method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      data: { //サーバーに送信するデータ
        'shop_id': shopId //押下された店舗のidを送る
      },
    })
    //通信成功した時の処理
    .done(function (data) {
        $this.toggleClass('liked'); //likedクラスのON/OFF切り替え。
        console.log('success',data);
    })
    //通信失敗した時の処理
      .fail(function (data) {
      console.log('fail',data);
      if (data.status === 401) {
        //モーダルを表示する
        container.addClass('active');
        text.text('お気に入り登録するにはログインが必要です。');
      } else if (data.status === 403) {
        //メールアドレス確認画面へ遷移
        window.location.href = '/email/verify';
      }
      return false;
    });
  });

  // モーダル
  //閉じるボタンをクリックしたらモーダルを閉じる
  close.on('click',function(){
    container.removeClass('active');
  });

  //モーダルの外側をクリックしたらモーダルを閉じる
  $(document).on('click',function(e) {
    if(!$(e.target).closest('.modal-body').length) {
      container.removeClass('active');
    }
  });
});
