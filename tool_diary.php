<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

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

if($request_method === 'POST'){

  //削除ボタンが押された時のみ実行

  if(isset($_POST['friend_list_delete']) === TRUE){
    $user_id = get_post_data('friend_list_delete');

    //ユーザー情報削除
    $delete_user = delete_user_data($link, $user_id);

    if($delete_user === TRUE){
      $msg[] = '削除完了';
      //ユーザーdiary削除
      $delete_diary = delete_user_diary($link, $user_id);
    }else {
      $error[] = '削除失敗';
    }
  }

  if(isset($_POST['friend_list_diary']) === TRUE){
    $user_email = get_post_data('friend_list_diary');
    //ユーザー予定内容取得
    $diary_list = get_diary_table_list($link, $user_email);

    //特殊文字をエンティティに変換
    $diary_table = entity_assoc_array($diary_list);

    //ユーザー名
    $user_name = get_userdata_name($link,$email);

    //ユーザー画像
    $user_img = get_userdata_img($link, $email);

    $_SESSION["diary_list"] = $diary_list;
    $_SESSION["name_list"] = $user_name;
    $_SESSION["email_list"] = $user_email;
    $_SESSION["img_list"] = $user_img;
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
    <p id="logo_img"><a href="index.php"><img src="Images/logo-image.png"></a></p>
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
           <p>社員一覧</p>
         </div>
       </a>
       <a href="tool_bbs.php">
         <div class="side-box">
           <p>書き込み一覧</p>
         </div>
       </a>
       <a href="tool_setting.php">
         <div class="side-box">
           <p>設定</p>
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
           if (count($msg) !==0){
             foreach ($msg as $msg_display) { ?>
               <li id="success"><?php echo $msg_display; ?></li>
             <?php }
           }?>
           <img src="<?php echo entity_str($user_img) ?>" alt="user_logo">
           <p><?php echo entity_str($user_name); ?></p>
           <?php foreach($diary_table as $value) { ?>
            <li><?php print $value['user_diary']. ' - '. $value['user_date']; ?></li>
          <?php } ?>
         </ul>
         <form method="post">
           <button type="submit" name="friend_list_password_reset" value="<?php echo entity_str($email); ?>">パスワード再設定</button>

         </form>
         <form method="post">
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
