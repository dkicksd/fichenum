<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

$message = '';
$fiche = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['content'] ?? '');
    if ($input === '') {
        $message = "Veuillez saisir un sujet pour générer une fiche.";
    } else {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM nfn_fiches WHERE user_id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $count = (int)$stmt->fetchColumn();

        if ($count >= MAX_DEMO_ATTEMPTS) {
            $message = "Limite d'essai gratuite atteinte.";
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
2. Une **catégorie** adaptée au sujet (ex: Cuisine, Physique, Productivité...)
3. Un **contenu pédagogique** complet sous forme de mini-ebook en Markdown, structuré en chapitres avec astuce, checklist, résumé, etc.

Réponds uniquement dans ce format :
---
TITLE: <titre en majuscule sans balise>
CATEGORY: <catégorie sans balise>
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
        return [
            'title' => trim($matches[1]),
            'category' => trim($matches[2]),
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

<!-- 🧭 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
      <img src="/assets/images/icon-512.png" alt="Fichesnum" class="me-2" style="height: 32px;"> Fichesnum
    </a>
    <div class="ms-auto">
      <a href="/logout.php" class="btn btn-sm btn-outline-light">Déconnexion</a>
    </div>
  </div>
</nav>

<!-- 📝 CONTENU PRINCIPAL -->
<div class="container py-5" style="max-width: 700px;">
  <h1 class="mb-4">Créer une fiche</h1>

  <?php if (!empty($message)): ?>
    <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label for="content" class="form-label">Sujet ou question</label>
      <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Générer la fiche</button>
  </form>

  <?php if (!empty($fiche)): ?>
    <hr>
    <h3><?= htmlspecialchars($fiche['title']) ?> <small class="text-muted">(<?= htmlspecialchars($fiche['category']) ?>)</small></h3>

    <div class="bg-light border rounded p-3" style="white-space: pre-wrap; font-family: monospace;">
      <?= nl2br(htmlspecialchars($fiche['text'])) ?>
    </div>

    <button onclick="speechSynthesis.speak(new SpeechSynthesisUtterance(<?= json_encode($fiche['text']) ?>))" class="btn btn-secondary mt-3">🔊 Lire à voix haute</button>

    <h4 class="mt-4">Quiz</h4>
    <div class="bg-light border rounded p-3" style="white-space: pre-wrap;">
      <?= nl2br(htmlspecialchars($fiche['quiz'])) ?>
    </div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
