<?php

require_once (dirname(__FILE__).'/conf.php');
require_once (dirname(__FILE__).'/function.php');

session_start();
$tool_name = $_SESSION["NAME_TOOL"];
$tool_email = $_SESSION["EMAIL_TOOL"];
$tool_session_password = $_SESSION["PASSWORD_TOOL"];
$tool_img = $_SESSION["IMG_TOOL"];

$diary_list = $_SESSION["diary_list"];
$username = $_SESSION["name_list"];
$email = $_SESSION["email_list"];
$user_img = $_SESSION["img_list"];

//ログインしていない場合　ログイン画面にリダイレクト
if (!isset($_SESSION["EMAIL_TOOL"]) || (!isset($_SESSION["NAME_TOOL"]))) {
  header('Location: http://localhost:8888/tool_login.php');
  exit();
}
//データベース接続
$link = get_db_connect($link);
// リクエストメソッド取得
$request_method = get_request_method();


//////ボタンが押された時の再読み込みのデータ
//ユーザー予定内容取得
$diary_list = get_diary_table_list($link, $email);
//特殊文字をエンティティに変換
$diary_table = entity_assoc_array($diary_list);
/////ここまで


if($request_method === 'POST'){

  //ページ遷移した時に受け取るポスト
  if(isset($_POST['friend_list_diary']) === TRUE){
    $email = get_post_data('friend_list_diary');
    //ユーザー予定内容取得
    $diary_list = get_diary_table_list($link, $email);

    //特殊文字をエンティティに変換
    $diary_table = entity_assoc_array($diary_list);

    //ユーザー名
    $username = get_userdata_name($link,$email);

    //ユーザー画像
    $user_img = get_userdata_img($link, $email);

    $_SESSION["diary_list"] = $diary_list;
    $_SESSION["name_list"] = $username;
    $_SESSION["email_list"] = $email;
    $_SESSION["img_list"] = $user_img;
  }

  //パスワードリセットボタンが押された時のみ実行
  if(isset($_POST['friend_list_password_reset']) === TRUE){

    $tool_pass = get_post_data('tool_pass');
    $email = get_post_data('friend_list_password_reset');

    //エラーチェック
    if (error_check_trim($tool_pass) !== true){
      $error[] = 'パスワードを入力してください';
    }
    //入力されたパスワードを照合
    if(password_verify($tool_pass, $tool_session_password) !== TRUE){
      $error[] = 'パスワードが間違っています';
    }

    //エラーがない場合のみ実行
    if(count($error) === 0){
      $id = get_pass();
      $ps = password_hash($id, PASSWORD_DEFAULT);

      if(change_user_password_reset($link, $email, $ps) === TRUE){
        $msg[] = 'ユーザーパスワード再設定　成功';
      }else{
        $error[] = 'ユーザーデータが取得できません';
      }
    }else{
      $error[] = 'ユーザーパスワード再設定 失敗';
    }
  }


  //削除ボタンが押された時のみ実行
  if(isset($_POST['friend_list_delete']) === TRUE){
    $user_id = get_post_data('friend_list_delete');
    $tool_pass = get_post_data('tool_pass');

    //エラーチェック
    if (error_check_trim($tool_pass) !== true){
      $error[] = 'パスワードを入力してください';
    }
    //入力されたパスワードを照合
    if(password_verify($tool_pass, $tool_session_password) !== TRUE){
      $error[] = 'パスワードが間違っています';
    }

    //ユーザー情報削除
    if(count($error) === 0){
      if(delete_user_data($link, $user_id) === TRUE){
        delete_user_diary($link, $user_id);

        $_SESSION["diary_list"] = '';
        $_SESSION["name_list"] = '';
        $_SESSION["email_list"] = '';
        $_SESSION["img_list"] = '';

        //削除完了画面に移動
        header('Location: http://localhost:8888/tool_delete.php');
        exit();
      }else{
        $error[] = 'ユーザーデータが取得できません';
      }
    }else{
      $error[] = 'ユーザーアカウント抹消　失敗';
    }
  }

}
//データベース切断
close_db_connect($link);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UFT-8">
  <title>ARG新人用掲示板-Doorkey's- 管理画面</title>
  <link rel="stylesheet" href="Style/stylesheet.css">
