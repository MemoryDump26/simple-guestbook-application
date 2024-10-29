<?php
require 'db.php';

try {
    $stmt = $pdo->query('SELECT name, message, image, created_at FROM messages ORDER BY created_at DESC');
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($messages as &$msg) {
        $msg['image'] = base64_encode($msg['image']);
    }
    echo json_encode($messages);
} catch (PDOException $e) {
    echo json_encode([]);
}
?>
