
<?php
require_once ('/Users/nk/github/doorkeys/bbs/conf.php');
require_once ('/Users/nk/github/doorkeys/bbs/function.php');

$bbs_table = array();
$name = '';
$text = '';
$error = array();

//echo "request---". $_REQUEST['check']. "\n";

  //データベース接続
  $link = get_db_connect($link);
  // リクエストメソッド取得
  $request_method = get_request_method();
  //var_dump($request_method);
  //実行
  if ($request_method === 'POST') {

      //フォーム内容取得
      $name = get_post_data('name');
      $text = get_post_data('text');
      $request = get_post_data('check');

      //エラーチェック
      if (error_check_trim($name) !== true) {
          $error[] = '名前を入力してください';
      }
      if (error_check_trim($text) !== true) {
          $error [] = 'コメントを入力してください';
      }
      if (error_check_name_length($name) !== true) {
          $error[] = '名前は１０文字以内で入力してください';
      }
      if (error_check_text_length($text) !== true) {
          $error[] = 'コメントは１００文字以内で入力してください';
      }
      if(error_check_duplication_bbs($link, $request) !== true){
        $error[] = 'リロード完了';
      }
      //var_dump($error);

      //書き込み内容を取得
      $bbs_update = get_insert_bbs_table($name, $text,$request);

      //エラーがない場合 クリエ実行
      if (count($error) === 0) {
          $result = mysqli_query($link, $bbs_update);
      }
  }

  //コメント表示内容を取得
  $bbs_data = get_bbs_table_list($link);

  //特殊文字をエンティティに変換
  $bbs_table = entity_assoc_array($bbs_table);

  $_SESSION["check"] = $check = mt_rand();
  //データベース切断
  close_db_connect($link);

?>

<!DOCTYPE html>
  <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>新入社員専用チャットDoorKey's</title>
        <link rel="stylesheet" href="style/bbs.css">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <h1>掲示板</h1>
        <form method="post">
            <ul>
                <?php
                if (count($error) !== 0 ) {
                    foreach($error as $error_msg) { ?>
                    <li id="error"><?php print $error_msg; ?></li>
                    <?php }
                } ?>
            </ul>
            名前:<input type="name" name="name" value="<?php $name ?>">
            ひとこと:<input type="text" name="text" value="<?php $text ?>">
            <input name="check" type="hidden" value="<?PHP print md5(microtime());?>">
            <input type="submit" name="send" value="投稿">
            <ul>
                <?php foreach($bbs_data as $value) { ?>
                <li><?php print $value['bbs_name']. '  '. $value['bbs_comment']. ' - '. $value['bbs_time']; ?></li>
                <?php } ?>
            </ul>
        </form>
    </body>
</html>