</head>
<body>
  <header>
    <p id="logo_img"><a href="tool.php"><img src="Images/logo-image.png"></a></p>
    <div class="login-text">
      <img src="<?php echo entity_str($tool_img); ?>" alt="tool_img">
      <?php echo 'ようこそ  '. entity_str($tool_name). '  さん';?>
      <a href="tool_logout.php">ログアウトはこちら</a>
    </div>
  </header>
  <main>
   <div class="big-container">
     <div class="main-container">
       <a href="tool.php">
         <div class="side-box">
           <p><img src="Images/friend-logo.png" alt="friend-logo">社員</p>
         </div>
       </a>
       <a href="tool_bbs.php">
         <div class="side-box">
           <p><img src="Images/bbs-logo.png" alt="bbs-logo">書き込み</p>
         </div>
       </a>
       <a href="tool_setting.php">
         <div class="side-box">
           <p><img src="Images/setting-logo.png" alt="setting-logo">設定</p>
         </div>
       </a>
    </div>
   <div class="sub-container">
     <div class="friend-list">
       <div class="friend-list-diary-tool">
         <ul>
           <?php
           if (count($error) !== 0 ) {
               foreach($error as $error_msg) { ?>
               <li id="error"><?php echo $error_msg; ?></li>
               <?php }
           } ?>
           <?php
           if (count($msg) !== 0){
             foreach ($msg as $msg_display) { ?>
               <li id="success"><?php echo $msg_display; ?></li>
             <?php }
           }?>
           <img src="<?php echo entity_str($user_img) ?>" alt="user_logo">
           <p><?php echo entity_str($username); ?></p>
           <?php foreach($diary_table as $value) { ?>
            <li id="tool-diary-list-display"><?php print $value['user_diary']. ' - '. $value['user_date']; ?></li>
          <?php } ?>
         </ul>
         <h1>メッセージを送る(メールアドレス)</h1>
         <a href="mailto:<?php echo entity_str($email);?>"><?php echo entity_str($email); ?></a>
         <form method="post">
           <h1>ユーザーパスワード再設定(パスワード初期化)</h1>
           <a href="mailto:<?php echo entity_str($email);?>?subject=Androbo %E6%96%B0%E4%BA%BA%E7%A4%BE%E5%93%A1%E5%B0%82%E7%94%A8Doorkeys%E3%81%AE%E3%83%91%E3%82%B9%E3%83%AF%E3%83%BC%E3%83%89%E3%83%AA%E3%82%BB%E3%83%83%E3%83%88%E3%81%AE%E9%80%9A%E7%9F%A5&amp;body=<?php echo entity_str($username);?>%E3%81%95%E3%82%93%E3%80%80%0D%0ADoorkeys%E3%82%92%E3%81%94%E5%88%A9%E7%94%A8%E9%A0%82%E3%81%8D%E8%AA%A0%E3%81%AB%E3%81%82%E3%82%8A%E3%81%8C%E3%81%A8%E3%81%86%E3%81%94%E3%81%96%E3%81%84%E3%81%BE%E3%81%99%E3%80%82%0D%0A%E3%83%AA%E3%82%BB%E3%83%83%E3%83%88%E3%83%91%E3%82%B9%E3%83%AF%E3%83%BC%E3%83%89%E3%81%AF%5B%5D%E3%81%A7%E3%81%99%E3%80%82%0D%0A%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3%E3%81%97%E3%81%9F%E9%9A%9B%E3%81%AF%E8%A8%AD%E5%AE%9A%E3%83%9A%E3%83%BC%E3%82%B8%E3%82%88%E3%82%8A%E6%96%B0%E3%81%97%E3%81%84%E3%83%91%E3%82%B9%E3%83%AF%E3%83%BC%E3%83%89%E3%81%AB%E5%86%8D%E8%A8%AD%E5%AE%9A%E3%81%97%E3%81%A6%E9%A0%82%E3%81%8D%E3%81%BE%E3%81%99%E3%82%88%E3%81%86%E3%81%94%E5%8D%94%E5%8A%9B%E3%82%92%E3%82%88%E3%82%8D%E3%81%97%E3%81%8F%E3%81%8A%E9%A1%98%E3%81%84%E8%87%B4%E3%81%97%E3%81%BE%E3%81%99%E3%80%82%0D%0A%0D%0AAndrobo Group Doorkeys %E3%80%80%E9%81%8B%E5%96%B6">
             パスワード初期化のメール送信はこちら
           </a>
           <label>管理者パスワード入力</label>
           <input type="password" name="tool_pass">
           <button type="submit" name="friend_list_password_reset" value="<?php echo entity_str($email); ?>">パスワード再設定</button>
         </form>
         <form method="post">
         <h1>ユーザーアカウント抹消</h1>
         <label>管理者パスワード入力</label>
         <input type="password" name="tool_pass">
           <button type="submit" name="friend_list_delete" value="<?php echo entity_str($email); ?>">アカウント削除</button>
        </form>
         <a href="tool.php">社員一覧に戻る</a>
       </div>
     </div>
   </div>
 </main>

 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</body>
</html>
