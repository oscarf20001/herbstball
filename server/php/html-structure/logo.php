<?php
$baseURL = ''; // Standard: Root-Verzeichnis des Webservers

// Nur lokal bei Entwicklung anpassen:
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
    $baseURL = '/Metis/herbstball_25';
}

echo '<img src="' . $baseURL . '/client/images/Metis.svg" alt="Metis-Ticketsystem Logo">';
?>