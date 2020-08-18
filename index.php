<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

session_start();
$user_name = $_SESSION["NAME"];

if (isset($_SESSION["EMAIL"]) && (isset($_SESSION["NAME"]))) {//ログインしているとき
    $msg = entity_str($user_name);

} else {//ログインしていない時
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
        <?php echo 'ようこそ  '. entity_str($user_name). '  さん';?>
        <a href="logout.php">ログアウトはこちら</a>
        <img id="header-logo-size" src="Images/arg-back.png" >
      </div>
  </header>

<main>
   <div class="big-container">
     <div class="main-container">
       <a herf="#">
         <div class="side-box">
           <h1>HOME</h1>
         </div>
       </a>
       <a herf="public-place">
         <div class="side-box">
           <h1>同期</h1>
         </div>
       </a>
       <a herf="dm">
         <div class="side-box">
           <h1>DM</h1>
         </div>
       </a>
       <a herf="video">
         <div class="side-box">
           <h1>動画</h1>
         </div>
       </a>
       <a herf="#">
         <div class="small-logo">
           <h1><img id="footer-logo-size" src="Images/logo-image.png"></h1>
         </div>
       </a>
     </div>
   </div>
   <div class="sub-container">
   </div>
 </main>

 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</body>
</html>
