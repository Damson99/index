<?php
    if(!isset($sefora)) die();
    if($sefora->zalogowany){
        $sefora->logout();
        header("Location:index.php?action=showLoginForm");
        $sefora->setMessage("Wylogowano");
    }
?>