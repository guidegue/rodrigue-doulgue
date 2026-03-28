<?php
require_once 'includes/db.php';
$db = initDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $db->prepare("INSERT INTO visiteurs (pays, ville, page) VALUES (:pays, :ville, :page)");
    $stmt->bindValue(':pays', $data['pays'] ?? 'Inconnu', SQLITE3_TEXT);
    $stmt->bindValue(':ville', $data['ville'] ?? 'Inconnu', SQLITE3_TEXT);
    $stmt->bindValue(':page', $data['page'] ?? '/', SQLITE3_TEXT);
    $stmt->execute();
    echo json_encode(['status' => 'ok']);
}
?>
