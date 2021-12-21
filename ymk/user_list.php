<?php
    //データベースへ接続
    $dsn = "mysql:host=localhost;dbname=user_list;charset=utf8";
    $username = "root";
    $password = "";
    $options = [];
    $pdo = new PDO($dsn, $username, $password, $options);
        if(@$_POST["id"] != "" OR @$_POST["user_name"] != ""){ //IDおよびユーザー名の入力有無を確認
            $stmt = $pdo->query("SELECT * FROM user_list WHERE ID='".$_POST["id"] ."' OR Name LIKE  '%".$_POST["user_name"]."%'");
        }
?>
<html>
<!-- 以下省略 -->

<html>
    <head>
        <title>User List</title>
    </head>
    <body>
        <form action="user_list.php" method="post">
            ID:<input type="text" name="id" value="<?php echo $_POST['id']?>">

            <br>
            Name:<input type="text" name="user_name" value="<?php echo $_POST['user_name']?>"><br>
            <input type="submit">
        </form>
    </body>
</html>


<!-- 省略 -->
</form>
        <table>
            <tr><th>ID</th><th>User Name</th></tr>
            <!-- ここでPHPのforeachを使って結果をループさせる -->
            <?php foreach ($stmt as $row): ?>
                <tr><td><?php echo $row[0]?></td><td><?php echo $row[1]?></td></tr>
            <?php endforeach; ?>
        </table>

    </body>
</html>
