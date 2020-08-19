<?php
require_once ('/Users/nk/github/DoorKeys/conf.php');
require_once ('/Users/nk/github/DoorKeys/function.php');

session_start();
$link = get_db_connect($link);

// リクエストメソッド取得
$request_method = get_request_method();

if ($request_method === 'POST') {

  $email = get_post_data('email');
  $password = get_post_data('password');
  $password2 = get_post_data('password2');
  $username = get_post_data('username');

  if (error_check_preg_match($password) !== true){
    $error[] = 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
  }
  if (error_check_validata($email) !== true){
    $error[] = '入力された値が不正です。';
  }
  if (error_check_duplication($link, $email) !== true){
    $error[] = '既に登録済みのメールアドレスです';
  }
  if (error_check_trim($email) !== true){
    $error[] = 'メールアドレスを入力してください';
  }
  if (error_check_trim($username) !== true){
    $error[] = 'ユーザーネームを入力してください';
  }
  if (error_check_trim($password) !== true){
    $error[] = 'パスワードを入力してください1';
  }
  if (error_check_trim($password2) !== true){
    $error[] = 'パスワードを入力してください2';
  }
  if (error_check_pw_match($password, $password2) !==true){
    $error[] = 'パスワードが一致していません';
  }

  //書き込み内容を取得
  $sign_up = get_insert_sign_up($username, $email, $password);
  //エラーがない場合 クリエ実行
  if(count($error) === 0){

    $result = mysqli_query($link, $sign_up);

    header('Location: http://localhost:8888/login.php');
    exit();

  }else{
    $error[] = '登録失敗';
  }
}

close_db_connect($link);
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
   <meta charset="utf-8">
   <title>ARG新人用掲示板-Doorkey's-signup</title>
   <link rel="stylesheet" href="Style/stylesheet.css">
 </head>
 <header>
     <div class="container">
       <p id="logo_img"><a href="index.php"><img src="Images/logo-image.png"></a></p>
       </div>
     </div>
 </header>
 <body>
   <div class="session">
     <h1>新規登録</h1>
     <ul>
       <?php
       if (count($error) !== 0 ) {
           foreach($error as $error_msg) { ?>
           <li id="error"><?php print $error_msg; ?></li>
           <?php }
       } ?>
     </ul>
     <form method="POST"　action="signUp.php">
       <label for="text">ユーザー名</label>
       <input type="text" name="username">
       <label for="email">メールアドレス</label>
       <input type="email" name="email">
       <label for="password">パスワード</label>
       <input type="password" name="password">
       <label for="password2">パスワード再入力</label>
       <input type="password" name="password2">
       <button type="submit" name="button">登録</button>
     </form>
     <p><a href="login.php">ログインはこちら</a></p>
   </div>
 </body>
 <footer>
   <p>copyright(c) & Debeloped  by ARG-ARQ:I.i K.k</p>
 </footer>
</html>
