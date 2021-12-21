<?php

  session_start();
  require('dbconnect.php');

  // ユーザーのログインIDがセッションにあるか確認。その後投稿一覧画面から渡された
  // URLパラメーターにあるposts_idの番号をもとにデータベースのデータを抽出し、
  // 削除する。最後に、投稿一覧画面に強制遷移する。
  if (isset($_SESSION['id'])) {

    $id = $_REQUEST['posts_id'];

    $messages = $db->prepare('SELECT * FROM posts WHERE posts_id=?');
    $messages->execute(array($id));
    $message = $messages->fetch();

    if ($message['user_id'] == $_SESSION['id']) {
      $del = $db->prepare('DELETE FROM posts WHERE posts_id=?');
      $del->execute(array($id));
    }

  }

  header('Location: post.php');
  exit();

?>