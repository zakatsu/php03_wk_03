-- ローカルXAMPP用:
-- phpMyAdminでDBを選択していない場合は、下の2行を使ってDBを作成・選択してください。
CREATE DATABASE IF NOT EXISTS maniarc_db
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE maniarc_db;

-- さくらサーバー用:
-- さくらのphpMyAdminでは、先に作成済みのDBを選択してから、
-- 下の CREATE TABLE 文だけを実行しても問題ありません。

CREATE TABLE IF NOT EXISTS passions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  owner_token VARCHAR(64) DEFAULT NULL,
  category VARCHAR(50) NOT NULL,
  target_name VARCHAR(100) NOT NULL,
  start_year INT NOT NULL,
  years INT NOT NULL,
  love_types TEXT NOT NULL,
  comment TEXT,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL DEFAULT NULL,
  INDEX idx_owner_token (owner_token)
);
