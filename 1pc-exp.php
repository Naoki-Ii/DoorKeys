<?php

require_once (dirname(__FILE__).'/conf.php');
require_once (dirname(__FILE__).'/function.php');

session_start();

$user_name = $_SESSION["NAME"];
$email = $_SESSION["EMAIL"];
$session_password = $_SESSION["PASSWORD"];
$user_task = $_SESSION["TASK"];
$user_img = $_SESSION["IMG"];

//ログインしていない場合　ログイン画面にリダイレクト
if (!isset($_SESSION["EMAIL"]) || (!isset($_SESSION["NAME"]))) {
  header('Location: http://localhost:8888/login.php');
  exit();
}

$post = get_request_method();
if($post === 'POST'){
  $pc_experience = get_post_data('pc_exprience');

if($pc_experience === 'true'){
  $_SESSION["pc_exprience"] = 'パソコンの基本操作は問題ないでしょう。';
  header('Location: http://localhost:8888/2office-exp.php');
  exit();
}else if($pc_experience === 'false'){
  $_SESSION["pc_exprience"] = 'まずはパソコン操作に慣れるためにタイピングから始めると良いでしょう。';
  header('Location: http://localhost:8888/4hobby.php');
  exit();
}
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
       <p id="logo_img"><a href="index.php"><img src="Images/logo-image.png"></a></p>
       <div class="login-text">
         <img src="<?php echo entity_str($user_img); ?>" alt="user_img">
         <?php echo 'ようこそ  '. entity_str($user_name). '  さん';?>
         <a href="logout.php">ログアウトはこちら</a>
       </div>
   </header>
   <main>
    <div class="big-container">
      <div class="main-container">
        <a href="index.php">
          <div class="side-box">
            <p><img src="Images/home-logo.png" alt="home-logo">HOME</p>
          </div>
        </a>
        <a href="friend.php">
          <div class="side-box">
            <p><img src="Images/friend-logo.png" alt="friend-logo">同期</p>
          </div>
        </a>
        <a href="bbs.php">
          <div class="side-box">
            <p><img src="Images/bbs-logo.png" alt="bbs-logo">広場</p>
          </div>
        </a>
        <a href="question.php">
        <div class="side-box">
          <p><img src="Images/qa-logo.png" alt="qa-logo">アンケート</p>
        </div>
        </a>
        <a href="setting.php">
          <div class="side-box">
            <p><img src="Images/setting-logo.png" alt="setting-logo">設定</p>
          </div>
        </a>
     </div>
    <div class="sub-container">
      <div class="question-list">
        <form method="post">
          <h1>Q: PCの使用経験はありますか？</h1>
          <input type="radio" name="pc_exprience" value="true" checked>
          <label>はい</label></br>
          <input type="radio" name="pc_exprience" value="false">
          <label>いいえ</label>
          <button type="submit" name="1"><img src="Images/next-robot.png"></button>
        </form>
      </div>
    </div>
  </div>
  </main>

  <footer>
    <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
  </footer>
 </body>
 </html>
