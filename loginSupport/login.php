<?php
    if(!isset($sefora)) die();
    if($sefora->zalogowany){
        $sefora->setMessage("Jesteś już zalogowany");
        header("Location:index.php?action=braceletFor&brn=all");
        return;
    }
    if(!$sefora->zalogowany){
        switch($sefora->login()){
            case FORM_DATA_MISSING:
                $sefora->setMessage("Uzupełnij wszystkie pola");
                header("Location:index.php?action=showLoginForm");
                break;
            case LOGIN_OK:
                header("Location:index.php?action=braceletFor&brn=all");
                break;
            case LOGIN_FAILED:
                $sefora->setMessage("Nieprawidłowa nazwa lub hasło");
                header("Location:index.php?action=showLoginForm");
                break;
            case SERVER_ERROR:
            default:
                $sefora->setMessage("Błąd serwera");
                header("Location:index.php?action=showLoginForm");
        }
    }else{
        $sefora->setMessage("Jesteś już zalogowany");
    }
?>