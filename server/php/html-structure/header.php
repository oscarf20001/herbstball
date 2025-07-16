<?php
// config.php einbinden (Pfad ggf. anpassen, je nachdem wo header.php liegt)
require_once __DIR__ . '/../../../config.php';

// Jetzt BASE_PATH verwenden, um die Datei einzubinden
require_once(BASE_PATH . '/server/php/html-structure/extract_part-URL.php');

$outputURLEnding = getOutputURLEnding();
?>

<div class="header-left">
    <h1 id="headliner">HERBSTBALL 2025 <span id="post-Headline">- Marie Curie meets Friedlieb Runge</span></h1>
    <?php
        if ($outputURLEnding == 'index' || $outputURLEnding == '') {
            echo '<p>🎟 Tickets vorbestellen</p>';
        } elseif ($outputURLEnding == 'einzahlung') {
            echo '<p>🤑 Geld einzahlen</p>';
        } elseif ($outputURLEnding == 'admin') {
            echo '<p>📈 Dashboard</p>';
        } elseif ($outputURLEnding == 'mails') {
            echo '<p>📧 Emails erneut versenden (Für den Fall, dass jemand zu dumm war, seine Mail richtig anzugeben)</p>';
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
