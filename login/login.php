<?php

  session_start();

  require('dbconnect.php');

  // formタグの「ログイン」ボタンを押した際、メールアドレスとパスワードが入力されているかを確認し、
  // それらがデータベースに登録されているか確認。メールアドレスとパスワードが一致するユーザーが
  // 確認できた場合、$memberにユーザー情報を格納する
  if ($_POST['email'] != '' && $_POST['pass'] != '') {

    $login = $db->prepare('SELECT * FROM users WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['pass'])
    ));
    $member = $login->fetch();

    // $memberに値が入っている場合、セッションに該当のユーザーのidとログイン時間を
    // 記録し、投稿一覧画面へ移動する。

    if ($member) {

      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      header('Location: post.php
      ');
      exit();

    } 

  } 

?>
<!DOCTYPE html>
<html lang="ja">

  <head>

  </head>

  <body>

  　<!-- action="" として移動先のURLを指定していないのは、submitの「確認画面へ」ボタンを
  　押した後、もう一度同じ画面を呼び出すことで、上記の header('Location: '); によって
  　画面を移動させたいから -->
  　<form action="" method="POST">

  　　
  　　<label for="email">メールアドレス</label>
  　　<input id="email" type="text" name='email' value="">

  　　<label for="pass">パスワード</label>
  　　<input id="pass" type="text" name='pass' value="">

  　　<input id="submit" type="submit" value="ログイン">

  　</form>

  </body>

</html>