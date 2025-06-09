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
        $message = "Veuillez saisir un texte ou un lien.";
    } else {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM nfn_fiches WHERE user_id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $count = (int)$stmt->fetchColumn();
        if ($count >= MAX_DEMO_ATTEMPTS) {
            $message = "Limite d'essai gratuite atteinte.";
        } else {
            $ficheText = generateFiche($input);
            if ($ficheText === false) {
                $message = "Erreur lors de la génération.";
            } else {
                $quiz = generateQuiz($ficheText);
                $audioPath = generateSpeech($ficheText);
                $stmt = $pdo->prepare('INSERT INTO nfn_fiches (user_id, input, fiche_text, quiz, audio_path, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
                $stmt->execute([$_SESSION['user_id'], $input, $ficheText, json_encode($quiz), $audioPath]);
                $fiche = ['text' => $ficheText, 'quiz' => $quiz, 'audio' => $audioPath];
            }
        }
    }
}

function generateFiche(string $text) {
    $prompt = "Résume le contenu suivant en une fiche pédagogique concise:\n" . $text;
    $data = [
        'model' => 'gpt-3.5-turbo',
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
    if ($response === false) return false;
    $result = json_decode($response, true);
    return $result['choices'][0]['message']['content'] ?? false;
}

function generateQuiz(string $ficheText) {
    $prompt = "Crée 3 questions QCM avec 4 propositions chacune sur la base du texte suivant:\n" . $ficheText;
    $data = [
        'model' => 'gpt-3.5-turbo',
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
    if ($response === false) return '';
    $result = json_decode($response, true);
    return $result['choices'][0]['message']['content'] ?? '';
}

function generateSpeech(string $ficheText) {
    if (!OPENAI_API_KEY) return '';
    $data = [
        'model' => 'tts-1',
        'input' => $ficheText,
        'voice' => 'alloy',
        'response_format' => 'mp3'
    ];
    $ch = curl_init('https://api.openai.com/v1/audio/speech');
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . OPENAI_API_KEY
        ],
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode($data)
    ]);
    $audio = curl_exec($ch);
    curl_close($ch);
    if ($audio === false) return '';
    if (!is_dir('audio')) {
        mkdir('audio', 0777, true);
    }
    $file = 'audio/' . uniqid('fiche_') . '.mp3';
    file_put_contents($file, $audio);
    return $file;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nouvelle fiche</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
      <img src="/assets/images/icon-512.png" alt="Fichesnum" class="logo me-2">Fichesnum
    </a>
    <div class="ms-auto">
      <a href="/logout.php" class="btn btn-sm btn-outline-light">Déconnexion</a>
    </div>
  </div>
</nav>
<div class="container py-5" style="max-width:700px;">
  <h1 class="mb-4">Créer une fiche</h1>
  <?php if ($message): ?>
    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <label for="content" class="form-label">Texte ou lien</label>
      <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Générer</button>
  </form>
  <?php if ($fiche): ?>
    <hr>
    <h3>Fiche générée</h3>
    <pre><?= htmlspecialchars($fiche['text']) ?></pre>
    <?php if ($fiche['audio']): ?>
      <audio controls src="<?= htmlspecialchars($fiche['audio']) ?>"></audio>
    <?php endif; ?>
    <h3 class="mt-4">Quiz</h3>
    <pre><?= htmlspecialchars($fiche['quiz']) ?></pre>
  <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
