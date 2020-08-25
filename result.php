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

//フロント言語、簡単順
$front = array('HTML/CSS','JavaScript','Ruby','Swift/Kotlin','C#','C言語','C++');
//money稼げる順
$front_money =array('JavaScript','Swift/Kotlin','Ruby','C言語','C#','C++','HTML/CSS');
 //AI、サーバー言語
 $server = array('PHP','Python','Go','Java','C言語','C++','R言語');
//money
 $server_money =array('python','Go','R言語','C言語','Java','C++','PHP');
//システム
$system = array('PHP','Python','Shell','C言語',);
//money
$system_money = array('Python','PHP','C言語','Shell',);


$post = get_request_method();
if($post === 'POST'){
  $risk = get_post_data('risk');

  if($_SESSION["interest"] === 'a' || $_SESSION["interest"] === 'b'){

    if($_SESSION["easy_diff"] === 'a'){

      $_SESSION["interest"] = $front;

    }else if($_SESSION["easy_diff"] === 'b'){

      $_SESSION["interest"] = array_reverse($front);
    }

    //リスク
    if($risk === 'true'){
      $_SESSION["risk"] = $front_money;

    }else if($risk === 'false'){

      $_SESSION["risk"] = array_reverse($front_money);

    }
  }
  if($_SESSION["interest"] === 'c' || $_SESSION["interest"] === 'd'){

    if($_SESSION["easy_diff"] === 'a'){

      $_SESSION["interest"] = $server;

    }else if($_SESSION["easy_diff"] === 'b'){

        $_SESSION["interest"] = array_reverse($server);
    }
    //リスク
    if($risk === 'true'){
      $_SESSION["risk"] = $server_money;

    }else if($risk === 'false'){

      $_SESSION["risk"] = array_reverse($server_money);

    }
  }
  if($_SESSION["interest"] === 'e'){

    if($_SESSION["easy_diff"] === 'a'){
      $_SESSION["interest"] = $system;

    }else if($_SESSION["easy_diff"] === 'b'){

      $_SESSION["interest"] = array_reverse($system);

    }
    //リスク
    if($risk === 'true'){
      $_SESSION["risk"] = $system_money;

    }else if($risk === 'false'){

      $_SESSION["risk"] = array_reverse($system_money);

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
     <p>こちらに結果を表示</p>
     <a href="question.php">もう一度診断する</a>
     <?php if($_SESSION["interest"] === 'F'){
       echo $_SESSION["hobby"];
     }else {?>
       <?php echo $_SESSION["pc_exprience"]?>
       <?php echo $_SESSION["office"]?>
       <?php echo $_SESSION["it_experience"]?>
       <?php echo $_SESSION["hobby"]?>
       <?php foreach($_SESSION["interest"] as $value){
         echo $value;
       }?>
       <?php foreach ($_SESSION["risk"] as $value) {
         echo $value;
       }?>
     <?php } ?>
   </div>
 </div>
 </main>

 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</body>
</html>
