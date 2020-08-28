<?php

require_once (dirname(__FILE__).'/conf.php');
require_once (dirname(__FILE__).'/function.php');

session_start();
$msg = '';
if(isset($_SESSION["EMAIL"]) && isset($_SESSION["NAME"])){
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
        <title>ARG新人用掲示板-Doorkey's-logout</title>
        <link rel="stylesheet" href="Style/stylesheet.css">
    </head>
    <header>
        <div class="container">
          <p id="logo_img"><a href="index.php"><img src="Images/logo-image.png"></a></p>
          </div>
        </div>
    </header>
    <body>
      <div class="session">
        <div><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></div>
        <span><a href="login.php">ログイン画面に戻る</a></span>
      </div>
    </body>
    <footer>
      <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
    </footer>
</html>
