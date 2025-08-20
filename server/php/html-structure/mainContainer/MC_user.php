<div id="mainContainer">
        <?php 
            if (!isset($_SESSION['logged_in'])){
                require __DIR__ . '/../loginForm.php';
            } else{
                // -- 👉 Hier wird der normale Bereich geladen

                // Login-Versuch
                if (empty($_SESSION['logged_in']) || empty($_SESSION['permissions']) || !in_array('can_change_password', $_SESSION['permissions'])) {
                    echo "<script>
                        alert('Permission denied');
                        window.location.href = document.referrer && document.referrer !== window.location.href 
                            ? document.referrer 
                            : '/../../../../index.php';
                    </script>";
                    exit;
                }


                ?>
                <div id="container">

                    <div id="toggle">
                        <div class="highlight"></div>
                        <div class="option active" data-index="0">Passwort ändern</div>
                        <div class="option" data-index="1" id="create_toggle" data-can-create="<?= in_array('can_create_user', $_SESSION['permissions'] ?? []) ? '1' : '0' ?>">User erstellen</div>
                    </div>

                    <div id="content_wrapper">
                        <div id="reset_password_wrapper" class="wrapper" data-id="wrapper-0">
                            <h2>Passwort-Reset anfordern</h2>
                            <p>Bitte gebe deine Email an, mit der du deinen User erstellt hast. Wir senden dir einen Link zum zurücksetzen deines Passworts zu!</p>
                            <div id="reset_formular">
                                <div class="input-field email">
                                    <input type="email" id="r-email" name="request_reset_password" required>
                                    <label for="r-email">Email:</label>
                                </div>
                                <input type="submit" value="Reset anfordern" id="reset_password_submit">
                            </div>
                        </div>
                        <div id="create_user_wrapper" class="wrapper" data-id="wrapper-1">
                            <h2>Einen neuen User erstellen</h2>
                            <p>Bitte gib alle benötigen Daten an, um einen neuen Benutzer zu erstellen</p>
                            <div id="create_formular">
                                <div class="input-field name">
                                    <input type="name" id="c-name" name="create_new_user-name" required>
                                    <label for="c-name">Name:</label>
                                </div>
                                <div class="input-field email">
                                    <input type="email" id="c-email" name="create_new_user-email" required>
                                    <label for="c-email">Email:</label>
                                </div>
                                <div class="input-field password">
                                    <input type="password" id="c-password" name="create_new_user-password" required>
                                    <label for="c-password">Passwort:</label>
                                </div>
                                <div class="input-field confirm_password">
                                    <input type="password" id="c-confirm_password" name="create_new_user-confirm_password" required>
                                    <label for="c-confirm_password">Passwort bestätigen:</label>
                                </div>
                                <input type="submit" value="User erstellen" id="create_new_user_submit">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- div für das Displayen der Nachrichten aus js -->
                <div id="display">
                    <div id="display_icon">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <div id="display_textContainer">
                        <p id="display_textNode">Hier steht eine Nachricht!</p>
                    </div>
                </div>
                <?php
            }
        ?>
</div>