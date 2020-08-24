<?php
require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

session_start();
$tool_name = $_SESSION["NAME_TOOL"];
$tool_email = $_SESSION["EMAIL_TOOL"];
$tool_session_password = $_SESSION["PASSWORD_TOOL"];
$tool_img = $_SESSION["IMG_TOOL"];

//ログインしていない場合　ログイン画面にリダイレクト
if (!isset($_SESSION["EMAIL_TOOL"]) || (!isset($_SESSION["NAME_TOOL"]))) {
  header('Location: http://localhost:8888/tool_login.php');
  exit();
}

//データベース接続
$link = get_db_connect($link);

//データベース切断
close_db_connect($link);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UFT-8">
  <title>ARG新人用掲示板-Doorkey's- 管理画面</title>
  <link rel="stylesheet" href="Style/stylesheet.css">
</head>
<body>
  <header>
    <p id="logo_img"><a href="index.php"><img src="Images/logo-image.png"></a></p>
    <div class="login-text">
      <img src="<?php echo entity_str($tool_img); ?>" alt="tool_img">
      <?php echo 'ようこそ  '. entity_str($tool_name). '  さん';?>
      <a href="tool_logout.php">ログアウトはこちら</a>
    </div>
  </header>
  <main>
   <div class="big-container">
     <div class="main-container">
       <a href="tool.php">
         <div class="side-box">
           <p>社員一覧</p>
         </div>
       </a>
       <a href="tool_bbs.php">
         <div class="side-box">
           <p>書き込み一覧</p>
         </div>
       </a>
       <a href="tool_setting.php">
         <div class="side-box">
           <p>設定</p>
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
