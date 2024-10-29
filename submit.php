<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $message = $_POST['message'];
    $image = $_FILES['image'];

    if (!empty($name) && !empty($message) && !empty($image)) {
        try {
            $blob = file_get_contents($image['tmp_name']);
            $stmt = $pdo->prepare('INSERT INTO messages (name, message, image) VALUES (:name, :message, :image)');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':image', $blob, PDO::PARAM_LOB);
            $stmt->execute();
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
    }
}
?>
