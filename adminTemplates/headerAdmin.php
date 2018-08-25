<?php if(!$sefora) die();?>
<header id="topDiv">
    <div class="loginInfo">
        <?php if($sefora->zalogowany_adm): ?>
            <div class="headerLinks">
                <a href="index.php">Strona główna</a>
                <a href="index2.php?action=usersAdmin">Zarządzaj</a>
                <a href="index2.php?action=logoutAdmin">Wyloguj</a>
            </div>
        <?php else: ?>
            <div>Nie jesteś zalogowany</div>
        <?php endif; ?>
    </div>
</header>