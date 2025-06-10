<?php
session_start();
require_once 'config.php';
require_once 'Parsedown.php';

$parsedown = new Parsedown();
$parsedown->setSafeMode(true);

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Gestion des limites de génération pour les comptes gratuits
$plan = $_SESSION['plan'] ?? 'free';
$remaining = '∞';
$dayCount = 0;
$weekCount = 0;

if ($plan === 'free') {
    // Fiches créées aujourd'hui
    $dayStmt = $pdo->prepare('SELECT COUNT(*) FROM nfn_fiches WHERE user_id = ? AND created_at >= CURDATE()');
    $dayStmt->execute([$_SESSION['user_id']]);
    $dayCount = (int)$dayStmt->fetchColumn();

    // Fiches créées sur les 7 derniers jours
    $weekStmt = $pdo->prepare('SELECT COUNT(*) FROM nfn_fiches WHERE user_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)');
    $weekStmt->execute([$_SESSION['user_id']]);
    $weekCount = (int)$weekStmt->fetchColumn();

    $remaining = 3 - $weekCount;
    if ($remaining < 0) $remaining = 0;
}

$message = '';
$fiche = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['content'] ?? '');
    if ($input === '') {
        $message = "Veuillez saisir un sujet pour générer une fiche.";
    } else {
        if ($plan === 'free') {
            if ($dayCount >= 1) {
                $message = "Vous avez déjà généré une fiche aujourd\'hui. Réessayez demain.";
            } elseif ($weekCount >= 3) {
                $message = "Vous avez atteint la limite de 3 fiches cette semaine.";
            } else {
                $ficheData = generateFiche($input);
                if (!$ficheData || empty($ficheData['fiche']) || empty($ficheData['title']) || empty($ficheData['category'])) {
                    $message = "Erreur lors de la génération de la fiche.";
                } else {
                    $quiz = generateQuiz($ficheData['fiche']);

                    $stmt = $pdo->prepare('INSERT INTO nfn_fiches (user_id, input, titre, categorie, fiche_text, quiz, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
                    $stmt->execute([
                        $_SESSION['user_id'], $input, $ficheData['title'], $ficheData['category'], $ficheData['fiche'], json_encode($quiz)
                    ]);

                    $fiche = [
                        'title' => $ficheData['title'],
                        'category' => $ficheData['category'],
                        'text' => $ficheData['fiche'],
                        'quiz' => $quiz
                    ];
                    $weekCount++;
                    $dayCount++;
                    $remaining = max(3 - $weekCount, 0);
                }
            }
        } else {
            $ficheData = generateFiche($input);
            if (!$ficheData || empty($ficheData['fiche']) || empty($ficheData['title']) || empty($ficheData['category'])) {
                $message = "Erreur lors de la génération de la fiche.";
            } else {
                $quiz = generateQuiz($ficheData['fiche']);

                $stmt = $pdo->prepare('INSERT INTO nfn_fiches (user_id, input, titre, categorie, fiche_text, quiz, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
                $stmt->execute([
                    $_SESSION['user_id'], $input, $ficheData['title'], $ficheData['category'], $ficheData['fiche'], json_encode($quiz)
                ]);

                $fiche = [
                    'title' => $ficheData['title'],
                    'category' => $ficheData['category'],
                    'text' => $ficheData['fiche'],
                    'quiz' => $quiz
                ];
            }
        }
    }
}

function generateFiche(string $text): array|null {
    $prompt = <<<EOT
Tu es un expert en pédagogie et en écriture de contenus éducatifs. L'utilisateur te fournit le sujet suivant :

"$text"

Génère une fiche professionnelle ultra complète avec ces éléments :
1. Un **titre pertinent et vendeur** (en majuscules)
2. Une **catégorie** adaptée au sujet en **un seul mot** (ex: Cuisine, Physique, Productivité...)
3. Un **contenu pédagogique** complet sous forme de mini-ebook en Markdown, structuré en chapitres avec astuce, checklist, résumé, etc.

Réponds uniquement dans ce format :
---
TITLE: <titre en majuscule sans balise>
CATEGORY: <catégorie en un mot sans balise>
FICHE:
<fichier markdown sans balise code>
---
EOT;

    $data = [
        'model' => 'gpt-4o',
        'messages' => [[ 'role' => 'user', 'content' => $prompt ]]
    ];
    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . OPENAI_API_KEY
        ],
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode($data)
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    
    if (!$response) return null;
    $result = json_decode($response, true);
    $content = $result['choices'][0]['message']['content'] ?? '';

    if (preg_match('/TITLE: (.+?)\nCATEGORY: (.+?)\nFICHE:\n(.+)/s', $content, $matches)) {
        $cat = trim($matches[2]);
        $cat = preg_split('/\s+/', $cat)[0]; // un seul mot maximum
        return [
            'title' => trim($matches[1]),
            'category' => $cat,
            'fiche' => trim($matches[3])
        ];
    }

    return null;
}

