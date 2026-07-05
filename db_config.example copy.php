<?php

/**
 * DB接続設定のサンプルです。
 *
 * さくらサーバーでは、このファイルを db_config.php にコピーし、
 * コントロールパネルで確認したDB情報に書き換えてください。
 *
 * db_config.php は .gitignore に入っているため、GitHubにはアップしません。
 */
return [
    'host' => 'mysql0000.db.sakura.ne.jp',
    'name' => 'your_account_maniarc_db',
    'user' => 'your_account',
    'pass' => 'your_database_password',
    'charset' => 'utf8mb4',
];
