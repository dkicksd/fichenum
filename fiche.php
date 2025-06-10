<?php
session_start();
require_once 'config.php';
require_once 'Parsedown.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header('Location: /index.php');
    exit;
}

$parsedown = new Parsedown();
$parsedown->setSafeMode(true);

$stmt = $pdo->prepare('SELECT id, titre, categorie, fiche_text, views, likes, shares, downloads FROM nfn_fiches WHERE id = ?');
$stmt->execute([$id]);
$fiche = $stmt->fetch();
if (!$fiche) {
    http_response_code(404);
    echo 'Fiche introuvable';
    exit;
}

// Determine if the current user already liked this fiche
$userLiked = false;
if (isset($_SESSION['user_id'])) {
    $likeStmt = $pdo->prepare('SELECT 1 FROM nfn_fiche_likes WHERE user_id = ? AND fiche_id = ?');
    $likeStmt->execute([$_SESSION['user_id'], $id]);
    $userLiked = (bool)$likeStmt->fetchColumn();
}

$pdo->prepare('UPDATE nfn_fiches SET views = views + 1 WHERE id = ?')->execute([$id]);
$fiche['views']++;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($fiche['titre']) ?> - Fichesnum</title>
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
        <li class="nav-item"><a class="nav-link" href="/dashboard.php">Mes fiches</a></li>
      </ul>
      <div class="ms-lg-3 mt-3 mt-lg-0">
        <a href="/logout.php" class="btn btn-sm btn-outline-light">Déconnexion</a>
      </div>
    </div>
  </div>
</nav>

<main id="main-content">

<div class="container py-5" style="max-width:800px;">
  <h1 class="mb-2"><?= htmlspecialchars($fiche['titre']) ?></h1>
  <p class="text-muted">Catégorie : <?= htmlspecialchars($fiche['categorie']) ?></p>
  <div class="ebook-content fiche-content mb-4">
    <?= $parsedown->text($fiche['fiche_text']) ?>
  </div>

  <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
    <button id="like-btn" class="btn btn-sm <?= $userLiked ? 'btn-primary active' : 'btn-outline-primary' ?>" aria-label="J’aime"<?= $userLiked ? ' aria-pressed="true"' : '' ?>>
      <i class="fas fa-thumbs-up me-1" aria-hidden="true"></i><span id="like-count"><?= (int)$fiche['likes'] ?></span>
    </button>
    <button id="share-btn" class="btn btn-sm btn-outline-secondary" aria-label="Partager">
      <i class="fas fa-share me-1" aria-hidden="true"></i><span id="share-count"><?= (int)$fiche['shares'] ?></span>
    </button>
    <a id="download-btn" href="download_pdf.php?id=<?= $fiche['id'] ?>" class="btn btn-sm btn-outline-success">
      <i class="fas fa-file-pdf me-1" aria-hidden="true"></i>Télécharger (<span id="download-count"><?= (int)$fiche['downloads'] ?></span>)
    </a>
    <div class="ms-auto text-muted">
      <i class="fas fa-eye me-1" aria-hidden="true"></i><span id="view-count"><?= (int)$fiche['views'] ?></span>
    </div>
  </div>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const likeBtn = document.getElementById('like-btn');
likeBtn.addEventListener('click', () => {
  fetch('like.php?id=<?= $fiche['id'] ?>')
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        document.getElementById('like-count').textContent = data.likes;
        likeBtn.classList.remove('btn-outline-primary');
        likeBtn.classList.add('btn-primary','active');
        likeBtn.setAttribute('aria-pressed', 'true');
      }
    });
});

document.getElementById('share-btn').addEventListener('click', () => {
  const url = window.location.href;
  if (navigator.share) {
    navigator.share({ url })
      .then(() => {
        fetch('share.php?id=<?= $fiche['id'] ?>')
          .then(r => r.json())
          .then(data => { if(data.success) document.getElementById('share-count').textContent = data.shares; });
      })
      .catch(() => alert('Échec du partage.'));
  } else {
    navigator.clipboard.writeText(url)
      .then(() => {
        fetch('share.php?id=<?= $fiche['id'] ?>')
          .then(r => r.json())
          .then(data => { if(data.success) document.getElementById('share-count').textContent = data.shares; });
      })
      .catch(() => alert('Impossible de copier le lien.'));
  }
});
</script>
</body>
</html>
