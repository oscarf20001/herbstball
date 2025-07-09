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