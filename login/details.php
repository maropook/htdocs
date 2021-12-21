<?php

  // 投稿一覧画面から送られてきたposts_id（URLパラメーターに付いている）が空ならば、
  // 投稿一覧画面に戻す
  if (empty($_REQUEST['posts_id'])) {
    header('Location: post.php');
    exit();
  }

  // 投稿一覧画面から送られてきたposts_id（URLパラメーターに付いている）などと一致する
  // データを$postsに格納
  $posts = $db->prepare('SELECT u.user_name, p.* FROM users u, posts p WHERE u.id=p.user_id AND p.posts_id=?');
  $posts->execute(array($_REQUEST['posts_id']));

?>
<!DOCTYPE html>
<html lang="ja">


  <body>

  　<!-- 上記で$postsに格納したデータを一つづつ取り出し、$postに格納 -->
  　<?php if ($post = $posts->fetch()): ?>

  　　<p>(<?php print(htmlspecialchars($post['user_name'], ENT_QUOTES)); ?>)</p>
  　　<p><?php print(htmlspecialchars($post['message'], ENT_QUOTES)); ?></p>
  　　<p>投稿日時：<?php print(htmlspecialchars($post['posts_time'], ENT_QUOTES)); ?></p>

  　<?php endif; ?>

  　<!-- ログインユーザーIDと投稿作成者のユーザーIDが一致していれば、「投稿内容の編集」ボタンを表示する -->
  　<!-- 投稿編集画面のURLパラメーターにposts_idの番号を渡しつつ、投稿編集画面に遷移する -->
  　<?php if ($_SESSION['id'] === $post['user_id']): ?>

  　　<a href="edit.php ?posts_id=<?php print(htmlspecialchars($_REQUEST['posts_id'], ENT_QUOTES)); ?>">投稿内容の編集</a>

  　<?php endif; ?>

  　<form action="" method="POST">

　　<label for="name">名前</label>
　　<input id="name" type="text" name='name' value="">

　　<label for="email">メールアドレス</label>
　　<input id="email" type="text" name='email' value="">

　　<label for="pass">パスワード</label>
　　<input id="pass" type="text" name='pass' value="">

　　<input id="submit" type="submit" value="投稿編集画面">

　</form>

  </body>

</html>