<?php
    //データベースへ接続
    $dsn = "mysql:host=localhost;dbname=test;charset=utf8";
    $username = "hogeUser";
    $password = "hogehoge";
    $options = [];
    $pdo = new PDO($dsn, $username, $password, $options);
        if(@$_POST["id"] != "" OR @$_POST["user_name"] != "" OR @$_POST["user_kana"] != ""){ //IDおよびユーザー名の入力有無を確認
            $stmt = $pdo->query("SELECT * FROM user_list WHERE ID='".$_POST["id"] ."' OR Name LIKE  '%".$_POST["user_name"]."%' OR kana LIKE  '%".$_POST["kana"]."%' "); 
        }
?>
<html>
<!-- 以下省略 -->

<html>
    <head>
        <title>User List</title>
    </head>
    <body>
        <p>ない場合はなしと入力してください</p>
        <form action="user_list2.php" method="post">
            <!-- ID:<input type="text" name="id" value="<?php echo $_POST['id']?>">
           <br> -->
           
            正式名称検索:<input type="text" name="user_name" value="<?php echo $_POST['user_name']?>">
            <?php
                if($_POST['user_name']==""){
                   echo " ない場合なしと入力してください";
                }
            ?>
            <br>
            ひらがな検索:<input type="text" name="kana" value="<?php echo $_POST['kana']?>">
            <?php
                if($_POST['kana']==""){
                   echo " ない場合なしと入力してください";
                }
            ?>
            <br>
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
                <tr><td><?php echo $row[0]?></td><td><?php echo $row[1]?></td><td><a target="_blank" href="<?php echo $row[3]?>">こちら</a></td></tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>