<form action="index2.php?action=usersAdmin&amp;wtd=<?=$wtd?>" method="post">
    <div id="loginFormWrapper">
        <img src="imageLog.jpg" class="imageLog"><br>
        <p>Id</p>
        <input type="text" name="id" <?=$readonly?> value="<?=$id?>">
        <p>Imię</p>
        <input type="text" name="imie" value="<?=$imie?>">
        <p>Nazwisko</p>
        <input type="text" name="nazwisko" value="<?=$nazwisko?>">
        <p>Hasło</p>
        <input type="password" name="haslo" value="">
        <p>E-mail</p>
        <input type="email" name="email" value="<?=$email?>">
        <p>Ulica</p>
        <input type="text" name="ulica" value="<?=$ulica?>">
        <p>Numer domu</p>
        <input type="text" name="nr_domu" value="<?=$nr_domu?>">
        <p>Numer mieszkania</p>
        <input type="text" name="nr_mieszkania" value="<?=$nr_mieszkania?>">
        <p>Miejscowość</p>
        <input type="text" name="miejscowosc" value="<?=$miejscowosc?>">
        <p>Kod pocztowy</p>
        <input type="text" pattern="^\d{2}-\d{3}$" name="kod" value="<?=$kod?>">
        <p>Kraj</p>
        <input type="text" name="kraj" value="<?=$kraj?>">
        <input type="submit" value="Zapisz"><br>
        <?php if($wtd=='modifyUser'):?>
            <center><a href="index2.php?action=usersAdmin&amp;wtd=deleteUser&amp;id=<?=$id?>">Usuń</a></center>
        <?php endif;?>
    </div>
</form>