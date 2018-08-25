<?php if(!isset($sefora)) die();?>
<div id="loginFormWrapper">
    <img src="imageLog.jpg" class="imageLog"><br>
    <h1>Zaloguj się</h1>
    <form action="index.php?action=login" method="post">
        <p>Email</p>
        <input type="email" name="email" placeholder="Wprowadź email">
        <p>Hasło</p>
        <input type="password" name="haslo" placeholder="Wprowadź hasło">
        <input type="submit" value="Zaloguj">
    </form>
    <a href="">Nie pamiętam hasła</a>
    <a href="index.php?action=showRegForm">Stwórz konto</a>
    <a href="index.php">Wróć do strony głównej</a>
    <div class="komunikat">
        <?php 
            if($komunikat){
                echo $komunikat;
            }
        ?>
    </div>
</div>
