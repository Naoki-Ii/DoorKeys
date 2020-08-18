<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

session_start();
$user_name = $_SESSION["NAME"];
$email = $_SESSION["EMAIL"];
$session_password = $_SESSION["PASSWORD"];

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

  //ユーザー名変更の場合のみ実行
  if(isset($_POST['submit_user']) === TRUE){

    $name = get_post_data('username');
    $password = get_post_data('password');

    //エラーチェック
    if (error_check_trim($name) !== true){
      $error[] = 'ユーザーネームを入力してください';
    }
    if (error_check_trim($password) !== true){
      $error[] = 'パスワードを入力してください1';
    }
    if (error_check_password($password, $session_password) !== true){
      $error[] = 'パスワードが間違っています';
    }
    if(count($error) === 0){
    $new_user_name = change_data_username($link, $name, $email);

    $_SESSION["NAME"] = $new_user_name;

    $user_name = $_SESSION["NAME"];
    echo 'ユーザー名変更完了';
    }else{
      echo 'ユーザー名変更失敗';
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
    if (error_check_password($password, $session_password) !== true){
      $error[] = 'パスワードが間違っています';
    }else{
      if (error_check_pw_match($password, $newpassword1) === true){
        $error[] = '現在と同じパスワードは設定できません';
      }
    }

    if (count($error) === 0){
      $new_password = change_data_password($link, $newpassword1, $email);

      $_SESSION["PASSWORD"] = $new_password;

      $session_password = $_SESSION["PASSWORD"];

      echo 'パスワード変更完了';
    }else{
      echo 'パスワード変更失敗';
    }

  }
}

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
      <div class="container">
        <div class="login-text">
        <?php echo 'ようこそ  '. entity_str($user_name). '  さん';?>
        <a href="logout.php">ログアウトはこちら</a>
        </div>
        <!--ここに画像挿入-->
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
       <a herf="#">
         <div class="side-box">
           <p>同期</p>
         </div>
       </a>
       <a href="bbs.php">
         <div class="side-box">
           <p>広場</p>
         </div>
       </a>
       <a href="#">
       <div class="side-box">
         <p>アンケート</p>
       </div>
       </a>
       <a href="setting.php">
         <div class="side-box">
           <p>設定</p>
         </div>
       </a>
       <a herf="#">
         <div class="small-logo">
          <img id="footer-logo-size" src="Images/logo-image.png">
         </div>
       </a>
     </div>
   <div class="sub-container">
     <form method="post">
       <h1>ユーザー名の変更</h1>
       <p>現在のユーザー名:  <?php echo entity_str($user_name); ?></p>
       <label for="name">新しいユーザー名</label>
       <input type="name" name="username" value="">
       <label for="password">パスワードを入力</label>
       <input type="password" name="password" value="">
       <input type="submit" name="submit_user" value="変更">
     </form>
     <form method="post">
       <h1>パスワードの変更</h1>
       <label for="password">現在のパスワードを入力</label>
       <input type="password" name="password" value="">
       <label for="newpassword1">新しいパスワード</label>
       <input type="password" name="newpassword1" value="">
       <label for="newpassword2">新しいパスワード(再入力)</label>
       <input type="password" name="newpassword2" value="">
       <input type="submit" name="submit_password" value="変更">
     </form>
   </div>
 </main>

 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</body>
</html>
