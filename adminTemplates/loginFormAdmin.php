<?php if(!isset($sefora)) die();?>
<div id="loginFormWrapper">
    <img src="img/imageLog.jpg" class="imageLog"><br>
    <h1>Zaloguj się</h1>
    <form action="index2.php?action=loginAdmin" method="post">
        <p>Imię</p>
        <input type="text" name="user" placeholder="Wprowadź imię administratora">
        <p>Hasło</p>
        <input type="password" name="haslo" placeholder="Wprowadź hasło administratota">
        <input type="submit" value="Zaloguj">
    </form>
    <a href="index.php">Wróć do strony głównej</a>
</div>