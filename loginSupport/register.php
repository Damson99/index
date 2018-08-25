<?php
if(!isset($sefora)) die();
switch($sefora->registerUser()){
    case ACTION_OK:
        $sefora->setMessage("Rejestracja udana. Możesz się zalogować");
        header("Location:index.php?action=showLoginForm");
        return;
        break;
    case FORM_DATA_MISSING:
        $sefora->setMessage("Wypełnij wymagane pola formularza");
        break;
    case INVALID_USER_NAME:
        $sefora->setMessage("Napisz imię i nazwisko dużą literą lub usuń znaki specjalne");
        break;
    case INVALID_PASS:
        $sefora->setMessage("Hasło musi zawierać co najmniej:"."<br>"."*jedną cyfrę"."<br>"."*dużą literę"."<br>"."*jedną małą literę"."<br>"."*jeden znak z grupy !@#$%^&*()_+-=."."<br>"."*musi mieć długość przynajmniej 8 znaków"."<br>"."Nie może zawierać spacji.");
        break;
    case PASSWORDS_DO_NOT_MATCH:
        $sefora->setMessage("Hasła różnią się od siebie");
        break;
    case USER_NAME_ALREADY_EXISTS:
        $sefora->setMessage("Ten adres email jest już zajęty");
        break;
    case INVALID_ADDRESS:
        $sefora->setMessage("Sprawdź czy dobrze został wpisany adres zamieszkania");
    case ACTION_FAILED:
        $sefora->setMessage("Obecnie rejestracja nie jest możliwa");
        break;
    case SERVER_ERROR:
    default:
        $sefora->setMessage("Błąd serwera");
}
header("Location:index.php?action=showRegForm");