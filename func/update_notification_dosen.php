<?php
session_start();
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notification_id'])) {
    try {
        $stmt = $koneksi->prepare("UPDATE mail_notif_dosen SET is_read = 1 WHERE id = ?");
        $stmt->execute([$_POST['notification_id']]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
