<?php

/**
 * データベース接続
 *
 * ローカルXAMPPでは下の初期値を使用します。
 * さくらサーバーでは db_config.php を作成し、接続情報を上書きしてください。
 * db_config.php は .gitignore に入れているため、GitHubにはアップしません。
 */
$dbConfig = [
    'host' => 'localhost',
    'name' => 'maniarc_db',
    'user' => 'root',
    'pass' => '',
    'charset' => 'utf8mb4',
];

$localConfigPath = __DIR__ . '/db_config.php';
if (is_readable($localConfigPath)) {
    $serverConfig = require $localConfigPath;
    if (is_array($serverConfig)) {
        $dbConfig = array_merge($dbConfig, $serverConfig);
    }
}

function db_connect(): PDO
{
    global $dbConfig;

    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $dbConfig['host'],
        $dbConfig['name'],
        $dbConfig['charset']
    );

    try {
        return new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $e) {
        exit('DB接続エラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
    }
}
