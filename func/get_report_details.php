<?php
session_start();
require_once '../connection.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

try {
    $query = "
        WITH ReportDetail AS (
            SELECT 
                r.*,
                LAG(id) OVER (ORDER BY waktu) as previous_report_id,
                LEAD(id) OVER (ORDER BY waktu) as next_report_id
            FROM vw_report_details r
            WHERE r.id = :report_id
        )
        SELECT 
            rd.*,
            (SELECT COUNT(*) 
             FROM report 
             WHERE nama_pelanggaran = rd.nama_pelanggaran) as similar_violations_count
        FROM ReportDetail rd";
    
    $stmt = $koneksi->prepare($query);
    $stmt->bindParam(':report_id', $_GET['id']);
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
