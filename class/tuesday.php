<!DOCTYPE html>
<html lang="ja">
<head>
</head>
<body>
    <form method="post">
        <p>名前</p>
        <input type="text" name="a">
        <!-- textとすると一行のテキストエリアになる -->
        <p>コメント</p>
        <textarea name="b"></textarea>
        <!-- 複数のテキストを入れる　それがbに入る -->
        <input type="submit" value="送信">
        <!-- submitとかくと，ボタンになる．valueに書かれた文字がボタンにかかれる -->
    </form>
    

    <?php
    print $_POST["a"] . "<br>";
    print $_POST["b"]. "<br>";

    print $_POST["a"] . "<br>"  . $_POST["b"];

//    .は文字列の連結を表すこれがないと改行ができない
    // aというところにテキストエリア，bというところには大きいテキストエリアに入力した文字列が
    // $_POST["この場所に入れて　配列のindexをここに書く"]これでデータのやり取りを全てできる
    // 連想配列　数字とかじゃなくて
    ?>
</body>
</html>