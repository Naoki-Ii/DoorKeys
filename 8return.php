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
  $interest = get_post_data('interest');
  if($interest === 'web'){

    //パズル
    if($_SESSION["hobby"] === 'c'){
      $_SESSION["hobby"] =
      'あなたは考えることが好きで、物事の順序建てや綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、スマホでアプリをはじめとし、WEB上でのブラウザアプリなどを作りそのシステムの構築、データベースの管理など裏側部分を担当する
      バックエンド・エンジニアリングに向いています。';
    }

    //数学
    if($_SESSION["hobby"] === 'd'){
      $_SESSION["hobby"] =
      'あなたは論理的に、数学的に考えることが好きで、与えられた仕事は時間がかかっても完ぺきにこなして、クオリティを重視したいと考えます。
      物事の順序建てなど綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、図形やグラフを用いてサイトやシステム内の膨大なデータを分析しそのシステムの構築、データベースの管理など裏側部分を担当する
      バックエンド・エンジニアリングに向いています。';
    }

    //教育
    if($_SESSION["hobby"] === 'e'){
      $_SESSION["hobby"] =
      'あなたは物事を考え、自身の中で分かりやすくかみ砕き処理する事に長けているでしょう。
      そんなあなたはそんなあなたは、知育サイトやアプリのシステムを構築したりサーバー、データベースの管理、セキュリティの構築・補修・管理など行う
      バックエンド・エンジニアリングに向いています。';
    }

    //設計
    if($_SESSION["hobby"] === 'f'){
      $_SESSION["hobby"] =
      'あなたは物事を考え、自身の中で分かりやすくかみ砕き処理する事に長けているでしょう。
      そんなあなたはそんなあなたは、知育サイトやアプリのシステムを構築したりサーバー、データベースの管理、セキュリティの構築・補修・管理など行う
      バックエンド・エンジニアリングに向いています。';
    }
    $_SESSION["interest"] = 'a';
  }else if($interest === 'sumaho'){

    //パズル
    if($_SESSION["hobby"] === 'c'){
      $_SESSION["hobby"] =
      'あなたは考えることが好きで、物事の順序建てや綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、スマホでアプリをはじめとし、WEB上でのブラウザアプリなどを作りそのシステムの構築、データベースの管理など裏側部分を担当する
      バックエンド・エンジニアリングに向いています。';
    }

    //数学
    if($_SESSION["hobby"] === 'd'){
      $_SESSION["hobby"] =
      'あなたは論理的に、数学的に考えることが好きで、与えられた仕事は時間がかかっても完ぺきにこなして、クオリティを重視したいと考えます。
      物事の順序建てなど綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、図形やグラフを用いてサイトやシステム内の膨大なデータを分析しそのシステムの構築、データベースの管理など裏側部分を担当する
      バックエンド・エンジニアリングに向いています。';
    }

    //教育
    if($_SESSION["hobby"] === 'e'){
      $_SESSION["hobby"] =
      'あなたは物事を考え、自身の中で分かりやすくかみ砕き処理する事に長けているでしょう。
      そんなあなたはそんなあなたは、知育サイトやアプリのシステムを構築したりサーバー、データベースの管理、セキュリティの構築・補修・管理など行う
      バックエンド・エンジニアリングに向いています。';
    }

    //設計
    if($_SESSION["hobby"] === 'f'){
      $_SESSION["hobby"] =
      'あなたは物事を考え、自身の中で分かりやすくかみ砕き処理する事に長けているでしょう。
      そんなあなたはそんなあなたは、知育サイトやアプリのシステムを構築したりサーバー、データベースの管理、セキュリティの構築・補修・管理など行う
      バックエンド・エンジニアリングに向いています。';
    }

    $_SESSION["interest"] = 'b';
  }else if($interest === 'AI'){

    //パズル
    if($_SESSION["hobby"] === 'c'){
      $_SESSION["hobby"] =
      'あなたは考えることが好きで、物事の順序建てや綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、新たにシステムを構築したりサーバー、データベースの管理、セキュリティの構築・補修・管理など行う
      バックエンド・エンジニアリングに向いています。';
    }

    //数学
    if($_SESSION["hobby"] === 'd'){
      $_SESSION["hobby"] =
      'あなたは論理的に、数学的に考えることが好きで、与えられた仕事は時間がかかっても完ぺきにこなして、クオリティを重視したいと考えます。
      物事の順序建てなど綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、図形やグラフを用いてサイトやシステム内の膨大なデータを分析することや、サーバーの構築、機械学習などうまくいくまで何度も繰り返す作業を得意とし、
      人工知能などを作るバックエンド・エンジニアリングに向いています。';
    }

    //教育
    if($_SESSION["hobby"] === 'e'){
      $_SESSION["hobby"] =
      'あなたは物事を考え、自身の中で分かりやすくかみ砕き処理する事に長けているでしょう。
      そんなあなたは、何度も繰り返しプログラムに学習させること（機械学習）や統計、データ分析を行う
      バックエンド・エンジニアリングに向いています。';
    }

    //設計
    if($_SESSION["hobby"] === 'f'){
      $_SESSION["hobby"] =
      'あなたは論理的に物事を組み立てて考えることができ、与えられた仕事は時間がかかっても完ぺきにこなして、クオリティを重視したいと考えます。
      物事の順序建てなど綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、ルーターやモデムなどの電子機器の中に組み込まれるようなのシステムの構築や電子制御プログラムの開発をメインに金融や保険会社などの膨大な顧客データを適切かつ安全にあつかう
      世の中のシステムの裏側部分を担当するバックエンド・エンジニアリングに向いています。';
    }
    $_SESSION["interest"] = 'c';
  }else if($interest === 'server'){

    //パズル
    if($_SESSION["hobby"] === 'c'){
      $_SESSION["hobby"] =
      'あなたは考えることが好きで、物事の順序建てや綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、新たにシステムを構築したりサーバー、データベースの管理、セキュリティの構築・補修・管理など行う
      バックエンド・エンジニアリングに向いています。';
    }

    //数学
    if($_SESSION["hobby"] === 'd'){
      $_SESSION["hobby"] =
      'あなたは論理的に、数学的に考えることが好きで、与えられた仕事は時間がかかっても完ぺきにこなして、クオリティを重視したいと考えます。
      物事の順序建てなど綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、図形やグラフを用いてサイトやシステム内の膨大なデータを分析することや、サーバーの構築、機械学習などうまくいくまで何度も繰り返す作業を得意とし、
      人工知能などを作るバックエンド・エンジニアリングに向いています。';
    }

    //教育
    if($_SESSION["hobby"] === 'e'){
      $_SESSION["hobby"] =
      'あなたは物事を考え、自身の中で分かりやすくかみ砕き処理する事に長けているでしょう。
      そんなあなたは、何度も繰り返しプログラムに学習させること（機械学習）や統計、データ分析を行う
      バックエンド・エンジニアリングに向いています。';
    }

    //設計
    if($_SESSION["hobby"] === 'f'){
      $_SESSION["hobby"] =
      'あなたは論理的に物事を組み立てて考えることができ、与えられた仕事は時間がかかっても完ぺきにこなして、クオリティを重視したいと考えます。
      物事の順序建てなど綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、ルーターやモデムなどの電子機器の中に組み込まれるようなのシステムの構築や電子制御プログラムの開発をメインに金融や保険会社などの膨大な顧客データを適切かつ安全にあつかう
      世の中のシステムの裏側部分を担当するバックエンド・エンジニアリングに向いています。';
    }

    $_SESSION["interest"] = 'd';
  }else if($interest === 'system'){

    //パズル
    if($_SESSION["hobby"] === 'c'){
      $_SESSION["hobby"] =
      'あなたは考えることが好きで、物事の順序建てや綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、新たにシステムを構築したりサーバー、データベースの管理、セキュリティの構築・補修・管理など行う
      バックエンド・エンジニアリングに向いています。';
    }

    //数学
    if($_SESSION["hobby"] === 'd'){
      $_SESSION["hobby"] =
      'あなたは論理的に、数学的に考えることが好きで、与えられた仕事は時間がかかっても完ぺきにこなして、クオリティを重視したいと考えます。
      物事の順序建てなど綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、図形やグラフを用いてサイトやシステム内の膨大なデータを分析することや、サーバーの構築、機械学習などうまくいくまで何度も繰り返す作業を得意とし、
      人工知能などを作るバックエンド・エンジニアリングに向いています。';
    }

    //教育
    if($_SESSION["hobby"] === 'e'){
      $_SESSION["hobby"] =
      'あなたは物事を考え、自身の中で分かりやすくかみ砕き処理する事に長けているでしょう。
      そんなあなたは、何度も繰り返しプログラムに学習させること（機械学習）や統計、データ分析を行う
      バックエンド・エンジニアリングに向いています。';
    }

    //設計
    if($_SESSION["hobby"] === 'f'){
      $_SESSION["hobby"] =
      'あなたは論理的に物事を組み立てて考えることができ、与えられた仕事は時間がかかっても完ぺきにこなして、クオリティを重視したいと考えます。
      物事の順序建てなど綿密で忍耐力が必要とされる作業を難なくこなすことができるでしょう。
      そんなあなたは、ルーターやモデムなどの電子機器の中に組み込まれるようなのシステムの構築や電子制御プログラムの開発をメインに金融や保険会社などの膨大な顧客データを適切かつ安全にあつかう
      世の中のシステムの裏側部分を担当するバックエンド・エンジニアリングに向いています。';
    }

    $_SESSION["interest"] = 'e';
  }else if($interest === 'HR'){

    //人事
    $_SESSION["interest"] = 'F';
    $_SESSION["hobby"] =
    'あなたは自身のスキル向上よりも他者の管理が得な傾向にあるのかもしれません。
    また、SES（派遣）でなく自社のために仕事をしたいと考えているでしょう。
    そんなあなたは、エンジニアにはこだわらず、一度担当の管理の方と面談をしましょう。
    弊社は多くの可能性があるので、担当の方が、あなたに合った働き方を示してくれます。';
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
       <form action="result.php" method="post">
         <h1>Q: どちらか一方を選択してください。</h1>
         <input type="radio" name="risk" value="true" checked>
         <label>言語の習得・成果物の制作に時間がかかるがハイリターン（高収入）を得られる</label></br>
         <input type="radio" name="risk" value="false">
         <label>ローリターン（低収入）だが、言語の習得・成果物の制作は比較的簡単</label>
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
