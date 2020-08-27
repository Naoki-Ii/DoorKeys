<?php

require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

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

if($_SESSION["pc_exprience"] === '' || isset($_SESSION["pc_exprience"]) === FALSE){
  header('Location: http://localhost:8888/question.php');
  exit();
}

$post = get_request_method();
if($post === 'POST'){
  $self_reveal = get_post_data('self_reveal');

  if($self_reveal === 'true'){
    if($_SESSION["hobby"] === 'a'){
      //イラスト
      $_SESSION["hobby"] =
      'あなたは、自身の成果物を多くの人に見てもらいたい、
      また、たくさんの人の目に留まるものが作りたいと考えていることでしょう。
      そんなあなたは、WEBデザイナーとも呼ばれるホームページやSNSのレイアウトや
      ビジュアルのデザインなど、エンドユーザー（お客様）が直接目にするページの仕事、
      フロントエンド・エンジニアリングに向いています。';
    }
    //ゲーム
    if($_SESSION["hobby"] === 'b'){
      $_SESSION["hobby"] =
      'あなたは、自身の作ったものを多くの人に見てもらいたい、遊んでもらいたい、
      また、たくさんの人の目に留まる面白いものが作りたいと考えていることでしょう。
      そんなあなたは、スマホでゲームアプリをはじめとするブラウザゲームなどを作り、エンドユーザー（お客様）が直接目にする作品を作る
      フロントエンド・エンジニアリングに向いています。';
    }
    $_SESSION["self_reveal"] = 'a';
  }else if($self_reveal === 'false'){
    //イラスト
    if($_SESSION["hobby"] === 'a'){
      $_SESSION["hobby"] =
      'あなたは、作品を作るのは好きですが、自身の成果物や作品を人に披露することがあまり好きではありません。
      また、一度制作を始めたら自身が満足するまで成果物（作品）を作りこみたいと考えていることでしょう。
      そんなあなたは、ホームページの細かい仕様の変更やシステムの構築、データベースの管理などWEBサイトの裏側部分を担当する
      バックエンド・エンジニアリングに向いています。';
    }
    //ゲーム
    if($_SESSION["hobby"] === 'b'){
      $_SESSION["hobby"] =
      'あなたは、かつて自分が好きだったゲームのような、面白いものが作りたいと考えていることでしょう。
      しかし、その反面たくさんの人に自分の作品をみられるのはあまり好きではありません。
      そんなあなたは、スマホでゲームアプリをはじめとするブラウザゲームを作りそのシステムの構築、データベースの管理など裏側部分を担当する
      バックエンド・エンジニアリングに向いています。';
    }
    $_SESSION["self_reveal"] = 'b';
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
       <form action="7interest.php" method="post">
         <h1>Q: どちらか一方を選択してください。</h1>
         <input type="radio" name="easy_diff" value="true" checked>
         <label>簡単な作業から始めて難易度を少しずつ上げていきたい</label></br>
         <input type="radio" name="easy_diff" value="false">
         <label>難易度の高いものから挑戦したい</label>
        <button type="submit" name="button"><img src="Images/next-robot.png"></button>
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
