<?php

require_once (dirname(__FILE__).'/conf.php');
require_once (dirname(__FILE__).'/function.php');

session_start();
$tool_name = $_SESSION["NAME_TOOL"];
$tool_email = $_SESSION["EMAIL_TOOL"];
$tool_session_password = $_SESSION["PASSWORD_TOOL"];
$tool_img = $_SESSION["IMG_TOOL"];

//ログインしていない場合　ログイン画面にリダイレクト
if (!isset($_SESSION["EMAIL_TOOL"]) || (!isset($_SESSION["NAME_TOOL"]))) {
  header('Location: http://localhost:8888/tool_login.php');
  exit();
}

//データベース接続
$link = get_db_connect($link);

// リクエストメソッド取得
$request_method = get_request_method();

//ポスト受け取り
if ($request_method === 'POST') {
  //削除ボタンが押された時のみ実行
  if(isset($_POST['bbs_delete']) === TRUE){
    $comment_id = get_post_data('bbs_delete');

    if (delete_user_bbs_comment($link, $comment_id) === TRUE){
      $msg[] = '削除完了';
    }else {
      $error[] = '削除失敗';
    }
  }
}
//コメント表示内容を取得
$bbs_data = get_bbs_table_list($link);

//特殊文字をエンティティに変換
$bbs_table = entity_assoc_array($bbs_data);

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
     <div class="bbs_display">
       <div class="bbs_display_tool">
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
         <?php foreach($bbs_table as $value) { ?>
         <li id="bbs_display_li">
           <span class="bbs_name"><img src="<?php echo $value['user_img'];?>" alt="user_img"><?php echo $value['bbs_name']; ?></span>
           <div>
             <span class="bbs_comment"><?php  echo $value['bbs_comment'];?></span>
           </div>
           <p><?php echo $value['bbs_time'];?></p>
           <form method="post">
             <button type="submit" name="bbs_delete" value="<?php echo $value['bbs_id']; ?>">削除</button>
           <?php }?>
           </form>
        </li>
       </ul>
     </div>
   </div>
   </div>
 </main>

 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</body>
</html>
