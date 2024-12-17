<?php
session_start();
require_once '../connection.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

try {
    $query = "
        WITH UserReports AS (
            SELECT 
                r.*,
                m.nama_lengkap,
                COUNT(*) OVER (PARTITION BY r.nama_pelanggaran) as violation_count,
                ROW_NUMBER() OVER (PARTITION BY r.name ORDER BY r.waktu DESC) as report_rank
            FROM report r
            JOIN mahasiswa m ON r.name = m.nama_lengkap
            WHERE m.id = :user_id
        ),
        ViolationStats AS (
            SELECT 
                nama_pelanggaran,
                COUNT(*) as total_occurrences,
                MAX(waktu) as last_occurrence
            FROM report
            GROUP BY nama_pelanggaran
        )
        SELECT 
            ur.*,
            vs.total_occurrences,
            vs.last_occurrence,
            (SELECT COUNT(*) FROM report WHERE waktu > ur.waktu) as newer_reports
        FROM UserReports ur
        LEFT JOIN ViolationStats vs ON ur.nama_pelanggaran = vs.nama_pelanggaran
        WHERE ur.id = :report_id";
    
    $stmt = $koneksi->prepare($query);
    $stmt->bindParam(':report_id', $_GET['id']);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode([
            'success' => true,
            'data' => $row
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Report not found'
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
