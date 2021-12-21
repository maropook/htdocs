<?php
    //データベースへ接続
    $dsn = "mysql:dbname=test;host=localhost;charset=utf8mb4";
    $username = "hogeUser";
    $password = "hogehoge";
    $options = [];
    $pdo = new PDO($dsn, $username, $password, $options);
        if(@$_POST["id"] != "" OR @$_POST["user_name"] != ""){ //IDおよびユーザー名の入力有無を確認
            $stmt = $pdo->query("SELECT * FROM user_list2 WHERE ID='".$_POST["id"] ."' OR Name LIKE  '%".$_POST["user_name"]."%')"); //SQL文を実行して、結果を$stmtに代入する。
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
            <?php
                if(preg_match("/[^0-9A-Za-z]/", $_POST['id'])){
                   echo " IDは英数字で入力してください！";
                }
            ?>
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