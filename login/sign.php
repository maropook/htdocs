<?php

 session_start();

 require('dbconnect.php');

 // 画面を表示した時、POSTに値が存在する場合、セッションの内容をデータベースに登録。
 if (!empty($_POST)) {
   $statement = $db->prepare('INSERT INTO users SET user_name=?, email=?, password=?, user_time=NOW()');

   echo $statement->execute(array(

     $_SESSION['query']['name'],
     $_SESSION['query']['email'],
     sha1($_SESSION['query']['pass'])

  ));

  // セッションを削除する
  unset($_SESSION['query']);

  // 登録完了画面に移動する
  header('Location: signok.php');
  exit();
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

  　　<label for="name">名前</label>
  　　<input id="name" type="text" name='name' value="">

  　　<label for="email">メールアドレス</label>
  　　<input id="email" type="text" name='email' value="">

  　　<label for="pass">パスワード</label>
  　　<input id="pass" type="text" name='pass' value="">

  　　<input id="submit" type="submit" value="登録">

  　</form>

  </body>

</html>