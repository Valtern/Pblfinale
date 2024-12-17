<?php
session_start();
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $koneksi->prepare("INSERT INTO mail_notif_dosen (title, content, mail_type) VALUES (:title, :content, :mail_type)");
        
        $stmt->bindParam(':title', $_POST['title']);
        $stmt->bindParam(':content', $_POST['content']);
        $stmt->bindParam(':mail_type', $_POST['mail_type']);
        
        $stmt->execute();
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
