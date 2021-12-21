<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=mydb;charset=utf8", "root", "");
    //ファイルアップロードがあったとき
    if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== "") {
        //画像・動画をバイナリデータにする．
        $raw_data = file_get_contents($_FILES['upfile']['tmp_name']);
        //拡張子を見る
        $tmp = pathinfo($_FILES["upfile"]["name"]);
        $extension = $tmp["extension"];
        if ($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG") {
            $extension = "jpeg";
        } elseif ($extension === "png" || $extension === "PNG") {
            $extension = "png";
        } elseif ($extension === "gif" || $extension === "GIF") {
            $extension = "gif";
        } elseif ($extension === "mp4" || $extension === "MP4") {
            $extension = "mp4";
        } else {
            echo "非対応ファイルです．<br/>";
            echo ("<a href=\"index.php\">戻る</a><br/>");
            exit(1);
        }
        //DBに格納するファイルネーム設定
        //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
        $date = getdate();
        $fname = $_FILES["upfile"]["tmp_name"];
        //$fname = hash("sha256", $fname);
        $name = $_POST['name'];
        $content = nl2br($_POST['content']);
        //画像・動画をDBに格納．
        $sql = "INSERT INTO movie(fname, extension, raw_data, name, content) VALUES (:fname, :extension, :raw_data, :name, :content);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->bindValue(":fname", $fname, PDO::PARAM_STR);
        $stmt->bindValue(":extension", $extension, PDO::PARAM_STR);
        $stmt->bindValue(":raw_data", $raw_data, PDO::PARAM_STR);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sth = $pdo->prepare("delete from movie where id = :id");
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
    } elseif (isset($_POST['search'])) {
        $dsn = "mysql:host=localhost;dbname=mydb;charset=utf8";
        $username = "hogeUser";
        $password = "hogehoge";
        $options = [];
        $pdo = new PDO($dsn, $username, $password, $options);
        if (@$_POST["name_search"] != "" or @$_POST["content"] != "") { //contentおよびユーザー名の入力有無を確認
            $_POST["content"] = nl2br($_POST["content"]);
            $st = $pdo->query("SELECT * FROM movie WHERE name LIKE '%" . $_POST["name_search"] . "%' AND content LIKE  '%" . $_POST["content"] . "%'");
        }
    }
} catch (PDOException $e) {
    echo ("<p>500 Inertnal Server Error</p>");
    exit($e->getMessage());
}
?>

<!DOCTYPE HTML>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>tiktok</title>

    <head>
        <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
        <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
        <link rel="stylesheet" href="style.css">
    </head>

<body>
    <div id="content">
        <header>
            <h1 class="headline">
                <a href="index.php">tiktok</a>
            </h1>
            <ul class="nav-list">
                <li class="nav-list-item"><a href="post.php">Post</a></li>
                <li class="nav-list-item"><a href="search.php">Search</a></li>
                <li class="nav-list-item"><a href="top.php">New</a></li>
            </ul>
        </header>
        <div id="container">
            <main>
                <section id="post">
                    <h2>
                        <a>投稿</a>
                    </h2>

                    <form action="index.php" enctype="multipart/form-data" method="post">
                        名前: <input type="text" name="name">
                        内容:<textarea name="content"></textarea>
                        <div class='body_file'>
                            <label for="file" class="filelabel">動画/画像選択</label>
                            <input type="file" name="upfile" id="file" class="fileinput">
                            jpeg，png，gif,mp4方式のみ対応
                        </div>
                        <br>
                        <div class="btn_submit">
                            <input type="submit" value="アップロード">
                        </div>
                    </form>
                </section>
               
         
            </main>
        </div>
    </div>
</body>

</html>