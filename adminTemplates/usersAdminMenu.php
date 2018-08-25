<?php if(!isset($sefora)) die();?>
<div class="pOfferts">Wybierz funkcję administracyjną</div>
<div id="userMenu">
    <div><a href="index2.php?action=usersAdmin&amp;wtd=showOrders">Zamówienia</a></div>
    <div><a href="index2.php?action=usersAdmin&amp;wtd=addBransoletForm">Dodaj bransoletkę</a></div>
    <div><a href="index2.php?action=usersAdmin&amp;wtd=searchBransoletForm">Szukaj Bransoletki</a></div>
    <div><a href="index2.php?action=usersAdmin&amp;wtd=showList">Lista użytkowników</a></div>
    <div><a href="index2.php?action=usersAdmin&amp;wtd=showSearchForm">Szukaj użytkowników</a></div>
    <div><a href="index2.php?action=usersAdmin&amp;wtd=showAddForm">Dodaj użytkownika</a></div>
</div>
<?php if($komunikat_adm):?>
    <div class="komunikat"><?=$komunikat_adm?></div>
<?php endif;?>