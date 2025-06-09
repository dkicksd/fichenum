<?php
/* =====================================================
   EXPORT PDF E‑BOOK PREMIUM — TCPDF
   Style pro + footer « Généré par FichesNum.fr »
   ===================================================== */

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';
require_once 'Parsedown.php';
require_once __DIR__ . '/tcpdf/tcpdf.php';

use TCPDF;

/* ---------- Classe personnalisée : Header + Footer pro ---------- */
class EbookPDF extends TCPDF {
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('dejavusans', 'I', 9);
        $this->Cell(0, 10, 'Généré par FichesNum.fr — Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

/* ---------- Récupération de la fiche ---------- */
$id = (int)($_GET['id'] ?? 0);
if (!$id) exit('ID manquant');

$stmt = $pdo->prepare('SELECT titre, fiche_text FROM nfn_fiches WHERE id = ?');
$stmt->execute([$id]);
$data = $stmt->fetch();
if (!$data) exit('Fiche introuvable');

$pdo->prepare('UPDATE nfn_fiches SET downloads = downloads + 1 WHERE id = ?')->execute([$id]);

/* ---------- Markdown -> HTML ---------- */
$parsedown = new Parsedown();
$markdown  = $data['fiche_text'];
$htmlBody  = $parsedown->text($markdown);
$titre     = htmlspecialchars($data['titre']);

/* ---------- CSS e‑book premium ---------- */
$css = <<<CSS
<style>
  @page { margin: 30mm 25mm 35mm 25mm; }
  body  { font-family: DejaVu Sans, Helvetica, sans-serif; font-size: 11pt; line-height: 1.6; color:#222; }
  h1.title { font-size: 28pt; color:#046e3b; text-align:center; margin-bottom: 0; }
  h2      { font-size: 18pt; color:#046e3b; margin-top:24pt; }
  h3      { font-size: 14pt; color:#046e3b; margin-top:16pt; }
  p       { text-align: justify; margin: 8pt 0; }
  ul,ol   { margin-left: 18pt; }
  blockquote { border-left:4px solid #8dc63f; padding-left:10pt; color:#4e5d6c; background:#f7fcf6; }
  .checklist li { list-style:"✔ \0020" inside; margin-left: 0; }
  code { background:#f0f0f0; padding:2px 4px; border-radius:4px; }
  .cover { page-break-after: always; }
</style>
CSS;

/* ---------- Construction HTML complet (cover + content) ---------- */
$today = date('d/m/Y');
$cover = <<<HTML
<div class="cover">
  <h1 class="title">$titre</h1>
  <p style="text-align:center; font-size:14pt; margin-top:10pt;">Édition du $today</p>
  <p style="text-align:center; font-size:12pt; color:#555;">Une publication FichesNum</p>
</div>
HTML;

$html = "<!DOCTYPE html><html lang='fr'><head><meta charset='UTF-8'>".$css."</head><body>".$cover.$htmlBody."</body></html>";

/* ---------- Génération PDF ---------- */
$pdf = new EbookPDF('P', 'mm', 'A4', true, 'UTF-8');
$pdf->SetCreator('FichesNum');
$pdf->SetAuthor('FichesNum');
$pdf->SetTitle($titre);
$pdf->SetMargins(25, 30, 25);
$pdf->SetAutoPageBreak(TRUE, 30);

$pdf->AddPage();
/* Ajout du HTML (TCPDF handle CSS limité) */
$pdf->writeHTML($html, true, false, true, false, '');

/* ---------- Téléchargement ---------- */
$filename = preg_replace('/[^A-Za-z0-9_-]/','_', $titre).'.pdf';
$pdf->Output($filename, 'D');
exit;

