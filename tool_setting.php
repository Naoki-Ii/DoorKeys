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

//トップ画像変更の場合のみ実行
if(isset($_POST['submit_img']) === TRUE){

  $img = get_file_data('img');
  //var_dump($img);
  //ファイルアップロード
  $res= get_input_image('img', UPLOADPATH);
  //var_dump($res);

  if (mb_strlen($img['name']) === 0) {
    $error [] = '画像が選択されていません';
  }
  if ($res['status'] === false) {
      $error [] = 'ファイル形式が間違っています';
  }

  if(count($error) === 0){
    $new_img = change_data_img_tool($link, UPLOADPATH. $res['status'], $tool_email);

    $_SESSION["IMG_TOOL"] = $new_img;

    $tool_img = $_SESSION["IMG_TOOL"];

    $msg[] = '画像変更完了';
  }
}
//ユーザー名変更の場合のみ実行
if(isset($_POST['submit_user']) === TRUE){

  $name = get_post_data('username');
  $password = get_post_data('password');

  //エラーチェック
  if (error_check_trim($name) !== true){
    $error[] = 'ユーザーネームを入力してください';
  }
  if (error_check_trim($password) !== true){
    $error[] = 'パスワードを入力してください1';
  }
  //入力されたパスワードを照合
  if(password_verify($password, $tool_session_password) !== TRUE){
    $error[] = 'パスワードが間違っています';
  }

  if(count($error) === 0){
  $new_user_name = change_data_username_tool($link, $name, $tool_email);

  $_SESSION["NAME_TOOL"] = $new_user_name;

  $tool_name = $_SESSION["NAME_TOOL"];

  $msg[] = '管理者名変更完了';
  }


}

//パスワード変更の時のみ実行
if(isset($_POST['submit_password']) === TRUE){
  $password = get_post_data('password');
  $newpassword1 = get_post_data('newpassword1');
  $newpassword2 = get_post_data('newpassword2');

  //エラーチェック
  if (error_check_trim($password) !== true){
    $error[] = '現在のパスワードを入力してください';
  }
  if (error_check_trim($newpassword1) !== true){
    $error[] = '新しいパスワードを入力してください';
  }
  if (error_check_trim($newpassword2) !== true){
    $error[] = '新しいパスワードを再入力してください';
  }
  if (error_check_pw_match($newpassword1, $newpassword2) !== true){
    $error[] = '新しいパスワードが一致しません';
  }
  if (error_check_preg_match($newpassword1) !== true){
    $error[] = 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください';
  }
  //入力されたパスワードを照合
  if(password_verify($password, $tool_session_password) !== TRUE){
    $error[] = 'パスワードが間違っています';
  }else{
    if (error_check_pw_match($password, $newpassword1) === true){
      $error[] = '現在と同じパスワードは設定できません';
    }
  }

  if (count($error) === 0){
    $hash = password_hash($newpassword1, PASSWORD_DEFAULT);
    $new_password = change_data_password_tool($link, $hash, $tool_email);

    $_SESSION["PASSWORD_TOOL"] = $new_password;

    $tool_session_password = $_SESSION["PASSWORD_TOOL"];

    $msg[] = 'パスワード変更完了';
  }

}
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
     <div class="setting_display">
     <ul>
       <?php
       if (count($error) !== 0 ) {
           foreach($error as $error_msg) { ?>
           <li id="error"><?php print $error_msg; ?></li>
           <?php }
       } ?>
       <?php
       if (count($msg) !==0){
         foreach ($msg as $msg_display) { ?>
           <li id="success"><?php echo $msg_display; ?></li>
         <?php }
       }?>
     </ul>
       <form method="post" enctype="multipart/form-data">
         <h1>メイン画像変更</h1>
         <img src="<?php echo entity_str($tool_img);?>" alt="tool_img" width="100px">
         <input type="file" name="img">
         <button type="submit" name="submit_img">変更</button>
       </form>
       <div class="psw_display">
         <form method="post">
           <h1>管理者名変更</h1>
           <p>現在のユーザー名:  <?php echo entity_str($tool_name); ?></p>
           <label for="name">新しいユーザー名</label>
           <input type="name" name="username">
           <label for="password">パスワードを入力</label>
           <input type="password" name="password">
           <button type="submit" name="submit_user">変更</button>
         </form>
         <form method="post">
           <h1>パスワード変更</h1>
           <label for="password">現在のパスワードを入力</label>
           <input type="password" name="password">
           <label for="newpassword1">新しいパスワード</label>
           <input type="password" name="newpassword1">
           <label for="newpassword2">新しいパスワード(再入力)</label>
           <input type="password" name="newpassword2">
           <button type="submit" name="submit_password">変更</button>
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
