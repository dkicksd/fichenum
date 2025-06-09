<?php
session_start();
require_once 'config.php';

// Récupérer toutes les fiches et les catégories distinctes
$stmt = $pdo->query('SELECT id, titre, categorie FROM nfn_fiches ORDER BY created_at ASC');
$fiches = $stmt->fetchAll();
$catsStmt = $pdo->query('SELECT DISTINCT categorie FROM nfn_fiches ORDER BY categorie');
$categories = $catsStmt->fetchAll(PDO::FETCH_COLUMN);

$username = $_SESSION['username'] ?? null;
$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bibliothèque - Fichesnum</title>
  <meta name="theme-color" content="#1a3c2c">
  <link rel="icon" href="/assets/images/icon-512.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
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
        <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>
        <?php if ($username): ?>
        <li class="nav-item"><a class="nav-link" href="/dashboard.php">Mes fiches</a></li>
        <?php endif; ?>
      </ul>
      <div class="ms-lg-3 mt-3 mt-lg-0">
        <?php if ($username): ?>
          <span class="navbar-text me-3">Bonjour, <?= htmlspecialchars($username) ?></span>
          <?php if ($role === 'admin'): ?>
            <a href="/admin/dashboard.php" class="btn btn-sm btn-warning me-2">Dashboard</a>
          <?php endif; ?>
          <a href="/logout.php" class="btn btn-sm btn-outline-light">Déconnexion</a>
        <?php else: ?>
          <a href="/login.php" class="btn btn-sm btn-outline-light">Connexion</a>
          <a href="/register.php" class="btn btn-sm btn-primary ms-2">Inscription</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<div class="container py-4">
  <h1 class="mb-4">Bibliothèque</h1>
  <div class="mb-3">
    <input type="text" id="search" class="form-control" placeholder="Rechercher...">
  </div>
  <div class="overflow-auto d-flex flex-nowrap mb-4 gap-2">
    <button class="btn btn-sm btn-primary category-btn" data-category="all">Toutes</button>
    <?php foreach ($categories as $cat): ?>
      <button class="btn btn-sm btn-outline-primary category-btn" data-category="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></button>
    <?php endforeach; ?>
  </div>
  <?php if (empty($fiches)): ?>
    <p>Aucune fiche disponible.</p>
  <?php else: ?>
    <div class="row g-3">
      <?php foreach ($fiches as $fiche): ?>
        <div class="col-md-4">
          <div class="fiche-card position-relative h-100 p-3" data-title="<?= strtolower(htmlspecialchars($fiche['titre'])) ?>" data-category="<?= htmlspecialchars($fiche['categorie']) ?>">
            <h5 class="fw-semibold mb-1"><?= htmlspecialchars($fiche['titre']) ?></h5>
            <p class="text-muted mb-2"><?= htmlspecialchars($fiche['categorie']) ?></p>
            <a href="/fiche.php?id=<?= $fiche['id'] ?>" class="stretched-link"></a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let active = 'all';
const search = document.getElementById('search');
const cards = document.querySelectorAll('.fiche-card');
function filter() {
    const q = search.value.toLowerCase();
    cards.forEach(c => {
        const matchCat = (active === 'all' || c.dataset.category === active);
        const matchTxt = c.dataset.title.includes(q) || c.dataset.category.toLowerCase().includes(q);
        c.parentElement.classList.toggle('d-none', !(matchCat && matchTxt));
    });
}
search.addEventListener('input', filter);
document.querySelectorAll('.category-btn').forEach(b => {
    b.addEventListener('click', () => {
        active = b.dataset.category;
        document.querySelectorAll('.category-btn').forEach(btn => btn.classList.toggle('btn-primary', btn === b));
        document.querySelectorAll('.category-btn').forEach(btn => btn.classList.toggle('btn-outline-primary', btn !== b));
        filter();
    });
});
</script>
</body>
</html>
