<?php
// Zugriff auf die globale Variable
$basePath = $_SERVER['DOCUMENT_ROOT']; // z. B. /Users/oscarstreich/httpdocs

// Nur lokal bei Entwicklung anpassen:
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
    $basePath .= '/Metis/herbstball_25';
}

require_once($basePath . '/server/php/html-structure/extract_part-URL.php');

$outputURLEnding = getOutputURLEnding();
?>

<div class="header-left">
    <h1 id="headliner">HERBSTBALL 2025 <span id="post-Headline">- Marie Curie meets Friedlieb Runge</span></h1>
    <?php
        if($outputURLEnding == 'index' || $outputURLEnding == ''){
            ?>
                <p>🎟 Tickets vorbestellen</p>
            <?php
        }else if($outputURLEnding == 'einzahlung'){
            ?>
                <p>🤑 Geld einzahlen</p>
            <?php
        }else if($outputURLEnding == 'admin'){
            ?>
                <p>📈 Dashboard</p>
            <?php
        }else if($outputURLEnding == 'mails'){
            ?>
                <p>📧 Emails erneut versenden (Für den Fall, dass jemand zu dumm war, seine Mail richtig anzugeben)</p>
            <?php
        }
    ?>
</div>
<div class="header-right">
    <?php if (isset($_SESSION['logged_in'])): ?>
        <div id="logout-container">
            <a href="?logout=1" id="logout-button">Logout</a>
        </div>
    <?php endif; ?>
</div>