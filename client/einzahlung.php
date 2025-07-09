<?php
session_start();

require('../server/php/html-structure/extract_part-URL.php');

// Logout abfangen
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: einzahlung.php");
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
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herbstball des MCG 2025 - Powered by Metis</title>
    <link rel="stylesheet" href="styles/barStyles.css">
    <link rel="stylesheet" href="styles/einzahlungen.css">
    <link rel="stylesheet" href="styles/inputFields.css">
    <link rel="stylesheet" href="styles/tables.css">
    <script src="https://kit.fontawesome.com/b9446e8a7d.js" crossorigin="anonymous"></script>
    <!--<script type="module" src="client/scripts/main.js"></script>
    <script type="module" src="client/scripts/finances.js"></script>
    <script type="module" src="client/scripts/dataTicket.js" defer></script>
    <script type="module" src="client/scripts/checks.js" defer></script>
    <script type="module" src="client/scripts/displayMessages.js"></script>-->
    <script type="module" src="scripts/denied.js" defer></script>
    <script type="module" src="scripts/searchEmails.js" defer></script>
    <script type="module" src="scripts/einzahlung.js" defer></script>
</head>
<body>

    <!-- div für das Displayen der Nachrichten aus js -->
    <div id="display">
        <?php
            require('../server/php/html-structure/displayMessages.php');
        ?>
    </div>

    <header id="header">
        <?php
            require('../server/php/html-structure/header.php');
        ?>
    </header>
    
    <div id="sidebar">
        <?php
            require('../server/php/html-structure/sidebar.php');
        ?>
    </div>

    <div id="logo">
        <?php
            require('../server/php/html-structure/logo.php');
        ?>
    </div>

    <div id="mainContainer">
        <?php 
            if (!isset($_SESSION['logged_in'])){
                require('../server/php/html-structure/loginForm.php');
            } else{
                // -- 👉 Hier wird der normale Einzahlungsbereich geladen 
                require('../server/php/html-structure/einzahlungsFormularUndTabellen.php');
            }
        ?>
    </div>

    <footer id="footer">
        <?php
            require('../server/php/html-structure/footer.php');
        ?>
    </footer>
</body>
</html>