<?php
session_start();
require_once '../connection.php';

try {
    $type = $_GET['type'];
    
    if ($type === 'dosen') {
        $query = "SELECT id, nama_lengkap FROM dosen ORDER BY nama_lengkap ASC";
    } else {
        $query = "SELECT id, nama_lengkap FROM mahasiswa ORDER BY nama_lengkap ASC";
    }
    
    $stmt = $koneksi->prepare($query);
    $stmt->execute();
    $recipients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($recipients);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
