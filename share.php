<?php
require_once 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
header('Content-Type: application/json');
if (!$id) {
    echo json_encode(['success' => false]);
    exit;
}
$pdo->prepare('UPDATE nfn_fiches SET shares = shares + 1 WHERE id = ?')->execute([$id]);
$stmt = $pdo->prepare('SELECT shares FROM nfn_fiches WHERE id = ?');
$stmt->execute([$id]);
$shares = (int)$stmt->fetchColumn();
echo json_encode(['success' => true, 'shares' => $shares]);
