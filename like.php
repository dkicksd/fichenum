<?php
session_start();
require_once 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
header('Content-Type: application/json');

if (!$id) {
    echo json_encode(['success' => false]);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'not_logged_in']);
    exit;
}

$userId = (int)$_SESSION['user_id'];

// Check if the user already liked this fiche
$stmt = $pdo->prepare('SELECT 1 FROM nfn_fiche_likes WHERE user_id = ? AND fiche_id = ?');
$stmt->execute([$userId, $id]);
if ($stmt->fetch()) {
    $stmt = $pdo->prepare('SELECT likes FROM nfn_fiches WHERE id = ?');
    $stmt->execute([$id]);
    $likes = (int)$stmt->fetchColumn();
    echo json_encode(['success' => true, 'likes' => $likes]);
    exit;
}

// Record the like and increment the count
$pdo->prepare('INSERT INTO nfn_fiche_likes (user_id, fiche_id) VALUES (?, ?)')
    ->execute([$userId, $id]);
$pdo->prepare('UPDATE nfn_fiches SET likes = likes + 1 WHERE id = ?')
    ->execute([$id]);
$stmt = $pdo->prepare('SELECT likes FROM nfn_fiches WHERE id = ?');
$stmt->execute([$id]);
$likes = (int)$stmt->fetchColumn();
echo json_encode(['success' => true, 'likes' => $likes]);
