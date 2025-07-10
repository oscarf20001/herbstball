<?php
// Zugriff auf die globale Variable
$basePath = $_SERVER['DOCUMENT_ROOT']; // z. B. /Users/oscarstreich/httpdocs

// Nur lokal bei Entwicklung anpassen:
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
    $basePath .= '/Metis/herbstball_25';
}

require_once($basePath . '/server/php/html-structure/extract_part-URL.php');
$outputURLEnding = getOutputURLEnding();

$basePath = (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) ? '/Metis/herbstball_25' : '';
?>

<div id="sidebarElementsWrapper">
    <!-- None Restricted Areas -->
    <div class="sidebarTextElement selected-site-active" id="site-index">
        <i class="fa-solid fa-ticket sideBarIconElement"></i>
        <a href="<?php echo $basePath; ?>/index.php">Tickets</a>
    </div>
    <div class="sidebarTextElement" id="site-music">
        <i class="fa-solid fa-music sideBarIconElement denied"></i>
        <a class="denied" href="#">Musikwünsche</a>
        <!--<a class="denied" href="client/musikwünsche.html">Musikwünsche</a>-->
    </div>
    
    <!-- Seperator Line -->
    <hr class="solid">

    <!-- Restricted Areas -->
    <div class="sidebarTextElement" id="site-einzahlung">
        <i class="fa-solid fa-euro-sign sideBarIconElement"></i>
        <a href="<?php echo $basePath; ?>/client/einzahlung.php">Einzahlung</a>
    </div>
    <div class="sidebarTextElement" id="site-admin">
        <i class="fa-solid fa-lock sideBarIconElement"></i>
        <a class="" href="<?php echo $basePath; ?>/client/admin.php">Admin-Panel</a>
    </div>
    <div class="sidebarTextElement" id="site-mails">
        <i class="fa-solid fa-envelope sideBarIconElement denied"></i>
        <a class="denied" href="#">Resend Mails</a>
        <!--<a class="denied" href="client/mails.html">Resend Mails</a>-->
    </div>
    <div class="sidebarTextElement" id="site-entrance">
        <i class="fa-solid fa-door-open sideBarIconElement denied"></i>
        <a class="denied" href="#">Einlass-Panel</a>
        <!--<a class="denied" href="client/einlass.html">Einlass-Panel</a>-->
    </div>
</div>

<script>
    const urlExtract = '<?php echo $outputURLEnding ?>';
    const elements = document.querySelectorAll('.sidebarTextElement').forEach(element => {
        element.classList.remove('selected-site-active');
    });

    const newActiveElement = document.getElementById('site-' + urlExtract).classList.add('selected-site-active');
</script>