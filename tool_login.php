<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

session_start();
$link = get_db_connect($link);

$error_display = array();
$flag = TRUE;

// リクエストメソッド取得
$request_method = get_request_method();

if ($request_method === 'POST') {
  $tool_email = get_post_data('email');
  $tool_password = get_post_data('password');

  //暗号化されたパスワードを取得
  $hash = get_user_password_tool($link, $tool_email);

  if (error_check_validata($tool_email) !== true){
    $error[] = '入力された値が不正です';
    $error_display[] = '入力された値が不正です';
  }
  if (error_check_duplication_login_tool($link, $tool_email) === true){
    $error[] = 'メールアドレス又はパスワードが間違っています';
    $flag = FALSE;
  }

  //入力されたパスワードを照合
  if(password_verify($tool_password, $hash) !== TRUE){
    $error[] = 'メールアドレス又はパスワードが間違っています';
    $flag = FALSE;
  }

  if (count($error) === 0){
    $tool_name = get_userdata_name_tool($link, $tool_email);
    $tool_img = get_userdata_img_tool($link, $tool_email);

    $_SESSION["EMAIL_TOOL"] = $tool_email;
    $_SESSION["NAME_TOOL"] = $tool_name;
    $_SESSION["PASSWORD_TOOL"] = $hash;
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
           <p id="logo_img"><a href="tool.php"><img src="Images/logo-image.png"></a></p>
          </div>
     </header>
    <div class="session">
      <h1>管理　ログイン</h1>
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
     <form method="post">
       <label for="email">メールアドレス</label>
       <input type="email" name="email" value="<?php echo entity_str($tool_email); ?>">
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
