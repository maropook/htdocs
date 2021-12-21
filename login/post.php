<?php

  session_start();

  require('dbconnect.php');

  // ログインしてから１時間を経過していなければ、投稿一覧画面が表示される
  // ログインしてから１時間を経過しているならば、ログイン画面に強制的に移動する
  if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {

    $_SESSION['time'] = time();     // セッションタイムを更新する

  } else {

    header('Location: login.php');
    exit();

  }

  // データベースに登録済みのユーザー名、及びpostsテーブルの全データを変数$postsに配列で格納
  $posts = $db->query('SELECT u.user_name, p.* FROM users u, posts p WHERE u.id=p.user_id ORDER BY p.posts_time DESC');

?>

<!DOCTYPE html>
<html lang="ja">

  <head>

　　　　　ログインできました

  </head>

  <body>

  　<!-- 上記のquery()メソッドで、データベースに登録済みのユーザー名、及びpostsテーブルの
  　 全データが$postsに配列で格納されているので、順番に一つずつ取り出し$postに格納 -->
  　<?php foreach ($posts as $post): ?>

  　　<p>(<?php print(htmlspecialchars($post['user_name'], ENT_QUOTES)); ?>)</p>
  　　<!-- 投稿内容をクリックすると投稿内容詳細画面に遷移すると同時に、投稿内容詳細画面のURLパラメーターにposts_idの番号を渡す -->
  　　<a href=" details.php ?posts_id=<?php print(htmlspecialchars($post['posts_id'], ENT_QUOTES)); ?>"><?php print(htmlspecialchars($post['message'], ENT_QUOTES)); ?></a>
  　　<p>
  　　　投稿日時：<?php print(htmlspecialchars($post['posts_time'], ENT_QUOTES)); ?>&emsp;

  　　　<!-- ログインユーザーIDと投稿作成者のユーザーIDが一致していれば、「削除」ボタンを表示する -->
  　　　<?php if ($_SESSION['id'] === $post['user_id']): ?>

  　　　　[<a href=" delete.php ?posts_id=<?php print(htmlspecialchars($post['posts_id'], ENT_QUOTES)); ?>">削除</a>]

  　　　<?php endif; ?>

  　　</p>     <!-- 「削除」ボタンを押すと、投稿削除画面に移動しつつ、投稿削除画面のURLパラメーターにposts_idの番号を渡す -->

  　<?php endforeach; ?>

  　<form action="" method="POST">

　　<label for="name">名前</label>
　　<input id="name" type="text" name='name' value="">

　　<label for="email">メールアドレス</label>
　　<input id="email" type="text" name='email' value="">

　　<label for="pass">パスワード</label>
　　<input id="pass" type="text" name='pass' value="">

　　<input id="submit" type="submit" value="投稿内容詳細">

　</form>

  </body>

</html>


