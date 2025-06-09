<?php
require_once 'config.php';
require_once 'Parsedown.php';

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
$text = strip_tags($parsedown->text($data['fiche_text']));
$title = $data['titre'];

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="'.preg_replace("/[^a-zA-Z0-9_-]/", "_", $title).'.pdf"');

echo generateSimplePdf($title, $text);
exit;

function pdfEscape($string) {
    return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $string);
}

function generateSimplePdf($title, $text) {
    $eol = "\n";
    $parts = [];
    $parts[1] = "<< /Type /Catalog /Pages 2 0 R >>";
    $parts[2] = "<< /Type /Pages /Kids [3 0 R] /Count 1 >>";
    $parts[3] = "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>";

    // Convert title to a PDF-friendly encoding
    $title = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $title);

    $content = 'BT /F1 16 Tf 50 750 Td (' . pdfEscape($title) . ') Tj';
    $y = 720;
    foreach (explode("\n", $text) as $line) {
        $line = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', trim($line));
        $content .= " 1 0 0 1 50 $y Tm(" . pdfEscape($line) . ") Tj";
        $y -= 14;
    }
    $content .= ' ET';
    $parts[4] = "<< /Length " . strlen($content) . " >>" . $eol . "stream" . $eol . $content . $eol . "endstream";
    $parts[5] = "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>";

    $pdf = "%PDF-1.4$eol";
    $offsets = [];
    $pos = strlen($pdf);
    for ($i = 1; $i <= 5; $i++) {
        $offsets[$i] = $pos;
        $pdf .= "$i 0 obj$eol" . $parts[$i] . "$eol" . "endobj$eol";
        $pos = strlen($pdf);
    }
    $xref = $pos;
    $pdf .= "xref$eol0 6$eol0000000000 65535 f $eol";
    for ($i = 1; $i <= 5; $i++) {
        $pdf .= sprintf('%010d 00000 n ', $offsets[$i]) . $eol;
    }
    $pdf .= "trailer$eol<< /Size 6 /Root 1 0 R >>$eolstartxref$eol$xref$eol%%EOF";
    return $pdf;
}
