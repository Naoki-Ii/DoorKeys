<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

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
        <title>ログアウト</title>
    </head>
    <body>
        <h1>ログアウト画面</h1>
        <div><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></div>
        <ul>
            <li><a href="login.php">ログイン画面に戻る</a></li>
        </ul>
    </body>
</html>
