<?php

require_once (dirname(__FILE__).'/conf.php');
require_once (dirname(__FILE__).'/function.php');

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

//データベース接続
$link = get_db_connect($link);
// リクエストメソッド取得
$request_method = get_request_method();
//実行
if ($request_method === 'POST') {


  //抱負の変更の場合のみ実行
  if(isset($_POST['submit_task']) === TRUE){
    $comment = get_post_data('comment');

    //エラーチェック
    if (error_check_trim($comment) !== true) {
        $error [] = '抱負を入力してください';
    }
    if (error_check_text_length($comment) !== true) {
        $error[] = '抱負は１００文字以内で入力してください';
    }

    if(count($error) === 0){
      $new_task = change_data_task($link, $comment, $email);

      $_SESSION["TASK"] = $new_task;

      $user_task = $_SESSION["TASK"];

      $msg[] = '変更完了';
    }
  }

  //予定の追加の場合ののみ実行
  if(isset($_POST['submit_diary']) === TRUE){
    $comment = get_post_data('comment');
    $request = get_post_data('check');

    //エラーチェック
    if (error_check_trim($comment) !== true) {
        $error [] = '予定を入力してください';
    }
    if (error_check_text_length($comment) !== true) {
        $error[] = '予定は１００文字以内で入力してください';
    }
    if(error_check_duplication_diary($link, $request) !== true){
      $error[] = 'リロード完了';
    }

    //エラーがない場合実行
    if(count($error) === 0){

      //書き込み内容取得
      $comment_update = get_insert_diary($email, $comment, $request);
      $result = mysqli_query($link, $comment_update);
      $msg[] = '追加完了';
    }
  }

  //トップ画像変更の場合のみ実行
  if(isset($_POST['submit_img']) === TRUE){

    $img = get_file_data('img');
    //var_dump($img);
    //ファイルアップロード
    $res= get_input_image('img', UPLOADPATH);
    //var_dump($res);

    if (mb_strlen($img['name']) === 0) {
      $error [] = '画像が選択されていません';
    }
    if ($res['status'] === false) {
        $error [] = 'ファイル形式が間違っています';
    }

    if(count($error) === 0){
      $new_img = change_data_img($link, UPLOADPATH. $res['status'], $email);

      $_SESSION["IMG"] = $new_img;

      $user_img = $_SESSION["IMG"];

      $msg[] = '画像変更完了';
    }
  }
  //ユーザー名変更の場合のみ実行
  if(isset($_POST['submit_user']) === TRUE){

    $name = get_post_data('username');
    $password = get_post_data('password');

    //エラーチェック
    if (error_check_trim($name) !== true){
      $error[] = 'ユーザーネームを入力してください';
    }
    if (error_check_trim($password) !== true){
      $error[] = 'パスワードを入力してください';
    }
    //入力されたパスワードを照合
    if(password_verify($password, $session_password) !== TRUE){
      $error[] = 'パスワードが間違っています';
    }
    if(count($error) === 0){
    $new_user_name = change_data_username($link, $name, $email);

    $_SESSION["NAME"] = $new_user_name;

    $user_name = $_SESSION["NAME"];

    $msg[] = 'ユーザー名変更完了';
    }


  }

  //パスワード変更の時のみ実行
  if(isset($_POST['submit_password']) === TRUE){
    $password = get_post_data('password');
    $newpassword1 = get_post_data('newpassword1');
    $newpassword2 = get_post_data('newpassword2');

    //エラーチェック
    if (error_check_trim($password) !== true){
      $error[] = '現在のパスワードを入力してください';
    }
    if (error_check_trim($newpassword1) !== true){
      $error[] = '新しいパスワードを入力してください';
    }
    if (error_check_trim($newpassword2) !== true){
      $error[] = '新しいパスワードを再入力してください';
    }
    if (error_check_pw_match($newpassword1, $newpassword2) !== true){
      $error[] = '新しいパスワードが一致しません';
    }
    if (error_check_preg_match($newpassword1) !== true){
      $error[] = 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください';
    }
    //入力されたパスワードを照合
    if(password_verify($password, $session_password) !== TRUE){
      $error[] = 'パスワードが間違っています';
    }else{
      if (error_check_pw_match($password, $newpassword1) === true){
        $error[] = '現在と同じパスワードは設定できません';
      }
    }

    if (count($error) === 0){
      $hash = password_hash($newpassword1, PASSWORD_DEFAULT);
      $new_password = change_data_password($link, $hash, $email);

      $_SESSION["PASSWORD"] = $new_password;

      $session_password = $_SESSION["PASSWORD"];

      $msg[] = 'パスワード変更完了';
    }

  }
}
$_SESSION["check"] = $check = mt_rand();

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
           <p><img src="Images/home-logo.png" alt="home-logo">HOME</p>
         </div>
       </a>
       <a href="friend.php">
         <div class="side-box">
           <p><img src="Images/friend-logo.png" alt="friend-logo">同期</p>
         </div>
       </a>
       <a href="bbs.php">
         <div class="side-box">
           <p><img src="Images/bbs-logo.png" alt="bbs-logo">広場</p>
         </div>
       </a>
       <a href="question.php">
       <div class="side-box">
         <p><img src="Images/qa-logo.png" alt="qa-logo">アンケート</p>
       </div>
       </a>
       <a href="setting.php">
         <div class="side-box">
           <p><img src="Images/setting-logo.png" alt="setting-logo">設定</p>
         </div>
       </a>
    </div>
   <div class="sub-container">
     <div class="setting_display">
     <ul>
       <?php
       if (count($error) !== 0 ) {
           foreach($error as $error_msg) { ?>
           <li id="error"><?php print $error_msg; ?></li>
           <?php }
       } ?>
       <?php
       if (count($msg) !==0){
         foreach ($msg as $msg_display) { ?>
           <li id="success"><?php echo $msg_display; ?></li>
         <?php }
       }?>
     </ul>
       <form method="post" class="task">
         <h1>抱負</h1>
         <textarea name="comment" rows="3" cols="50"><?php echo entity_str($user_task); ?></textarea>
         <button type="submit" name="submit_task">更新</button>
       </form>
       <form method="post" class="diary">
         <h1>予定</h1>
         <input type="text" name="comment" value="">
         <input type="hidden" name="check" value="<?PHP print md5(microtime());?>">
         <button type="submit" name="submit_diary">追加</button>
       </form>
       <form method="post" enctype="multipart/form-data">
         <h1>メイン画像変更</h1>
         <img src="<?php echo entity_str($user_img);?>" alt="user_img" width="100px">
         <input type="file" name="img">
         <button type="submit" name="submit_img">変更</button>
       </form>
       <div class="psw_display">
         <form method="post">
           <h1>ユーザー名変更</h1>
           <p>現在のユーザー名:  <?php echo entity_str($user_name); ?></p>
           <label for="name">新しいユーザー名</label>
           <input type="name" name="username" value="">
           <label for="password">パスワードを入力</label>
           <input type="password" name="password" value="">
           <button type="submit" name="submit_user">変更</button>
         </form>
         <form method="post">
           <h1>パスワード変更</h1>
           <label for="password">現在のパスワードを入力</label>
           <input type="password" name="password" value="">
           <label for="newpassword1">新しいパスワード</label>
           <input type="password" name="newpassword1" value="">
           <label for="newpassword2">新しいパスワード(再入力)</label>
           <input type="password" name="newpassword2" value="">
           <button type="submit" name="submit_password">変更</button>
         </form>
       </div>
     </div>
    </div>
 </main>

 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</body>
</html>
