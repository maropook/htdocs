<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>メイン</title>

        <style rel="stylesheet" type="text/css">
body {
	padding: 20px;
	text-align: center;
}

h1 {
	margin-bottom: 20px;
	padding: 20px 0;
	color: #209eff;
	font-size: 122%;
	border-top: 1px solid #999;
	border-bottom: 1px solid #999;
}
a{

    margin-bottom: 20px;
	padding: 20px 0;
	color: #209eff;
	font-size: 100%;


}
</style>
    </head>
    <body>
        <h1>メイン画面</h1>
        <!-- ユーザーIDにHTMLタグが含まれても良いようにエスケープする -->

        <p>あなたのログインIDは<u><?php echo htmlspecialchars($_SESSION["ID"], ENT_QUOTES); ?></u>です</p>
        <p>ようこそ<u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん</p><!-- ユーザー名をechoで表示 -->
    
     <a href="Logout.php">ログアウト</a>
    
    </body>
</html>