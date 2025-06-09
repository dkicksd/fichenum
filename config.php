<?php
$host = '';
$db   = '';
$user = '';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// --- CLÉ API OPENAI ---
// Remplace "SK-XXXXX" par ta vraie clé.  
// Pour plus de sécurité, tu peux la stocker en variable d’environnement et utiliser getenv('OPENAI_API_KEY').
define('OPENAI_API_KEY', '');
define('MAX_DEMO_ATTEMPTS', 2);
?>
