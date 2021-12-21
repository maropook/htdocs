<?php
require 'password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "hogeUser";  // ユーザー名
$db['pass'] = "hogehoge";  // ユーザー名のパスワード
$db['dbname'] = "loginManagement";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["userid"])) {  // emptyは値が空のとき
        $errorMessage = 'ログインIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
        // 入力したユーザIDを格納
        $userid = $_POST["userid"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare('SELECT * FROM userData WHERE id = ?');
            $stmt->execute(array($userid));

            $password = $_POST["password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);

                    // 入力したIDのユーザー名を取得
                    $id = $row['id'];
                    $_SESSION["ID"] = $id;
                    $sql = "SELECT * FROM userData WHERE id = $id";  //入力したIDからユーザー名を取得
                    $stmt = $pdo->query($sql);
                    foreach ($stmt as $row) {
                        $row['name'];  // ユーザー名
                    }
                    
                    $_SESSION["NAME"] = $row['name'];
                    header("Location: Main.php");  // メイン画面へ遷移
                    exit();  // 処理終了
                } else {
                    // 認証失敗
                    $errorMessage = 'ログインIDあるいはパスワードに誤りがあります。';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ログインIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>ログイン</title>

            <link rel="stylesheet" href="style.css">
 
    </head>


<body>
    <div class="my-container">
        <main id="app">
            <header class="container">
                <div class="icon"><img src="img/white_logo.png" class="smile" alt=""></div>
                <!-- <div class="service"><img src="img/logo.png" class="logo" alt=""></div> -->
                <a class="icon"><img src="img/logo.png" class="notification" alt=""></a>
            </header>
               
          
                <div class="form-wrapper">
                    <div class="form-logo"><img src="img/logo.png" alt=""></div>
                    <h1>far-milyログイン</h1>
                    
                    <form id="loginForm" name="loginForm" action="" method="POST">
                        <div>
                            <font color="#ff0000">
                            <?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?>
                            </font>
                        </div>

                        <div class="form-item">
                            <label for="userid"></label><input type="text" id="userid" name="userid"
                                placeholder="ログインIDを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
                        </div>
                        <div class="form-item">

                            <label for="password"></label><input type="password" id="password" name="password" value=""
                                placeholder="パスワードを入力">
                        </div>
                        <div class="button-panel">
                            <input type="submit" class="button" id="login" name="login" value="ログイン">
                            <br>
                        </div>
                    </form>
                    <form name="jump" action="SignUp.php">
                        <div class="form-footer">
                            <p>アカウントがない場合はこちら</p>
                            <p><a href="javascript:document.jump.submit()">新規登録</a></p>
                        </div>
                    </form>
                </div>

     


        </main>
        <footer id="footer">
            <ul>

                <li>
                    <a href=""><p>far-milyへようこそ</p></a>
                </li>
                <!-- <li><a><img src="img/home.png">
                        <p>ホーム</p>
                    </a></li>
                <li class="plus-circle"><a class="icon"><img src="img/plus.png" class="plus-icon" alt=""></a>
                </li>
                <li><a class="icon"><img src="img/heart.png" alt="">
                        <p>お気に入り</p>
                    </a></li> -->



                    <!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>新規登録</title>
<link rel="stylesheet" href="style.css">
    </head>
    <body>
		<div class="my-container">
			<main id="app">
				<header class="container">
					<div class="icon"><img src="img/white_logo.png" class="smile" alt=""></div>
					<!-- <div class="service"><img src="img/logo.png" class="logo" alt=""></div> -->
					<a class="icon"><img src="img/logo.png" class="notification" alt=""></a>
				</header>
				   

					<div class="form-wrapper">
						<div class="form-logo"><img src="img/logo.png" alt=""></div>
						<h1>far-mily新規登録</h1>
		<form id="loginForm" name="loginForm" action="" method="POST">
			<div>
				<font color="#ff0000">
					<!-- phpmエラーメッセ -->
				</font>
			</div>
			<div>
				<font color="#ff0000">
					<!-- phpmサインアップメッセ -->
				</font>
			</div>

			<div class="form-item">
				<label for="username"></label><input type="text" id="username" name="username"
					placeholder="ユーザ名を入力" value="">
			</div>
			<div class="form-item">

				<label for="password"></label><input type="password" id="password" name="password" value=""
					placeholder="パスワードを入力">
			</div>
			<div class="form-item">

				<label for="password2"></label><input type="password" id="password2" name="password2" value=""
					placeholder="再度パスワードを入力">
			</div>
			<div class="button-panel">
				<input type="submit" class="button" id="signUp" name="signUp" value="新規登録">
				<br>
			</div>
		</form>

		<form name="jump" action="Login.php">
			<div class="form-footer">
				
				<p><a href="javascript:document.jump.submit()">ログイン画面に戻る</a></p>
			</div>
		</form>
	</div>




</main>
<footer id="footer">
<ul>

	<li>
		<a href=""><p>far-milyへようこそ</p></a>
	</li>
	<!-- <li><a><img src="img/home.png">
			<p>ホーム</p>
		</a></li>
	<li class="plus-circle"><a class="icon"><img src="img/plus.png" class="plus-icon" alt=""></a>
	</li>
	<li><a class="icon"><img src="img/heart.png" alt="">
			<p>お気に入り</p>
		</a></li> -->
</ul>
</footer>

</div>
</body>

</html>














































            </ul>
        </footer>

    </div>
</body>

</html>