<?php
// translations.txt fájl beolvasása
$file = 'translations.txt';
if (!file_exists($file)) {
    die("A fájl nem található: $file");
}
$content = file_get_contents($file);

// Multibyte ucfirst-függvény
function mb_ucfirst(string $str, string $encoding = 'UTF-8'): string {
    $str = mb_strtolower($str, $encoding);
    $firstChar = mb_substr($str, 0, 1, $encoding);
    $then = mb_substr($str, 1, null, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}

// Regex és callback, ami minden 'key' => 'value' sort megkap
$pattern = "/'([^']+)'\\s*=>\\s*'([^']+)',?/u";
$modified = preg_replace_callback($pattern, function($m) {
    list(, $key, $val) = $m;
    // először kisbetűsre, majd csak az első karaktert tesszük nagyra multibyte formában
    $key = mb_ucfirst($key, 'UTF-8');
    $val = mb_ucfirst($val, 'UTF-8');
    return "'{$key}' => '{$val}',";
}, $content);

// Eredmény visszaírása a fájlba
file_put_contents($file, $modified);

?>
