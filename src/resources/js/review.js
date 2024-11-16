$(function () {
    // 文字数カウント
    $('[name="comment"]').on('keyup', function (e) {
        $("#commentCnt").html($(this).val().length + "/400（最高文字数）");
    });

    // ドラッグオーバー時の処理
    $(document).on('dragover', '.drop-area', function(e){
        e.preventDefault();
        $(this).addClass('drag-over');
    });

    // ドラッグアウト時の処理
    $(document).on('dragleave', '.drop-area', function(e){
        e.preventDefault();
        $(this).removeClass('drag-over');
    });

    // ドロップ時の処理
    $(document).on('drop', '.drop-area', function (e) {
        $(this).removeClass('drag-over');
        $(this).find('.uploader')[0].files=e.originalEvent.dataTransfer.files
        $(this).find('.uploader').trigger('change')
    })

    // ドロップされた画像をプレビューエリアに表示
    $(document).on('change', '.drop-area .uploader', function (e) {
        let area = $(this)
        let fileReader = new FileReader()
        fileReader.onload = (function () {
            let imgTag = `<img src='${fileReader.result}'>`
            area.closest(".drop-area").find(".preview-area").html(imgTag)
        })
        fileReader.readAsDataURL(e.target.files[0])
    })

    // ドロップエリア以外のドロップ禁止
    $(document).on('dragenter dragover drop', function (e) {
        e.stopPropagation()
        e.preventDefault()
    })
});
