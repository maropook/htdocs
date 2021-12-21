<?php

  try {
    $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8', 'root', '');
  } catch(PDOException $e) {
    print('DB接続エラー：' . $e->getMessage());
  }

?>