function generateQuiz(string $ficheText): string {
    if (empty($ficheText)) return 'Impossible de générer le quiz. Le texte de la fiche est vide.';

    $prompt = <<<EOT
À partir du texte suivant, crée 3 questions de quiz à choix multiples (QCM) :

"$ficheText"

Chaque question doit proposer 1 bonne réponse et 3 mauvaises. Utilise ce format :

Question 1 :
a) mauvaise réponse
b) mauvaise réponse
c) bonne réponse
d) mauvaise réponse
Réponse correcte : c)
EOT;

    $data = [
        'model' => 'gpt-4o',
        'messages' => [[ 'role' => 'user', 'content' => $prompt ]]
    ];
    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . OPENAI_API_KEY
        ],
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode($data)
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($response, true);
    return $result['choices'][0]['message']['content'] ?? 'Quiz non généré.';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nouvelle fiche</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/index.css"> <!-- Ton style perso -->
</head>
<body>
<a href="#main-content" class="visually-hidden-focusable skip-link">Aller au contenu principal</a>

<!-- 🧭 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
      <img src="/assets/images/icon-512.png" alt="Fichesnum" class="me-2" style="height: 32px;"> Fichesnum
    </a>
    <div class="ms-auto">
      <a href="/dashboard.php" class="btn btn-sm btn-primary me-2">Mes fiches</a>
      <a href="/logout.php" class="btn btn-sm btn-outline-light">Déconnexion</a>
    </div>
  </div>
</nav>

<main id="main-content">

<!-- 📝 CONTENU PRINCIPAL -->
<div class="container py-5" style="max-width: 700px;">
  <h1 class="mb-4">Créer une fiche</h1>

  <?php if (!empty($message)): ?>
    <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <form method="post" id="fiche-form">
    <div class="mb-3">
      <label for="content" class="form-label">Sujet ou question</label>
      <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Générer la fiche</button>
    <div id="progress-container" class="progress mt-3 d-none" style="height:20px;">
      <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width:0%"></div>
    </div>
    <p class="mt-2 text-muted">Fiches restantes : <?= $remaining ?></p>
  </form>

  <?php if (!empty($fiche)): ?>
    <hr>
    <h3><?= htmlspecialchars($fiche['title']) ?> <small class="text-muted">(<?= htmlspecialchars($fiche['category']) ?>)</small></h3>

    <div class="ebook-content fiche-content">
      <?= $parsedown->text($fiche['text']) ?>
    </div>

    <button onclick="speechSynthesis.speak(new SpeechSynthesisUtterance(<?= json_encode($fiche['text']) ?>))" class="btn btn-secondary mt-3">🔊 Lire à voix haute</button>

    <h4 class="mt-4">Quiz</h4>
    <div class="quiz-content">
      <?= nl2br(htmlspecialchars($fiche['quiz'])) ?>
    </div>
  <?php endif; ?>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('fiche-form');
  const progressContainer = document.getElementById('progress-container');
  const progressBar = document.getElementById('progress-bar');

  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      progressContainer.classList.remove('d-none');
      progressBar.style.width = '0%';
      progressBar.setAttribute('aria-valuenow', '0');
      let width = 0;
      const interval = setInterval(() => {
        if (width < 95) {
          width += 5;
          progressBar.style.width = width + '%';
          progressBar.setAttribute('aria-valuenow', width.toString());
        }
      }, 500);

      const formData = new FormData(form);
      try {
        const response = await fetch('create_fiche.php', { method: 'POST', body: formData });
        const html = await response.text();
        clearInterval(interval);
        progressBar.style.width = '100%';
        progressBar.setAttribute('aria-valuenow', '100');
        document.open();
        document.write(html);
        document.close();
      } catch (err) {
        clearInterval(interval);
        progressBar.classList.add('bg-danger');
        progressBar.style.width = '100%';
        progressBar.setAttribute('aria-valuenow', '100');
      }
    });
  }
});
</script>
</body>
</html>
