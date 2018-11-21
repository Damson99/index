<header id="topDiv">
    <div class="header">
        <a href="index.php?action=braceletFor&brn=all"><img src="img/sefora.jpg" class="logo"title="Strona główna"></a>
        <form action="index.php?action=showSearchResult" method="post">
            <input type="search" class="search" placeholder="Szukaj..." name="bransoletka">
            <input type="submit" value="Szukaj" class="subsearch">
        </form>
    </div>
    <div class="loginInfo">
        <?php if($sefora->zalogowany):?>
            <div class="hiUser"><?=$sefora->zalogowany->nazwa?></div>
        <?php endif;?>
        <div>Główna<a href="index.php?action=braceletFor&brn=all" title="Strona główna"><img src="img/main.png"></a></div>
        <div>Koszyk<a href="index.php?action=showBasket" title="Koszyk"><img src="img/basket.png" style="width:35px;height:35px;"></a></div>
        <div>Ulubione<a href="index.php?action=showWishList" title="Lista życzeń"><img src="img/heart.png"></a></div>
        <?php if(!$sefora->zalogowany):?>
            <div>Logowanie<a href="index.php?action=showLoginForm" title="Logowanie"><img src="img/user.png"></a></div>
            <div><a href="index.php?action=showRegForm">Rejestracja</a></div>
        <?php endif; ?>
        <?php if($sefora->zalogowany):?>
            <div>Wyloguj<a href="index.php?action=logout" title="Wyloguj"><img src="img/logout.png"></a></div>
            <?php if(isset($_SESSION['przywileje'])=='1'):?>
                    <a href="index2.php">Administracja</a>
            <?php endif;?>
        <?php endif; ?>
    </div>
</header>