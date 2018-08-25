<?php
    if(!isset($sefora)) die();
    if($sefora->zalogowany){
        $sefora->logout();
    }
?>