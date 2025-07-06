<?php
session_start();

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
<html lang="en">
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
    <script type="module" src="client/scripts/denied.js" defer></script>
    <script type="module" src="client/scripts/displayMessages.js"></script>-->
    <script type="module" src="scripts/searchEmails.js" defer></script>
    <script type="module" src="scripts/einzahlung.js" defer></script>
</head>
<body>
    <header id="header">
        <div class="header-left">
            <h1 id="headliner">HERBSTBALL 2025 <span id="post-Headline">- Marie Curie meets Friedlieb Runge</span></h1>
            <p>🤑🤑🤑 Einzahlungen vornehmen 🤑🤑🤑</p>
        </div>
        <div class="header-right">
            <?php if (isset($_SESSION['logged_in'])): ?>
                <div id="logout-container">
                    <a href="?logout=1" id="logout-button">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </header>
    
    <div id="sidebar">
        <div id="sidebarElementsWrapper">
            <!-- None Restricted Areas -->
            <div class="sidebarTextElement">
                <i class="fa-solid fa-ticket sideBarIconElement"></i>
                <a href="../index.html">Tickets</a>
            </div>
            <div class="sidebarTextElement">
                <i class="fa-solid fa-music sideBarIconElement denied"></i>
                <a class="denied" href="#">Musikwünsche</a>
                <!--<a class="denied" href="client/musikwünsche.html">Musikwünsche</a>-->
            </div>
            
            <!-- Seperator Line -->
            <hr class="solid">

            <!-- Restricted Areas -->
            <div class="sidebarTextElement selected-site-active">
                <i class="fa-solid fa-euro-sign sideBarIconElement"></i>
                <a class="" href="client/einzahlung.php">Einzahlung</a>
            </div>
            <div class="sidebarTextElement">
                <i class="fa-solid fa-lock sideBarIconElement denied"></i>
                <a class="denied" href="#">Admin-Panel</a>
                <!--<a class="denied" href="client/admin.html">Admin-Panel</a>-->
            </div>
            <div class="sidebarTextElement">
                <i class="fa-solid fa-envelope sideBarIconElement denied"></i>
                <a class="denied" href="#">Resend Mails</a>
                <!--<a class="denied" href="client/mails.html">Resend Mails</a>-->
            </div>
            <div class="sidebarTextElement">
                <i class="fa-solid fa-door-open sideBarIconElement denied"></i>
                <a class="denied" href="#">Einlass-Panel</a>
                <!--<a class="denied" href="client/einlass.html">Einlass-Panel</a>-->
            </div>
        </div>
    </div>

    <div id="logo">
        <img src="images/Metis.svg" alt="Metis-Ticketsystem Logo" srcset="">
    </div>

    <div id="mainContainer">
        <?php if (!isset($_SESSION['logged_in'])): ?>
            <div id="login-box">
                <h2>Login erforderlich</h2>
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                <form method="POST">
                    <div class="input-field username">
                        <input type="text" name="username" id="username" required>
                        <label for="username">Benutzername:</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" id="password" required>
                        <label for="password">Passwort:</label>
                    </div>
                    <button type="submit" id="login-btn">Einloggen</button>
                </form>
            </div>
        <?php else: ?>
            <!-- 👉 Hier wird der normale Einzahlungsbereich geladen -->
            <?php include 'einzahlungsFormularUndTabellen.php'; ?>
        <?php endif; ?>
    </div>

    <footer id="footer">
        <p id="copyright">© Oscar Streich 2025</p>
        <p>contact <span id="highlight">oscar-streich@t-online.de</span> for help</p>
    </footer>
</body>
</html>