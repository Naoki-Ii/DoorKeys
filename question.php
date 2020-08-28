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

//データベース接続
$link = get_db_connect($link);

//初期化
$_SESSION["pc_exprience"] = '';
$_SESSION["office"] = '';
$_SESSION["it_experience"] = '';
$_SESSION["hobby"] = '';
$_SESSION["easy_diff"] = '';
$_SESSION["interest"] = '';
$_SESSION["risk"] = '';

//データがあるかどうかの確認
$flag = get_user_qa_result($link, $email);

if($flag === FALSE){

  //診断結果データ取得
  $qa_result_list = get_userdata_qa_result($link, $email);
  //エンティティ変換
  $qa_result = entity_assoc_array($qa_result_list);
}


//データベース切断
close_db_connect($link);

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
     <div class="question-list-result">
       <form  action ='1pc-exp.php' method="post">
           <h1>業務適正アンケート</h1>
           <div>あなたに合った業務内容やプログラミング言語を教えてくれます。</div>
           <div><img src="Images/arrow.png" alt="arrow"></div>
           <button class="start_logo" type="submit" name="start"><img src="Images/start_logo.png" alt="start_button"></button>
       </form>
       <?php if($flag === FALSE){?>
         <h1>直近の診断結果</h1>
         <?php foreach($qa_result as $value) {?>
           <?php if($value["a"] === ''){ ?>
             <p><?php echo $value["d"]; ?></p>
          <?php }else{ ?>
           <p><?php echo $value["a"];?></p>
           <p><?php echo $value["b"];?></p>
           <p><?php echo $value["c"];?></p>
           <p><?php echo $value["d"];?></p>
           <h1>あなたにおすすめの言語</h1>
           <div><?php echo $value["e"];?></div>
           <h1>稼げるランキング</h1>
           <div><?php echo $value["f"];?></div>
          <?php };?>
         <?php };?>
       <?php };?>
     </div>
   </div>
 </div>
 </main>

 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</body>
</html>
