<?php

  session_start();

  require('dbconnect.php');

  // ログインしてから１時間を経過していなければ、投稿編集画面が表示され、
  // 変数$memberにログインユーザーの登録情報を格納する。
  // ログインしてから１時間を経過しているならば、ログイン画面に強制遷移する。
  if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {

    $_SESSION['time'] = time();     // セッションタイムを更新する

    $members = $db->prepare('SELECT * FROM users WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();

  } else {

    header('Location: login.php');
    exit();

  }

  // 「投稿内容を編集する」ボタンが押された場合、投稿内容が空欄でなければ、
  // その内容をもとにデータベースに登録されている内容を変更する。その後、投稿一覧画面に移動する。
  if (!empty($_POST)) {
    if ($_POST['message'] !== '') {

      // WHEREに複数条件を設定する場合は「,」でなく「AND」なので注意！
      $message = $db->prepare('UPDATE posts SET message=?, posts_modify=NOW() WHERE posts_id=? AND user_id=?');
      $message->execute(array(
        $_POST['message'],
        $_REQUEST['posts_id'],
        $member['id']
      ));

      header('Location: post.php');
      exit();

    }
  }

?>