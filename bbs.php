
<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

session_start();

$user_name = $_SESSION["NAME"];
$email = $_SESSION["EMAIL"];
$session_password = $_SESSION["PASSWORD"];
$user_task = $_SESSION["TASK"];
$user_img = $_SESSION["IMG"];

//ログインしていない場合　ログイン画面にリダイレクト
if (!isset($_SESSION["EMAIL"]) || (!isset($_SESSION["NAME"]))) {
  header('Location: http://localhost:8888/login.php');
  exit();
}

$bbs_table = array();
$text = '';
//echo "request---". $_REQUEST['check']. "\n";

  //データベース接続
  $link = get_db_connect($link);
  // リクエストメソッド取得
  $request_method = get_request_method();
  //実行
  if ($request_method === 'POST') {

      //フォーム内容取得
      $text = get_post_data('text');
      $request = get_post_data('check');

      //エラーチェック
      if (error_check_trim($text) !== true) {
          $error [] = 'コメントを入力してください';
      }
      if (error_check_text_length($text) !== true) {
          $error[] = 'コメントは１００文字以内で入力してください';
      }
      if(error_check_duplication_bbs($link, $request) !== true){
        $error[] = 'リロード完了';
      }
      //var_dump($error);

      //書き込み内容を取得
      $bbs_update = get_insert_bbs_table($user_name, $text,$request, $email);

      //エラーがない場合 クリエ実行
      if (count($error) === 0) {
          $result = mysqli_query($link, $bbs_update);
          $msg[] = '投稿完了';
      }
  }

  //コメント表示内容を取得
  $bbs_data = get_bbs_table_list($link);

  //特殊文字をエンティティに変換
  $bbs_table = entity_assoc_array($bbs_data);

  $_SESSION["check"] = $check = mt_rand();
  //データベース切断
  close_db_connect($link);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UFT-8">
  <title>ARG新人用掲示板-Doorkey's-</title>
  <link rel="stylesheet" href="Style/stylesheet.css">
</head>
<body>
  <header>
      <p id="logo_img"><a href="index.php"><img src="Images/logo-image.png"></a></p>
      <div class="login-text">
        <img src="<?php echo entity_str($user_img); ?>" alt="user_img">
        <?php echo 'ようこそ  '. entity_str($user_name). '  さん';?>
        <a href="logout.php">ログアウトはこちら</a>
      </div>
  </header>
  <main>
   <div class="big-container">
     <div class="main-container">
       <a href="index.php">
         <div class="side-box">
           <p>HOME</p>
         </div>
       </a>
       <a href="friend.php">
         <div class="side-box">
           <p>同期</p>
         </div>
       </a>
       <a href="bbs.php">
         <div class="side-box">
           <p>広場</p>
         </div>
       </a>
       <a href="question.php">
       <div class="side-box">
         <p>アンケート</p>
       </div>
       </a>
       <a href="setting.php">
         <div class="side-box">
           <p>設定</p>
         </div>
       </a>
     </div>
   <div class="sub-container">
     <div class="bbs_display">
     <h1>掲示板</h1>
     <form method="post">
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

       </ul>
         <label for="comment">ひとこと:  </label>
         <input type="text" name="text" value="<?php $text ?>">
         <input name="check" type="hidden" value="<?PHP print md5(microtime());?>">
         <button type="submit" name="send">投稿</button>
       <ul>
         <?php foreach($bbs_table as $value) { ?>
         <li id="bbs_display_li">
           <span class="bbs_name"><img src="<?php echo $value['user_img'];?>" alt="user_img"><?php echo $value['bbs_name']; ?></span>
           <div>
             <span class="bbs_comment"><?php  echo $value['bbs_comment'];?></span>
           </div>
           <p><?php echo $value['bbs_time'];}?></p>
        </li>
       </ul>
     </form>
   </div>
   </div>
 </main>

 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</body>
</html>
