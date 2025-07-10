<div id="mainContainer">
        <?php 
            if (!isset($_SESSION['logged_in'])){
                require __DIR__ . '/../loginForm.php';
            } else{
                // -- 👉 Hier wird der normale Einzahlungsbereich geladen 
                require __DIR__ . '/../einzahlungsFormularUndTabellen.php';
            }
        ?>
    </div>