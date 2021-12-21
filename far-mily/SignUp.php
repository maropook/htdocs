<?php
require 'password.php';   // password_hash()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "hogeUser";  // ユーザー名
$db['pass'] = "hogehoge";  // ユーザー名のパスワード
$db['dbname'] = "loginManagement";  // データベース名

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["username"])) {  // 値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["password2"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
        // 入力したユーザIDとパスワードを格納
        $username = $_POST["username"];
        $password = $_POST["password"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO userData(name, password) VALUES (?, ?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
            $userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

            $signUpMessage = '登録が完了しました。あなたのユーザーIDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>新規登録</title>
            <style rel="stylesheet" type="text/css">



/* Fonts */
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400);

/* fontawesome */
@import url(http://weloveiconfonts.com/api/?family=fontawesome);
[class*="fontawesome-"]:before {
  font-family: 'FontAwesome', sans-serif;
}

/* Simple Reset */
* { margin: 0; padding: 0; box-sizing: border-box; }

/* body */
body {
  background: #e9e9e9;
  color: #5e5e5e;
  font: 400 87.5%/1.5em 'Open Sans', sans-serif;
}

/* Form Layout */
.form-wrapper {
  background: #fafafa;
  margin:20% auto 70%;
  padding: 0 1em;
  max-width: 370px;
  
}

h1 {
  text-align: center;
  
  padding: 0 0 1em 0;
}




form {
  padding: 0 1.5em;
}

.form-item {
  margin-bottom: 0.75em;
  width: 100%;
}

.form-item input {
  background: #fafafa;
  border: none;
  border-bottom: 2px solid #e9e9e9;
  color: #666;
  font-family: 'Open Sans', sans-serif;
  font-size: 1em;
  height: 50px;
  transition: border-color 0.3s;
  width: 100%;
}

.form-item input:focus {
  border-bottom: 2px solid #f3a0a0;
  outline: none;
}

.button-panel {
  margin: 2em 0 0;
  width: 100%;
}

.button-panel .button {
  background: #f3a0a0;
  border: none;
  color: #fff;
  cursor: pointer;
  height: 50px;
  font-family: 'Open Sans', sans-serif;
  font-size: 1.2em;
  letter-spacing: 0.05em;
  text-align: center;
  text-transform: uppercase;
  transition: background 0.3s ease-in-out;
  width: 100%;
}

.button:hover {
  background: #ef7d8a;
}

.form-footer {
  font-size: 1em;
  padding: 2em 0;
  text-align: center;

}

.form-footer a,.form-footer p{
  color: #8c8c8c;
  text-decoration: none;
  transition: border-color 0.3s;
}

.form-footer a:hover {
  border-bottom: 1px dotted #8c8c8c;
}







.my-container{
  max-width: 620px;
  margin-right: auto;
  margin-left: auto;
  background: rgb(239, 230, 230);
}

.form-logo{


  
  display: inline-block;
position: relative;
margin-left: 270px;
padding: 5px;


}

footer,header,main{
  display:block;
}



header{
position: sticky;
z-index: 11;
display: flex;

max-width: 620px;
margin-right: auto;
margin-left: auto;
top: 0;
height: 48px;
background-color: #f3a0a0;



}

header .icon,header .service{
  position: relative;
  top: -1px;
  padding: 10px 18px;
  text-align: center;
  font-size: 1.8rem;
}


header .icon .smile{
  width: 98px;
  height: 33px;
}
header .service .logo{
  width: 33px;
  height: 33px;
}
header .service .logo{
  position: absolute;
  margin-left: 240px;
  width: 40px;
  height: 40px;

}


header .notification{
  position: absolute;
  margin-left: 500px;
  margin-top: -5px;
  width: 40px;
  height: 40px;

}
header .smile{
  position: absolute;
  margin-left: 0px;
}
.tags{
  margin-top:50px;


  display: flex;
  list-style-type:none;
  padding: 0;
  margin-bottom: 20px;
}
.tags li{
  width: 50%;
  text-align: center;
  margin:12px 0;
}
.tags li a{
  color: #999;
  text-decoration: none;
  margin:12px 0;
  font-size: 13px;
  
}



.tags{
  position: sticky;
  top: 0;
  z-index: 10;
  list-style-type: none;
  padding: 0;
  border-bottom: .5px solid #e5e5e5;
  margin-bottom: 20px;
  background-color: rgb(241, 156, 156);
}
.tags li{
  width: 50%;
  text-align: center;
  margin:12px 0;
}
.tags li a{
  text-decoration: none;
}




footer{
  position: sticky;
  bottom: 0;
  z-index: 1;
  height: 40px;
  max-width: 620px;
  margin-right: auto;
  margin-left: auto;
  background-color: rgb(67, 34, 0);
}
footer ul{
 display: flex;
 list-style-type: none;
 padding: 0;
 margin-bottom: 0;
}
footer ul li{
  flex-grow: 1;
  text-align: center;
  width: 33.33333333%;
  padding-top: 13px;
}
footer ul li img{
  height: 24px;
  padding: 2.25px;
}
footer ul li img.plus-icon{
  width: 38px;
  height: 38px;
}
footer a{
  color: #202020;
  font-size: 0.3rem;
}
footer a p{

font-size: 0.8rem;
line-height: 0.4rem;
padding-top: 5px;
color: #fff;
  
}



</style>
    </head>



    <body>
		<div class="my-container">
			<main id="app">
				<header class="container">
					<div class="icon"><img src="img/farmily_logo.png" class="smile" alt=""></div>
					<!-- <div class="service"><img src="img/clova_logo.png" class="logo" alt=""></div> -->
					<a class="icon"><img src="img/clova_logo.png" class="notification" alt=""></a>
				</header>
				   

					<div class="form-wrapper">
						<div class="form-logo"><img src="img/clova_logo.png" alt=""></div>
						<h1>far-mily新規登録</h1>
		<form id="loginForm" name="loginForm" action="" method="POST">
			<div>
            <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>

			<div class="form-item">
				<label for="username"></label><input type="text" id="username" name="username"
					placeholder="ユーザ名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
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