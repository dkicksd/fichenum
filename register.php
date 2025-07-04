<?php
session_start();
require_once 'config.php';

$message = '';
$preselectPlan = '';
if (isset($_GET['plan']) && in_array($_GET['plan'], ['free', 'premium'], true)) {
    $preselectPlan = $_GET['plan'];
}

if ($preselectPlan === 'premium' && isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("UPDATE nfn_users SET plan = 'premium' WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $_SESSION['plan'] = 'premium';
    $message = "Votre compte a été mis à niveau vers le plan Premium.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';
    $plan     = $_POST['plan'] ?? 'free';
    $plan     = ($plan === 'premium') ? 'premium' : 'free';

    if (!$email || !$username || !$password || !$confirm) {
        $message = "Tous les champs sont obligatoires.";
    } elseif ($password !== $confirm) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        $stmt = $pdo->prepare('SELECT id FROM nfn_users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $message = "Cette adresse email est déjà enregistrée.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(16));

            $role = 'user';
            $stmt = $pdo->prepare('INSERT INTO nfn_users (email, password, username, verify_token, verified, role, plan) VALUES (?, ?, ?, ?, 0, ?, ?)');
            $stmt->execute([$email, $hash, $username, $token, $role, $plan]);

            $domain = $_SERVER['HTTP_HOST'];
            $verifyLink = 'http://' . $domain . '/verify.php?token=' . $token;
            $subject = 'Confirmez votre inscription';

            $body = '<html><body>';
            $body .= '<p>Bienvenue sur FichesNum !</p>';
            $body .= '<p>Cliquez sur le bouton ci-dessous pour vérifier votre adresse email :</p>';
            $body .= '<p style="text-align:center; margin:20px 0;">'
                   . '<a href="' . $verifyLink . '" '
                   . 'style="background:#00b874;color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px;"'
                   . '>Vérifier mon adresse</a></p>';
            $body .= '</body></html>';

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: FichesNum <no-reply@" . $domain . ">\r\n";

            @mail($email, $subject, $body, $headers);

            $message = "Inscription réussie. Vérifiez vos emails pour confirmer votre compte.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscription - Fichesnum</title>
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
        <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>
      </ul>
      <div class="ms-lg-3 mt-3 mt-lg-0">
        <a href="/login.php" class="btn btn-sm btn-outline-light">Connexion</a>
      </div>
    </div>
  </div>
</nav>

<main id="main-content">

<div class="container py-5" style="max-width:600px;">
  <h1 class="mb-4">Créer un compte</h1>
  <?php if ($message): ?>
    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

<div class="row g-4 mb-4">
  <!-- Carte FREE -->
  <div class="col-md-6">
    <div class="plan-card card h-100 text-center border-primary border-2" data-plan="free" style="cursor:pointer;">
      <div class="card-body d-flex flex-column">
        <div class="mb-3 text-primary">
          <i class="fas fa-gift fa-3x"></i>
        </div>
        <h2 class="card-title h5">Formule gratuite</h2>
        <p class="plan-price h3 fw-bold mb-3">0&nbsp;&euro;</p>
        <ul class="list-group list-group-flush mb-4">
          <li class="list-group-item">Accès aux fiches gratuites</li>
          <li class="list-group-item">Création de compte</li>
          <li class="list-group-item">Historique des achats</li>
        </ul>
        <div class="mt-auto">
          <button class="btn btn-outline-primary w-100">Choisir ce plan</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Carte PREMIUM -->
  <div class="col-md-6">
    <div class="plan-card card h-100 text-center border-warning border-2" data-plan="premium" style="cursor:pointer;">
      <div class="card-body d-flex flex-column">
        <div class="mb-3 text-warning">
          <i class="fas fa-crown fa-3x"></i>
        </div>
        <h2 class="card-title h5">Formule Premium</h2>
        <p class="plan-price h3 fw-bold mb-3">4,90&nbsp;&euro;</p>
        <ul class="list-group list-group-flush mb-4">
          <li class="list-group-item">Toutes les fiches illimitées</li>
          <li class="list-group-item">Options de génération avancée</li>
          <li class="list-group-item">Support prioritaire</li>
        </ul>
        <div class="mt-auto">
          <button class="btn btn-warning w-100">Choisir ce plan</button>
        </div>
      </div>
    </div>
  </div>
</div>


  <div id="register-form" style="display:none">
  <form method="post" novalidate>
    <input type="hidden" name="plan" id="plan-input" value="">
    <div class="mb-3">
      <label for="username" class="form-label">Pseudo</label>
      <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Adresse email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3 position-relative">
      <label for="password" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" id="password" name="password" required>
      <span class="position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePassword('password')" aria-label="Afficher le mot de passe">
        <i class="fas fa-eye-slash" id="eye-password" aria-hidden="true"></i>
      </span>
    </div>
    <div class="mb-3 position-relative">
      <label for="confirm" class="form-label">Confirmer le mot de passe</label>
      <input type="password" class="form-control" id="confirm" name="confirm" required>
      <span class="position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePassword('confirm')" aria-label="Afficher le mot de passe">
        <i class="fas fa-eye-slash" id="eye-confirm" aria-hidden="true"></i>
      </span>
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
  </form>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(fieldId) {
  const field = document.getElementById(fieldId);
  const eye = document.getElementById('eye-' + fieldId);
  const toggle = eye.parentElement;
  if (field.type === 'password') {
    field.type = 'text';
    eye.classList.remove('fa-eye-slash');
    eye.classList.add('fa-eye');
    toggle.setAttribute('aria-label', 'Masquer le mot de passe');
  } else {
    field.type = 'password';
    eye.classList.remove('fa-eye');
    eye.classList.add('fa-eye-slash');
    toggle.setAttribute('aria-label', 'Afficher le mot de passe');
  }
}

// Plan potentially chosen via URL parameter
const preselectPlan = <?= json_encode($preselectPlan) ?>;
document.querySelectorAll('.plan-card').forEach(card => {
  card.addEventListener('click', () => {
    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    document.getElementById('plan-input').value = card.dataset.plan;
    const container = document.getElementById('register-form');
    container.style.display = 'block';
    container.scrollIntoView({behavior: 'smooth'});
  });
});

if (preselectPlan) {
  const card = document.querySelector(`.plan-card[data-plan="${preselectPlan}"]`);
  if (card) {
    card.classList.add('active');
    document.getElementById('plan-input').value = preselectPlan;
    const container = document.getElementById('register-form');
    container.style.display = 'block';
  }
}
</script>
</body>
</html>
