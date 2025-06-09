<?php
require_once 'config.php';
require_once 'Parsedown.php';
require_once __DIR__ . '/dompdf-master/autoload.inc.php';
use Dompdf\Dompdf;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    exit('ID manquant');
}

$stmt = $pdo->prepare('SELECT titre, fiche_text FROM nfn_fiches WHERE id = ?');
$stmt->execute([$id]);
$data = $stmt->fetch();
if (!$data) {
    exit('Fiche introuvable');
}
$pdo->prepare('UPDATE nfn_fiches SET downloads = downloads + 1 WHERE id = ?')->execute([$id]);

$parsedown = new Parsedown();
$parsedown->setSafeMode(true);
$html = $parsedown->text($data['fiche_text']);
$title = $data['titre'];

$dompdf = new Dompdf();
$dompdf->loadHtml('<h1>'.htmlspecialchars($title).'</h1>'.$html, 'UTF-8');
$dompdf->setPaper('A4');
$dompdf->render();
$filename = preg_replace("/[^a-zA-Z0-9_-]/", "_", $title) . '.pdf';
$dompdf->stream($filename, ['Attachment' => true]);
exit;
