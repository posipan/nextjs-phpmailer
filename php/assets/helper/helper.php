<?php

/**
 * .envファイルの読み込み
 */
if (!function_exists('loadEnv')) {
  function loadEnv($path): void
  {
    if (!file_exists($path)) {
      throw new Exception('.env file not found');
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
      if (strpos(trim($line), '#') === 0) {
        continue;
      }

      list($name, $value) = explode('=', $line, 2);
      $name = trim($name);
      $value = trim($value);

      if (!empty($name)) {
        $_ENV[$name] = $value;
      }
    }
  }
}

/**
 * お問い合わせ内容
 */
if (!function_exists('set_mail_content')) {
  function set_mail_content($post): string
  {
    return <<<EOM
■お名前
{$post['name']} 様

■メールアドレス
{$post['email']}

■お問い合わせ内容
{$post['content']}
EOM;
  }
}

/**
 * サニタイズ処理
 */
if (!function_exists('sanitize')) {
  function sanitize($value): string
  {
    return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
  }
}
