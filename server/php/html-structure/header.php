<?php
// Zugriff auf die globale Variable
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
                <p>🤑🤑🤑 Einzahlungen vornehmen 🤑🤑</p>
            <?php
        }else if($outputURLEnding == 'admin'){
            ?>
                <p>📈📈📈 Dashboard 📈📈</p>
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