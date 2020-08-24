<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

session_start();
$link = get_db_connect($link);
// リクエストメソッド取得
$request_method = get_request_method();

if ($request_method === 'POST') {
  $tool_email = get_post_data('email');
  $tool_password = get_post_data('password');

  if (error_check_validata($tool_email) !== true){
    $error[] = '入力された値が不正です。';
  }
  if (error_check_duplication_login_tool($link, $tool_email) === true){
    $error[] = 'メールアドレス又はパスワードが間違っています。1';
  }
  if (error_check_duplication_pw_tool($link, $tool_password) === true){
    $error[] = 'メールアドレス又はパスワードが間違っています。2';
  }
  if (error_check_userdata_compare_tool($link, $tool_email, $tool_password) !== true){
    $error[] = 'メールアドレス又はパスワードが間違っています。3';
  }
  if (count($error) === 0){
    $tool_name = get_userdata_name_tool($link, $tool_email);
    $tool_img = get_userdata_img_tool($link, $tool_email);

    $_SESSION["EMAIL_TOOL"] = $tool_email;
    $_SESSION["NAME_TOOL"] = $tool_name;
    $_SESSION["PASSWORD_TOOL"] = $tool_password;
    $_SESSION["IMG_TOOL"] = $tool_img;

    header('Location: http://localhost:8888/tool.php');
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
   <title>ARG新人用掲示板-Doorkey's-Login(管理画面)</title>
 </head>
   <body>
     <header>
         <div class="container">
           <p id="logo_img"><a href="index.php"><img src="Images/logo-image.png"></a></p>
          </div>
     </header>
    <div class="session">
      <h1>管理　ログイン</h1>
      <ul>
        <?php
        if (count($error) !== 0 ) {
            foreach($error as $error_msg) { ?>
            <li id="error"><?php print $error_msg; ?></li>
            <?php }
        } ?>
      </ul>
     <form method="post">
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
