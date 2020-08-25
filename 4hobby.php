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
  $it_experience = get_post_data('it_experience');

  if(isset($_SESSION["office"]) === TRUE){

    if($it_experience === 'true'){
      $_SESSION["it_experience"] = '経験したことのあるPC言語を継続するとよいでしょう。新たな言語に挑戦するのもよいですが、今までの経験を活かすことでより深いPC言語の理解につながります。';

    }else if($it_experience === 'false'){
      $_SESSION["it_experience"] = 'IT経験がない場合にはより簡単な難易度のPC言語の習得やPCに関する知識をつけるために、ITパスポートなどの資格の取得に挑戦してみることを推奨します';
    }
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
    </div>
   <div class="sub-container">
     <div class="question-list">
       <form action="5showing.php" method="post">
         <h1>最も興味のあるものを一つ選択してください</h1>
         <input type="radio" name="hobby" value="illustration" checked>
         <label>イラスト</label>
         <input type="radio" name="hobby" value="game">
         <label>ゲーム</label>
         <input type="radio" name="hobby" value="puzzle">
         <label>パズル</label>
         <input type="radio" name="hobby" value="math">
         <label>数学</label>
         <input type="radio" name="hobby" value="education">
         <label>教育</label>
         <input type="radio" name="hobby" value="degign">
         <label>設計</label>
        <button type="submit" name="button">次へ</button>
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
