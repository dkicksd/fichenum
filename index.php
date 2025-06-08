<?php
session_start();
$username = $_SESSION["username"] ?? null;
$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fichesnum - IA mobile et durable</title>
  <meta name="theme-color" content="#1a3c2c">
  <link rel="icon" href="/assets/images/icon-512.png">
  <link rel="manifest" href="manifest.json">
  <link rel="apple-touch-icon" href="icons/icon-192.png">
  <meta name="apple-mobile-web-app-capable" content="yes">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/index.css">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
      <img src="/assets/images/icon-512.png" alt="Fichesnum" class="logo me-2">Fichesnum
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#features">Fonctionnalités</a></li>
        <li class="nav-item"><a class="nav-link" href="#explorer">Explorer</a></li>
        <li class="nav-item"><a class="nav-link" href="#eco">Écologie</a></li>
        <li class="nav-item"><a class="nav-link" href="#testimonials">Témoignages</a></li>
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

<section class="hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h1>Fiches IA. Mobile. Durable.</h1>
<?php if ($username): ?>
          <p class="lead">Bienvenue, <?= htmlspecialchars($username) ?>.</p>
<?php endif; ?>
        <p>Générez vos fiches pédagogiques où que vous soyez, sans gaspiller d'énergie ni compromettre la qualité.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
<?php if (!$username): ?>
          <a href="/register.php" class="btn btn-primary btn-lg px-4 py-2">
            <i class="fas fa-user-plus me-2"></i>Créer un compte
          </a>
<?php endif; ?>
          <a href="#features" class="btn btn-outline-light btn-lg px-4 py-2">
            <i class="fas fa-compass me-2"></i>Découvrir
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="features" class="py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">Fonctionnalités clés</h2>
      <p class="lead">Une IA au service de votre savoir, accessible partout</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-bolt"></i>
          </div>
          <h3 class="h5 fw-semibold mb-3">Génération IA instantanée</h3>
          <p class="mb-0">Transformez vos idées en fiches pédagogiques en quelques secondes avec notre IA intelligente et précise.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-users"></i>
          </div>
          <h3 class="h5 fw-semibold mb-3">Communauté mobile</h3>
          <p class="mb-0">Commentez, échangez et collaborez sur vos fiches préférées via notre réseau social d'apprentissage.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-cloud-download-alt"></i>
          </div>
          <h3 class="h5 fw-semibold mb-3">Accessible hors-ligne</h3>
          <p class="mb-0">Vos dernières fiches restent accessibles même sans connexion, pour réviser en toute situation.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="eco" class="eco-section py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <h2 class="section-title text-start">Pensé pour l'impact minimal</h2>
        <p class="mb-4">Notre engagement écologique se traduit dans chaque aspect de notre plateforme :</p>
        
        <div class="eco-badge">
          <div class="eco-icon">
            <i class="fas fa-leaf"></i>
          </div>
          <span>Code ultra-léger optimisé pour mobile</span>
        </div>
        
        <div class="eco-badge">
          <div class="eco-icon">
            <i class="fas fa-cloud"></i>
          </div>
          <span>Compression WebP et chargement différé</span>
        </div>
        
        <div class="eco-badge">
          <div class="eco-icon">
            <i class="fas fa-battery-three-quarters"></i>
          </div>
          <span>Service worker économe en énergie</span>
        </div>
        
        <div class="eco-badge">
          <div class="eco-icon">
            <i class="fas fa-server"></i>
          </div>
          <span>Hébergement vert certifié</span>
        </div>
        
        <div class="mt-4">
          <a href="/green.php" class="btn btn-outline-primary mt-3">
            <i class="fas fa-seedling me-2"></i>Découvrir notre charte éco-responsable
          </a>
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <div class="position-relative">
          <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary rounded-3" style="opacity: 0.1; transform: rotate(3deg);"></div>
          <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&h=400&q=80" alt="Éco-conception" class="img-fluid rounded-3 position-relative" style="max-width: 100%">
        </div>
      </div>
    </div>
  </div>
</section>

