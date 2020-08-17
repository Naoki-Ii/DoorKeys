<?php
session_start();
$user_name = $_SESSION["NAME"];

if (isset($_SESSION["EMAIL"]) && (isset($_SESSION["NAME"]))) {//ログインしているとき
    $msg = entity_str($user_name);
    echo 'ようこそ'. $msg. 'さん';
    $link = '<a href="logout.php">ログアウト</a>';

} else {//ログインしていない時
    $msg = 'ログインしていません';
    echo $msg;
    $link = '<a href="login.php">ログイン</a>';
}
echo $link;
?>
