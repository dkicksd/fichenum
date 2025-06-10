<?php
require_once 'config.php';

$message = 'Lien de vérification invalide.';

$token = $_GET['token'] ?? '';
if ($token) {
    $stmt = $pdo->prepare('SELECT id FROM nfn_users WHERE verify_token = ? AND verified = 0');
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    if ($user) {
        $stmt = $pdo->prepare('UPDATE nfn_users SET verified = 1, verify_token = NULL WHERE id = ?');
        $stmt->execute([$user['id']]);
        $message = 'Votre adresse email a été vérifiée avec succès.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vérification - Fichesnum</title>
  <meta name="theme-color" content="#1a3c2c">
  <link rel="icon" href="/assets/images/icon-512.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
<a href="#main-content" class="visually-hidden-focusable skip-link">Aller au contenu principal</a>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
      <img src="/assets/images/icon-512.png" alt="Fichesnum" class="logo me-2">Fichesnum
    </a>
  </div>
</nav>

<main id="main-content">
<div class="container py-5" style="max-width:600px;">
  <h1 class="mb-4">Vérification de l'email</h1>
  <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
  <a href="/login.php" class="btn btn-primary">Se connecter</a>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
