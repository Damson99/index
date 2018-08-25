<header id="topDiv">
    <?php /*if($sefora->zalogowany):*/?>
        <nav>
            <button><img src="settings.jpg"></button>
            <aside class="side-menu">
                <ul>
                    <li><a href="index.php?action=editAccountForm">Edutuj konto</a></li>
                    <li><a href="index.php?action=deleteAccountForm">Usuń konto</a></li>
                </ul>
            </aside>
        </nav>
    <?php /*endif;*/?>
    <div class="header">
    <a href="index.php"><img src="sefora.jpg" class="logo"></a>
        <form action="index.php?action=showSearchResult" method="post">
            <input type="search" class="search" placeholder="Szukaj..." name="bransoletka">
            <input type="submit" value="Szukaj" class="subsearch">
        </form>
    </div>
    <div class="loginInfo">
        <div class="basketDiv">
            <a href="index.php?action=showBasket">KOSZYK</a>
        </div>
        <?php if($sefora->zalogowany):?>
            <div>Miłych zakupów <?php $sefora->zalogowany->$nazwa;?></div>
            <div><a href="index.php?action=logout">Wyloguj się</a></div>
            <?php if(isset($sefora->przywileje[1])):?>
                <a href="index2.php">Administracja</a>
            <?php endif;?>
        <?php else: ?>
            <div></div>
        <?php if(!$sefora->zalogowany):?>
            <div><a href="index.php?action=showRegForm">Zarejestruj się</a></div>
            <div><a href="index.php?action=showLoginForm">Zaloguj się</a></div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</header>