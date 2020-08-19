<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

session_start();
$link = get_db_connect($link);
// リクエストメソッド取得
$request_method = get_request_method();

if ($request_method === 'POST') {
  $email = get_post_data('email');
  $password = get_post_data('password');

  if (error_check_validata($email) !== true){
    $error[] = '入力された値が不正です。';
  }
  if (error_check_duplication_login($link, $email) === true){
    $error[] = 'メールアドレス又はパスワードが間違っています。1';
  }
  if (error_check_duplication_pw($link, $password) === true){
    $error[] = 'メールアドレス又はパスワードが間違っています。2';
  }
  if (error_check_userdata_compare($link, $email, $password) !== true){
    $error[] = 'メールアドレス又はパスワードが間違っています。3';
  }
  if (count($error) === 0){
    $user_name = get_userdata_name($link, $email);
    $user_task = get_userdata_task($link, $email);

    $_SESSION["EMAIL"] = $email;
    $_SESSION["NAME"] = $user_name;
    $_SESSION["PASSWORD"] = $password;
    $_SESSION["TASK"] = $user_task;

    header('Location: http://localhost:8888/index.php');
    exit();
  } else{
    $error[] = 'ログイン失敗';
    //var_dump($error);
  }
}

close_db_connect($link);

?>

<!DOCTYPE html>
<html lang="ja">
 <head>
   <meta charset="utf-8">
   <title>Login</title>
 </head>
 <body>
   <h1>ようこそ、ログインしてください。</h1>
   <ul>
      <?php
      if (count($error) !== 0 ) {
          foreach($error as $error_msg) { ?>
          <li id="error"><?php print $error_msg; ?></li>
          <?php }
      } ?>
    </ul>
   <form  action="login.php" method="post">
     <label for="email">メールアドレス</label>
     <input type="email" name="email">
     <label for="password">パスワード</label>
     <input type="password" name="password">
     <button type="submit">ログイン</button>
   </form>
   <a href="signUp.php">新規登録はこちら</a>
 </body>
</html>
