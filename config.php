<?php
// config.php - universell nutzbar

// Document Root (Server-Dateisystem-Pfad ohne Slash am Ende)
$docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

// Prüfen, ob localhost
$isLocalhost = strpos($_SERVER['HTTP_HOST'], 'localhost') !== false
    || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false;

// Absolute Pfad (für require etc.)
if ($isLocalhost) {
    // Prüfen, ob der Dokumentenstamm schon das Projektverzeichnis ist
    // Beispiel: Wenn du im Verzeichnis herbstball_25 startest, ist es enthalten
    if (str_ends_with($docRoot, 'herbstball_25')) {
        define('BASE_PATH', $docRoot);
        define('BASE_URL', ''); // Webroot ist herbstball_25
    } else {
        // Wenn du lokal in einem höheren Verzeichnis bist, z.B. localhost/Metis/herbstball_25
        define('BASE_PATH', $docRoot . '/Metis/herbstball_25');
        define('BASE_URL', '/Metis/herbstball_25');
    }
} else {
    // Produktion: Pfad ist DocumentRoot, URL-Basis leer (wenn im Root deployt)
    define('BASE_PATH', $docRoot);
    define('BASE_URL', ''); 
}

// Falls PHP < 8, str_ends_with nicht verfügbar, dann hier Polyfill:
if (!function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle) {
        return substr($haystack, -strlen($needle)) === $needle;
    }
}