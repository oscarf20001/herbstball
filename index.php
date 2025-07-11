<?php

session_start();

// Logout abfangen
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Login-Versuch
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === 'admin' && $pass === 'herbstball25') {
        $_SESSION['logged_in'] = true;
    } else {
        $error = "Falscher Benutzername oder Passwort!";
    }
}

$basePath = $_SERVER['DOCUMENT_ROOT']; // z. B. /Users/oscarstreich/httpdocs

// Nur lokal bei Entwicklung anpassen:
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
    $basePath .= '/Metis/herbstball_25';
}

// Inkludiere das ausgelagerte Script
require_once($basePath . '/server/php/html-structure/extract_part-URL.php');

// Speichere die Ausgabe des Scripts in einer Variablen
$outputURLEnding = getOutputURLEnding();

// Mach die Variable global
$GLOBALS['outputURLEnding'] = $outputURLEnding;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herbstball des MCG 2025 - Powered by Metis</title>
    <link rel="stylesheet" href="client/styles/barStyles.css">
    <link rel="stylesheet" href="client/styles/form.css">
    <link rel="stylesheet" href="client/styles/inputFields.css">
    <script src="https://kit.fontawesome.com/b9446e8a7d.js" crossorigin="anonymous"></script>
    <script type="module" src="client/scripts/main.js"></script>
    <script type="module" src="client/scripts/finances.js"></script>
    <script type="module" src="client/scripts/dataTicket.js" defer></script>
    <script type="module" src="client/scripts/checks.js" defer></script>
    <script type="module" src="client/scripts/denied.js" defer></script>
    <!--<script src="client/scripts/analytics.js"></script>-->
    <script type="module" src="client/scripts/displayMessages.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
</head>
<body>

    <!-- DEFAULT TEMPLATE LADEN -->
    <?php
        require($basePath . '/server/php/html-structure/DEFAULT-HTML-TEMPLATE.php');
    ?>

</body>
</html>