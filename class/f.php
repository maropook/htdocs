<?php
 $price = 100; //元金
 print<<<EOF
 <HTML>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <HEAD><TITLE>フォームのテスト</TITLE></HEAD>
 <BODY>
 EOF;
 if(isset($_REQUEST["price"])){ // もし前ページからの値(price)がセットされていれば
 $price = $_REQUEST["price"]; // 値を取得
 }
 if(isset($_REQUEST["soushin"])){ // 結果表示画面（もしsoushinがセットされていれば
 print<<<EOF
 <H1>現在の給料＝ $price 円</H1>
 <form method="POST" action="{$_SERVER["PHP_SELF"]}">
 <inputtype="hidden" name="price" size="30" maxlength="20" value=$price>
 <input type="submit" value="戻る" name="modoru">
 </form>
 EOF;
 } 
 else { // 初期画面
 print<<<EOF
 <H1>給料を入力してください。</H1>
 <form method="POST" action="{$_SERVER["PHP_SELF"]}"> 
 <input type="text" name="price" size="30" maxlength="20" value=$price>
 <input type="submit" value="送信" name="soushin">
 </form>
 EOF; 
 }
 print<<<EOF
 </body> 
 </html> 
 EOF;
?>