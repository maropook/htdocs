<?php
    $pdo = new PDO("mysql:host=localhost;dbname=mydb;charset=utf8","root","", [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);

    if(isset($_POST['submit']) ){
        $name = $_POST['name'];
        $content = nl2br($_POST['content']);
        $sth = $pdo->prepare("INSERT INTO chat (name, content) VALUES (:name, :content)");
        $sth->bindValue(':name', $name, PDO::PARAM_STR);
        $sth->bindValue(':content', $content, PDO::PARAM_STR);
        $sth->execute();
    }elseif(isset($_POST['delete'])){
        $id = $_POST['id'];
        $sth = $pdo->prepare("delete from chat where id = :id");
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
    }
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
</head>

<body class="container">
    <form method="post">
        <p>名前</p> <input type="text" name="name">
        <p>内容</p><textarea name="content"></textarea>
        <input type="submit" name="submit" value="投稿">
    </form>
    <table class="table table-striped">
        <tbody>
<?php
    $sth = $pdo->prepare("SELECT * FROM chat ORDER BY id DESC");
    $sth->execute();
    
    foreach($sth as $row) {
?>
            <tr>
            <!-- htmlspecialcharsとはセキュリティーのためにこの中身を完全な文字列として認識させる -->
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['content'] ?></td>
                <td>
                    <form method="POST">
                        <button type="submit" name="delete">削除</button>
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="delete" value="true">
                    </form>
                </td>
            </tr>
<?php
    }
?>
        </tbody>
    </table>
</body>
</html>