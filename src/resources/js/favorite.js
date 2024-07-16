$(function () {
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
      if (data.status === 401) {
        alert('お気に入り登録するにはログインが必要です。');
      }
      console.log('fail',data);
    });
  });
});