<section id="testimonials" class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">Ce que disent nos utilisateurs</h2>
      <p class="lead">Rejoignez les milliers d'apprenants qui utilisent Fichesnum</p>
    </div>
    
    <div class="row">
      <div class="col-md-4">
        <div class="testimonial">
          <div class="testimonial-text mb-3">
            "Fichesnum a révolutionné ma façon de réviser. Les fiches générées sont pertinentes et le design est tellement agréable à utiliser."
          </div>
          <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary me-3" style="width: 50px; height: 50px;"></div>
            <div>
              <strong>Marie L.</strong>
              <div class="text-muted">Étudiante en médecine</div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="testimonial">
          <div class="testimonial-text mb-3">
            "L'application mobile fonctionne parfaitement hors ligne. Je peux réviser dans le métro sans connexion, un vrai gain de temps."
          </div>
          <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary me-3" style="width: 50px; height: 50px;"></div>
            <div>
              <strong>Thomas P.</strong>
              <div class="text-muted">Prépa scientifique</div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="testimonial">
          <div class="testimonial-text mb-3">
            "En tant qu'enseignant, j'apprécie l'approche écologique. Une plateforme performante qui respecte l'environnement."
          </div>
          <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary me-3" style="width: 50px; height: 50px;"></div>
            <div>
              <strong>Sophie D.</strong>
              <div class="text-muted">Professeure de SVT</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="explorer" class="py-5">
  <div class="container text-center">
    <div class="mb-5">
      <h2 class="section-title">Rejoignez la communauté</h2>
      <p class="lead mb-4">Découvrez, partagez et likez les fiches d'autres apprenants partout dans le monde</p>
    </div>
    
    <div class="d-flex flex-wrap justify-content-center gap-3">
      <a href="/explore.php" class="btn btn-primary btn-lg px-4 py-2">
        <i class="fas fa-binoculars me-2"></i>Explorer les fiches
      </a>
<?php if (!$username): ?>
      <a href="/register.php" class="btn btn-outline-primary btn-lg px-4 py-2">
        <i class="fas fa-user-plus me-2"></i>Créer un compte gratuit
      </a>
<?php endif; ?>
    </div>
    
    <div class="mt-5">
      <div class="row g-4">
        <div class="col-md-3 col-6">
          <div class="bg-white rounded-3 p-3 shadow-sm">
            <div class="display-5 fw-bold text-primary">25k+</div>
            <div class="text-muted">Utilisateurs</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="bg-white rounded-3 p-3 shadow-sm">
            <div class="display-5 fw-bold text-primary">120k+</div>
            <div class="text-muted">Fiches créées</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="bg-white rounded-3 p-3 shadow-sm">
            <div class="display-5 fw-bold text-primary">98%</div>
            <div class="text-muted">Satisfaction</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="bg-white rounded-3 p-3 shadow-sm">
            <div class="display-5 fw-bold text-primary">60%</div>
            <div class="text-muted">Économie d'énergie</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-4 mb-lg-0">
        <h4 class="mb-3">
          <img src="/assets/images/icon-512.png" alt="Fichesnum" class="logo me-2">Fichesnum
        </h4>
        <p>Apprendre efficacement, partout, tout en respectant notre planète.</p>
        <div class="social-icons mt-3">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="col-lg-4 mb-4 mb-lg-0">
        <h5 class="mb-3">Liens rapides</h5>
        <div class="footer-links">
          <a href="#features">Fonctionnalités</a>
          <a href="#eco">Écologie</a>
          <a href="#explorer">Explorer</a>
          <a href="/privacy.php">Confidentialité</a>
          <a href="/legal.php">Mentions légales</a>
          <a href="/green.php">Charte éco</a>
        </div>
      </div>
      <div class="col-lg-4">
        <h5 class="mb-3">Newsletter</h5>
        <p>Restez informé des nouveautés et astuces d'apprentissage.</p>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Votre email">
          <button class="btn btn-primary" type="button">S'inscrire</button>
        </div>
      </div>
    </div>
    <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
    <div class="text-center pt-2">
      <p class="mb-0">© 2025 Fichesnum – Apprendre durablement. Tous droits réservés.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/index.js"></script>

</body>
</html>
