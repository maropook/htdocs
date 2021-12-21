<?php
$from = 'i444409024444@gmail.com';
$to = 'i444409024444@gmail.com';
$subject = '件名: テスト送信';
$message = <<< EOF
{$from}より。

こんにちは。
これはテスト送信です。
EOF;

if (mb_send_mail($to, $subject, $message, "From: {$from}")) {
echo '送信成功。';
} else {
echo '送信失敗。<br>エラーログを確認してください。 (xampp\sendmail\error.log)';
}