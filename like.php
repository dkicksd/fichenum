<?php
require_once 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
header('Content-Type: application/json');
if (!$id) {
    echo json_encode(['success' => false]);
    exit;
}
$pdo->prepare('UPDATE nfn_fiches SET likes = likes + 1 WHERE id = ?')->execute([$id]);
$stmt = $pdo->prepare('SELECT likes FROM nfn_fiches WHERE id = ?');
$stmt->execute([$id]);
$likes = (int)$stmt->fetchColumn();
echo json_encode(['success' => true, 'likes' => $likes]);
