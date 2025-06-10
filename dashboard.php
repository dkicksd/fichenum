<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT id, titre, categorie FROM nfn_fiches WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$_SESSION['user_id']]);
$fiches = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mes fiches - Fichesnum</title>
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
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/create_fiche.php">Nouvelle fiche</a></li>
      </ul>
      <div class="ms-lg-3 mt-3 mt-lg-0">
        <a href="/logout.php" class="btn btn-sm btn-outline-light">Déconnexion</a>
      </div>
    </div>
  </div>
</nav>

<main id="main-content">

<div class="container py-5">
  <h1 class="mb-4">Mes fiches</h1>
  <?php if (empty($fiches)): ?>
    <p>Aucune fiche créée pour le moment.</p>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($fiches as $fiche): ?>
        <div class="col-md-4">
          <div class="fiche-card position-relative h-100 p-3">
            <h5 class="fw-semibold mb-1"><?= htmlspecialchars($fiche['titre']) ?></h5>
            <p class="text-muted mb-2"><?= htmlspecialchars($fiche['categorie']) ?></p>
            <a href="/fiche.php?id=<?= $fiche['id'] ?>" class="stretched-link">Voir</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
