<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

session_start();

$user_name = $_SESSION["NAME"];
$email = $_SESSION["EMAIL"];
$session_password = $_SESSION["PASSWORD"];
$user_task = $_SESSION["TASK"];

//ログインしていない場合　ログイン画面にリダイレクト
if (!isset($_SESSION["EMAIL"]) || (!isset($_SESSION["NAME"]))) {
  header('Location: http://localhost:8888/login.php');
  exit();
}
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
       <a href="friend.php">
         <div class="side-box">
           <p>同期</p>
         </div>
       </a>
       <a href="bbs.php">
         <div class="side-box">
           <p>広場</p>
         </div>
       </a>
       <a href="question.php">
       <div class="side-box">
         <p>アンケート</p>
       </div>
       </a>
       <a href="setting.php">
         <div class="side-box">
           <p>設定</p>
         </div>
       </a>
       <a herf="index.php">
         <div class="small-logo">
          <img id="footer-logo-size" src="Images/logo-image.png">
         </div>
       </a>
     </div>
   <div class="sub-container">
   </div>
 </main>

 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</body>
</html>
