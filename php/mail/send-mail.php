<?php
require_once '../assets/helper/helper.php';

require_once '../assets/libs/phpmailer/src/PHPMailer.php';
require_once '../assets/libs/phpmailer/src/SMTP.php';
require_once '../assets/libs/phpmailer/src/Exception.php';

loadEnv(__DIR__ . '/../.env');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
  echo json_encode([
    "success" => false,
  ]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);

// ユーザーからの入力を取得
$name = isset($data['name']) ? sanitize($data['name']) : '';
$email = isset($data['email']) ? sanitize($data['email']) : '';
$content = isset($data['content']) ? sanitize($data['content']) : '';

// バリデーションチェック（簡易）
if (
  empty($name) ||
  empty($email) ||
  empty($content)
) {
  echo json_encode([
    "success" => false,
  ]);
  exit;
}

/**
 * メール送信処理
 */
$mail = new PHPMailer(true);

$appEnv = $_ENV['APP_ENV'];

try {
  $mail->isSMTP();
  $mail->Host = $_ENV['MAIL_HOST'];
  $mail->SMTPAuth = $appEnv === 'local' ? false : true;
  $mail->Username = $appEnv === 'local' ? '' : $_ENV['MAIL_USERNAME'];
  $mail->Password = $appEnv === 'local' ? '' : $_ENV['MAIL_PASSWORD'];
  $mail->SMTPSecure = $appEnv === 'local' ? '' : $_ENV['MAIL_SMTP_SECURE'];
  $mail->Port = $_ENV['MAIL_PORT'];
  $mail->CharSet = 'UTF-8';
  $mail->isHTML();

  $appName = $_ENV['APP_NAME'];
  $adminEmail = $_ENV['ADMIN_MAIL_ADDRESS'];

  $post = [
    'name' => $name,
    'email' => $email,
    'content' => $content,
  ];

  /**
   * ユーザー宛
   */
  $mail->setFrom($adminEmail, $appName);
  $mail->addAddress($email, $name); // 宛先
  $mail->Subject = "【{$appName}】お問い合わせいただきありがとうございました"; // 件名
  $lead = "{$name}様<br><br>お問い合わせいただきありがとうございました。\n以下の内容でお問い合わせをお受けしました。<br><br>";
  $body = $lead . set_mail_content($post);
  $mail->Body = nl2br($body);
  $mail->send();

  /**
   * 管理者宛
   */
  $mail->clearAddresses(); // 宛先をクリア
  $mail->addAddress($adminEmail, $appName);
  $mail->Subject = "ホームページからお問い合わせがありました";
  $lead = '以下の内容でホームページからお問い合わせがありました。<br><br>';
  $body = $lead . set_mail_content($post);
  $mail->Body = nl2br($body);

  $mail->send();

  echo json_encode([
    "success" => true,
  ]);
} catch (Exception $e) {
  echo json_encode([
    "success" => false,
  ]);
  exit;
}
