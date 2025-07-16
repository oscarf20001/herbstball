<?php
// config.php einbinden (Pfad ggf. anpassen, je nachdem wo header.php liegt)
require_once __DIR__ . '/../../../config.php';

// Jetzt BASE_PATH verwenden, um die Datei einzubinden
require_once(BASE_PATH . '/server/php/html-structure/extract_part-URL.php');

$outputURLEnding = getOutputURLEnding();
$loginFormSubText = '';

if($outputURLEnding == 'index'){
    $loginFormSubText = '';
}else if($outputURLEnding == 'einzahlung'){
    $loginFormSubText = 'Einzahlungen';
}else if($outputURLEnding == 'admin'){
    $loginFormSubText = 'Adminpanel';
}else if($outputURLEnding == 'mails'){
    $loginFormSubText = 'Mails erneut senden';
}

?>

<div id="login-box">
    <h2>Login erforderlich</h2>
    <sub><?php echo $loginFormSubText ?></sub>
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