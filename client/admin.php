<?php
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
</head>
<body>
    <header id="header">
        <div class="header-left">
            <h1 id="headliner">HERBSTBALL 2025 <span id="post-Headline">- Marie Curie meets Friedlieb Runge</span></h1>
            <p>📈📈📈 Dashboard 📈📈📈</p>
        </div>
        <div class="header-right">
            <?php if (isset($_SESSION['logged_in'])): ?>
                <div id="logout-container">
                    <a href="?refresh=1" id="logout-button">Akualisieren</a>
                    <a href="?logout=1" id="logout-button">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <div id="sidebar">
        <div id="sidebarElementsWrapper">
            <!-- None Restricted Areas -->
            <div class="sidebarTextElement" onclick="window.location='../index.html'">
                <i class="fa-solid fa-ticket sideBarIconElement"></i>
                <a href="../index.html">Tickets</a>
            </div>
            <div class="sidebarTextElement" onclick="window.location='musikwünsche.html'">
                <i class="fa-solid fa-music sideBarIconElement"></i>
                <a href="musikwünsche.html">Musikwünsche</a>
            </div>
            
            <!-- Seperator Line -->
            <hr class="solid">

            <!-- Restricted Areas -->
            <div class="sidebarTextElement">
                <i class="fa-solid fa-euro-sign sideBarIconElement"></i>
                <a class="" href="einzahlung.php">Einzahlung</a>
            </div>
            <div class="sidebarTextElement selected-site-active">
                <i class="fa-solid fa-lock sideBarIconElement"></i>
                <a href="#">Admin-Panel</a>
            </div>
            <div class="sidebarTextElement" onclick="window.location='mails.html'">
                <i class="fa-solid fa-envelope sideBarIconElement"></i>
                <a href="mails.html">Resend Mails</a>
            </div>
            <div class="sidebarTextElement" onclick="window.location='einlass.html'">
                <i class="fa-solid fa-door-open sideBarIconElement"></i>
                <a href="einlass.html">Einlass-Panel</a>
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
            <?php include 'dashboard/dashboard.php'; ?>
        <?php endif; ?>
    </div>

    <footer id="footer">
        <p id="copyright">© Oscar Streich 2025</p>
        <p id="help">concact <span id="highlight">oscar-streich@t-online.de</span> for help</p>

        <div id="socialMedia">
            <div class="oscar">
                <a target="_blank" href="https://www.instagram.com/oscar_f20001/">
                    <i class="fa-brands fa-instagram"></i>
                    <p>@oscar_f20001</p>
                </a>
            </div>
            <div class="rapha">
                <a target="_blank" href="https://www.instagram.com/rap.haelo/">
                    <i class="fa-brands fa-instagram"></i>
                    <p>@rap.haelo</p>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>