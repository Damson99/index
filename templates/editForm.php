<?php if(!isset($this)) die();?>
<div id="loginFormWrapper">
    <img src="img/imageLog.jpg" class="imageLog"><br>
    <h1>Edytuj</h1>
    <form action="index.php?action=checkPass" method="post">
        <p>Wprowadź stare hasło</p>
        <input type="password" name="oldPass" placeholder="Wprowadź hasło">
        <p>Wprowadź nowe hasło</p>
        <input type="password" name="newPass" placeholder="Wprowadź hasło">
        <input type="submit" value="Zmień">
    </form>
    <a href="">Nie pamiętam hasła</a>
    <a href="index.php?action=bransoletFor&brn=all">Wróć do strony głównej</a>
</div>