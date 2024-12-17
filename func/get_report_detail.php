<?php
session_start();
require_once '../connection.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

try {
    // Use CTE to handle data type conversion safely
    $query = "
        WITH ReportData AS (
            SELECT 
                r.*,
                h.status,
                CASE 
                    WHEN ISNUMERIC(h.bobot) = 1 THEN CAST(h.bobot AS FLOAT)
                    ELSE NULL 
                END as bobot
            FROM report r
            INNER JOIN history h ON h.fk_report = r.id
            WHERE r.id = :report_id
        )
        SELECT * FROM ReportData";
    
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
