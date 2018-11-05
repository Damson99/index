<?php if(!$sefora) die();?>
<header id="topDiv">
    <div class="header" title="Strona główna"><a href="index.php?action=braceletFor&brn=all"><img src="img/sefora.jpg" class="logo"></a></div>
    <div class="loginInfo">
        <?php if($sefora->zalogowany_adm && $_SESSION['przywileje']==='1'): ?>
            <div class="hiUser"style="margin-left:200px;">Dzień dobry <?=$sefora->zalogowany_adm->nazwa?></div>
            <a href="index.php?action=braceletFor&brn=all">Strona główna</a>
            <a href="index2.php?action=usersAdmin">Zarządzaj</a>
            <a href="index2.php?action=logoutAdmin">Wyloguj</a>
        <?php else: ?>
            <div>Nie jesteś zalogowany</div>
        <?php endif; ?>
    </div>
</header><br><br><br><br><br>