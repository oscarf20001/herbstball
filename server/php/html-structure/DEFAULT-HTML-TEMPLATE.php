<!--
===========================================================================
|                                                                         |
|        GENERATE THE DEFAULT ELEMENTS WITHOUT THE MAIN CONTAINER         |
|                                                                         |
===========================================================================
-->

<div id="display">
    <?php
        //require($basePath . '/server/php/html-structure/displayMessages.php');
        require __DIR__ . '/displayMessages.php';
    ?>
</div>

<header id="header">
    <?php
        //require($basePath . '/server/php/html-structure/header.php');
        require __DIR__ . '/header.php';
    ?>
</header>

<div id="sidebar">
    <?php
        //require($basePath . '/server/php/html-structure/sidebar.php');
        require __DIR__ . '/sidebar.php';
    ?>
</div>

<div id="logo">
    <?php
        //require($basePath . '/server/php/html-structure/logo.php');
        require __DIR__ . '/logo.php';
    ?>
</div>

<footer id="footer">
    <?php
        //require($_SERVER['DOCUMENT_ROOT'] . '/Metis/herbstball_25/server/php/html-structure/footer.php');
        //require($basePath . '/server/php/html-structure/footer.php');
        require __DIR__ . '/footer.php';
    ?>
</footer>

<!--
===========================================================================
|                                                                         |
|     NOW WE GENERATE THE MAIN CONTAINER DEPENEND ON THE URL IT SENDS     |
|                                                                         |
===========================================================================
-->

<?php

// Zugriff auf die globale Variable
$basePath = $_SERVER['DOCUMENT_ROOT']; // z. B. /Users/oscarstreich/httpdocs

// Nur lokal bei Entwicklung anpassen:
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
    $basePath .= '/Metis/herbstball_25';
}

require_once($basePath . '/server/php/html-structure/extract_part-URL.php');
$outputURLEnding = getOutputURLEnding();

if($outputURLEnding == 'index'){
    require __DIR__ . '/mainContainer/MC_index.php';
}else if($outputURLEnding == 'einzahlung'){
    require __DIR__ . '/mainContainer/MC_einzahlung.php';
}else if($outputURLEnding == 'admin'){
    require __DIR__ . '/mainContainer/MC_admin.php';
}

?>