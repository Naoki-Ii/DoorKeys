<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

session_start();
$msg = '';
if(isset($_SESSION["EMAIL_TOOL"]) && isset($_SESSION["NAME_TOOL"])){
  $msg = 'ログアウトしました';
}else{
  $msg = 'セッションがタイムアウトしました';
}

//セッション変数のクリア
$_SESSION = array();

//セッションリセット
session_destroy();
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ARG新人用掲示板-Doorkey's-logout(管理画面)</title>
        <link rel="stylesheet" href="Style/stylesheet.css">
    </head>
    <header>
        <div class="container">
          <p id="logo_img"><a href="tool.php"><img src="Images/logo-image.png"></a></p>
          </div>
        </div>
    </header>
    <body>
      <div class="session">
        <div><?php echo entity_str($msg); ?></div>
        <span><a href="tool_login.php">ログイン画面に戻る</a></span>
      </div>
    </body>
    <footer>
      <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
    </footer>
</html>
