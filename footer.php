<footer>
     <?php if($sefora->zalogowany):?>
        <nav id="footerNav">
            <button><img src="img/settings.jpg"></button>
            <aside class="side-menu">
                <ul>
                    <a href="index.php?action=changePassForm">Zmień hasło</a>
                    <a href="index.php?action=deleteAccountForm">Usuń konto</a>
                </ul>
            </aside>
        </nav>
    <?php endif;?>
    <div>
        <ul>
        <h3>Informacje o sklepie</h3>
            <li>pracownia artystyczna sefory</li>
            <li>Lidia Szczypior</li>
            <li>ul.Elbląska 59/25</li>
            <li>01-737 Warszawa</li>
            <li>NIP: 525-160-28-68</li>
            <li>pracowniasefory@gmail.com</li>
        </ul>
    </div>
    <div>
        <ul>
        <h3>Informacje ogólne</h3>
            <li>Wysyłki</li>
            <li>Reklamacje i zwroty</li>
            <li>Polityka prywatności</li>
        </ul>
    </div>
</footer>