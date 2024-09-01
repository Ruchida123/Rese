$(function () {
  // 変数に要素を入れる
  var close = $('.modal-close'),
    container = $('.modal-container'),
    text = $('.modal-content').children('p');

  let send = $('.mail-form__button-submit'); //タグを取得し代入。
  send.on('click', function () { //onはイベントハンドラー
    let $this = $(this); //this=イベントの発火した要素＝タグを代入
    //ajax処理スタート
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/mail', //通信先アドレスで、このURLをあとでルートで設定します
      method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      data: { //サーバーに送信するデータ
        'admin_name': $this.data('admin_name'),
        'admin_email': $this.data('admin_email'),
        'user_name': $this.data('user_name'),
        'user_email': $this.data('user_email')
      },
    })
    //通信成功した時の処理
    .done(function (data) {
      //モーダルを表示する
      container.addClass('active');
      text.text('お知らせメールを送信しました。');
      console.log('success',data);
    })
    //通信失敗した時の処理
      .fail(function (data) {
      console.log('fail',data);
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
