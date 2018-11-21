<div id="loginFormWrapper">
    <img src="img/imageLog.jpg" class="imageLog"><br>
    <h1>Dane do wysyłki</h1><br><br>
    <form name="formUpdate" action="index.php?action=registerAdress" method="post">
        <div>
            <input type="text" name="adres" placeholder="Adres" value="<?=$rowForm[1]?>">
            <input type="text" name="miejscowosc" placeholder="Miejscowosc" value="<?=$rowForm[2]?>">
            <input type="text" name="kod" placeholder="Kod pocztowy" value="<?=$rowForm[3]?>">
            <input type="text" name="kraj" placeholder="Kraj" value="<?=$rowForm[4]?>">
                
            <p><input type="submit" value="Potwierdź"></p>
        </div>
    </form>
</div>