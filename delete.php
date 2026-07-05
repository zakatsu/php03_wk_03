<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: read.php');
    exit;
}

$requestedId = (int) ($_POST['id'] ?? 0);
$ownerToken = get_owner_token();

if ($requestedId > 0) {
    try {
        $pdo = db_connect();
        $stmt = $pdo->prepare('DELETE FROM passions
                               WHERE id = :id
                                 AND owner_token = :owner_token');
        $stmt->bindValue(':id', $requestedId, PDO::PARAM_INT);
        $stmt->bindValue(':owner_token', $ownerToken, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header('Location: read.php?deleted=1');
            exit;
        }
    } catch (PDOException $e) {
        header('Location: read.php?delete_error=1');
        exit;
    }
}

header('Location: read.php?delete_error=1');
exit;
