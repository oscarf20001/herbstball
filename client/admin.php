<?php
$basePath = $_SERVER['DOCUMENT_ROOT']; // z. B. /Users/oscarstreich/httpdocs

// Nur lokal bei Entwicklung anpassen:
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
    $basePath .= '/Metis/herbstball_25';
}

session_start();

// Logout abfangen
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Logout abfangen
if (isset($_GET['refresh'])) {
    echo "Hier würden wir refreshen haha";
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herbstball des MCG 2025 - Powered by Metis</title>
    <link rel="stylesheet" href="styles/barStyles.css">
    <link rel="stylesheet" href="styles/einzahlungen.css">
    <link rel="stylesheet" href="styles/inputFields.css">
    <link rel="stylesheet" href="styles/tables.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <script src="https://kit.fontawesome.com/b9446e8a7d.js" crossorigin="anonymous"></script>
    <script type="module" src="scripts/denied.js" defer></script>
</head>
<body>

    <!-- DEFAULT TEMPLATE LADEN -->
    <?php
        require($basePath . '/server/php/html-structure/DEFAULT-HTML-TEMPLATE.php');
    ?>
</body>
</html>