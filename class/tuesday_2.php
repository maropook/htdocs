<!DOCTYPE HTML>
<body>
    <form method="post" action="">
        <input type="text" name="name" value="">
        <input type="submit" name="submit" value="投稿">
    </form>
    <?php
        $pdo = new PDO("mysql:host=localhost;dbname=mydb;charset=utf8","root","");

        if(isset($_POST['submit']) ){
            $name = $_POST['name'];
            $sth = $pdo->prepare("INSERT INTO todos (name) VALUES (:name)");
            $sth->bindValue(':name', $name, PDO::PARAM_STR);
            $sth->execute();
        }
    ?>
    <h1>Todoリスト</h1>
    <?php
    $sth = $pdo->prepare("SELECT * FROM todos ORDER BY id DESC");
    $sth->execute();
    
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        echo "<p>". $row['name']. "</p>";
    }
?>
</body>
</html>