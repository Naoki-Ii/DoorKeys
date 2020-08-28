<?php

require_once (dirname(__FILE__).'/conf.php');
require_once (dirname(__FILE__).'/function.php');

session_start();

$error_display = array();
$flag = TRUE;

$link = get_db_connect($link);
// リクエストメソッド取得
$request_method = get_request_method();

if ($request_method === 'POST') {
  $email = get_post_data('email');
  $password = get_post_data('password');

  //暗号化されたパスワードを取得
  $hash = get_user_password($link, $email);

  if (error_check_validata($email) !== true){
    $error[] = '入力された値が不正です';
    $error_display[] = '入力された値が不正です';
  }
  if (error_check_duplication_login($link, $email) === true){
    $error[] = 'メールアドレス又はパスワードが間違っています';
    $flag = FALSE;
  }
  //入力されたパスワードを照合
  if(password_verify($password, $hash) !== TRUE){
    $error[] = 'メールアドレス又はパスワードが間違っています';
    $flag = FALSE;
  }

  if (count($error) === 0){
    $user_name = get_userdata_name($link, $email);
    $user_task = get_userdata_task($link, $email);
    $user_img = get_userdata_img($link, $email);

    $_SESSION["EMAIL"] = $email;
    $_SESSION["NAME"] = $user_name;
    $_SESSION["PASSWORD"] = $hash;
    $_SESSION["TASK"] = $user_task;
    $_SESSION["IMG"] = $user_img;

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
   <link rel="stylesheet" href="Style/stylesheet.css">
   <title>ARG新人用掲示板-Doorkey's-Login</title>
 </head>
   <body>
     <header>
         <div class="container">
           <p id="logo_img"><a href="index.php"><img src="Images/logo-image.png"></a></p>
          </div>
     </header>
    <div class="session">
      <h1>ようこそ、ログインしてください。</h1>
      <ul>
        <?php
        if (count($error_display) !== 0 ) {
            foreach($error_display as $error_msg) { ?>
            <li id="error"><?php print $error_msg; ?></li>
            <?php }
        } ?>
        <?php if($flag === FALSE){ ?>
          <li id="error"><?php echo 'メールアドレス又はパスワードが間違っています'; ?></li>
        <?php }; ?>
      </ul>
     <form  action="login.php" method="post">
       <label for="email">メールアドレス</label>
       <input type="email" name="email" value="<?php echo entity_str($email); ?>">
       <label for="password">パスワード</label>
       <input type="password" name="password">
       <button type="button" onclick="submit();">ログイン</button>
     </form>
    </div>
 </body>
 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</html>
