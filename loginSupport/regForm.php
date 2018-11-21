<div id="loginFormWrapper">
    <img src="img/imageLog.jpg" class="imageLog"><br>
    <h1>Zarejestruj się</h1><br>
    <form name="regForm" action="index.php?action=registerUser" method="post">
        <div>
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="haslo" placeholder="Hasło">
            <input type="password" name="haslo2" placeholder="Powtórz Hasło">
            <input type="text" name="imie" placeholder="Imię">
            <input type="text" name="nazwisko" placeholder="Nazwisko">
            
            <input type="submit" value="Zarejestruj">
            <a href="index.php?action=braceletFor&brn=all">Wróć do strony głównej</a>
        </div>
    </form>
</div>